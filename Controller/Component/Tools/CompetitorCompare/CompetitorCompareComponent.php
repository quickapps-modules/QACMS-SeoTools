<?php 
class CompetitorCompareComponent extends Component {
    public $tmp;
    public $Controller;
	private $report = array(
		'config' => array(),
		'site_data' => array(),
		'competitors_data' => array(),
		'factors' => array(
			'essential' => array(0, 0), // success, failed
			'very_important' => array(0, 0),
			'important' =>  array(0, 0)
		)
	);

	public function startup(&$Controller) {
		$this->Controller = $Controller;

		$this->Controller->Layout['javascripts']['file'][] = '/seo_tools/js/Tools/CompetitorCompare/cc.js';
	}

    public function main(&$Controller) {
		if (isset($Controller->data['Tool']['cmd'])) {
			App::import('Vendor', 'SeoTools.simple_html_dom');

			$CMD = $this->Controller->data['Tool']['cmd'];
			$TOKEN = $this->getToken();
			$CACHE_FOLDER =  CACHE . 'seo_tools' . DS . 'cc_' . $TOKEN;

			if ($CMD == 'start') {
				if (is_dir($CACHE_FOLDER)) {
					$Folder = new Folder($CACHE_FOLDER);
					$Folder->delete();
				}

				@mkdir($CACHE_FOLDER . DS);
			}

			set_time_limit(0);

			if (is_dir($CACHE_FOLDER)) {
				Cache::config('seo_cache_cc',
					array(
						'engine' => 'File',
						'path' => $CACHE_FOLDER
					)
				);
			}

			if (isset($Controller->data['Tool']['engine'])) {
				$data = $Controller->data;
				$parts = explode('|', $data['Tool']['engine']);
				$data['Tool']['engine'] = array(
					'class' => array_shift($parts),
					'options' => $parts
				);
				$Controller->data = $data;
			}

			Cache::config('seo_cache_cc_report',
				array(
					'engine' => 'File',
					'path' => CACHE . 'seo_tools',
					'duration' => '+30 minutes'
				)
			);

			switch ($CMD) {
				default:
					case 'start':
					if (Cache::read('top_10_optimizer_' . $TOKEN, 'seo_cache_cc_report')) {
						echo "setToken('{$TOKEN}');";
						echo 'finalizeWork();';
						die;
					}

					$errors = array();

					if (empty($Controller->data['Tool']['url'])) {
						$errors[] = __d('seo_tools', 'Invalid URL');
					}

					if (empty($Controller->data['Tool']['criteria'])) {
						$errors[] = __d('seo_tools', 'Invalid criteria');
					}

					if (count($errors)) {
						$Controller->flashMsg(implode('<br />', $errors), 'error');
						die('location.reload();');
					}

					$config = array(
						'token' => $this->getToken(),
						'url' => $Controller->data['Tool']['url'],
						'criteria' => $Controller->data['Tool']['criteria'],
						'engine' => array(
							'class' => $Controller->data['Tool']['engine']['class'],
							'options' => $Controller->data['Tool']['engine']['options']
						),
						'competitors' => array() // list of cache names
					);

					Cache::write('config', $config, 'seo_cache_cc');

					echo "setToken('{$TOKEN}');";
					echo "taskDone('{$CMD}');";
					echo "runTask('get_site_page');";
					die;
				break;

				case 'get_site_page':
					$config = Cache::read('config', 'seo_cache_cc');

					Cache::write('site_html', $this->BaseTools->getPage($config['url']), 'seo_cache_cc');

					echo "taskDone('{$CMD}');";
					echo "runTask('get_snippets');";
					die;
				break;

				case 'get_snippets':
					$config = Cache::read('config', 'seo_cache_cc');
					$snippets = $this->getSnippet($config['criteria'], $config['engine']);

					foreach ($snippets as $s) {
						$competitorCachePrefix = 'competitor_' . md5($s['url']);
						$s['_cache_prefix'] = $competitorCachePrefix;
						$config['competitors'][$competitorCachePrefix] = $s;
					}

					Cache::write('snippets', $snippets, 'seo_cache_cc');
					Cache::write('config', $config, 'seo_cache_cc');

					echo "taskDone('{$CMD}');";
					echo "runTask('get_competitor_page');";
					die;
				break;

				case 'get_competitor_page':
					$config = Cache::read('config', 'seo_cache_cc');

					foreach ($config['competitors'] as &$c) {
						if (!isset($c['_page_downloaded'])) {
							$c['_page_downloaded'] = true;

							Cache::write('config', $config, 'seo_cache_cc');
							Cache::write("{$c['_cache_prefix']}_html", $this->BaseTools->getPage($c['url']), 'seo_cache_cc');
							echo "runTask('get_competitor_page');";
							die;
						}
					}

					echo "taskDone('{$CMD}');";
					echo "runTask('analize_competitor');";
					die;			
				break;

				case 'analize_competitor':
					$config = Cache::read('config', 'seo_cache_cc');
					$competitor = array_shift($config['competitors']);
					$competitorCachePrefix = $competitor['_cache_prefix'];
					$SeoStats = $this->BaseTools->loadTool('SeoStats');

					if ($competitor) {
						Cache::write('config', $config, 'seo_cache_cc');

						$competitor['page_cache'] = "{$competitorCachePrefix}_html";
						$competitor['meta_tags'] = @(array)get_meta_tags($competitor['url']);
						$parseUrl = $this->BaseTools->parseUrl($competitor['url']);

						$competitor['alexa_rank'] = $this->formatedNumberToInteger($SeoStats->getAlexaRank($competitor['url']));
						$competitor['domain_age'] = $SeoStats->getAge($parseUrl['host']);
						$competitor['backlinks'] = array(
							'alexa' => $this->formatedNumberToInteger($SeoStats->getBacklinkAlexa($parseUrl['full'])),
							'google' => $this->formatedNumberToInteger($SeoStats->getBacklinksGoogle($parseUrl['full'])),
							'seoprofiler' => $this->formatedNumberToInteger($SeoStats->getBacklinksSEOprofiler($parseUrl['full']))
						);

						foreach ($competitor['meta_tags'] as $c_tag_name => &$c_tag_data) {
							$c_tag_data = $this->BaseTools->toUTF8(html_entity_decode($c_tag_data));
						}

						$competitors_data = Cache::read('competitors_data', 'seo_cache_cc');
						$competitors_data = !$competitors_data ? array() : $competitors_data;
						$competitors_data[] = $competitor;

						Cache::write('competitors_data', $competitors_data, 'seo_cache_cc');
						echo "runTask('{$CMD}');";
						die;
					} else {
						echo "taskDone('{$CMD}');";
						echo "runTask('analize_site');";
						die;
					}
				break;

				case 'analize_site':
					$config = Cache::read('config', 'seo_cache_cc');
					$parseUrl = $this->BaseTools->parseUrl($config['url']);
					$SeoStats = $this->BaseTools->loadTool('SeoStats');

					$site_data = array(
						'url' => $parseUrl['full'],
						'page_cache' => 'site_html',
						'meta_tags' => @(array)get_meta_tags($parseUrl['full']),
						'backlinks' => array(
							'alexa' => $this->formatedNumberToInteger($SeoStats->getBacklinkAlexa($parseUrl['full'])),
							'google' => $this->formatedNumberToInteger($SeoStats->getBacklinksGoogle($parseUrl['full'])),
							'seoprofiler' => $this->formatedNumberToInteger($SeoStats->getBacklinksSEOprofiler($parseUrl['full']))
						),
						'alexa_rank' => $this->formatedNumberToInteger($SeoStats->getAlexaRank($parseUrl['full'])),
						'domain_age' => $SeoStats->getAge($parseUrl['host'])
					);

					foreach ($site_data['meta_tags'] as $s_tag_name => &$s_tag_data) {
						$s_tag_data = $this->BaseTools->toUTF8(html_entity_decode($s_tag_data));
					}

					Cache::write('site_data', $site_data, 'seo_cache_cc');

					echo "taskDone('{$CMD}');";
					echo "runTask('report');";
					die;
				break;

				case 'report':
					$this->report['config'] = Cache::read('config', 'seo_cache_cc');
					$this->report['site_data'] = (array)Cache::read('site_data', 'seo_cache_cc');
					$this->report['competitors_data'] = (array)Cache::read('competitors_data', 'seo_cache_cc');

					Cache::write('top_10_optimizer_' . $this->getToken(), $this->prepareReport(), 'seo_cache_cc_report');

					echo "taskDone('{$CMD}');";
					echo "finalizeWork();";
					die;
				break;

				case 'finalize':
					$token = $this->getToken();
					$data = Cache::read('top_10_optimizer_' . $this->getToken(), 'seo_cache_cc_report');

					// clear tmps if exists
					$Folder = new Folder($CACHE_FOLDER);
					$Folder->delete();

					return $data;
				break;
			}
		}

        return false;
    }

