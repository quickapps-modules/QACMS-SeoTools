<?php 
class RobotsTxtComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

		$parseUrl = $this->BaseTools->parseUrl($Controller->data['Tool']['url']);
		$page = $this->BaseTools->getPage($parseUrl['full'] . '/robots.txt');

        return $this->BaseTools->toUTF8($page);
    }
}