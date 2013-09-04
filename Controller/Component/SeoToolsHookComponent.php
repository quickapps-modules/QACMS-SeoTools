<?php
class SeoToolsHookComponent extends Component {
	private $Controller = null;
	public $components = array('Hook');

	public function initialize(Controller $Controller){
		$this->Controller = $Controller;

		// is localhost
		if (in_array(env('HTTP_HOST'), array('localhost','127.0.0.1'))) {
			return;
		}

		if ($cd = Configure::read('Modules.SeoTools.settings.canonical_domain')) {
			$hereFull = Router::url('/' . $this->Controller->request->url, true);
			$domain = env('HTTP_HOST');

			switch ($cd) {
				case 'www':
					if (!preg_match('/^www\./', $domain)) {
						$redirectTo = QuickApps::str_replace_once($domain, "www.{$domain}", $hereFull);
					}
				break;

				case 'non-www':
					if (preg_match('/^www\./', $domain)) {
						$redirectTo = QuickApps::str_replace_once('www.', '', $hereFull);
					}
				break;
			}

			if (isset($redirectTo)) {
				header('HTTP/1.1 301 Moved Permanently'); 
				header("Location: {$redirectTo}");
				die();
			}
		}
		
	}
}