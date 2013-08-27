<?php 
class LinkExtractorComponent extends Component {
    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }
		
		App::import('Vendor', 'SeoTools.simple_html_dom');

		$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
		$page = file_get_html($parseUrl['full']);
		$links = array();

		foreach ($page->find('a') as $a) {
			$link = $this->BaseTools->unrelativizeLink($a->href, $parseUrl['full']);

			if ($link) {
				$links[] = $link;
			}
		
		}

		return array_unique($links);
    }
}