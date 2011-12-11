<?php
class SeoToolsComponent extends Object {
        
	var $url;
	var $tmp;
	
	function set_url($url) {
		set_time_limit(0);
		$this->url = parse_url('http://' . ereg_replace('^http://', '', $url));
		$this->url['full'] = 'http://' . ereg_replace('^http://', '', $url);
	}

	function getPage($url = null) {
		$url = $url === null ? $this->url['full'] : $url;
		if (function_exists('curl_init')) {
			$ch = curl_init($url);
			
			$options = array(
				CURLOPT_RETURNTRANSFER => true,     // return web page
				CURLOPT_HEADER         => false,    // don't return headers
				CURLOPT_FOLLOWLOCATION => true,     // follow redirects
				CURLOPT_ENCODING       => "",       // handle all encodings
				CURLOPT_USERAGENT      => env('HTTP_USER_AGENT'), // who am i
				CURLOPT_AUTOREFERER    => true,     // set referer on redirect
				CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
				CURLOPT_TIMEOUT        => 120,      // timeout on response
				CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			);
			@curl_setopt_array( $ch, $options );
			return curl_exec($ch);
		} else {

			return file_get_contents($url);
		}
	}

	function getPagerank ($url = null) {
		$url = $url === null ? $this->url['full'] : $url;
		$chwrite = $this->__CheckHash($this->__HashURL($url));
	
		$url="http://toolbarqueries.google.com/search?client=navclient-auto&ch=".$chwrite."&features=Rank&q=info:".$url."&num=100&filter=0";			
		$data = $this->getPage($url);
		preg_match('#Rank_[0-9]:[0-9]:([0-9]+){1,}#si', $data, $p);
		$value = isset($p[1]) ? $p[1] : 0;
		return $value;
	}

	function getAlexaRank ($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
	
		// for PHP 4.x and PHP 5.x
		$url = 'http://data.alexa.com/data?cli=10&url='.$url;
		$data = $this->getPage($url);
		preg_match('/TEXT="(.*?)"/i', $data, $p);
		$value = isset($p[1]) ? number_format($this->toInt($p[1])) : 0;
		return $value;
	}
	
	function getDmoz () {
		$url = ereg_replace('^www\.', '', $this->url['host']);
		$url = "http://www.dmoz.org/search?q=$url";
		$data = $this->getPage($url);
		if (ereg('<strong>Open Directory Sites</strong>', $data)) {
			$value = 1;
		} else {
			$value = 0;
		}
		return $value;
	}
        
	function getYahooDirectory() {
		$url = ereg_replace('^www\.', '', $this->url['host']);
		$url = "http://search.yahoo.com/search/dir?p=$url";
		$data = $this->getPage($url);
		if (ereg('No Directory Search results were found\.', $data)) {
			$value = 0;
		} else {
			$value = 1;
		}
		return $value;
	}
	
	function getBacklinksGoogle () {
		$url = $this->url['host'];
		$url = 'http://www.google.com/search?q=link:'.urlencode($url).'&hl=en';
		$data = $this->getPage($url);
		preg_match('/([0-9\,]+) (results|result)<nobr>/si', $data, $p);
		$value = isset($p[1]) ? number_format($this->toInt($p[1])) : 0;
		return $value;

	}

	function getBacklinksYahoo () {
		$url = $this->url['host'];
		
		$url01 = 'http://siteexplorer.search.yahoo.com/search?p='.urlencode("$url").'&bwm=i&bwmo=d&bwmf=u';
		$data01 = $this->getPage($url01);
		preg_match('/Inlinks \(([0-9\,]+)\)/si', $data01, $p01);
		$value01 = isset($p01[1]) ? number_format($this->toInt($p01[1])) : 0;
		$value01 = str_replace(",", "", $value01);
		
		$url02 = 'http://siteexplorer.search.yahoo.com/search?p=www.'.urlencode("$url").'&bwm=i&bwmo=d&bwmf=u';
		$data02 = $this->getPage($url02);
		preg_match('/Inlinks \(([0-9\,]+)\)/si', $data02, $p02);
		$value02 = isset($p02[1]) ? number_format($this->toInt($p02[1])) : 0;
		$value02 = str_replace(",", "", $value02);
					
		if ($value01 > $value02) {
			$value = number_format($this->toInt($value01));
		} else {
			$value = number_format($this->toInt($value02));
		}
		
		return $value;
	}     
        
