<?php
class Bing {
	public function results($keywords, $options) {
		App::import('Vendor', 'SeoTools.simple_html_dom');

		$out = array();
		$domain = $options[0];
		$q = urlencode($keywords);
		$html = file_get_html("http://{$domain}/search?q={$q}");

		foreach ($html->find('li.sa_wr') as $snippet) {
			$title = $snippet->find('h3', 0);
			$url = $snippet->find('h3 a', 0);
			$description = $snippet->find('p', 0);

			if ($url && $title && $description) {
				$out[] = array(
					'url' => $url->href,
					'title' => $this->BaseTools->toUTF8($title->plaintext),
					'description' => $this->BaseTools->toUTF8($description->plaintext)
				);
			}
		}

		return $out;
	}
}