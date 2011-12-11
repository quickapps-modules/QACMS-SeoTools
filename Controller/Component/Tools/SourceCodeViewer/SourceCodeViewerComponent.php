<?php 
class SourceCodeViewerComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

        $parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);

        return $this->BaseTools->getPage($parseUrl['full']);
    }
}