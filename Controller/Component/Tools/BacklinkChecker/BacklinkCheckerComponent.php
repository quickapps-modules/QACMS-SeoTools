<?php 
class BacklinkCheckerComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

        $results = array(
            'alexa' => $this->getBacklinkAlexa($Controller->data['Tool']['url']),
            'google' => $this->getBacklinksGoogle($Controller->data['Tool']['url']),
            'yahoo' => $this->getBacklinksYahoo($Controller->data['Tool']['url']),
        );

        return $results;
    }
    
	public function getBacklinkAlexa($url) {
		$url = 'http://data.alexa.com/data?cli=10&dat=s&url=' . $url;
		$data = $this->BaseTools->getPage($url);

        preg_match('/LINKSIN NUM="(.*?)"/i', $data, $p);

        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;
		
        return $value;
	}
    
	public function getBacklinksGoogle($url) {
		$url = 'http://www.google.com/search?q=link:' . urlencode($url) . '&hl=en';
		$data = $this->BaseTools->getPage($url);

        preg_match('/([0-9\,]+) (results|result)<nobr>/si', $data, $p);

        $value = isset($p[1]) ? number_format($this->BaseTools->toInt($p[1])) : 0;

        return $value;
	}

	function getBacklinksYahoo($url) {
		$url01 = 'http://siteexplorer.search.yahoo.com/search?p='. urlencode("$url") . '&bwm=i&bwmo=d&bwmf=u';
		$data01 = $this->BaseTools->getPage($url01);

        preg_match('/Inlinks \(([0-9\,]+)\)/si', $data01, $p01);

        $value01 = isset($p01[1]) ? number_format($this->BaseTools->toInt($p01[1])) : 0;
		$value01 = str_replace(",", "", $value01);
		$url02 = 'http://siteexplorer.search.yahoo.com/search?p=www.' . urlencode("$url") . '&bwm=i&bwmo=d&bwmf=u';
		$data02 = $this->BaseTools->getPage($url02);

        preg_match('/Inlinks \(([0-9\,]+)\)/si', $data02, $p02);

        $value02 = isset($p02[1]) ? number_format($this->BaseTools->toInt($p02[1])) : 0;
		$value02 = str_replace(",", "", $value02);

		if ($value01 > $value02) {
			$value = number_format($this->BaseTools->toInt($value01));
		} else {
			$value = number_format($this->BaseTools->toInt($value02));
		}

		return $value;
	}
}