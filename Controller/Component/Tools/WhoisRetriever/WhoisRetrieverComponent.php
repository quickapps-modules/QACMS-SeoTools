<?php 
class WhoisRetrieverComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

		$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
		$url = preg_replace('/www\./', '', $parseUrl['host']);
		$url = "http://reports.internic.net/cgi/whois?whois_nic={$url}&type=domain";
		$page = $this->BaseTools->getPage($url);

		preg_match('/<pre>(.*)<\/pre>/si', $page, $p);

		return isset($p[1]) ? $p[1] : '';        
    }
}