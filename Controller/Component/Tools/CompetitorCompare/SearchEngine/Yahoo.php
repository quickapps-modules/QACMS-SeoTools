<?php
class Yahoo {
	public function results($keywords, $options) {
		App::import('Vendor', 'SeoTools.simple_html_dom');

		$out = array();
		$domain = $options[0];
		$q = urlencode($keywords);
		$html = file_get_html("http://{$domain}/search?p={$q}");

		foreach ($html->find('div.res') as $snippet) {
			$url = $snippet->find('h3 a', 0);
			$title = $snippet->find('h3', 0);
			$description = $snippet->find('div.abstr', 0);

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