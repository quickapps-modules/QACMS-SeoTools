<?php 
class SeoToolsAppController extends AppController {
	public function beforeFilter() {
		if (
			isset($this->request->params['admin']) &&
            $this->request->params['plugin'] == 'seo_tools'	&&	
			!Configure::read('Variable.site_description')
		) {
			if (!CakeSession::read('Message.flash')) {
				$this->flashMsg(
					__d('seo_tools',
						'<b>IMPORTANT:</b> Please enter a <a href="%s">site description</a>, it will be used as default meta-description.',
						Router::url('/admin/system/configuration')
					), 'warning'
				);
			}
		}

		parent::beforeFilter();
	}
}