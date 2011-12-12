<?php 
class KeywordExtractorComponent extends Component {
    protected $Controller;

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

        $this->Controller = $Controller;
		$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
		$page = $this->BaseTools->getPage($parseUrl['full']);
		$page = $this->__string2keywords($page);

        if (empty($page)) {
            return array(
                'words_1' => '',
                'words_2' => '',
                'words_3' => '',
                'words_all' => ''
            );
        }

		include_once dirname(__FILE__) . DS . 'Autokeyword.php';

		$opts = array(
			'content' => $page,					//page content
			'min_word_length' => 2,				//minimum length of single words
			'min_word_occur' => 1,				//minimum occur of single words
			'min_2words_length' => 2,			//minimum length of words for 2 word phrases
			'min_2words_phrase_length' => 2,	//minimum length of 2 word phrases
			'min_2words_phrase_occur' => 2,		//minimum occur of 2 words phrase
			'min_3words_length' => 2,			//minimum length of words for 3 word phrases
			'min_3words_phrase_length' => 2,	//minimum length of 3 word phrases
			'min_3words_phrase_occur' => 1		//minimum occur of 3 words phrase
		);
		$keyword = new Autokeyword($opts, 'utf-8');
		$out = array(
			'words_1' => $keyword->parse_words(),
			'words_2' => $keyword->parse_2words(),
			'words_3' => $keyword->parse_3words(),
			'words_all' => $keyword->get_keywords()
		);

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
        
        $page = html_entity_decode($page);
		$page = preg_replace(array_keys($replacement), array_values($replacement), $page);
		$page = explode(' ', $page);

		foreach ($page as $key => $word) {
			if (strlen($word) == 1) {
				unset($page[$key]);
            }
		}

		$page = implode(' ', $page);
		$page = strtolower($page);

        if (isset($this->Controller->data['Tool']['exclude_words']) && !empty($this->Controller->data['Tool']['exclude_words'])) {
            $ew = explode("\n", $this->Controller->data['Tool']['exclude_words']);
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
}