	private function prepareReport() {
		$out = array(
			'site_data' => $this->report['site_data'],
			'competitors_data' => $this->report['competitors_data']
		);

		// Keyword use in document title
		$out['keyword_use_in_document_title'] = $this->keyword_use_in_document_title();

		// Global link popularity of web site
		$out['number_of_backlinks'] = $this->number_of_backlinks();

		
		// Keyword use in body text
		$out['keyword_use_in_body_text'] = $this->keyword_use_in_body_text();
		
		// Age of web site
		$out['age_of_web_site'] = $this->age_of_web_site();

		// Keyword use in H1 headline texts
		$out['keyword_use_in_h1_headline_texts'] = $this->keyword_use_in_h1_headline_texts();
		
		
		// Keyword use in page URL
		$out['keyword_use_in_page_url'] = $this->keyword_use_in_page_url();
		
		// Number of visitors to the site
		$out['number_of_visitors_to_the_site'] = $this->number_of_visitors_to_the_site();

		// Keyword use in meta description
		$out['keyword_use_in_meta_description'] = $this->keyword_use_in_meta_description();

		// factors stats
		$out['factors'] = $this->report['factors'];

		return $out;
	}

	private function keyword_use_in_document_title() {
		$criteriaWords = $this->criteriaWords($this->report['config']['criteria']);
		$competitorsTitles = array();
		$page = str_get_html(Cache::read($this->report['site_data']['page_cache'], 'seo_cache_cc'));
		$site_title = $page ? $page->find('title', 0) : '';

		if ($site_title) {
			$your_content = $this->emphasizeKeywords($site_title->plaintext, $criteriaWords);
		} else {
			$your_content = '';
		}

		$out = array(
			'their_content' => array(),
			'your_content' => $your_content
		);

		foreach ($this->report['competitors_data'] as $cData) {
			$page = str_get_html(Cache::read($cData['page_cache'], 'seo_cache_cc'));
			$competitor_title = $page ? $page->find('title', 0) : '';

			if ($competitor_title) {
				$out['their_content'][] = $this->emphasizeKeywords($competitor_title->plaintext, $criteriaWords);
				$competitorsTitles[] = $competitor_title->plaintext;
			} else {
				$out['their_content'][] = __d('seo_tools', '[No content was found]');
				$competitorsTitles[] = '';
			}
		}

		$out['keywords_stats'] = $this->keywordsStats(
			$criteriaWords,
			(empty($your_content) ? '' : $site_title->plaintext),
			$competitorsTitles
		);

		foreach ($out['keywords_stats'] as $keyword => $info) {
			foreach ($info as $type => $stats) {
				/* FACTOR-RULE */
				if ($stats['min'] == 0 && $stats['max'] > 0 && $stats['site'] == 0) {
					$class = 'error';
					$this->pushFactor('essential', false); // failed
				} elseif ($stats['avg'] == 0 && $stats['site'] == 0) {
					$class = 'warning';
					$this->pushFactor('essential', true); // passed
				} elseif ($stats['site'] >= $stats['min'] && $stats['max'] >= $stats['site']) { // between ranges -> OK
					$class = 'success';
					$this->pushFactor('essential', true); // passed
				} else {
					$class = 'warning';
					$this->pushFactor('essential', false); //failed
				}

				$out['keywords_stats'][$keyword][$type]['class'] = $class;
				/* FACTOR-RULE */
			}
		}

		return $out;
	}

