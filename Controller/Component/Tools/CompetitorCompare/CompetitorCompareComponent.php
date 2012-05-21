<?php 
class CompetitorCompareComponent extends Component {
    public $tmp;
    public $Controller;
    public $EngineParser;

    public function __construct(ComponentCollection $collection, $settings = array()) {
        include dirname(__FILE__) . DS . 'EngineParser.php';

        $this->EngineParser = new EngineParser;

        parent::__construct($collection, $settings);
    }

    public function main(&$Controller) {
        $this->Controller = $Controller;

		if (isset($Controller->data['Tool'])) {
            $Controller->helpers[] = 'SeoTools.CC';

            Cache::config('seo_cache_cc', array('engine' => 'File', 'path' => CACHE, 'duration' => '+1 day'));

            $errors = array();

			if (empty($Controller->data['Tool']['url'])) {
				$errors[] = __d('seo_tools', 'Invalid URL');
            }

			if (empty($Controller->data['Tool']['criteria'])) {
				$errors[] = __d('seo_tools', 'Invalid criteria');
            }

			if (count($errors) > 0) {
				$Controller->flashMsg(implode('<br/>', $errors), 'error');

				return false;
			}

            $cache = Cache::read('top_10_optimizer_' . md5($Controller->data['Tool']['url'] . $Controller->data['Tool']['criteria'] . $Controller->data['Tool']['engine']), 'seo_cache_cc');

            if (!$cache) {
                $results = $this->competitor_compare($Controller->data['Tool']['url'], $Controller->data['Tool']['criteria'], $Controller->data['Tool']['engine']);

                Cache::write('top_10_optimizer_' . md5($Controller->data['Tool']['url'] . $Controller->data['Tool']['criteria'] . $Controller->data['Tool']['engine']), $results, 'seo_cache_cc');
            } else {
                $results = $cache;
            }

			return $results;
		}
        
        return false;
    }

