<?php 
class SourceCodeViewerComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

        $parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
		$Controller->Layout['javascripts']['file'][] = '/seo_tools/js/highlight-master/jquery.highlight.js';
		$Controller->Layout['stylesheets']['all'][] = '/seo_tools/js/highlight-master/jquery.highlight.css';

        return $this->BaseTools->toUTF8($this->BaseTools->getPage($parseUrl['full']));
    }
}