<?php
$tSettings = array(
    'columns' => array(
        '<input type="checkbox" onclick="QuickApps.checkAll(this);">' => array(
            'value' => '<input type="checkbox" name="data[Items][id][]" value="{SeoUrl.id}">',
            'thOptions' => array('align' => 'center'),
            'tdOptions' => array('width' => '25', 'align' => 'center')
        ),
        __t('URL') => array(
            'value' => '<a href="{url}/admin/seo_tools/urls/edit/{SeoUrl.id}{/url}">{SeoUrl.url}</a>',
            'sort' => 'SeoUrl.url',
            'tdOptions' => array('width' => '20%', 'align' => 'left')
        ),
        __t('Page Title') => array(
            'value' => '{SeoUrl.title}',
            'sort'    => 'SeoUrl.title',
            'tdOptions' => array('width' => '15%', 'align' => 'left')
        ),
        __t('Description') => array(
            'value' => '{SeoUrl.description}',
            'sort'    => 'SeoUrl.description',
            'tdOptions' => array('width' => '30%', 'align' => 'left')
        ), 
        __t('Keywords') => array(
            'value' => '{SeoUrl.keywords}',
            'sort'    => 'SeoUrl.Keywords',
            'tdOptions' => array('width' => '20%', 'align' => 'left')
        ),
        __t('Status') => array(
            'value' => '{php} return ("{SeoUrl.status}" == 0 ? "' . __t('inactive') . '" : "' . __t('active') . '" ); {/php}',
            'sort'    => 'SeoUrl.status'
        )
    ),
    'noItemsMessage' => __t('There are no URLs to display'),
    'paginate' => true,
    'headerPosition' => 'top',
    'tableOptions' => array('width' => '100%')    # table attributes
);
?>

<?php echo $this->Form->create(null, array('onsubmit' => 'return confirm("' . __t('Are you sure about this changes ?') . '");')); ?>
    <!-- Update -->
    <?php echo $this->Html->useTag('fieldsetstart', '<span id="toggle-update_fieldset" style="cursor:pointer;">' . __t('Update Options') . '</span>' ); ?>
        <div id="update_fieldset" class="horizontalLayout" style="<?php echo isset($this->data['Node']['update']) ? '' : 'display:none;'; ?>">
            <?php echo $this->Form->input('Node.update',
                    array(
                        'type' => 'select',
                        'label' => false,
                        'options' => array(
                            'publish' => __t('Publish selected content'),
                            'unpublish' => __t('Unpublish selected content'),
                            'promote' => __t('Promote selected content to front page'),
                            'demote' => __t('Demote selected content from front page'),
                            'sticky' => __t('Make selected content sticky'),
                            'unsticky' => __t('Make selected content not sticky'),
                            'delete' => __t('Delete selected content'),
                            'clear_cache' => __t('Clear cache')
                        )
                    )
                );
            ?>
            <?php echo $this->Form->input(__t('Update'), array('type' => 'submit', 'label' => false)); ?>
        </div>
    <?php echo $this->Html->useTag('fieldsetend'); ?>
    <!-- table results -->
    <?php echo $this->Html->table($results, $tSettings); ?>
    <!-- end: table results -->
<?php echo $this->Form->end(); ?>


<script type="text/javascript">

    $("#toggle-update_fieldset").click(function () {
        $("#update_fieldset").toggle('fast', 'linear');
    });

    $("#toggle-filter_fieldset").click(function () {
        $("#filter_fieldset").toggle('fast', 'linear');
    });
</script>