<?php
class Google {
	public function main($keywords, $domain = 'google.com', $limit = 10) {
        $out = array();

		if (strpos($domain, 'google.') !== false) {
			$q = urlencode($keywords);
			$query = "http://www.{$domain}/search?q={$q}&oq={$q}&num=10";
			$exp = '/<li class="g">(.*)<\/li>/iUs';
            $results = $this->BaseTools->toUTF8($this->BaseTools->getPage($query));

            preg_match_all($exp, $results, $matches);

            foreach ($matches[1] as $data) {
                $out[] = array(
                    'url' => $this->__getUrl($data),
                    'title' => $this->__getTitle($data),
                    'snippet' => $this->__getSnippet($data)
                );
            }        
        }

		return $out;
	}

	private function __getUrl($data) {
		preg_match('/<h3 class="r"><a href="(.*)".+?>/iUs', $data, $url);

		list($url, $dummy) = explode('&sa=', html_entity_decode(urldecode($url[1])));
		$url = str_replace('/url?q=', '', $url);

		return $url;
	}

	private function __getTitle($data) {
		preg_match('/<h3 class="r">(.*)<\/h3>/iUs', $data, $title);

		return strip_tags($title[1]);
	}

	private function __getSnippet($data) {
		preg_match('/<span class="st">(.*)<\/span>/iUs', $data, $snippet);

		return strip_tags($snippet[1]);
	}
}