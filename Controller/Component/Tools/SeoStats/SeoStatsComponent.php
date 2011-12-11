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
                        'backlinksYahoo' => $this->getBacklinksYahoo($url),
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

	function getPagerank($url) {
		$chwrite = $this->__CheckHash($this->__HashURL($url));
		$url="http://toolbarqueries.google.com/search?client=navclient-auto&ch=".$chwrite."&features=Rank&q=info:".$url."&num=100&filter=0";			
		$data = $this->BaseTools->getPage($url);
		
        preg_match('#Rank_[0-9]:[0-9]:([0-9]+){1,}#si', $data, $p);
		
        $value = isset($p[1]) ? $p[1] : 0;
		
        return $value;
	} 
    
	function checkFake($url) {
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
		$url = "http://www.dmoz.org/search?q=$url";
		$data = $this->BaseTools->getPage($url);

        if (preg_match('/\<strong\>Open Directory Sites\<\/strong\>/', $data)) {
			$value = 1;
		} else {
			$value = 0;
		}

		return $value;
	}   

	function getYahooDirectory($host) {
		$url = preg_replace('/www\./', '', $host);
		$url = "http://search.yahoo.com/search/dir?p={$url}";
		$data = $this->BaseTools->getPage($url);

        if (stripos('No Directory Search results were found.', $data) !== false) {
			$value = 0;
		} else {
			$value = 1;
		}

		return $value;
	}   

	function getBacklinksYahoo($url) {
		$url01 = 'http://siteexplorer.search.yahoo.com/search?p='. urlencode("$url") . '&bwm=i&bwmo=d&bwmf=u';
		$data01 = $this->BaseTools->getPage($url01);

        preg_match('/Inlinks \(([0-9\,]+)\)/si', $data01, $p01);

        $value01 = isset($p01[1]) ? number_format($this->BaseTools->toInt($p01[1])) : 0;
		$value01 = str_replace(",", "", $value01);
		$url02 = 'http://siteexplorer.search.yahoo.com/search?p=www.' . urlencode("$url") . '&bwm=i&bwmo=d&bwmf=u';
		$data02 = $this->BaseTools->getPage($url02);

        preg_match('/Inlinks \(([0-9\,]+)\)/si', $data02, $p02);

        $value02 = isset($p02[1]) ? number_format($this->BaseTools->toInt($p02[1])) : 0;
		$value02 = str_replace(",", "", $value02);

		if ($value01 > $value02) {
			$value = number_format($this->BaseTools->toInt($value01));
		} else {
			$value = number_format($this->BaseTools->toInt($value02));
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
  
	function getAlexaRank($url) {
		$url = 'http://data.alexa.com/data?cli=10&url=' . $url;
		$data = $this->BaseTools->getPage($url);

        preg_match('/TEXT="(.*?)"/i', $data, $p);

        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;

        return $value;
	}    
    
	function getAge($host) {
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
    
	function getGooglebotLastAccess($url) {
		$url = 'http://webcache.googleusercontent.com/search?q=cache:'.$url.'&cd=1&hl=en&ct=clnk';
		$data = $this->BaseTools->getPage($url); 

        preg_match('/appeared on (.*?). The/i', $data, $p);
		
        $value = isset($p[1]) ? $p[1] : 'No Data';
		
        return $value;
	}   

	function getSiteValue($url) {
		$url = (strpos($url, 'www.') === false) ? "www.{$url}" : $url;
		$url = str_replace(array('http://', 'https://', 'ftp://'), '', $url);
		$url = "http://www.websiteoutlook.com/" . urlencode($url);
		$data = $this->BaseTools->getPage($url);
		
        preg_match('/Estimated Worth (.*) by websiteoutlook/i', $data, $p);
		
        $value = isset($p[1]) ? $p[1] : false;
		
        return $value;
	} 

	function bingIndexed($url) {
		$url = 'http://www.bing.com/search?q=site%3A' . urlencode($url) . '&mkt=en-US&setlang=match&FORM=W0FD&smkt=es-US';
		$data = $this->BaseTools->getPage($url); 
		
        preg_match('/of (.*?) results/i', $data, $p);
		
        $value = isset($p[1]) ? $p[1] : 0;
		
        return $value;
	}    
    
	function googleIndexed($url) {
		$url = 'http://www.google.com/search?q=site%3A' . urlencode($url) . '&hl=en';
		$data = $this->BaseTools->getPage($url);

        preg_match('/About ([0-9\,]+) (results|result)/si', $data, $p);

        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;

        return $value;
	}
	
	function yahooIndexed($url) {
		$url = 'http://siteexplorer.search.yahoo.com/search?p=' . urlencode("http://{$url}");
		$data = $this->BaseTools->getPage($url);
		
        preg_match('/Pages \(([0-9\,]+)\)/si', $data, $p);
		
        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	}  

	//get digg links
	function diggLinks($url) {
		$url = 'http://digg.com/search?q=site%3A' . $url;
		$data = $this->BaseTools->getPage($url);
		
        preg_match('/s.prop2 = \'(.*?)\'/i', $data, $p);
		
        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	}
    

	function deliciousLinks($url) {
		$url = "http://" . $url . "/";
		$hash = md5($url);
		$url = 'http://delicious.com/url/' . $hash;
		$data = $this->BaseTools->getPage($url);
		
        preg_match('/Saved (.*?) times/i', $data, $p);
		
        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	}	

	function technoratiRank($url) {
		$url = 'http://technorati.com/blogs/' . $url;
		$data = $this->BaseTools->getPage($url);
		
        preg_match('/<span class="blog-authorities-number">(.*?)<\/span>/i', $data, $p);
		
        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	} 

	function competeRank($url) {
		$url = 'http://siteanalytics.compete.com/' . $url . '/';
		$data = $this->BaseTools->getPage($url);

        preg_match('/\(rank #(.*?)\)/i', $data, $p);

        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;

        return $value;
	}
    
/* 
 * Genearate a hash for a url 
 */ 
	function __HashURL($String) {
		$Check1 = $this->__StrToNum($String, 0x1505, 0x21); 
		$Check2 = $this->__StrToNum($String, 0, 0x1003F); 

		$Check1 >>= 2;      
		$Check1 = (($Check1 >> 4) & 0x3FFFFC0) | ($Check1 & 0x3F); 
		$Check1 = (($Check1 >> 4) & 0x3FFC00) | ($Check1 & 0x3FF); 
		$Check1 = (($Check1 >> 4) & 0x3C000) | ($Check1 & 0x3FFF);    
		
		$T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2) | ($Check2 & 0xF0F); 
		$T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000); 
		
		return ($T1 | $T2); 
	}    

/**
 * genearate a checksum for the hash string 
 */ 
	function __CheckHash($Hashnum) {
		$CheckByte = 0; 
		$Flag = 0; 

		$HashStr = sprintf('%u', $Hashnum) ; 
		$length = strlen($HashStr); 
		
		for ($i = $length - 1;  $i >= 0;  $i --) { 
			$Re = $HashStr{$i}; 
            
			if (1 === ($Flag % 2)) {              
				$Re += $Re;      
				$Re = (int)($Re / 10) + ($Re % 10); 
			} 
            
			$CheckByte += $Re; 
			$Flag ++;    
		} 

		$CheckByte %= 10; 
        
		if (0 !== $CheckByte) { 
			$CheckByte = 10 - $CheckByte; 
            
			if (1 === ($Flag % 2)) { 
				if (1 === ($CheckByte % 2)) { 
					$CheckByte += 9; 
				} 
                
				$CheckByte >>= 1; 
			} 
		} 

		return '7' . $CheckByte.$HashStr; 
	}
    
	function __StrToNum($Str, $Check, $Magic) {
		$Int32Unit = 4294967296;  // 2^32 
		$length = strlen($Str); 
        
		for ($i = 0; $i < $length; $i++) { 
			$Check *= $Magic;      
			//If the float is beyond the boundaries of integer (usually +/- 2.15e+9 = 2^31), 
			//  the result of converting to integer is undefined 
			//  refer to http://www.php.net/manual/en/language.types.integer.php 
			if ($Check >= $Int32Unit) { 
				$Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit)); 
				//if the check less than -2^31 
				$Check = ($Check < -2147483648) ? ($Check + $Int32Unit) : $Check; 
			} 
            
			$Check += ord($Str{$i}); 
		}
        
		return $Check; 
	}     
    
}