	private function number_of_backlinks() {
		$out = array(
			'sites' => array(),
			'message' => '', // tips
			'class' => 'info' // success, warning, error
		);

		$yourSite = array(
			'site_name' => __d('seo_tools', 'Your Site'),
			'alexa' => $this->report['site_data']['backlinks']['alexa'],
			'google' => $this->report['site_data']['backlinks']['google'],
			'seoprofiler' => $this->report['site_data']['backlinks']['seoprofiler'],
			'peak' => max(
				array(
					$this->report['site_data']['backlinks']['alexa'],
					$this->report['site_data']['backlinks']['google'],
					$this->report['site_data']['backlinks']['seoprofiler']
				)
			)
		);

		foreach ($this->report['competitors_data'] as $i => $competitor) {
			$out['sites'][] = array(
				'site_name' => __d('seo_tools', 'Site #%d', $i + 1),
				'alexa' => $competitor['backlinks']['alexa'],
				'google' => $competitor['backlinks']['google'],
				'seoprofiler' => $competitor['backlinks']['seoprofiler'],
				'peak' => max(
					array(
						$competitor['backlinks']['alexa'],
						$competitor['backlinks']['google'],
						$competitor['backlinks']['seoprofiler']
					)
				)
			);
		}

		/* FACTOR-RULE */
		$peaks = Hash::extract($out, 'sites.{n}.peak');
		$your = $yourSite['peak'];
		$average = @(array_sum($peaks) / count($peaks));

		if ($your >= max($peaks)) {
			$out['class'] = 'success';
			$this->pushFactor('essential', true);
		} elseif ($your >= $average) {
			$out['class'] = 'warning';
			$this->pushFactor('essential', true);
		} else {
			$out['class'] = 'error';
			$this->pushFactor('essential', false);
		}
		/* FACTOR-RULE */

		array_unshift($out['sites'], $yourSite);

		switch ($out['class']) {
			default:
				case 'error':
					$out['message'] = __d('seo_tools', 'In average, less web pages link to your page than to the top ranked pages. The average link popularity of the top ranked pages is %s, the link popularity of your web page is %s. You must increase the number of web pages from different domains that link to your web site. Keep in mind that all search engines also evaluate the link texts and the quality of the web pages that link to your web site', $average, $your);
			break;

			case 'warning':
				$out['message'] = __d('seo_tools', 'Summing up all analyzed search engines, there are at least as many web pages linking to your page as to the top ranked pages. This meets the basic requirements for getting high rankings on %s. Keep in mind that all search engines also evaluate the link texts and the quality of the web pages that link to your web site', $this->report['config']['engine']['class']);
			break;

			case 'success':
				$out['message'] = __d('seo_tools', 'Summing up all analyzed search engines, you have more web pages linking to your web page than the top ranking web pages. This is very good. However, %s also evaluates the link texts and the quality of the web pages that link to your web site', $this->report['config']['engine']['class']);
			break;
		}

		return $out;
	}

