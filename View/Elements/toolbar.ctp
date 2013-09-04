<?php
    $links = array(
        array(__d('seo_tools', 'URLs'), '/admin/seo_tools/urls'),
        array(__d('seo_tools', 'Optimize new URL'), '/admin/seo_tools/urls/add'),
        array(__d('seo_tools', 'Tools'), '/admin/seo_tools/tools', 'pattern' => 'admin/seo_tools/tools*'),
        array(__d('seo_tools', 'Site Settings'), '/admin/seo_tools/site_settings')
    );

    echo $this->Menu->toolbar($links);