<?php 
class HtmlEncrypterComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['text'])) {
            return false;
        }

        $results = "
<script language=\"JavaScript\" type=\"text/javascript\">
    <!-- HTML Encryption provided by QuickApps CMS SeoTools Module -->
    <!--
    document.write(unescape('". rawurlencode($Controller->data['Tool']['text']) . "'));
    //-->
</script>";

        return $results;
    }
}