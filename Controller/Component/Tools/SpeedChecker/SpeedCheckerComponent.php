<?php 
class SpeedCheckerComponent extends Component {
    public function main(&$Controller) {
		if (isset($Controller->data['Tool']['url'])) {
			$debugLVL = Configure::read('debug');
			$Controller->Layout['javascripts']['file'][] = '/seo_tools/js/Tools/SpeedChecker/jquery.tablesorter.js';
			$Controller->Layout['javascripts']['file'][] = '/seo_tools/js/Tools/SpeedChecker/jquery.tablesorter.widgets.min.js';
			$Controller->Layout['javascripts']['file'][] = '/seo_tools/js/Tools/SpeedChecker/jquery.metadata.js';

			set_time_limit(0);
			Configure::write('debug', 0);
			App::import('Vendor', 'SeoTools.simple_html_dom');
			App::uses('Timer', 'SeoTools.Lib');
			App::uses('FieldFile', 'FieldFile.Lib');

			$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
			$URL = $parseUrl['full'];
			$haders = get_headers($URL, 1);
			$globalTime = 0;
			$globalSize = $haders['Content-Length'];
			$Timer = new Timer();

			$Timer->start();
			$page = file_get_html($URL);
			$Timer->stop();

			if (!$page) {
				$Controller->flashMsg(__d('seo_tools', 'Invalid URL, page does not exists or could not be retrieved.'), 'error');
				return false;
			}

			$globalTime = $Timer->get();
			$resources = array();

			foreach ($page->find('img') as $img) {
				if (!empty($img->src)) {
					$resources['img'][] = array(
						'link' => $img->src,
						'size' => 0,
						'time' => 0,
						'width' => __d('seo_tools', 'n/a'),
						'height' => __d('seo_tools', 'n/a')
					);
				}
			}

			foreach ($page->find('script') as $js) {
				if (!empty($js->src)) {
					$resources['js'][] = array(
						'link' => $js->src,
						'size' => 0,
						'time' => 0
					);
				}
			}

			foreach ($page->find('link') as $css) {
				if ($css->type == 'text/css') {
					$resources['css'][] = array(
						'link' => $css->href,
						'size' => 0,
						'time' => 0
					);
				}
			}

			foreach ($resources as $type => $links) {
				foreach ($links as $i => $r) {
					if (substr($r['link'], 0, 1) == '/' || substr($r['link'], 0, 1) == '.') {
						$r['link'] = $parseUrl['full'] . $r['link'];
					} elseif(substr($r['link'], 0, 11) == 'javascript:' || substr($r['link'], 0, 7) == 'mailto:') {
						unset($resources[$type][$i]);
						continue;
					} elseif (substr($r['link'], 0, 7) != 'http://' && substr($r['link'], 0, 8) != 'https://') {
						$r['link'] = $parseUrl['full'] . '/' . $r['link'];
					}

					$haders = get_headers($r['link'], 1);
					$r['size'] = $haders['Content-Length'];
					$globalSize += $r['size'];

					if (preg_match('/^image\//', $haders['Content-Type'])) {
						$imgSize = getimagesize($r['link']);
						$r['width'] = $imgSize[0];
						$r['height'] = $imgSize[1];
					}

					$Timer->reset();
					$Timer->start();
					file_get_contents("http://example.com/image.jpg");
					$Timer->stop();

					$r['time'] = $Timer->get();
					$globalTime += $r['time'];
					$resources[$type][$i] = $r;
				}
			}

			Configure::write('debug', $debugLVL);

			return array(
				'resources' => $resources,
				'url' => $URL,
				'size' => $globalSize,
				'time' => $globalTime
			);
		}
    }
}