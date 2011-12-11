<?php
class ToolsController extends ModSeoAppController {

	var $name = 'Tools';
	var $components = array('ModSeo.SeoTools');
	var $helpers = array('ModSeo.SeoTools');
	
	
	function index() {
	}
	
	function reverse_ip(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if (	empty($this->data['Tool']['ip']) || 
					!preg_match("/^((\d{1,2}|[01]\d{2}|2([0-4]\d|5[0-5]))\.){3}(\d{1,2}|[01]\d{2}|2([0-4]\d|5[0-5]))$/", $this->data['Tool']['ip'])
			)
				$errors['url'] = _e('Invalid IP');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
		
			$results = @$this->SeoTools->ping($this->data['Tool']['ip'], true);
			
			$this->set('results', $results);
		}	
	}
	
	function ping(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid URL');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
		
			$results = @$this->SeoTools->ping($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}	
	}
	
	function keyword_extractor(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid URL');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
		
			$results = @$this->SeoTools->keyword_extractor($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}	
	}
	
	function spider_viewer(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid URL');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
		
			$results = @$this->SeoTools->spider_viewer($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}	
	}
	
	function http_header_extractor(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid url');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
			
			$results = $this->SeoTools->http_header_extractor($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}
	}
	
	function html_validator(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid url');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
			
			$results = $this->data['Tool']['url'];
			
			$this->set('results', $results);
		}
	}
	
	function meta_tags_generator(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$results = $this->SeoTools->meta_tags_generator($this->data['Tool']['metas']);
			
			$this->set('results', $results);
		}	
	}
	
	function meta_tags_extractor(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid url');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
			
			$results = $this->SeoTools->meta_tags_extractor($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}	
	}
	
	function whois_retriever(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid url');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
			
			$results = $this->SeoTools->whois_retriever($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}	
	}
	
	function css_validator(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid url');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
			
			$results = $this->data['Tool']['url'];
			
			$this->set('results', $results);
		}
	}
	
	function source_code_viewer(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid url');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
			
			$this->SeoTools->set_url($this->data['Tool']['url']);
			$results = $this->SeoTools->getPage($this->SeoTools->url['full']);
			
			$this->set('results', $results);
		}
	}
	
	function html_encrypter(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['text']) )
				$errors['url'] = _e('Invalid text');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}

$results = "<script language=\"JavaScript\" type=\"text/javascript\">
<!-- HTML Encryption provided by Webmanager SEO Module -->
<!--
document.write(unescape('".rawurlencode($this->data['Tool']['text'])."'));
//-->
</script>";
			
			$this->set('results', $results);
		}	
	}
	
	function md5_encrypter(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['text']) )
				$errors['url'] = _e('Invalid text');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
		
			$results = md5($this->data['Tool']['text']);
			
			$this->set('results', $results);
		}		
	}
	
	function robots_txt(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid URL');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
		
			$results = @$this->SeoTools->robots_txt($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}
	}
	
	function keyword_density(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid URL');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
		
			$results = @$this->SeoTools->keyword_density($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}	
	}
	
	function link_extractor(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid URL');
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
		
			$results = @$this->SeoTools->link_extractor($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}	
	}
	
	function top_10_optimizer(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			$errors = array();
			
			if ( empty($this->data['Tool']['url']) )
				$errors['url'] = _e('Invalid URL');
				
			if ( empty($this->data['Tool']['criteria']) )
				$errors['url'] = _e('Invalid criteria');
				
			
			if ( count($errors) > 0 ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $errors );
				die();
			}
			$this->data['Tool']['engine_results_num'] = 
				($this->data['Tool']['engine_results_num'] > 10 ||  0 > $this->data['Tool']['engine_results_num'] ) ? 10 :
				$this->data['Tool']['engine_results_num'];
			
			$results = @$this->SeoTools->competitor_compare($this->data['Tool']['url'], $this->data['Tool']['criteria'], $this->data['Tool']['engine'], $this->data['Tool']['engine_results_num']);
			
			$this->set('results', $results);
		}
	}
	
	function seo_stats(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			if ( empty($this->data['Tool']['url']) ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', array('url' => _e('Invalid URL')) );
				die();
			}
			
			$url = $this->data['Tool']['url'];
			$results = Cache::read('mod_seo_stats_'. md5($this->data['Tool']['url']));
			
			if ( !$results ){
			$this->SeoTools->set_url($url);
			$results = array (
						'url' => $this->SeoTools->url['host'],
						'pagerank' => $this->SeoTools->getPagerank(),
						'validrank' => $this->SeoTools->checkFake($url),
						'dmoz' => $this->SeoTools->getDmoz(),
						'yahooDirectory' => $this->SeoTools->getYahooDirectory(),
						'backlinksYahoo' => $this->SeoTools->getBacklinksYahoo(),
						'backlinksGoogle' => $this->SeoTools->getBacklinksGoogle(),
						'alexarank' => $this->SeoTools->getAlexaRank($url),
						'alexabacklink' => $this->SeoTools->getAlexaBacklink($url),
						'age' => $this->SeoTools->getAge(),
						'googlebot' => $this->SeoTools->get_googlebot_lastaccess($url),
						'sitevalue' => $this->SeoTools->getSiteValue($url),
						'bingindexed' => $this->SeoTools->bing_indexed($url),
						'googleindexed' => $this->SeoTools->google_indexed($url),
						'yahooindexed' => $this->SeoTools->yahoo_indexed($url),
						'digglinks' => $this->SeoTools->digg_links($url),
						'deliciouslinks' => $this->SeoTools->delicious_links($url),
						'technoratirank' => $this->SeoTools->technorati_rank($url),
						'competerank' => $this->SeoTools->compete_rank($url),
						'thumb' =>"http://images.websnapr.com/?size=s&key=".Configure::read('ModSeo.Config.seo_websnapr_key')."&nocache=".rand(1,999)."&url=".$url

				);
				
				
				Cache::config('short', array(  
					'engine' => 'File',  
					'duration'=> '+3 days',  
					'path' => CACHE
				));
				
			
				Cache::write('mod_seo_stats_'. md5($this->data['Tool']['url']), $results, 'short');
			}
		
			$this->set('results', $results);
		}
	}
	
	function keyword_suggestion(){
		$this->autoRender = true;
	}
	
	function backlink_checker(){
		$this->autoRender = true;
		if ( isset($this->data['Tool']) ){
			if ( empty($this->data['Tool']['url']) ){
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', array('url' => _e('Invalid URL')) );
				die();
			}
		
			$this->SeoTools->set_url($this->data['Tool']['url']);
			$results = array(
				'alexa' => @$this->SeoTools->getAlexaBacklink(),
				'google' => @$this->SeoTools->getBacklinksGoogle(),
				'yahoo' => @$this->SeoTools->getBacklinksYahoo(),
			);
		
			$this->set('results', $results);
		}
	}

}
?>