	private function keyword_use_in_body_text() {
		$criteriaWords = $this->criteriaWords($this->report['config']['criteria']);
		$competitorsBodies = array();
		$page = str_get_html(Cache::read($this->report['site_data']['page_cache'], 'seo_cache_cc'));
		$site_body = $page ? $page->find('body', 0) : '';

		if ($site_body) {
			$your_content = $this->emphasizeKeywords($site_body->plaintext, $criteriaWords);
		} else {
			$your_content = '';
		}

		$out = array(
			'their_content' => array(),
			'your_content' => $your_content
		);

		foreach ($this->report['competitors_data'] as $cData) {
			$page = str_get_html(Cache::read($cData['page_cache'], 'seo_cache_cc'));
			$competitor_body = $page ? $page->find('body', 0) : '';

			if ($competitor_body) {
				$out['their_content'][] = $this->emphasizeKeywords($competitor_body->plaintext, $criteriaWords);
				$competitorsBodies[] = $competitor_body->plaintext;
			} else {
				$out['their_content'][] = __d('seo_tools', '[No content was found]');
				$competitorsBodies[] = '';
			}
		}

		$out['keywords_stats'] = $this->keywordsStats(
			$criteriaWords,
			(empty($your_content) ? '' : $site_body->plaintext),
			$competitorsBodies
		);

		foreach ($out['keywords_stats'] as $keyword => $info) {
			foreach ($info as $type => $stats) {
				/* FACTOR-RULE */
				if ($stats['min'] == 0 && $stats['max'] > 0 && $stats['site'] == 0) {
					$class = 'error';
					$this->pushFactor('essential', false); // failed
				} elseif ($stats['avg'] == 0 && $stats['site'] == 0) {
					$class = 'warning';
					$this->pushFactor('essential', true); // passed
				} elseif ($stats['site'] >= $stats['min'] && $stats['max'] >= $stats['site']) { // between ranges -> OK
					$class = 'success';
					$this->pushFactor('essential', true); // passed
				} else {
					$class = 'warning';
					$this->pushFactor('essential', false); //failed
				}

				$out['keywords_stats'][$keyword][$type]['class'] = $class;
				/* FACTOR-RULE */
			}
		}

		return $out;
	}

