<?php 
class CssValidatorComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['url'])) {
            return false;
        }

        return "http://jigsaw.w3.org/css-validator/validator?uri={$Controller->data['Tool']['url']}";        
    }
}