	public function competitor_compare($url = null, $keywords, $engine = 'google.com', $engine_results_num = 10) {
		set_time_limit(0);

        $SeoStats = $this->BaseTools->loadTool('SeoStats');
        $competitors_data = $this->getSnippet($keywords, $engine, $engine_results_num);

		foreach ($competitors_data as $pos => $data) {
			$page = $this->BaseTools->getPage($competitors_data[$pos]['url']);
			$competitors_data[$pos]['body'] = $this->BaseTools->toUTF8($this->BaseTools->html2text($this->parseTag('body', $page))); 
			$competitors_data[$pos]['tags'] = @(array)get_meta_tags($competitors_data[$pos]['url']);
			$competitors_data[$pos]['h1'] = $this->BaseTools->toUTF8($this->BaseTools->html2text(@implode(' ', $this->parseTag('h1', $page, true)))); #get all
			$parseUrl = $this->BaseTools->parseUrl($competitors_data[$pos]['url']);

            // SEM
			$competitors_data[$pos]['backlinks'] = array(
				'alexa' => $SeoStats->getBacklinkAlexa($parseUrl['full']),
				'google' => $SeoStats->getBacklinksGoogle($parseUrl['full']),
				'yahoo' => $SeoStats->getBacklinksYahoo($parseUrl['full'])
			);
			$competitors_data[$pos]['alexa_rank'] = $SeoStats->getAlexaRank($competitors_data[$pos]['url']);
			$competitors_data[$pos]['age'] = $SeoStats->getAge($parseUrl['host']);

			foreach ($competitors_data[$pos]['tags'] as $c_tag_name => &$c_tag_data) {
				$c_tag_data = $this->BaseTools->toUTF8(html_entity_decode($c_tag_data));
			}
		}

		$parseUrl = $this->BaseTools->parseUrl($url);
		$page = $this->BaseTools->getPage($parseUrl['full']);
		$h1_array = (array)$this->parseTag('h1', $page, true);

		foreach ($h1_array as &$h1) { 
            $h1 = $this->BaseTools->toUTF8($h1);
        }

		$site_data = array(
			'url' => $parseUrl['full'],
			'title' => $this->BaseTools->toUTF8($this->BaseTools->html2text($this->parseTag('title', $page))), #sanitize
			'body' => $this->BaseTools->toUTF8($this->BaseTools->html2text($this->parseTag('body', $page))), #sanitize
			'tags' => get_meta_tags($parseUrl['full']),
			'h1' => $this->BaseTools->html2text(implode(' ', $h1_array)), #get all

			/* SEM */
			'backlinks' =>
			 array(
				'alexa' => $SeoStats->getBacklinkAlexa($parseUrl['full']),
				'google' => $SeoStats->getBacklinksGoogle($parseUrl['full']),
				'yahoo' => $SeoStats->getBacklinksYahoo($parseUrl['full'])
			),
			'alexa_rank' => $SeoStats->getAlexaRank($parseUrl['full']),
			'age' => $SeoStats->getAge($parseUrl['host'])
		);

		foreach ($site_data['tags'] as $s_tag_name => &$s_tag_data) {
			$s_tag_data = $this->BaseTools->toUTF8(html_entity_decode($s_tag_data));
		}

		/*********************/
			# $site_data
			# $competitors_data
		/* Analysis */

		$analysis = array(
			'title' => null,
			'backlinks' => null,
			'body' => null,

			'age' => null,
			'h1' => null,

			'url' => null,
			'alexa_rank' => null,
			'tags/description' => null
		);

		/* SEO */
		foreach ($analysis as $aspect => &$aspect_data) {
			if (in_array($aspect, array('backlinks', 'alexa_rank', 'age'))) {
                continue;
            }

			$site_aspect_data = Set::extract("/{$aspect}", $site_data);
			$site_aspect_data = @$site_aspect_data[0];

			$_keywords = explode(' ', str_replace(',', '', $keywords));
			$_keywords[] = $this->__exclude_words(str_replace(',', '', $keywords));

			foreach ($_keywords as $word) {
				$strpos = $aspect == 'h1' ? 0 : $this->word_position($site_aspect_data, $word); #h1 aspect = no position required
				$quantity = $this->word_occurr($site_aspect_data, $word); // --> auto set $this->tmp = source # words
				$aspect_data[$word]['site'] = array(
					'quantity'	=> $quantity,
					'density'	=> @number_format(($quantity*100) / $this->tmp, 2), // --> overload: $this->word_density($site_aspect_data, $word)
					'position'	=> $strpos
				);

				if ($aspect == 'body') {
					$aspect_data[$word]['site']['words_count'] = $this->words_count($site_aspect_data, $word);
				}

				$c_quantity = $c_density = $c_position = $c_body_word_count = array();

				foreach ($competitors_data as $pos => $data) {
					$competitor_aspect_data = Set::extract("/{$aspect}", $competitors_data[$pos]);
					$competitor_aspect_data = @$competitor_aspect_data[0];

					if ($aspect == 'tags/description' && empty($competitor_aspect_data)) {
						continue;
                    }

					$q = $this->word_occurr($competitor_aspect_data, $word); // --> improve: $this->tmp

					$c_quantity[] = $q;
					$c_density[] = @number_format(($q*100) / $this->tmp, 2);
					$strpos = $aspect == 'h1' ? 0 : $this->word_position($competitor_aspect_data, $word); #h1 aspect = no position required
					$c_position[] = $strpos;

					if ($aspect == 'body') {
						$c_body_word_count[] = $this->words_count($competitor_aspect_data, $word);
                    }
				}

				$aspect_data[$word]['competitors'] = array(
					'quantity'	=> $c_quantity,
					'density'	=> $c_density,
					'position'	=> $c_position
				);

				if ($aspect == 'body') {
					$aspect_data[$word]['competitors']['words_count'] = $c_body_word_count;
                }
			}
		}

		/* SEM */
		$analysis['backlinks'] = array(
			'alexa' => Set::extract('{n}.backlinks.alexa', $competitors_data),
			'google' => Set::extract('{n}.backlinks.google', $competitors_data),
			'yahoo' => Set::extract('{n}.backlinks.yahoo', $competitors_data)
		);
		$analysis['alexa_rank'] = Set::extract('{n}.alexa_rank', $competitors_data);
		$analysis['age'] = Set::extract('{n}.age', $competitors_data);
		$data = array(
			'Analysis' => $analysis,
			'Data'	=> array(
				'Site' => $site_data,
				'Competitors' => $competitors_data
			)
		);

		$data['Data']['Site']['h1_array'] = $h1_array;

		return $data;
	}

