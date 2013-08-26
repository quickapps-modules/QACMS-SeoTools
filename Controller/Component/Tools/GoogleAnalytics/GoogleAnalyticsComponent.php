<?php
class GoogleAnalyticsComponent extends Component {
    public function main(Controller $Controller) {
		if (!empty($Controller->data)) {
			$module = $Controller->Module->find('first',
				array(
					'fields' => array('name', 'settings'),
					'conditions' => array('Module.name' => 'SeoTools')
				)
			);

			if (isset($Controller->data['Tool']['google_analytics'])) {
				$module['Module']['settings']['google_analytics'] = $Controller->data['Tool']['google_analytics'];
			}

			$Controller->Module->save($module);
			Cache::delete('Modules');
			$Controller->QuickApps->loadModules();
			
			if (!empty($Controller->data['Tool']['google_analytics'])) {
				$Controller->flashMsg(__d('seo_tools', 'Your Google Analytics tracking code has been added.'));
			} else {
				$Controller->flashMsg(__d('seo_tools', 'Your Google Analytics tracking code has been disabled.'), 'warning');
			}
        }
    }
}