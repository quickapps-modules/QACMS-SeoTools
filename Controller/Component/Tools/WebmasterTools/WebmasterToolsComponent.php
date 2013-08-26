<?php
class WebmasterToolsComponent extends Component {
    public function main(Controller $Controller) {
		if (!empty($Controller->data)) {
			$module = $Controller->Module->find('first',
				array(
					'fields' => array('name', 'settings'),
					'conditions' => array('Module.name' => 'SeoTools')
				)
			);

			if (isset($Controller->data['Tool']['google_meta'])) {
				$module['Module']['settings']['google_meta'] = $Controller->data['Tool']['google_meta'];
			}

			if (isset($Controller->data['Tool']['bing_meta'])) {
				$module['Module']['settings']['bing_meta'] = $Controller->data['Tool']['bing_meta'];
			}

			if (isset($Controller->data['Tool']['alexa_meta'])) {
				$module['Module']['settings']['alexa_meta'] = $Controller->data['Tool']['alexa_meta'];
			}

			$Controller->Module->save($module);
			Cache::delete('Modules');
			$Controller->QuickApps->loadModules();
			$Controller->flashMsg(__d('seo_tools', 'Verification codes saved.'));
        }
    }
}