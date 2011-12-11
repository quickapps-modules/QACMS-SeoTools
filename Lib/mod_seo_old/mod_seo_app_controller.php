<?php 
class ModSeoAppController extends AppController {


    function beforeFilter(){
		parent::beforeFilter();
		$configs = Cache::read('ModSeoConfig');
		if  ( !$configs ){
			$this->loadModel('ModuleConfig');
			$configs = $this->ModuleConfig->findAllByProductId(30);
			Cache::write('ModSeoConfig', $configs);
		}
		
		foreach( $configs as $conf){
			if ( $conf['ModuleConfig']['key'] == 'seo_exclude_words' ){
				$conf['ModuleConfig']['value'] = explode(',', $conf['ModuleConfig']['value']);
			}
			Configure::write('ModSeo.Config.' . $conf['ModuleConfig']['key'], $conf['ModuleConfig']['value']);
		}

	}
    
}
?>
