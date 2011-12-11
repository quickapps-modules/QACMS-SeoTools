<?php 
class LinkExtractorComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

		$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
		$page = $this->BaseTools->getPage($parseUrl['full']);

		preg_match_all ("/a[\s]+[^>]*?href[\s]?=[\s\"\']+" . "(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/", $page, $matches);

		if (isset($matches[1])) {
			foreach ($matches[1] as  $index => &$link) {
				$link = strtolower($link);

				if (substr($link, 0, 1) == '/' || substr($link, 0, 1) == '.') {
					$link = $parseUrl['full'] . $link;
				} elseif(substr($link, 0, 11) == 'javascript:' || substr($link, 0, 7) == 'mailto:') {
					unset($matches[1][$index]);
				} elseif (substr($link, 0, 7) != 'http://' && substr($link, 0, 8) != 'https://') {
					$link = $parseUrl['full'] . '/' . $link;
				}
				
				$link = $this->BaseTools->toUTF8($link);
			}

			return array_unique($matches[1]);
		}

		return false;        
    }
}