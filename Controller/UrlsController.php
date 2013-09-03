<?php 
class UrlsController extends SeoToolsAppController {
    public $uses = array('SeoTools.SeoUrl');

	public function beforeFilter() {
		if (isset($this->data['fetch_url'])) {
			Configure::write('debug', 0);
			App::import('Vendor', 'SeoTools.simple_html_dom');

			$url = Router::url($this->data['fetch_url'], true);
			$html = file_get_html($url);
			$out = array(
				'title' => '',
				'url' => $url,
				'description' => '',
				'keywords' => ''
			);

			if ($html) {
				if ($desc = $html->find('meta[name=description]', 0)->content) {
					$out['description'] = $desc;
				}

				if ($keys = $html->find('meta[name=keywords]', 0)->content) {
					$out['keywords'] = $keys;
				}

				if ($title = $html->find('title', 0)->innertext) {
					$out['title'] = $title;
				}
			}

			header('Content-type: application/json');
			die(json_encode($out));
		}

		parent::beforeFIlter();
	}

    public function admin_index() {
        if (isset($this->data['SeoUrl']['update']) && isset($this->data['Items'])) {
            foreach ($this->data['Items']['id'] as $id) {
                switch ($this->data['SeoUrl']['update']) {
                    case 'enable':
                        $this->admin_enable($id);
                    break;

                    case 'disable':
                        $this->admin_disable($id);
                    break;

                    case 'delete':
                        $this->admin_delete($id);
                    break;
                }
            }

            $this->redirect('/admin/seo_tools/urls/index');
        }

		if (isset($this->data['Filter'])) {
			$paginate = $this->paginate;
			$paginate['limit'] = 50;

			foreach ($this->data['Filter'] as $field => $value) {
				if ($field == 'status') {
					$paginate['conditions']["SeoUrl.{$field}"] = intval($value);
				} else {
					if (!empty($value)) {
						$value = str_replace('*', '%', $value);
						$paginate['conditions']["SeoUrl.{$field} LIKE"] = $value;
					}
				}
			}

			$this->paginate = $paginate;
		}

        $this->set('results', $this->paginate('SeoUrl'));
        $this->setCrumb(
            '/admin/seo_tools',
            array(__d('seo_tools', 'URL List'))
        );
    }

    public function admin_add() {
		if (isset($this->data['SeoUrl'])) {
			if ($url = $this->SeoUrl->save($this->data)) {
				$this->flashMsg('New URL has been successfully created');
				$this->redirect('/admin/seo_tools/urls/edit/' . $url['SeoUrl']['id']);
			} else {
				$this->flashMsg('Something went wrong, please check your information');
			}
		}

		$this->Layout['stylesheets']['all'][] = '/seo_tools/css/styles.css';
		$this->Layout['javascripts']['file'][] = '/seo_tools/js/seo_tools.js';

		$this->__setBaseUrl();
		$this->setCrumb(
			'/admin/seo_tools', 
			array(__d('seo_tools', 'Add URL'))
		);
	}

    public function admin_edit($id) {
        $result = $this->SeoUrl->findById($id);

        if (!$result) {
            $this->redirect('/admin/seo_tools/urls/index');
        }

        if (isset($this->data['SeoUrl'])) {
			if ($this->SeoUrl->save($this->data)) {
				$this->flashMsg('URL information has been updated');
				$this->redirect('/admin/seo_tools/urls/edit/' . $result['SeoUrl']['id']);
			} else {
				$this->flashMsg('Something went wrong, please check your information');
			}
        }

        $this->data = $result;
		$this->Layout['stylesheets']['all'][] = '/seo_tools/css/styles.css';
		$this->Layout['javascripts']['file'][] = '/seo_tools/js/seo_tools.js';

		$this->__setBaseUrl();
        $this->setCrumb(
            '/admin/seo_tools',
            array(__d('seo_tools', 'URL List'), '/admin/seo_tools'),
            array(__d('seo_tools', 'Editing URL'))
        );
    }

    public function admin_enable($id) {
        $this->SeoUrl->id = $id;
        return $this->SeoUrl->saveField('status', 1);
    }

    public function admin_disable($id) {
        $this->SeoUrl->id = $id;
        return $this->SeoUrl->saveField('status', 0);
    }

    public function admin_delete($id) {
        return $this->SeoUrl->delete($id);
    }
	
	private function __setBaseUrl() {
		$base_url = Router::url('/', true);
		$base_url = Configure::read('Variable.url_language_prefix') ? preg_replace('/\/[a-z]{3}\/$/s', '', $base_url) : $base_url;
		$base_url = preg_replace('/\/$/s', '', $base_url);

		$this->set('base_url', $base_url);
	}
}