<?php 
class HtmlValidatorComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

        return "http://validator.w3.org/check?uri={$Controller->data['Tool']['url']}";
    }
}