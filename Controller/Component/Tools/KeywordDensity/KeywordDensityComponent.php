<?php 
class KeywordDensityComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

		$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
		$page = $this->BaseTools->getPage($parseUrl['full']);
		$page = $this->__string2keywords($page);
		$words = str_word_count($page, 1);
		$words = array_unique($words);

		foreach ($words as &$word) {
			$out[$word] = $this->__word_density($page, $word);
		}

		return $out;
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

	private function __exclude_words($str, $exclude_words = array()) {
		foreach ($exclude_words as $filter_word) {
			$str = preg_replace(array('/[ ]{2,}/', '/\b' . strtolower($filter_word) . '\b/i'), array(' ', ''), $str);
		}

		return $str; 
	}

	private function __word_density($source, $word) {
		$occurr = $this->__word_occurr($source, $word);
		$words = str_word_count($source, 1);

		return number_format(($occurr * 100) / count($words), 2);
	}

	private function __word_occurr($source, $word) {
		$source = $this->__string2keywords($source);
		$word = strtolower($word);
		$words = str_word_count($source, 1);
		$word_c = str_word_count($word, 1);  // words of keyword
		$occurr = 0;

		foreach ($words as $index => $_word) {
			if (count($word_c) > 0) {
				$sub_occurr = 0;
                
				for ($i = 0; $i < count($word_c); $i++) {
					$sub_occurr = ($words[$index+$i] == $word_c[$i]) ? $sub_occurr+1 : $sub_occurr;
				}
                
				$occurr = ($sub_occurr == count($word_c)) ? $occurr + 1 : $occurr;
			} else {
				$occurr = ($_word == $word) ? $occurr + 1 : $occurr;
			}
		}

		return $occurr;
	}    
}