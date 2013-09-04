<?php 
class SiteSettingsController extends SeoToolsAppController {
	public $uses = array('System.Module');

    public function admin_index() {
		if (isset($this->data['Module']['settings'])) {
			$data = $this->data;
			$data['Module']['name'] = 'SeoTools';

			if ($this->Module->save($data)) {
				$this->flashMsg(__d('seo_tools', 'Site configuration has been saved.'));
				Cache::delete('modules');
				Cache::delete('robots', 'seo_tools_optimized_url');
			} else {
				$this->flashMsg(__d('seo_tools', 'Site configuration could not be saved.'), 'error');
			}

			$this->redirect($this->referer());
		}

		$this->data = $this->Module->findByName('SeoTools');
        $this->setCrumb(
            '/admin/seo_tools',
            array(__d('seo_tools', 'Site configuration'))
        );		
	}
}