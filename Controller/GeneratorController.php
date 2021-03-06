<?php 
class GeneratorController extends SeoToolsAppController {
	public $uses = array(
		'Node.Node',
		'Menu.MenuLink'
	);

	public function beforeFilter() {
		$this->Auth->allow('robots_txt', 'sitemap_xml');
		parent::beforeFilter();
	}

    public function robots_txt() {
		$txt = Cache::read('robots', 'seo_tools_optimized_url');

		if (!$txt) {
			$txt = Configure::read('Modules.SeoTools.settings.site_robots');
			Cache::write('robots', $txt, 'seo_tools_optimized_url');
		}

		header('Content-Type: text/plain');
		die($txt);
    }

	public function sitemap_xml() {
		App::uses('Xml', 'Utility');

		$this->viewClass = 'Xml';
        $urlset = array(
			'url' => array()
        );

		foreach ($this->Node->find('all',
			array(
				'conditions' => array('Node.status' => 1),
				'fields' => array('id', 'node_type_id', 'title', 'slug', 'modified'),
				'recursive' => -1
			)
		) as $node) {
			$urlset['url'][] = array(
				'loc' => Router::url("/{$node['Node']['node_type_id']}/{$node['Node']['slug']}.html", true),
				'lastmod' => date('Y-m-d', $node['Node']['modified'])
			);
		}

		$this->set('urlset', $urlset);
    }
}