	function getAge() {
		$url = ereg_replace('^www\.', '', $this->url['host']);
		$url = "http://www.who.is/whois/{$url}";
		$data = $this->getPage($url);
		preg_match('#Creation Date: ([a-z0-9-]+)#si', $data, $p);
		if ( isset($p[1]) ) {
			$time = time() - strtotime($p[1]);
			$years = floor($time / 31556926);
			$days = round(($time % 31556926) / 86400);
			$value = array(
				'years' => $years,
				'days' => $days
			);
		} else {
			$value = 0;
		}
		return $value;
	}


	//get alexa backlink
	function getAlexaBacklink ($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		// for PHP 4.x and PHP 5.x
		$url = 'http://data.alexa.com/data?cli=10&dat=s&url='.$url;
		$data = $this->getPage($url);
		preg_match('/LINKSIN NUM="(.*?)"/i', $data, $p);
		$value = isset($p[1]) ? number_format($this->toInt($p[1])) : 0;
		return $value;
	}		
	
	//get googlebot last access 
	function get_googlebot_lastaccess($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		$url = 'http://webcache.googleusercontent.com/search?q=cache:'.$url.'&cd=1&hl=en&ct=clnk';
		$data = $this->getPage($url); 
		preg_match('/appeared on (.*?). The/i', $data, $p);
		$value = isset($p[1]) ? $p[1] : 'No Data';
		return $value;
	
	}

	//get site value $dollar 
	function getSiteValue ($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		$url = ( strpos($url, 'www.') === false ) ? "www.{$url}" : $url;
		$url = str_replace(array('http://', 'https://', 'ftp://'), '', $url);
		$url = "http://www.websiteoutlook.com/".urlencode($url);
		$data = $this->getPage($url);
		preg_match('/Estimated Worth (.*) by websiteoutlook/i', $data, $p);
		$value = isset($p[1]) ? $p[1] : false;
		return $value;
	}
	
	//get bing indexed pages 
	function bing_indexed($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		$url = 'http://www.bing.com/search?q=site%3A'.urlencode($url).'&mkt=en-US&setlang=match&FORM=W0FD&smkt=es-US';
		$data = $this->getPage($url); 
		preg_match('/of (.*?) results/i', $data, $p);
		$value = isset($p[1]) ? $p[1] : 0;
		return $value;
	}
	
	//get google indexed pages 
	function google_indexed ($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		$url = 'http://www.google.com/search?q=site%3A'.urlencode($url).'&hl=en';
		$data = $this->getPage($url);
		preg_match('/About ([0-9\,]+) (results|result)/si', $data, $p);
		$value = isset($p[1]) ? number_format($this->toInt($p[1])) : 0;
		return $value;
	}
	
	//get yahoo indexed pages 
	function yahoo_indexed () {
		$url = $this->url['host'];
		$url = 'http://siteexplorer.search.yahoo.com/search?p='.urlencode("http://$url");
		$data = $this->getPage($url);
		preg_match('/Pages \(([0-9\,]+)\)/si', $data, $p);
		$value = isset($p[1]) ? number_format($this->toInt($p[1])) : 0;
		return $value;
	}
	
	//get digg links
	function digg_links ($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		$url = 'http://digg.com/search?q=site%3A'.$url;
		$data = $this->getPage($url);
		preg_match('/s.prop2 = \'(.*?)\'/i', $data, $p);
		$value = isset($p[1]) ? number_format($this->toInt($p[1])) : 0;
		return $value;
	}
	
	//get delicious links
	function delicious_links ($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		$url = "http://".$url."/";
		$hash = md5($url);
		$url = 'http://delicious.com/url/'.$hash;
		$data = $this->getPage($url);
		preg_match('/Saved (.*?) times/i', $data, $p);
		$value = isset($p[1]) ? number_format($this->toInt($p[1])) : 0;
		return $value;
	}
	
