<?php 
class Md5EncrypterComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['text'])) {
            return false;
        }

        return md5($Controller->data['Tool']['text']);
    }
}