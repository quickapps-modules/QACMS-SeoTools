<?php
class Google {
	public function main($keywords, $domain = 'google.com', $limit = 10) {
        $out = array();

		if (strpos($domain, 'google.') !== false) {
			$query = "http://www.{$domain}/search?q=" . urlencode($keywords) ."&num=10";
			$exp = '@<li class=g><div class=vsc.*?><.*? class="?r"?>.+?href="(.+?)".*?>(.+?)<\/a>.+?<span class=vshid><a href="(.+?)".*?>.+?<\/a>.+?<span class=st>(.+?)<br><\/span>.+?@m';
            $results = $this->BaseTools->toUTF8($this->BaseTools->getPage($query));

            preg_match_all($exp, $results, $matches, PREG_SET_ORDER);

            foreach ($matches as $pos => $data) {
                $out[] = array(
                    'url' => strip_tags($data[1]),
                    'title' => strip_tags($data[2]),
                    'cache_url' => strip_tags($data[3]),
                    'snippet' => strip_tags($data[4])
                );
            }        
        }

		return $out;
	}
}