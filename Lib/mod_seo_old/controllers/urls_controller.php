<?php
class UrlsController extends ModSeoAppController {

	var $name = 'Urls';
	var $uses = array('ModSeo.Url');
	
	function index(){
		$conditions = $joins = null;
		$limit = Configure::read('rows_per_page');
		
		if ( isset($this->data['Url']['search']) ){
			if ( !empty($this->data['Url']['search']['field']) && !empty($this->data['Url']['search']['value']) )
				$conditions["Url.{$this->data['Course']['search']['field']} LIKE"] = "%{$this->data['Url']['search']['value']}%";

			$limit = 9999;
		}
		
		$this->paginate = array(
			'joins' => $joins, 
			'conditions' => $conditions,
			'limit' => $limit
		);		
		
		$results = $this->paginate('Url');
		$this->set('results', $results);
	}
	
	function edit($id = null){
		$id = isset($this->data['Url']['id']) ? $this->data['Url']['id'] : $id;
		
		if ( isset($this->data['Url']['id']) ){
			$this->Url->set($this->data);
			
			if ( $this->Url->validates() ){
				$this->Url->save($this->data, false);
			} else {
				header('HTTP/1.1 403 Forbidden');
				$this->cakeError('form_error', $this->Url->invalidFields());
				die();
			}
		}
	
		$this->data = $this->Url->findById($id);
		if ( empty($this->data) )
			$this->redirect("/{$this->plugin}/");
	}
	

}
?>
