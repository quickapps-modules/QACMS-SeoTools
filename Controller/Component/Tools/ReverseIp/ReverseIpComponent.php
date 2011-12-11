<?php 
class ReverseIpComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['ip'])) {
            return false;
        }

        $results = $this->BaseTools->ping($Controller->data['Tool']['ip'], true);

        return $results;
    }
}