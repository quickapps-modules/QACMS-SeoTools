<?php
class SeoStatsComponent extends Component {
    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

        Cache::config('seo_stats_short', array(
            'engine' => 'File',  
            'duration'=> '+3 days',
            'path' => CACHE
        ));

        $url = $Controller->data['Tool']['url'];
        $results = Cache::read('seo_stats_'. md5($url), 'seo_stats_short');

        if (!$results) {
            $parseUrl = $this->BaseTools->parseUrl($url);
            $results = array(
				'url' => $parseUrl['host'],
				'pagerank' => $this->getPagerank($parseUrl['full']),
				'validrank' => $this->checkFake($url),
				'dmoz' => $this->getDmoz($parseUrl['host']),
				'yahooDirectory' => $this->getYahooDirectory($parseUrl['host']),
				'backlinksGoogle' => $this->getBacklinksGoogle($url),
				'alexabacklink' => $this->getBacklinkAlexa($url),
				'alexarank' => $this->getAlexaRank($url),
				'age' => $this->getAge($parseUrl['host']),
				'googlebot' => $this->getGooglebotLastAccess($url),
				'sitevalue' => $this->getSiteValue($url),
				'bingindexed' => $this->bingIndexed($url),
				'googleindexed' => $this->googleIndexed($url),
				'yahooindexed' => $this->yahooIndexed($url),
				'digglinks' => $this->diggLinks($url),
				'deliciouslinks' => $this->deliciousLinks($url),
				'technoratirank' => $this->technoratiRank($url),
				'competerank' => $this->competeRank($url)
            );

            Cache::write('seo_stats_'. md5($url), $results, 'seo_stats_short');
        }

        return $results;
    }

	public function getPagerank($url) {
		$pageRank = $this->BaseTools->loadTool('PageRank');

		return $pageRank->getpageRank($url);
	} 

	public function checkFake($url) {
		$siteurl = 'http://www.google.com/search?q=info:' . $url . '&cd=1&hl=en&ct=clnk';
		$data = $this->BaseTools->getPage($siteurl); 
		
        preg_match('/<cite>(.*?)<\/cite>/i', $data, $p);
		
        $datatext = isset($p[1]) ? $p[1] : '';
		
		if (stripos($url, $datatext) !== false) {
			$value = "1";
		} else {
			$value = "0";
		}
        
		return $value;
	}   

	function getDmoz($host) {
		$url = preg_replace('/www\./', '', $host);
		$url = "http://www.dmoz.org/search?q={$url}";
		$data = $this->BaseTools->getPage($url);

        if (preg_match('/\<strong\>Open Directory Sites\<\/strong\>/', $data)) {
			$value = 1;
		} else {
			$value = 0;
		}

		return $value;
	}   

	public function getYahooDirectory($host) {
		$url = preg_replace('/www\./', '', $host);
		$url = "http://dir.search.yahoo.com/search?p={$url}";
		$data = $this->BaseTools->getPage($url);

        if (preg_match('/We did not find results for/i', $data)) {
			$value = 0;
		} else {
			$value = 1;
		}

		return $value;
	}

	public function getBacklinksGoogle($url) {
		$url = 'http://www.google.com/search?q=link:' . urlencode($url) . '&hl=en';
		$data = $this->BaseTools->getPage($url);

        preg_match('/([0-9\,]+) (results|result)<nobr>/si', $data, $p);

        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;

        return $value;
	}
    
	public function getBacklinkAlexa($url) {
		$url = 'http://data.alexa.com/data?cli=10&dat=s&url=' . $url;
		$data = $this->BaseTools->getPage($url);

        preg_match('/LINKSIN NUM="(.*?)"/i', $data, $p);

        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	}
  
	public function getAlexaRank($url) {
		$url = 'http://data.alexa.com/data?cli=10&url=' . $url;
		$data = $this->BaseTools->getPage($url);

        preg_match('/TEXT="(.*?)"/i', $data, $p);

        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;

        return $value;
	}    
    
	public function getAge($host) {
		$url = preg_replace('/www\./', '', $host);
		$url = "http://www.who.is/whois/{$url}";
		$data = $this->BaseTools->getPage($url);

        preg_match('#Creation Date: ([a-z0-9-]+)#si', $data, $p);

        if (isset($p[1])) {
			$time = time() - strtotime($p[1]);
			$years = floor($time / 31556926);
			$days = round(($time % 31556926) / 86400);
			$value = array('years' => $years, 'days' => $days);
		} else {
			$value = 0;
		}

		return $value;
	}
    
	public function getGooglebotLastAccess($url) {
		$url = 'http://webcache.googleusercontent.com/search?q=cache:'.$url.'&cd=1&hl=en&ct=clnk';
		$data = $this->BaseTools->getPage($url); 

        preg_match('/appeared on (.*?). The/i', $data, $p);
		
        $value = isset($p[1]) ? $p[1] : 'No Data';
		
        return $value;
	}   

	public function getSiteValue($url) {
		$url = (strpos($url, 'www.') === false) ? "www.{$url}" : $url;
		$url = str_replace(array('http://', 'https://', 'ftp://'), '', $url);
		$url = "http://www.websiteoutlook.com/" . urlencode($url);
		$data = $this->BaseTools->getPage($url);
		
        preg_match('/Estimated Worth (.*) by websiteoutlook/i', $data, $p);
		
        $value = isset($p[1]) ? $p[1] : false;
		
        return $value;
	} 

	public function bingIndexed($url) {
		$url = 'http://www.bing.com/search?q=site:' . urlencode($url) . '&mkt=en-US&setlang=match&FORM=W0FD&smkt=es-US';
		$data = $this->BaseTools->getPage($url); 

        preg_match('/<span.+?id="count">(.*?) results<\/span>/i', $data, $p);

        $value = isset($p[1]) ? $p[1] : 0;
		
        return $value;
	}    
    
	public function googleIndexed($url) {
		$url = 'http://www.google.com/search?q=site%3A' . urlencode($url) . '&hl=en';
		$data = $this->BaseTools->getPage($url);

        preg_match('/About ([0-9\,]+) (results|result)/si', $data, $p);

        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;

        return $value;
	}
	
	public function yahooIndexed($url) {
		$url = 'http://search.yahoo.com/search?p=site%3A' . $url;
		$data = $this->BaseTools->getPage($url);
		
        preg_match('/resultCount\">(.*?)<\/span>/i', $data, $p);
		
        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	}  

	public function diggLinks($url) {
		$url = 'http://digg.com/search?q=site%3A' . $url;
		$data = $this->BaseTools->getPage($url);

        preg_match('/Digg - (.*?) Results For/i', $data, $p);
		
        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	}
    

	public function deliciousLinks($url) {
		$url = "http://" . $url . "/";
		$hash = md5($url);
		$url = 'http://feeds.delicious.com/v2/json/urlinfo/' . $hash;
		$data = $this->BaseTools->getPage($url);
		
        preg_match('/\"total_posts\"\:(.*?)\,/i', $data, $p);
		
        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	}	

	public function technoratiRank($url) {
		$url = 'http://technorati.com/blogs/' . $url;
		$data = $this->BaseTools->getPage($url);
		
        preg_match('/<span class="blog-authorities-number">(.*?)<\/span>/i', $data, $p);
		
        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	} 

	public function competeRank($url) {
		$url = 'http://siteanalytics.compete.com/' . $url . '/';
		$data = $this->BaseTools->getPage($url);

		preg_match('/delta-positive">(.*?)<\/h4>/i', $data, $p);

		$value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;

		return $value;
	}
}