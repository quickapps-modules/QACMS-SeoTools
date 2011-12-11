<?php 
class HeaderExtractorComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

		$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);

		if (function_exists('curl_init')) {
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $parseUrl['full']);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_HEADER, true);

            $html = curl_exec($ch);

			return $html;
		} else {
			$http_response_header = get_headers($parseUrl['full']);

			return implode("\n", $http_response_header);
		}

        return false;        
    }
}