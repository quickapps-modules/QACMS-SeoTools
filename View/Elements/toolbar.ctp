<?php
    $links = array(
        array(__t('URLs'), '/admin/seo_tools/urls/index'),
        array(__t('Add URL'), '/admin/seo_tools/urls/add'),
        array(__t('Tools'), '/admin/seo_tools/tools', 'pattern' => 'admin/seo_tools/tools*')
    );

    echo $this->Layout->toolbar($links);