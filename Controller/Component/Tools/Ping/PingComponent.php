<?php 
class PingComponent extends Component {
    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['domain_ip'])) {
            return false;
        }

        $results = $this->BaseTools->ping($Controller->data['Tool']['domain_ip']);

        return $results;
    }
}