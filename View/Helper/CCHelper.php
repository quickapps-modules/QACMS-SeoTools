<?php
class CCHelper extends AppHelper {
	public $red = 0;
	public $yellow = 0;
	public $green = 0;

	public $essential_passed = 0;
	public $essential_failed = 0;

	public $very_important_passed = 0;
	public $very_important_failed = 0;

	public $important_passed = 0;
	public $important_failed = 0;

	public $tmp = null;

	public function competitor_average($data = array(), $type = 'integer') {
		$data = Set::filter($data);
		$min = min($data);
		$max = max($data);

		if ($min == 0 && $min == $max) {
			if ($type == 'integer') {
				return __t('all 0');
            }

			if ($type == 'percent') {
				return __t('all 0%');
            }
		}

		if ($type == 'integer') {
			return sprintf(__t('%s to %s'), number_format(intval($min), 2), number_format(intval($max), 2));
        }

		if ($type == 'percent')
			return sprintf(__t('%s to %s %%'), number_format($min, 2), number_format($max, 2)); 
	}


	public function advice_color($competitor = array(), $your, $aspect = null) {
		if ($aspect === null) {
			return false;
        }

		if ($aspect == 'alexa_rank') {
			$competitor = Set::filter($competitor);
			$competitor = $this->__str2int($competitor);
			$your = $this->__str2int($your);

			$average = array_sum($competitor) / count($competitor);
			$this->tmp = array($your, $average);
			if (($your > $average) ||
				(170000 < $your && $your < $average)
			) {
				return $this->return_color(0, $aspect);
			} else{
				return $this->return_color(2, $aspect);
			}
		} elseif ($aspect == 'backlinks') {
			$competitor = $this->__str2int($competitor);
			$your = $this->__str2int($your);

			$average = array_sum($competitor) / count($competitor);

			$this->tmp = array(number_format($average), number_format($your));

			if ($your >= max($competitor)) {
				return $this->return_color(2, $aspect);
            }

			if ($your >= $average) {
				return $this->return_color(1, $aspect);
            }

			return $this->return_color(0, $aspect);
		} elseif ($aspect == 'age') {
			$competitor = Set::filter($competitor);
			if ($your == 'n/a' || 
                ($your != 'n/a' &&  $your > (31556926/2) && $your < min($competitor))  
			) {
				return $this->return_color(1, $aspect);
			}

			if ($your < 31556926) { # yours < 1 year
				return $this->return_color(0, $aspect);
            }

			return $this->return_color(2, $aspect);
		}

		$competitor = (array)Set::filter($competitor);
		$min = min($competitor);
		$max = max($competitor);

		if ($min == 0 && $max > 0 && $your == 0) {
			if ($this->relevance($aspect) === 1) {
				return $this->return_color(0, $aspect);
            }

			return $this->return_color(1, $aspect); //yellow
		}

		if ($min == 0 && $max == 0 && $your == 0) {
			if ($this->relevance($aspect) === 1) {
				return $this->return_color(1, $aspect);
            }

			return $this->return_color(2, $aspect);
		}

		if ($your >= $min && $max >= $your) { #between ranges = OK
			return $this->return_color(2, $aspect); //green
		} else {
			return $this->return_color(0, $aspect); //red
		}
	}

	public function __str2int($data) {
		if (is_array($data)) {
			foreach($data as &$rank) { 
                $rank = (int)str_replace(array(',', '.'), '', $rank);
            }

			return $data;
		}

		$data = (int)str_replace(array(',', '.'), '', $data);
        
		return $data;
	}

	/*0 = min, 1=max;  3<2<1*/
	public function relevance($aspect) {
		if (in_array($aspect, array('title', 'body', 'tags/description'))) {
			return 1;
		}

		return 0;
	}

	public function emphasize_keywords($str, $words = array(), $type = 'bold') {
		switch($type) {
			case 'highlight': 
                default: 
                    $var_style = 'background: #CEDAEB;'; 
            break;
            
			case 'bold': 
                $var_style = 'font-weight: bold;'; 
            break;
            
			case 'underline': 
                $var_style = 'text-decoration: underline;'; 
            break;
		}

		if(is_array($words)) {
			foreach($words as $word) {
				if(strlen($word) <= 1) {
					continue;
                }
                
				if(!empty($word)) {
					$word= strip_tags($word);
					$word= preg_quote($word, '/');

					$str = preg_replace("/({$word})/i", "<span style='".$var_style."'>\\1</span>", $str);
				}
			}

			return $str;
		}

		return false;
	}

	public function return_color($num, $aspect = null) {
		$color = array('red', 'yellow', 'green');

		if (in_array($aspect, array('title', 'backlinks', 'body'))) {
			if (in_array($color[$num], array('green', 'yellow'))) {
				$this->essential_passed++;
			} else {
				$this->essential_failed++;
			}
		} elseif (in_array($aspect, array('age', 'h1'))) {
			if (in_array($color[$num], array('green', 'yellow'))) {
				$this->very_important_passed++;
			} else {
				$this->very_important_failed++;
			}
		} else {
			if (in_array($color[$num], array('green', 'yellow'))) {
				$this->important_passed++;
			} else {
				$this->important_failed++;
			}
		}

		$this->{$color[$num]}++;
		return "{$num}";
	}

	public function age($data) {
		if (!isset($data['years']) || !isset($data['days'])) {
			return 'n/a';
        }

		$stamp = ($data['years']*31556926) + ($data['days'] * 86400);
		$this->tmp = $stamp;

		$out = sprintf(__t('%s years, %s days. (%s)'), $data['years'], $data['days'], date(__t('Y-m-d'), strtotime(date('Y-m-d'))-$stamp));
		return $out;
	}

	public function color_totals() {
		return array(
			'red' => $this->red,
			'yellow' => $this->yellow,
			'green' => $this->green
		);
	}
}