	private function age_of_web_site() {
		$out = array(
			'sites' => array(),
			'message' => '', // tips
			'class' => 'info' // success, warning, error
		);

		$competitorsStamps = array();
		$yourAge = $this->ageFormat($this->report['site_data']['domain_age']);
		$yourSite = array(
			'site_name' => __d('seo_tools', 'Your Site'),
			'url' => $this->report['site_data']['url'],
			'age' => $yourAge[0]
		);

		foreach ($this->report['competitors_data'] as $i => $competitor) {
			$age = $this->ageFormat($competitor['domain_age']);
			$competitorsStamps[] = $age[1];
			$out['sites'][] = array(
				'site_name' => __d('seo_tools', 'Site #%d', $i + 1),
				'url' => $competitor['url'],
				'age' => $age[0]

			);
		}

		/* FACTOR-RULE */
		if ($yourAge[1] == 0 ||
			($yourAge[1] != 0 && $yourAge[1] > (31556926/2) && $yourAge[1] < min($competitorsStamps))
		) {
			$out['class'] = 'warning';
			$this->pushFactor('very_important', true);
		} elseif ($yourAge[1] < 31556926) { // yours < 1 year
			$out['class'] = 'error';
			$this->pushFactor('very_important', false);
		} else {
			$out['class'] = 'success';
			$this->pushFactor('very_important', true);
		}
		/* FACTOR-RULE */

		array_unshift($out['sites'], $yourSite);

		switch ($out['class']) {
			default:
				case 'error':
					$out['message'] = __d('seo_tools', 'Your web site is less than 1 year old');
			break;

			case 'warning':
				$out['message'] = __d('seo_tools', 'The web site age could not be determined or is newer than the newer of your competitors. In general, the older your web site, the better it is for your rankings on %s. If you have a young web site, you must compensate by improving the other search engine ranking factors', $this->report['config']['engine']['class']);
			break;

			case 'success':
				$out['message'] = __d('seo_tools', 'Your web site is about %s years old. This is very good because the older your web site, the better it is for your rankings on %s', number_format($yourAge[1]/31556926, 0), $this->report['config']['engine']['class']);
			break;
		}

		return $out;
	}

	private function keyword_use_in_h1_headline_texts() {
		$criteriaWords = $this->criteriaWords($this->report['config']['criteria']);
		$allCompetitorsH1 = array();
		$your_content_is_empty = false;
		$page = str_get_html(Cache::read($this->report['site_data']['page_cache'], 'seo_cache_cc'));
		$site_h1 = $page ? $page->find('h1') : '';
		$site_h1_list = array();

		if (!empty($site_h1)) {
			foreach ($site_h1 as $h1) {
				$site_h1_list[] = $this->emphasizeKeywords($h1->plaintext, $criteriaWords);
			}
		}

		$out = array(
			'their_content' => array(),
			'your_content' => $site_h1_list
		);

		foreach ($this->report['competitors_data'] as $cData) {
			$page = str_get_html(Cache::read($cData['page_cache'], 'seo_cache_cc'));
			$competitor_h1 = $page ? $page->find('h1') : '';
			$competitor_h1_list = array();

			if ($competitor_h1) {
				foreach ($competitor_h1 as $h1) {
					$competitor_h1_list[] = $this->emphasizeKeywords($h1->plaintext, $criteriaWords);
				}
			}

			$out['their_content'][] = $competitor_h1_list;
			$allCompetitorsH1[] = implode("\n", $competitor_h1_list);
		}

		$out['keywords_stats'] = $this->keywordsStats(
			$criteriaWords,
			($your_content_is_empty ? '' : implode("\n", $site_h1_list)),
			$allCompetitorsH1
		);

		foreach ($out['keywords_stats'] as $keyword => $info) {
			foreach ($info as $type => $stats) {
				if ($type == 'position') {
					continue;
				}

				/* FACTOR-RULE */
				if ($stats['min'] == 0 && $stats['max'] > 0 && $stats['site'] == 0) {
					$class = 'error';
					$this->pushFactor('very_important', false); // failed
				} elseif ($stats['avg'] == 0 && $stats['site'] == 0) {
					$class = 'warning';
					$this->pushFactor('very_important', true); // passed
				} elseif ($stats['site'] >= $stats['min'] && $stats['max'] >= $stats['site']) { // between ranges -> OK
					$class = 'success';
					$this->pushFactor('very_important', true); // passed
				} else {
					$class = 'warning';
					$this->pushFactor('very_important', false); //failed
				}

				$out['keywords_stats'][$keyword][$type]['class'] = $class;
				/* FACTOR-RULE */
			}
		}

		return $out;
	}

