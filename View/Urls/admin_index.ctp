<?php
$tSettings = array(
    'columns' => array(
        '<input type="checkbox" onclick="QuickApps.checkAll(this);">' => array(
            'value' => '<input type="checkbox" name="data[Items][id][]" value="{SeoUrl.id}">',
            'thOptions' => array('align' => 'center'),
            'tdOptions' => array('width' => '25', 'align' => 'center')
        ),
        __d('seo_tools', 'URL') => array(
            'value' => '<a href="{url}/admin/seo_tools/urls/edit/{SeoUrl.id}{/url}">{SeoUrl.url}</a>',
            'sort' => 'SeoUrl.url',
            'tdOptions' => array('width' => '20%', 'align' => 'left')
        ),
        __d('seo_tools', 'Page Title') => array(
            'value' => '{SeoUrl.title}',
            'sort'    => 'SeoUrl.title',
            'tdOptions' => array('width' => '15%', 'align' => 'left')
        ),
        __d('seo_tools', 'Description') => array(
            'value' => '{SeoUrl.description}',
            'sort'    => 'SeoUrl.description',
            'tdOptions' => array('width' => '30%', 'align' => 'left')
        ), 
        __d('seo_tools', 'Keywords') => array(
            'value' => '{SeoUrl.keywords}',
            'sort'    => 'SeoUrl.Keywords',
            'tdOptions' => array('width' => '20%', 'align' => 'left')
        ),
        __d('seo_tools', 'Status') => array(
            'value' => '{php} return ("{SeoUrl.status}" == 0 ? "' . __d('seo_tools', 'inactive') . '" : "' . __d('seo_tools', 'active') . '" ); {/php}',
            'sort'    => 'SeoUrl.status'
        )
    ),
    'noItemsMessage' => __d('seo_tools', 'There are no URLs to display'),
    'paginate' => true,
    'headerPosition' => 'top',
    'tableOptions' => array('width' => '100%')
);
?>

<?php echo $this->Form->create(null, array('onsubmit' => 'return confirm("' . __d('seo_tools', 'Are you sure about this changes ?') . '");')); ?>
    <!-- Update -->
    <?php echo $this->Html->useTag('fieldsetstart', '<span class="fieldset-toggle">' . __d('seo_tools', 'Update Options') . '</span>' ); ?>
        <div class="fieldset-toggle-container horizontalLayout" style="<?php echo isset($this->data['Node']['update']) ? '' : 'display:none;'; ?>">
            <?php echo $this->Form->input('SeoUrl.update',
                    array(
                        'type' => 'select',
                        'label' => false,
                        'options' => array(
                            'delete' => __d('seo_tools', 'Delete selected urls'),
                            'enable' => __d('seo_tools', 'Enable selected urls'),
                            'disable' => __d('seo_tools', 'Disable selected urls')
                        )
                    )
                );
            ?>
            <?php echo $this->Form->input(__d('seo_tools', 'Update'), array('type' => 'submit', 'label' => false)); ?>
        </div>
    <?php echo $this->Html->useTag('fieldsetend'); ?>

    <!-- table results -->
    <?php echo $this->Html->table($results, $tSettings); ?>
    <!-- end: table results -->
<?php echo $this->Form->end(); ?>