	private function __string2keywords($page) {
		$page = $this->BaseTools->html2text($page);

		/**
		 * Default map of accented and special characters to ASCII characters
		 *
		 * @var array
		 * @access protected
		 */
		$replacement = array(
			'/ä|æ|ǽ/' => 'ae',
			'/ö|œ/' => 'oe',
			'/ü/' => 'ue',
			'/Ä/' => 'Ae',
			'/Ü/' => 'Ue',
			'/Ö/' => 'Oe',
			'/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
			'/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
			'/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
			'/ç|ć|ĉ|ċ|č/' => 'c',
			'/Ð|Ď|Đ/' => 'D',
			'/ð|ď|đ/' => 'd',
			'/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
			'/è|é|ê|ë|ē|ĕ|ė|ę|ě/' => 'e',
			'/Ĝ|Ğ|Ġ|Ģ/' => 'G',
			'/ĝ|ğ|ġ|ģ/' => 'g',
			'/Ĥ|Ħ/' => 'H',
			'/ĥ|ħ/' => 'h',
			'/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/' => 'I',
			'/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/' => 'i',
			'/Ĵ/' => 'J',
			'/ĵ/' => 'j',
			'/Ķ/' => 'K',
			'/ķ/' => 'k',
			'/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
			'/ĺ|ļ|ľ|ŀ|ł/' => 'l',
			'/Ñ|Ń|Ņ|Ň/' => 'N',
			'/ñ|ń|ņ|ň|ŉ/' => 'n',
			'/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
			'/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
			'/Ŕ|Ŗ|Ř/' => 'R',
			'/ŕ|ŗ|ř/' => 'r',
			'/Ś|Ŝ|Ş|Š/' => 'S',
			'/ś|ŝ|ş|š|ſ/' => 's',
			'/Ţ|Ť|Ŧ/' => 'T',
			'/ţ|ť|ŧ/' => 't',
			'/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
			'/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
			'/Ý|Ÿ|Ŷ/' => 'Y',
			'/ý|ÿ|ŷ/' => 'y',
			'/Ŵ/' => 'W',
			'/ŵ/' => 'w',
			'/Ź|Ż|Ž/' => 'Z',
			'/ź|ż|ž/' => 'z',
			'/Æ|Ǽ/' => 'AE',
			'/ß/'=> 'ss',
			'/Ĳ/' => 'IJ',
			'/ĳ/' => 'ij',
			'/Œ/' => 'OE',
			'/ƒ/' => 'f',
			'/[^ a-zA-Z\s]/' => '',
			'/[ ]{2,}/' => ' '
		);

		$page = preg_replace(array_keys($replacement), array_values($replacement), $page);
		$page = explode(' ', $page);

		foreach ($page as $key => $word) {
			if (strlen($word) == 1) {
				unset($page[$key]);
            }
		}

		$page = implode(' ', $page);
		$page = strtolower($page);

        if (isset($Controller->data['Tool']['exclude_words']) && !empty($Controller->data['Tool']['exclude_words'])) {
            $ew = explode("\n", $Controller->data['Tool']['exclude_words']);
            $page = $this->__exclude_words($page, $ew);
        }

		return $page;
	}     
    
	public function word_position($source, $word) {
		$source = $this->__exclude_words($source);
		$strpos = strpos(strtolower($source), strtolower($word));

		return ($strpos === false ? 0 : $strpos+1);
	}

	public function words_count($source) {
		$source = $this->__string2keywords($source);
		$words  = str_word_count($source, 1);

		return count($words);
	}

	public function word_occurr($source, $word) {
		$source = $this->__string2keywords($source);
		$word = strtolower($word);
		$words = str_word_count($source, 1);
		$word_c = str_word_count($word, 1);  // words of keyword
		$occurr = 0;

		foreach ($words as $index => $_word) {
			if (count($word_c) > 0) {
				$sub_occurr = 0;

				for ($i = 0; $i < count($word_c); $i++) {
					$sub_occurr = (isset($words[$index+$i]) && $words[$index+$i] == $word_c[$i]) ? $sub_occurr+1 : $sub_occurr;
				}

				$occurr = ($sub_occurr == count($word_c)) ? $occurr + 1 : $occurr;
			} else {
				$occurr = ($_word == $word) ? $occurr + 1 : $occurr;
			}
		}

        $this->tmp = count($words);

		return $occurr;
	}

	public function word_density($source, $word) {
		$occurr = $this->word_occurr($source, $word);
		$words = str_word_count($source, 1);
        
		return number_format(($occurr * 100) / count($words), 2);
	}

	public function getSnippet($keywords, $engine = 'google.com', $limit = 10) {
        $this->EngineParser->BaseTools = $this->BaseTools;
        $this->EngineParser->loadEngine($engine);

        return $this->EngineParser->parse($keywords, $limit);
	}

	public function parseTag($tag, $haystack, $all = false) {
		$pattern = '/\<' . $tag . '(.*)\>(.*)\<\/' . $tag . '\>/iUs';

        if ($all) {
			preg_match_all($pattern, $haystack, $matches);
		} else {
			preg_match($pattern, $haystack, $matches);
		}

		$matches = isset($matches[2]) ? $matches[2] : '';

		return $matches;
	}  

	private function __exclude_words($str, $exclude_words = array()) {
		foreach ($exclude_words as $filter_word) {
			$str = preg_replace(array('/[ ]{2,}/', '/\b' . strtolower($filter_word) . '\b/i'), array(' ', ''), $str);
		}

		return $str; 
	}    
}