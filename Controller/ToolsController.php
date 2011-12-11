<?php 
class ToolsController extends SeoToolsAppController {
    public $components = array('SeoTools.SeoTools');
    public $helpers = array('SeoTools.SeoTools');

    public function admin_index() {
        $this->set('tools', $this->SeoTools->toolsList());
    }

    public function admin_execute($tool) {
        $Tool = $this->SeoTools->loadTool($tool);

        if (!empty($this->data)) {
            $this->set('results', $Tool->main($this));
        }

        $this->render($tool);
    }

	public function admin_seo_stats() {
		if (isset($this->data['Tool'])) {
			if (empty($this->data['Tool']['url'])) {
				$this->flashMsg(__t('Invalid URL'), 'error');
				$this->redirect($this->referer());
			}



			$this->set('results', $results);
		}
	}
    
	public function admin_top_10_optimizer() {
        Cache::config('seo_cache', array('engine' => 'File', 'path' => CACHE, 'duration' => '+1 day'));

		if (isset($this->data['Tool'])) {
			$errors = array();

			if (empty($this->data['Tool']['url'])) {
				$errors[] = __t('Invalid URL');
            }

			if (empty($this->data['Tool']['criteria'])) {
				$errors[] = __t('Invalid criteria');
            }

			if (count($errors) > 0) {
				$this->flashMsg(implode('<br/>', $errors), 'error');
				$this->redirect($this->referer());
			}

			if ($this->data['Tool']['engine_results_num'] > 10 || 0 > $this->data['Tool']['engine_results_num']) {
                $data = $this->data;
                $data['Tool']['engine_results_num'] = 10;
                $this->data = $data;
            }

            $cache = Cache::read('top_10_optimizer_' . md5($this->data['Tool']['url'] . $this->data['Tool']['criteria'] . $this->data['Tool']['engine_results_num']), 'seo_cache');
            if (!$cache) {
                $results = @$this->SeoTools->competitor_compare($this->data['Tool']['url'], $this->data['Tool']['criteria'], $this->data['Tool']['engine'], $this->data['Tool']['engine_results_num']);
                Cache::write('top_10_optimizer_' . md5($this->data['Tool']['url'] . $this->data['Tool']['criteria'] . $this->data['Tool']['engine_results_num']), $results, 'seo_cache');
            } else {
                $results = $cache;
            }
			
			$this->set('results', $results);
		}
	}    

	public function admin_keyword_suggestion() {
    
	}

	public function admin_backlink_checker() {

	}
}