	private function keyword_use_in_page_url() {
		$criteriaWords = $this->criteriaWords($this->report['config']['criteria']);
		$competitorsURLs = array();

		if (!empty($this->report['site_data']['url'])) {
			$your_content = $this->emphasizeKeywords($this->report['site_data']['url'], $criteriaWords);
		} else {
			$your_content = '';
		}

		$out = array(
			'their_content' => array(),
			'your_content' => $your_content
		);

		foreach ($this->report['competitors_data'] as $cData) {
			if (!empty($cData['url'])) {
				$out['their_content'][] = $this->emphasizeKeywords($cData['url'], $criteriaWords);
			} else {
				$out['their_content'][] = __d('seo_tools', '[No content was found]');
			}

			$competitorsURLs[] = $cData['url'];
		}

		$out['keywords_stats'] = $this->keywordsStats(
			$criteriaWords,
			(empty($your_content) ? '' : $this->report['site_data']['url']),
			$competitorsURLs
		);

		foreach ($out['keywords_stats'] as $keyword => $info) {
			foreach ($info as $type => $stats) {
				/* FACTOR-RULE */
				if ($stats['min'] == 0 && $stats['max'] > 0 && $stats['site'] == 0) {
					$class = 'error';
					$this->pushFactor('very_important', false); // failed
				} elseif ($stats['avg'] == 0 && $stats['site'] == 0) {
					$class = 'warning';
					$this->pushFactor('very_important', true); // passed
				} elseif ($stats['site'] >= $stats['min'] && $stats['max'] >= $stats['site']) { // between ranges -> OK
					$class = 'success';
					$this->pushFactor('very_important', true); // passed
				} else {
					$class = 'warning';
					$this->pushFactor('very_important', false); //failed
				}

				$out['keywords_stats'][$keyword][$type]['class'] = $class;
				/* FACTOR-RULE */
			}
		}

		return $out;
	}

	private function number_of_visitors_to_the_site() {
		$out = array(
			'sites' => array(),
			'message' => '', // tips
			'class' => 'info' // success, warning, error
		);

		$competitorsRanks = array();
		$yourSite = array(
			'site_name' => __d('seo_tools', 'Your Site'),
			'url' => $this->report['site_data']['url'],
			'rank' => ($this->report['site_data']['alexa_rank'] < 0 ? __d('seo_tools', 'n/a') : $this->report['site_data']['alexa_rank'])
		);

		foreach ($this->report['competitors_data'] as $i => $competitor) {
			if ($competitor['alexa_rank'] >= 0) {
				$competitorsRanks[] = $competitor['alexa_rank'];
			}

			$out['sites'][] = array(
				'site_name' => __d('seo_tools', 'Site #%d', $i + 1),
				'url' => $competitor['url'],
				'rank' => ($competitor['alexa_rank'] < 0 ? __d('seo_tools', 'n/a') : $competitor['alexa_rank'])

			);
		}

		/* FACTOR-RULE */
		$your = $yourSite['rank'];
		$average = count($competitorsRanks) ? array_sum($competitorsRanks) / count($competitorsRanks) : -1;

		if ($your < $average && 170000 < $average) {
			$out['message'] = __d('seo_tools', "Although your web site %s appears to attract more visitors than the average of your competitors sites, the absolute number of visitors is low. This could be disadvantageous to your rankings on %s", $this->report['site_data']['url'], $this->report['config']['engine']['class']);
			$out['class'] = 'warning';
			$this->pushFactor('important', true);
		} elseif (
			$your > $average ||
			($your > 170000 && $average < $your)
		) {
			$out['message'] = __d('seo_tools', 'Your web site %s does not appear to attract many visitors because your traffic trank is above #100,000 and you have less visitors than the average of your competitors. This could be disadvantageous to your rankings on %s', $this->report['site_data']['url'], $this->report['config']['engine']['class']);
			$out['class'] = 'error';
			$this->pushFactor('important', false);
		} elseif ($your < 170000) {
			$out['message'] = __d('seo_tools', 'Your web site %s appears to attract a lot of visitors. This is very good and might be beneficial to your rankings on %s', $this->report['site_data']['url'], $this->report['config']['engine']['class']);
			$out['class'] = 'success';
			$this->pushFactor('important', true);
		}
		/* FACTOR-RULE */

		array_unshift($out['sites'], $yourSite);

		return $out;
	}
	
