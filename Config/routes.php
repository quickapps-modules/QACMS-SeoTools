<?php
	Router::connect('/robots.txt',
		array(
			'plugin' => 'seo_tools',
			'controller' => 'generator',
			'action' => 'robots_txt'
		)
	);

	Router::connect('/sitemap.xml',
		array(
			'plugin' => 'seo_tools',
			'controller' => 'generator',
			'action' => 'sitemap_xml'
		)
	);
	
