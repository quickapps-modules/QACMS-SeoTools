<?php
class Google {
	public function main($keywords, $domain = 'google.com', $limit = 10) {
        $out = array();

		if (strpos($domain, 'google.') !== false) {
			$query = "http://www.{$domain}/search?q=" . urlencode($keywords) ."&num=10";
			$exp = '/<li class="g">(.*)<\/li>/iUs';
            $results = $this->BaseTools->toUTF8($this->BaseTools->getPage($query));

            preg_match_all($exp, $results, $matches);

            foreach ($matches[1] as $data) {
                $out[] = array(
                    'url' => $this->__getUrl($data),
                    'title' => $this->__getTitle($data),
                    'cache_url' => $this->__getCacheUrl($data),
                    'snippet' => $this->__getSnippet($data)
                );
            }        
        }

		return $out;
	}

	private function __getUrl($data) {
		preg_match('/<h3 class="r"><a href="(.*)" .+?>/iUs', $data, $url);

		return $url[1];
	}

	private function __getTitle($data) {
		preg_match('/<h3 class="r">(.*)<\/h3>/iUs', $data, $title);

		return strip_tags($title[1]);
	}

	private function __getCacheUrl($data) {
		preg_match('/<span class="vshid"><a href="(.*)">.+?<\/a><\/span>/iUs', $data, $cacheUrl);

		return $cacheUrl[1];
	}

	private function __getSnippet($data) {
		preg_match('/<span class="st">(.*)<\/span>/iUs', $data, $snippet);

		return strip_tags($snippet[1]);
	}
}