	private function keyword_use_in_meta_description() {
		$criteriaWords = $this->criteriaWords($this->report['config']['criteria']);
		$competitorsMetas = array();

		if (
			isset($this->report['site_data']['meta_tags']['description']) &&
			!empty($this->report['site_data']['meta_tags']['description'])
		) {
			$your_content = $this->emphasizeKeywords($this->report['site_data']['meta_tags']['description'], $criteriaWords);
		} else {
			$your_content = '';
		}

		$out = array(
			'their_content' => array(),
			'your_content' => $your_content
		);

		foreach ($this->report['competitors_data'] as $cData) {
			if (isset($cData['meta_tags']['description']) && !empty($cData['meta_tags']['description'])) {
				$out['their_content'][] = $this->emphasizeKeywords($cData['meta_tags']['description'], $criteriaWords);
				$competitorsMetas[] = $cData['meta_tags']['description'];
			} else {
				$out['their_content'][] = __d('seo_tools', '[No content was found]');
			}
		}

		$out['keywords_stats'] = $this->keywordsStats(
			$criteriaWords,
			(empty($your_content) ? '' : $this->report['site_data']['meta_tags']['description']),
			$competitorsMetas
		);

		foreach ($out['keywords_stats'] as $keyword => $info) {
			foreach ($info as $type => $stats) {
				/* FACTOR-RULE */
				if ($stats['min'] == 0 && $stats['max'] > 0 && $stats['site'] == 0) {
					$class = 'error';
					$this->pushFactor('essential', false); // failed
				} elseif ($stats['avg'] == 0 && $stats['site'] == 0) {
					$class = 'warning';
					$this->pushFactor('essential', true); // passed
				} elseif ($stats['site'] >= $stats['min'] && $stats['max'] >= $stats['site']) { // between ranges -> OK
					$class = 'success';
					$this->pushFactor('essential', true); // passed
				} else {
					$class = 'warning';
					$this->pushFactor('essential', false); //failed
				}

				$out['keywords_stats'][$keyword][$type]['class'] = $class;
				/* FACTOR-RULE */
			}
		}

		return $out;
	}

	private function ageFormat($data) {
		if (!isset($data['years']) || !isset($data['days'])) {
			return array('n/a', 0);
        }

		$stamp = ($data['years'] * 31556926) + ($data['days'] * 86400);
		$human = __d('seo_tools', '%s years, %s days. (%s)', $data['years'], $data['days'], date(__d('seo_tools', 'Y-m-d'), strtotime(date('Y-m-d')) - $stamp));

		return array($human, $stamp);	
	}

	private function formatedNumberToInteger($data) {
		if (is_array($data)) {
			foreach($data as &$rank) { 
                $rank = (int)str_replace(array(',', '.'), '', $rank);
            }

			return $data;
		}

		$data = (int)str_replace(array(',', '.'), '', $data);

		return $data;
	}

/**
 * Get a list of words by Splitting criteria into words.
 * The last element in the list will be the complete criteria.
 * Words of 1-2 letters length are automatically ignored.
 *
 * Example:
 *
 *     criteriaChunk('Where can I buy a unicorn');
 *     // returns: array('Where', 'can', 'buy', 'unicorn', 'Where can I buy a unicorn');
 *
 * @param string $criteria Search criteria
 * @return array List of words
 */
	private function criteriaWords($criteria) {
		$words = explode(' ', preg_replace('/\s{2,}/', ' ', trim($criteria)));

		foreach ($words as $i => $word) {
			if (strlen($word) <= 2) {
				unset($words[$i]);
			}
		}

		$words[] = $criteria;

		return $words;
	}

/**
 * Registers a new factor as failed/passed.
 *
 * @param string $type essential, very_important, important
 * @param boolean $status TRUE means passed, FALSE means failed
 * @return void
 */
	private function pushFactor($type, $status) {
		if ($status) {
			$this->report['factors'][$type][0]++;
		} else {
			$this->report['factors'][$type][1]++;
		}
	}

/**
 * Keywords stats. Quantity, Density, Positioning.
 *
 * @param $keywords The keywords no analize
 * @param $siteContent Your site content
 * @param $competitors A list of each competitor's content. 
 */
	private function keywordsStats($keywords, $siteContent = '', $competitors = array()) {
		$out = array();

		foreach ($keywords as $kw) {
			$quantity = $density = $position = array();

			foreach ($competitors as $competitorContent) {
				$quantity[] = $this->wordOccurr($competitorContent, $kw);
				$density[] = $this->wordDensity($competitorContent, $kw);
				$position[] = $this->wordPosition($competitorContent, $kw);
			}

			$out[$kw] = array(
				'quantity' => array(
					'min' => min($quantity), // min of competitors
					'max' => max($quantity), // max of competitors
					'avg' => (array_sum($quantity) / count($quantity)), // average value from competitors
					'site' => $this->wordOccurr($siteContent, $kw), // your's site value
					'class' => '' // success, warning, error
				),
				'density' => array(
					'min' => min($density),
					'max' => max($density),
					'avg' => (array_sum($density) / count($density)),
					'site' => $this->wordDensity($siteContent, $kw),
					'class' => '' // success, warning, error
				),
				'position' => array(
					'min' => min($position),
					'max' => max($position),
					'avg' => (array_sum($position) / count($position)),
					'site' => $this->wordPosition($siteContent, $kw),
					'class' => '' // success, warning, error
				)
			);
		}

		return $out;
	}

