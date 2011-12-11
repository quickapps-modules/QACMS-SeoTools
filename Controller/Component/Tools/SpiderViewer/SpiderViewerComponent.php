<?php 
class SpiderViewerComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

		$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
		$page = $this->BaseTools->getPage($parseUrl['full']);

        return $this->BaseTools->toUTF8($this->BaseTools->html2text($page));        
    }
}