	//get technorati rank
	function technorati_rank ($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		$url = 'http://technorati.com/blogs/'.$url;
		$data = $this->getPage($url);
		preg_match('/<span class="blog-authorities-number">(.*?)<\/span>/i', $data, $p);
		$value = isset($p[1]) ? number_format($this->toInt($p[1])) : 0;
		return $value;
	}
	
	//get compete rank
	function compete_rank ($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		$url = 'http://siteanalytics.compete.com/'.$url.'/';
		$data = $this->getPage($url);
		preg_match('/\(rank #(.*?)\)/i', $data, $p);
		$value = isset($p[1]) ? number_format($this->toInt($p[1])) : 0;
		return $value;
	}
	
	// Check Fake PageRank
	function checkFake($url = null) {
		$url = $url === null ? $this->url['host'] : $url;
		$siteurl = 'http://www.google.com/search?q=info:'.$url.'&cd=1&hl=en&ct=clnk';
		$data = $this->getPage($siteurl); 
		preg_match('/<cite>(.*?)<\/cite>/i', $data, $p);
		$datatext = isset($p[1]) ? $p[1] : '';
		
		if (eregi($url, $datatext)) {
			$value = "1";
		} else {
			$value = "0";
		}
		return $value;
		
	}

	
	function toInt ($string) {
		return preg_replace('#[^0-9]#si', '', $string);
	}
	
	
	
	
	
	
	
	function spider_viewer($url){
		$this->set_url($url);
		$page = $this->getPage($this->url['full']);
		return $this->__2utf8($this->html2text($page));
	}
	
	function robots_txt($url){
		$this->set_url($url);
		$page = $this->getPage($this->url['full'] . '/robots.txt');
		return $this->__2utf8($page);
	}
	
	function whois_retriever($url){
		$this->set_url($url);
		$url = ereg_replace('^www\.', '', $this->url['host']);
		$url = "http://reports.internic.net/cgi/whois?whois_nic={$url}&type=domain";
		$page = $this->getPage($url);
		
		preg_match('/<pre>(.*)<\/pre>/si', $page, $p);
		
		return isset($p[1]) ? $p[1] : '';
	}
	
	function ping($domain, $reverse = false){
		$this->set_url($domain);
		$host = $this->url['host'];
		$response = '';
		ob_start();
		if ( strpos(strtoupper(php_uname('s')), 'WIN') !== false ){
			$cmd = ( $reverse ) ? "ping -a -n 4 {$host}" : "ping -n 4 {$host}";
			system($cmd);
		} else {
			$cmd = ( $reverse ) ? "dig +noall +answer -x {$host}" : "ping -c4 -w4 {$host}";
			system ($cmd);
			system("killall ping");
		}
		
		$response = ob_get_contents();
		ob_end_clean();
		
		return $this->__2utf8($response);
	}

	function meta_tags_extractor($url){
		$this->set_url($url);

		$tags = get_meta_tags($this->url['full']);
		$out = array();

		foreach ($tags as $key => $value) {
			$out[] = "<meta name=\"{$key }\" content=\"{$value}\" >";
		}		

		return $out;
	}
	
	function http_header_extractor($url){
		$this->set_url($url);
		
		if ( function_exists('curl_init') ){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->url['full']);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HEADER, true);
			$html = curl_exec($ch);
			
