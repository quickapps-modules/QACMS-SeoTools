<?php
    $links = array(
        array(__d('seo_tools', 'URLs'), '/admin/seo_tools/urls'),
        array(__d('seo_tools', 'Optimize new URL'), '/admin/seo_tools/urls/add'),
        array(__d('seo_tools', 'Tools'), '/admin/seo_tools/tools', 'pattern' => 'admin/seo_tools/tools*')
    );

    echo $this->Menu->toolbar($links);