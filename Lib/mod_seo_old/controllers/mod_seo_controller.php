<?php
class ModSeoController extends ModSeoAppController {

	var $name = 'ModSeo';
	var $uses = array();
	
	function index(){
		$this->redirect("/{$this->plugin}/urls");
	}
	
}
?>