	private function emphasizeKeywords($str, $words = array(), $type = 'bold') {
		switch($type) {
			case 'highlight': 
                default: 
                    $var_style = 'background: #CEDAEB;'; 
            break;
            
			case 'bold': 
                $var_style = 'font-weight: bold;'; 
            break;
            
			case 'underline': 
                $var_style = 'text-decoration: underline;'; 
            break;
		}

		if (is_array($words)) {
			foreach($words as $word) {
				if(strlen($word) <= 1) {
					continue;
                }
                
				if(!empty($word)) {
					$word= strip_tags($word);
					$word= preg_quote($word, '/');

					$str = preg_replace("/({$word})/i", "<span style='".$var_style."'>\\1</span>", $str);
				}
			}

			return $str;
		}

		return false;
	}	

	private function getToken() {
		$token = false;

		if (isset($this->Controller->data['Tool']['cmd']) && $this->Controller->data['Tool']['cmd'] == 'start') {
			$token = md5($this->Controller->data['Tool']['url'] . $this->Controller->data['Tool']['criteria'] . $this->Controller->data['Tool']['engine']);
		} elseif (isset($this->Controller->data['Tool']['token'])) {
			$token = $this->Controller->data['Tool']['token'];
		}

		return $token;
	}

	private function stringToKeywords($page) {
		$page = $this->BaseTools->html2text($page);

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

		foreach ($page as $key => $word) {
			if (strlen($word) == 1) {
				unset($page[$key]);
            }
		}

		$page = implode(' ', $page);
		$page = strtolower($page);

        if (isset($Controller->data['Tool']['exclude_words']) && !empty($Controller->data['Tool']['exclude_words'])) {
            $ew = explode("\n", $Controller->data['Tool']['exclude_words']);
            $page = $this->excludeWords($page, $ew);
        }

		return $page;
	}     
    
	private function wordPosition($source, $word) {
		$source = $this->excludeWords($source);
		$strpos = strpos(strtolower($source), strtolower($word));

		return $strpos === false ? 0 : $strpos + 1;
	}

	private function wordsCount($source) {
		$source = $this->stringToKeywords($source);
		$words  = str_word_count($source, 1);

		return count($words);
	}

	private function wordOccurr($source, $word) {
		$source = $this->stringToKeywords($source);
		$word = strtolower($word);
		$words = str_word_count($source, 1);
		$word_c = str_word_count($word, 1);  // words of keyword
		$occurr = 0;

		foreach ($words as $index => $_word) {
			if (count($word_c) > 0) {
				$sub_occurr = 0;

				for ($i = 0; $i < count($word_c); $i++) {
					$sub_occurr = (isset($words[$index+$i]) && $words[$index+$i] == $word_c[$i]) ? $sub_occurr+1 : $sub_occurr;
				}

				$occurr = ($sub_occurr == count($word_c)) ? $occurr + 1 : $occurr;
			} else {
				$occurr = ($_word == $word) ? $occurr + 1 : $occurr;
			}
		}

        $this->tmp = count($words);

		return $occurr;
	}

	private function wordDensity($source, $word) {
		$occurr = $this->wordOccurr($source, $word);
		$words = str_word_count($source, 1);
		$count = count($words);

		if (!$count) {
			return 0;
		}

		return number_format(($occurr * 100) / $count, 2);
	}

	private function getSnippet($keywords, $engine) {
        $className = Inflector::camelize($engine['class']);
        $class = dirname(__FILE__) . DS  . 'SearchEngine' . DS . $className . '.php';

        if (file_exists($class)) {
            require_once $class;

            $Engine = new $className;
            $Engine->BaseTools = $this->BaseTools;
			
			return $Engine->results($keywords, $engine['options']);
        }

        return array();
	}

	private function parseTag($tag, $haystack, $all = false) {
		$pattern = '/\<' . $tag . '(.*)\>(.*)\<\/' . $tag . '\>/iUs';

        if ($all) {
			preg_match_all($pattern, $haystack, $matches);
		} else {
			preg_match($pattern, $haystack, $matches);
		}

		$matches = isset($matches[2]) ? $matches[2] : '';

		return $matches;
	}  

	private function excludeWords($str, $exclude_words = array()) {
		foreach ($exclude_words as $filter_word) {
			$str = preg_replace(array('/[ ]{2,}/', '/\b' . strtolower($filter_word) . '\b/i'), array(' ', ''), $str);
		}

		return $str; 
	}    
}