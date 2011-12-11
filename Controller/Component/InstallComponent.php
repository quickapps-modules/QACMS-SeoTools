<?php
class InstallComponent extends Component {
	public $Controller = null;
	public $components = array('Installer');

    function beforeInstall($Installer) {
        @App::import('Model', 'ConnectionManager');
        @ConnectionManager::create('default');

        $db = ConnectionManager::getDataSource('default');
        $query = "
            CREATE TABLE IF NOT EXISTS `{$db->config['prefix']}seo_tools_urls` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `url` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
              `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
              `description` text COLLATE utf8_unicode_ci,
              `keywords` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
              `header` text COLLATE utf8_unicode_ci,
              `footer` text COLLATE utf8_unicode_ci NOT NULL,
              `redirect` text COLLATE utf8_unicode_ci,
              `status` tinyint(1) NOT NULL,
              `created` datetime NOT NULL,
              `created_by` int(11) NOT NULL,
              `modified` datetime NOT NULL,
              `modified_by` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;";        

        return $db->execute($create_table);
    }

    function beforeUninstall() {
        return true;
    }

    function afterUninstall() {
        @App::import('Model', 'ConnectionManager');
        @ConnectionManager::create('default');

        $db = ConnectionManager::getDataSource('default');    

        return $db->execute("DROP TABLE `{$db->config['prefix']}seo_tools_urls`;");
    }
}