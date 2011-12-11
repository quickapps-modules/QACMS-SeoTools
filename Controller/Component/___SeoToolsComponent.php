<?php
class SeoToolsComponent extends Component {
	var $url;
	var $tmp;
	






    
        



	
	



	

	


	

	

	



	/**********************/
	/* COMPETITOR COMPARE */
	/**********************/
	function competitor_compare($url = null, $keywords, $engine = 'google.com', $engine_results_num = 10) {
		$competitors_data = $this->getSnippet($keywords, $engine, $engine_results_num);

		foreach ($competitors_data as $pos => $data) {
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

			foreach ($competitors_data[$pos]['tags'] as $c_tag_name => &$c_tag_data) {
				$c_tag_data = $this->__2utf8(html_entity_decode($c_tag_data));
			}
		}
		
		$this->set_url($url);
		$page = $this->getPage($this->url['full']);
		$h1_array = $this->__parseTag('h1', $page, true);
        
		foreach ($h1_array as &$h1) { 
            $h1 = $this->__2utf8($h1);
        }

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
			
		foreach ($site_data['tags'] as $s_tag_name => &$s_tag_data) {
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
		foreach ($analysis as $aspect => &$aspect_data) {
			if (in_array($aspect, array('backlinks', 'alexa_rank', 'age'))) {
                continue;
            }

			$site_aspect_data = Set::extract("/{$aspect}", $site_data);
			$site_aspect_data = @$site_aspect_data[0];
		
			$_keywords = explode(' ', str_replace(',', '', $keywords));
			$_keywords[] = $this->__exclude_words(str_replace(',', '', $keywords));
		
			foreach ($_keywords as $word) {
				$strpos = $aspect == 'h1' ? 0 : $this->word_position($site_aspect_data, $word); #h1 aspect = no position required
				$quantity = $this->word_occurr($site_aspect_data, $word); // --> auto set $this->tmp = source # words
				$aspect_data[$word]['site'] = array(
					'quantity'	=> $quantity,
					'density'	=> number_format(($quantity*100) / $this->tmp, 2), // --> overload: $this->word_density($site_aspect_data, $word)
					'position'	=> $strpos
				);
				
				if ($aspect == 'body') {
					$aspect_data[$word]['site']['words_count'] = $this->words_count($site_aspect_data, $word);
				}
				
				$c_quantity = $c_density = $c_position = $c_body_word_count = array();
				
				foreach ($competitors_data as $pos => $data) {
					$competitor_aspect_data = Set::extract("/{$aspect}", $competitors_data[$pos]);
					$competitor_aspect_data = @$competitor_aspect_data[0];
					
					if ($aspect == 'tags/description' && empty($competitor_aspect_data)) {
						continue;
                    }
					
					$q = $this->word_occurr($competitor_aspect_data, $word); // --> improve: $this->tmp
					
					$c_quantity[] = $q;
					$c_density[] = number_format(($q*100) / $this->tmp, 2);
					$strpos = $aspect == 'h1' ? 0 : $this->word_position($competitor_aspect_data, $word); #h1 aspect = no position required
					$c_position[] = $strpos;
					
					if ($aspect == 'body') {
						$c_body_word_count[] = $this->words_count($competitor_aspect_data, $word);
                    }
				}

				$aspect_data[$word]['competitors'] = array(
					'quantity'	=> $c_quantity,
					'density'	=> $c_density,
					'position'	=> $c_position
				);
				
				if ($aspect == 'body') {
					$aspect_data[$word]['competitors']['words_count'] = $c_body_word_count;
                }
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

	
	function __parseTag($tag, $haystack, $all = false, $force_broken_tags = true) {
		$pattern = '/\<' . $tag . '(.*)\>(.*)\<\/' . $tag . '\>/iUs';

        if ($all) {
			preg_match_all($pattern, $haystack, $matches);
		} else {
			preg_match($pattern, $haystack, $matches);
		}

		$matches = isset($matches[2]) ? $matches[2] : '';
/*
		if (empty($matches) && !empty($haystack)) { #BUG: preg_match cant handle long texts, try other way:
			$o_tag = strpos($haystack, "<{$tag}");
			$c_tag = strpos($haystack, "</{$tag}");

			if ($c_tag !== false && $force_broken_tags) {
				$matches = substr($haystack, $o_tag, $c_tag);
			} elseif($c_tag !== false && $o_tag === false && $force_broken_tags) { #unopened tag, extract from begin to close tag
				$matches = substr($haystack, 0, $c_tag);
			} elseif ($c_tag === false && $force_broken_tags) { # uncloses tag, extract from opening to end
				$matches = substr($haystack, $o_tag);
			}
		}
*/
		return $matches;
	}
	

	
	function word_position($source, $word) {
		$source = $this->__exclude_words($source);
		$strpos = strpos(strtolower($source), strtolower($word));
        
		return ($strpos === false ? 0 : $strpos+1);
	}
	
	function words_count($source) {
		$source = $this->__string2keywords($source);
		$words  = str_word_count($source, 1);
		
		return count($words);
	}
	
	function word_occurr($source, $word, $exclude_words = array()) {
		$exclude_words = array_merge($exclude_words, Configure::read('ModSeo.Config.seo_exclude_words'));
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
		$this->tmp = count($words); //--> set source # words to tmp var
		return $occurr;
	}
	
	/* return % */
	function word_density($source, $word, $exclude_words = array()) {
		$occurr = $this->word_occurr($source, $word, $exclude_words);
		$words = str_word_count($source, 1);
        
		return number_format(($occurr * 100) / count($words), 2);
	}
	
	function getSnippet($keywords, $engine = 'google.com', $results_num = 10) {
		if (strpos($engine, 'google.') !== false) {
			$query	= "http://www.{$engine}/search?q=" . urlencode($keywords) ."&num={$results_num}";
			$exp	= '(<h3 class="r"><a href="(.*)".+>(.*)<\/a><\/h3>.+class="s">(.+)<cite>.+class=gl><a href="(.+)".+<\/div>)siU';
		} else {
			return false;
		};
		
		$results = $this->__2utf8($this->getPage($query));
		
		preg_match_all($exp, $results, $matches, PREG_SET_ORDER);
		
		$out = array();
		
		foreach ($matches as $pos => $data) {
			$out[] = array(
				'url' => strip_tags($data[1]),
				'title' => strip_tags($data[2]),
				'snippet' => strip_tags($data[3]),
				'cache_url' => strip_tags($data[4])
			);
		}
        
		return $out;
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
		$query = "http://toolbarqueries.google.com/search?client=navclient-auto&ch=" . $this->__CheckHash($this->__HashURL($url)). "&features=Rank&q=info:" . $url . "&num=100&filter=0"; 
		$data = $this->__file_get_contents_curl($query); 
		$pos = strpos($data, "Rank_");
        
		if ($pos !== false) { 
			$pagerank = substr($data, $pos + 9); 

			return $pagerank; 
		} 
	}
}