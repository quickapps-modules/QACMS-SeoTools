<?php
class InstallComponent extends Component {
    public function beforeInstall() {
        $query = "
            CREATE TABLE IF NOT EXISTS `#__seo_tools_urls` (
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

        $this->Installer->menuLink(
			array(
				'title' => 'Seo Tools',
				'url' => '/admin/seo_tools'
			),
			1, // admin menu
			1 // move up
		);

        return $this->Installer->sql($query);
    }

    public function beforeUninstall() {
        return true;
    }

    public function afterUninstall() {
        return $this->Installer->sql("DROP TABLE `#__seo_tools_urls`;");
    }
}