			return $html;
		} else {
			file_get_contents($this->url['full']);
			return implode("\n", $http_response_header);
		}
	}
		
	
	function meta_tags_generator($data = array()){
		$default = array(
			'title' => '',
			'description' => '',
			'keywords' => '',
			'author' => '',
			'owner' => '',
			'copyright' => ''
		);
		$data = array_merge($default, $data);
		
		$out = '';
		
		foreach($data as $name => $content){
			if ( empty($content) )
				continue;
				
			$content = str_replace('"', "'", $content);
			$name = str_replace('"', "'", $name);
			
			$out .= "<meta name=\"{$name}\" content=\"{$content}\" />\n";
		}
		
		return $out;
	
	}
	
	/**********************/
	/* COMPETITOR COMPARE */
	/**********************/
	function competitor_compare($url = null, $keywords, $engine = 'google.com', $engine_results_num = 10){
		$competitors_data = $this->getSnippet($keywords, $engine, $engine_results_num);
		
		foreach ($competitors_data as $pos => $data){
			$page = $this->getPage($competitors_data[$pos]['url']);
			$competitors_data[$pos]['body'] = $this->__2utf8($this->html2text($this->__parseTag('body', $page))); 
			$competitors_data[$pos]['tags'] = get_meta_tags($competitors_data[$pos]['url']);
			$competitors_data[$pos]['h1'] = $this->__2utf8($this->html2text(implode(' ', $this->__parseTag('h1', $page, true)))); #get all
			
			$this->set_url($competitors_data[$pos]['url']);
			/* SEM */
			$competitors_data[$pos]['backlinks'] = array(
				'alexa' => $this->getAlexaBacklink($competitors_data[$pos]['url']),
				'google' => $this->getBacklinksGoogle(),
				'yahoo' => $this->getBacklinksYahoo()
			);
			$competitors_data[$pos]['alexa_rank'] = $this->getAlexaRank($competitors_data[$pos]['url']);
			$competitors_data[$pos]['age'] = $this->getAge();

			foreach ( $competitors_data[$pos]['tags'] as $c_tag_name => &$c_tag_data ){
				$c_tag_data = $this->__2utf8(html_entity_decode($c_tag_data));
			}
		}
		
		$this->set_url($url);
		$page = $this->getPage($this->url['full']);
		
		$h1_array = $this->__parseTag('h1', $page, true);
		foreach($h1_array as &$h1){ $h1 = $this->__2utf8($h1); }
		
		$site_data = array(
			'url' => $this->url['full'],
			'title' => $this->__2utf8($this->html2text($this->__parseTag('title', $page))), #sanitize
			'body' => $this->__2utf8($this->html2text($this->__parseTag('body', $page))), #sanitize
			'tags' => get_meta_tags($this->url['full']),
			'h1' => $this->html2text(implode(' ', $h1_array)), #get all
			
			/* SEM */
			'backlinks' =>
			 array(
				'alexa' => $this->getAlexaBacklink($this->url['full']),
				'google' => $this->getBacklinksGoogle(),
				'yahoo' => $this->getBacklinksYahoo()
			),
			'alexa_rank' => $this->getAlexaRank($this->url['full']),
			'age' => $this->getAge()
		);
			
		foreach ( $site_data['tags'] as $s_tag_name => &$s_tag_data ){
			$s_tag_data = $this->__2utf8(html_entity_decode($s_tag_data));
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
		foreach ($analysis as $aspect => &$aspect_data){
			if ( in_array($aspect, array('backlinks', 'alexa_rank', 'age')) ) continue;
			$site_aspect_data = Set::extract("/{$aspect}", $site_data);
			$site_aspect_data = @$site_aspect_data[0];
		
			$_keywords = explode(' ', str_replace(',', '', $keywords) );
			$_keywords[] = $this->__exclude_words(str_replace(',', '', $keywords));
		
			foreach($_keywords as $word ){
				$strpos = $aspect == 'h1' ? 0 : $this->word_position($site_aspect_data, $word); #h1 aspect = no position required
				$quantity = $this->word_occurr($site_aspect_data, $word); // --> auto set $this->tmp = source # words
				$aspect_data[$word]['site'] = array(
					'quantity'	=> $quantity,
					'density'	=> number_format(($quantity*100) / $this->tmp, 2), // --> overload: $this->word_density($site_aspect_data, $word)
					'position'	=> $strpos
				);
				
				if ( $aspect == 'body' )
					$aspect_data[$word]['site']['words_count'] = $this->words_count($site_aspect_data, $word);
				
				
				$c_quantity = $c_density = $c_position = $c_body_word_count = array();
				
				foreach ($competitors_data as $pos => $data){
					$competitor_aspect_data = Set::extract("/{$aspect}", $competitors_data[$pos]);
					$competitor_aspect_data = @$competitor_aspect_data[0];
					
					if ( $aspect == 'tags/description' && empty($competitor_aspect_data) )
						continue;
					
					$q = $this->word_occurr($competitor_aspect_data, $word); // --> improve: $this->tmp
					
					$c_quantity[] = $q;
					$c_density[] = number_format( ($q*100) / $this->tmp, 2);
					$strpos = $aspect == 'h1' ? 0 : $this->word_position($competitor_aspect_data, $word); #h1 aspect = no position required
					$c_position[] = $strpos;
					
					if ( $aspect == 'body' )
						$c_body_word_count[] = $this->words_count($competitor_aspect_data, $word);
				}
			
				$aspect_data[$word]['competitors'] = array(
					'quantity'	=> $c_quantity,
					'density'	=> $c_density,
					'position'	=> $c_position
				);
				
				if ( $aspect == 'body' )
					$aspect_data[$word]['competitors']['words_count'] = $c_body_word_count;
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
	
	function html2text($s, $keep  = '', $expand = 'script|style|noframes|select|option|noscript'){
        $s = ' ' . $s;
       
        if(strlen($keep) > 0){
            $k = explode('|',$keep);
            for($i=0;$i<count($k);$i++){
                $s = str_replace('<' . $k[$i],'[{(' . $k[$i],$s);
                $s = str_replace('</' . $k[$i],'[{(/' . $k[$i],$s);
            }
        }
       
        while(stripos($s,'<!--') > 0){
            $pos[1] = stripos($s,'<!--');
            $pos[2] = stripos($s,'-->', $pos[1]);
            $len[1] = $pos[2] - $pos[1] + 3;
            $x = substr($s,$pos[1],$len[1]);
            $s = str_replace($x,'',$s);
        }
       
        if(strlen($expand) > 0){
            $e = explode('|',$expand);
            for($i=0;$i<count($e);$i++){
                while(stripos($s,'<' . $e[$i]) > 0){
                    $len[1] = strlen('<' . $e[$i]);
                    $pos[1] = stripos($s,'<' . $e[$i]);
                    $pos[2] = stripos($s,$e[$i] . '>', $pos[1] + $len[1]);
                    $len[2] = $pos[2] - $pos[1] + $len[1];
                    $x = substr($s,$pos[1],$len[2]);
                    $s = str_replace($x,'',$s);
                }
            }
        }
       
        while(stripos($s,'<') > 0){
            $pos[1] = stripos($s,'<');
            $pos[2] = stripos($s,'>', $pos[1]);
            $len[1] = $pos[2] - $pos[1] + 1;
            $x = substr($s,$pos[1],$len[1]);
            $s = str_replace($x,'',$s);
        }
       
        for($i=0;$i<count($k);$i++){
            $s = str_replace('[{(' . $k[$i],'<' . $k[$i],$s);
            $s = str_replace('[{(/' . $k[$i],'</' . $k[$i],$s);
        }
				
		$s = preg_replace(
			array(
			"/[\n\t]+/",
			'/\r/',
			'/[ ]{2,}/'
			),
			array(
			' ',
			' ',
			' '
			)
		, $s);
       
        return trim($s);
	}
	
	function __parseTag($tag, $haystack, $all = false, $force_broken_tags = true) {
		$pattern = '/\<' . $tag . '(.*)\>(.*)\<\/' . $tag . '\>/iUs';
		if ($all) {
			preg_match_all($pattern, $haystack, $matches);
		} else {
			preg_match($pattern, $haystack, $matches);
		}
		$matches = isset($matches[2]) ? $matches[2] : '';
		
		if ( empty($matches) && !empty($haystack) ){ #BUG: preg_match cant handle long texts, try other way:
			$o_tag = strpos($haystack, "<{$tag}");
			$c_tag = strpos($haystack, "</{$tag}");
			
			if ( $c_tag !== false && $force_broken_tags){
				$matches = substr($haystack, $o_tag, $c_tag);
			} elseif($c_tag !== false && $o_tag === false && $force_broken_tags) { #unopened tag, extract from begin to close tag
				$matches = substr($haystack, 0, $c_tag);
			} elseif ( $c_tag === false && $force_broken_tags) { # uncloses tag, extract from opening to end
				$matches = substr($haystack, $o_tag);
			}
		}
		
		return $matches;
	}
	
	function __exclude_words($str, $exclude_words = array()){
		$exclude_words = array_merge($exclude_words, Configure::read('ModSeo.Config.seo_exclude_words'));
		foreach($exclude_words as $filter_word){
			$str = preg_replace(array('/[ ]{2,}/', '/\b'.strtolower($filter_word).'\b/i'), array(' ', ''), $str);
		}
		return $str; 
	}
	
	function word_position($source, $word){
		$source = $this->__exclude_words($source);
		$strpos = strpos(strtolower($source), strtolower($word));
		return ($strpos === false ? 0 : $strpos+1);
	}
	
	function words_count($source){
		$source = $this->__string2keywords($source);
		$words  = str_word_count($source, 1);
		
		return count($words);
	}
	
	function word_occurr($source, $word, $exclude_words = array()){
		$exclude_words = array_merge($exclude_words, Configure::read('ModSeo.Config.seo_exclude_words'));
		$source = $this->__string2keywords($source);
		$word = strtolower($word);
		$words = str_word_count($source, 1);
		$word_c = str_word_count($word, 1);  // words of keyword
		$occurr = 0;
		foreach ($words as $index => $_word ){
			if ( count($word_c) > 0 ){
				$sub_occurr = 0;
				for ($i=0; $i<count($word_c); $i++){
					$sub_occurr = ($words[$index+$i] == $word_c[$i]) ? $sub_occurr+1 : $sub_occurr;
				}
				$occurr = ( $sub_occurr == count($word_c) ) ? $occurr+1 : $occurr;
			} else {
				$occurr = ($_word == $word) ? $occurr+1 : $occurr;
			}
		}
		$this->tmp = count($words); //--> set source # words to tmp var
		return $occurr;
	}
	
	/* return % */
	function word_density($source, $word, $exclude_words = array()){
		$occurr = $this->word_occurr($source, $word, $exclude_words);
		$words = str_word_count($source, 1);
		return number_format(($occurr * 100) / count($words), 2);
	}
	
	function getSnippet($keywords, $engine = 'google.com', $results_num = 10 ){

		if ( strpos($engine, 'google.') !== false ):
			$query	= "http://www.{$engine}/search?q=" . urlencode($keywords) ."&num={$results_num}";
			$exp	= '(<h3 class="r"><a href="(.*)".+>(.*)<\/a><\/h3>.+class="s">(.+)<cite>.+class=gl><a href="(.+)".+<\/div>)siU';
		else:
			return false;
		endif;
		
		$results = $this->__2utf8($this->getPage($query));
		
		preg_match_all($exp, $results, $matches, PREG_SET_ORDER);
		
		$out = array();
		
		foreach($matches as $pos => $data){
			$out[] = array(
				'url' => strip_tags($data[1]),
				'title' => strip_tags($data[2]),
				'snippet' => strip_tags($data[3]),
				'cache_url' => strip_tags($data[4])
			);
		}
		return $out;
	}
	
	function link_extractor($url){
		$this->set_url($url);
		$page = $this->getPage($this->url['full']);
		
		preg_match_all ("/a[\s]+[^>]*?href[\s]?=[\s\"\']+".
                    "(.*?)[\"\']+.*?>"."([^<]+|.*?)?<\/a>/", 
                    $page, &$matches);
		if ( isset($matches[1]) ){
			foreach($matches[1] as  $index => &$link){
				$link = strtolower($link);
				
				if ( substr($link, 0, 1) == '/' || substr($link, 0, 1) == '.' ){
					$link = $this->url['full'] . $link;
				} elseif( substr($link, 0, 11) == 'javascript:' || substr($link, 0, 7) == 'mailto:' ) {
					unset($matches[1][$index]);
				} elseif ( substr($link, 0, 7) != 'http://' && substr($link, 0, 8) != 'https://' ){
					$link = $this->url['full'] . '/' . $link;
				}
				
				$link = $this->__2utf8($link);
			}
			
			return array_unique($matches[1]);
		}
		return false;
	}
	
	function keyword_density($url){
	
		$this->set_url($url);
		$page = $this->getPage($this->url['full']);
		$page = $this->__string2keywords($page);
		
		$words = str_word_count($page, 1);
		$words = array_unique($words);
		foreach($words as &$word){
			$out[$word] = $this->word_density($page, $word);
		}

		return $out;
	}
	
	function keyword_extractor($url){
		$this->set_url($url);
		$page = $this->getPage($this->url['full']);
		$page = $this->__string2keywords($page);
		
		$this->tmp = $page;						//improve: save all content for keywords_density function

		App::import('Lib', 'ModSeo.autokeyword');
		
		$opts = array(
			'content' => $page,					//page content
			'min_word_length' => 2,				//minimum length of single words
			'min_word_occur' => 1,				//minimum occur of single words
			'min_2words_length' => 2,			//minimum length of words for 2 word phrases
			'min_2words_phrase_length' => 2,	//minimum length of 2 word phrases
			'min_2words_phrase_occur' => 2,		//minimum occur of 2 words phrase
			'min_3words_length' => 2,			//minimum length of words for 3 word phrases
			'min_3words_phrase_length' => 2,	//minimum length of 3 word phrases
			'min_3words_phrase_occur' => 2		//minimum occur of 3 words phrase
		);
		
		$keyword = new autokeyword($opts, 'utf-8');
		
		$out = array(
			'words_1' => $keyword->parse_words(),
			'words_2' => $keyword->parse_2words(),
			'words_3' => $keyword->parse_3words(),
			'words_all' => $keyword->get_keywords()
		);
		
		return $out;
	}
	
	/* only alphanumeric characters (words) */
	function __string2keywords($page){
		$page = $this->html2text($page);
		
		
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
		
		foreach( $page as $key => $word){
			if( strlen($word) == 1 )
				unset($page[$key]);
		}
		$page = implode(' ', $page);
		$page = strtolower($page);
		$page = $this->__exclude_words($page);
		
		return $page;	
	}
	
	function __2utf8($str){
		if( !$this->__detectUTF8($str) ){
			return utf8_encode($str);
		} else	{
			return $str;
		}
	}
	
	function __detectUTF8($string) {
		return preg_match('%(?:
			[\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
			|\xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
			|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
			|\xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
			|\xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
			|[\xF1-\xF3][\x80-\xBF]{3}         # planes 4-15
			|\xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
			)+%xs', 
		$string);
	}
	/*******************************************/	
		
		
		
		
		
		
		
	//--> for google pagerank 
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


	/* 
	* Genearate a hash for a url 
	*/ 
	function __HashURL($String) {
		$Check1 = $this->__StrToNum($String, 0x1505, 0x21); 
		$Check2 = $this->__StrToNum($String, 0, 0x1003F); 

		$Check1 >>= 2;      
		$Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F); 
		$Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF); 
		$Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);    
		
		$T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) <<2 ) | ($Check2 & 0xF0F ); 
		$T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 ); 
		
		return ($T1 | $T2); 
	}


	/* 
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
			if (1 === ($Flag % 2) ) { 
				if (1 === ($CheckByte % 2)) { 
					$CheckByte += 9; 
				} 
				$CheckByte >>= 1; 
			} 
		} 

		return '7'.$CheckByte.$HashStr; 
	}

	function __file_get_contents_curl($url) { 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser. 
		curl_setopt($ch, CURLOPT_URL, $url); 
		$data = curl_exec($ch); 
		curl_close($ch); 

		return $data; 
	}

	//get google pagerank 
	function __getpr($url) {
		$query="http://toolbarqueries.google.com/search?client=navclient-auto&ch=".$this->__CheckHash($this->__HashURL($url)). "&features=Rank&q=info:".$url."&num=100&filter=0"; 
		$data= $this->__file_get_contents_curl($query); 
		//print_r($data); 
		$pos = strpos($data, "Rank_"); 
		if($pos === false){} else{ 
			$pagerank = substr($data, $pos + 9); 
			return $pagerank; 
		} 
	}		


}
?>
