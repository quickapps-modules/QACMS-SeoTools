<?php
class Google {
	public function results($keywords, $options) {
		App::import('Vendor', 'SeoTools.simple_html_dom');

		$out = array();
		$domain = $options[0];
		$q = urlencode($keywords);
		$html = file_get_html("http://{$domain}/search?q={$q}&num=10");

		foreach ($html->find('li.g') as $snippet) {
			// ignore Gmap results
			if (!$snippet->find('table', 0)) {
				$url = $snippet->find('h3.r a', 0);
				$title = $snippet->find('h3', 0);
				$description = $snippet->find('span.st', 0);

				if ($url && $title && $description) {
					$out[] = array(
						'url' => $this->__fixUrl($url->href),
						'title' => $this->BaseTools->toUTF8($title->plaintext),
						'description' => $this->BaseTools->toUTF8($description->plaintext)
					);
				}
			}
		}

		return $out;
	}

	private function __fixUrl($url) {
		list($url, $dummy) = explode('&sa=', html_entity_decode(urldecode($url)));
		$url = str_replace('/url?q=', '', $url);

		return $url;
	}
}