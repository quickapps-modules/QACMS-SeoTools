<?php 
class MetatagsExtractorComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

		$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
		$tags = get_meta_tags($parseUrl['full']);
		$out = array();

		foreach ($tags as $key => $value) {
			$out[] = "<meta name=\"{$key}\" content=\"{$value}\" >";
		}

        return $out;
    }
}