<?php
class SiteRobotsComponent extends Component {
    public function main(Controller $Controller) {
		if (!empty($Controller->data)) {
			if (isset($Controller->data['Tool']['site_robots'])) {
				if (!empty($Controller->data['Tool']['site_robots'])) {
					Cache::write('robots', $Controller->data['Tool']['site_robots'], 'seo_tools_optimized_url');
					$Controller->flashMsg(__d('seo_tools', 'Your <strong>robots.txt</strong> file has been saved.'));
				} else {
					Cache::delete('robots', 'seo_tools_optimized_url');
					$Controller->flashMsg(__d('seo_tools', 'Your <strong>robots.txt</strong> file is now empty!'), 'warning');
				}
			}
        }
    }
}