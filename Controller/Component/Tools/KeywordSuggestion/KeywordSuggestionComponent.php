<?php 
class KeywordSuggestionComponent extends Component {
    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['query'], $Controller->data['Tool']['language'])) {
            return false;
        }

		Cache::config('seo_tools_suggestions',
			array(
				'engine' => 'File',
				'path' => TMP . 'cache' . DS,
				'duration' => '+5 minutes'
			)
		);

		$suggestions = array();
		$query = $Controller->data['Tool']['query'];
		$language = $Controller->data['Tool']['language'];

		if ($cache = Cache::read('suggestions_' . md5($query . $language), 'seo_tools_suggestions')) {
			return $cache;
		} else {
			$s = $this->__getSuggestions($query, $language);

			if ($s === false) {
				$Controller->flashMsg(__d('seo_tools', 'Unable to connect to Google Suggest service, try again later.'), 'error');
				return false;
			} else {
				$suggestions[$query] = $s[1];

				foreach (range('a', 'z') as $letter) {
					$s = $this->__getSuggestions("{$query} {$letter}", $language);
					$suggestions["{$query} + {$letter}"] = $s[1];
				}

				foreach (range(0, 9) as $digit) {
					$s = $this->__getSuggestions("{$query} {$digit}", $language);
					$suggestions["{$query} + {$digit}"] = $s[1];
				}

				Cache::write('suggestions_' . md5($query . $language), $suggestions, 'seo_tools_suggestions');

				return $suggestions;
			}
		}
	}

	private function __getSuggestions($query, $language) {
		$gs = "http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl={$language}&q=" . urlencode($query);
		$html = $this->BaseTools->getPage($gs);

		if ($html) {
			$data = json_decode($html, true);

			return (array)$data;
		}

		return false;
	}
}