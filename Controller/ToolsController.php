<?php 
class ToolsController extends SeoToolsAppController {
    public $components = array('SeoTools.SeoTools');
    public $helpers = array('SeoTools.SeoTools');

    public function admin_index() {
        
    }
    
	public function admin_reverse_ip() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['ip']) ||
                !preg_match("/^((\d{1,2}|[01]\d{2}|2([0-4]\d|5[0-5]))\.) {3}(\d{1,2}|[01]\d{2}|2([0-4]\d|5[0-5]))$/", $this->data['Tool']['ip'])
            ) {
				$this->flashMsg(__t('Invalid IP'), 'error');
				$this->redirect($this->referer());
			}

			$results = @$this->SeoTools->ping($this->data['Tool']['ip'], true);

			$this->set('results', $results);
		}	
	}
	
	public function admin_ping() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$results = @$this->SeoTools->ping($this->data['Tool']['url']);

			$this->set('results', $results);
		}	
	}
	
	public function admin_keyword_extractor() {
        if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}
		
			$results = @$this->SeoTools->keyword_extractor($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}	
	}
	
	public function admin_spider_viewer() {
        if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}
            
			$results = @$this->SeoTools->spider_viewer($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}	
	}
	
	public function admin_http_header_extractor() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}
			
			$results = $this->SeoTools->http_header_extractor($this->data['Tool']['url']);
			
			$this->set('results', $results);
		}
	}
	
	public function admin_html_validator() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$results = $this->data['Tool']['url'];

			$this->set('results', $results);
		}
	}
	
	public function admin_meta_tags_generator() {
		if (isset($this->data['Tool'])) {
			$results = $this->SeoTools->meta_tags_generator($this->data['Tool']['metas']);

			$this->set('results', $results);
		}	
	}
	
	public function admin_meta_tags_extractor() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$results = $this->SeoTools->meta_tags_extractor($this->data['Tool']['url']);

			$this->set('results', $results);
		}	
	}
	
	public function admin_whois_retriever() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$results = $this->SeoTools->whois_retriever($this->data['Tool']['url']);

			$this->set('results', $results);
		}	
	}
	
	public function admin_css_validator() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$results = $this->data['Tool']['url'];

			$this->set('results', $results);
		}
	}
	
	public function admin_source_code_viewer() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$this->SeoTools->set_url($this->data['Tool']['url']);

			$results = $this->SeoTools->getPage($this->SeoTools->url['full']);

			$this->set('results', $results);
		}
	}
	
	public function admin_html_encrypter() {
		if (isset($this->data['Tool'])) {
			$errors = array();

			if (empty($this->data['Tool']['text'])) {
				$this->flashMsg(__t('Invalid text'), 'error');
				$this->redirect($this->referer());
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
	
	public function admin_md5_encrypter() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['text'])) {
				$this->flashMsg(__t('Invalid text'), 'error');
				$this->redirect($this->referer());
			}

			$results = md5($this->data['Tool']['text']);

			$this->set('results', $results);
		}		
	}
	
	public function admin_robots_txt() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$results = @$this->SeoTools->robots_txt($this->data['Tool']['url']);

			$this->set('results', $results);
		}
	}
	
	public function admin_keyword_density() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$results = @$this->SeoTools->keyword_density($this->data['Tool']['url']);

			$this->set('results', $results);
		}	
	}
	
	public function admin_link_extractor() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$results = @$this->SeoTools->link_extractor($this->data['Tool']['url']);

			$this->set('results', $results);
		}	
	}
	
	public function admin_top_10_optimizer() {
        Cache::config('seo_cache', array('engine' => 'File', 'path' => CACHE, 'duration' => '+1 day'));

		if (isset($this->data['Tool'])) {
			$errors = array();

			if (empty($this->data['Tool']['url'])) {
				$errors[] = __t('Invalid URL');
            }

			if (empty($this->data['Tool']['criteria'])) {
				$errors[] = __t('Invalid criteria');
            }

			if (count($errors) > 0) {
				$this->flashMsg(implode('<br/>', $errors), 'error');
				$this->redirect($this->referer());
			}

			if ($this->data['Tool']['engine_results_num'] > 10 || 0 > $this->data['Tool']['engine_results_num']) {
                $data = $this->data;
                $data['Tool']['engine_results_num'] = 10;
                $this->data = $data;
            }

            $cache = Cache::read('top_10_optimizer_' . md5($this->data['Tool']['url'] . $this->data['Tool']['criteria'] . $this->data['Tool']['engine_results_num']), 'seo_cache');
            if (!$cache) {
                $results = @$this->SeoTools->competitor_compare($this->data['Tool']['url'], $this->data['Tool']['criteria'], $this->data['Tool']['engine'], $this->data['Tool']['engine_results_num']);
                Cache::write('top_10_optimizer_' . md5($this->data['Tool']['url'] . $this->data['Tool']['criteria'] . $this->data['Tool']['engine_results_num']), $results, 'seo_cache');
            } else {
                $results = $cache;
            }
			
			$this->set('results', $results);
		}
	}

	public function admin_seo_stats() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}

			$url = $this->data['Tool']['url'];
			$results = Cache::read('seo_stats_'. md5($this->data['Tool']['url']));

			if (!$results) {
                $this->SeoTools->set_url($url);
                $results = array(
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

				Cache::write('seo_stats_'. md5($this->data['Tool']['url']), $results, 'short');
			}
		
			$this->set('results', $results);
		}
	}
	
	public function admin_keyword_suggestion() {
    
	}
	
	public function admin_backlink_checker() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
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