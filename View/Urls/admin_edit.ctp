<?php echo $this->Form->create('SeoUrl'); ?>
    <?php echo $this->Html->useTag('fieldsetstart', __d('seo_tools', 'Editing URL')); ?>
        <?php 
            $base_url = Router::url('/', true);
            $base_url = Configure::read('Variable.url_language_prefix') ? preg_replace('/\/[a-z]{3}\/$/s', '', $base_url) : $base_url;
            $base_url = preg_replace('/\/$/s', '', $base_url);
        ?>

        <?php echo $this->Form->input('SeoUrl.id'); ?>
        <?php echo $this->Form->input('SeoUrl.status', array('type' => 'checkbox', 'label' => __d('seo_tools', 'Optimization Active'))); ?>
        <?php echo $this->Form->input('SeoUrl.url', array('between' => $base_url, 'type' => 'text', 'label' => 'URL *')); ?>
        <?php echo $this->Form->input('SeoUrl.redirect', array('type' => 'text', 'label' => __d('seo_tools', 'Redirect to'))); ?>
        <?php echo $this->Form->input('SeoUrl.title', array('type' => 'text', 'label' => __d('seo_tools', 'Page title'))); ?>
        <?php echo $this->Form->input('SeoUrl.description', array('type' => 'textarea', 'label' => __d('seo_tools', 'Description'))); ?>
        <?php echo $this->Form->input('SeoUrl.keywords', array('type' => 'textarea', 'label' => __d('seo_tools', 'Keywords'))); ?>
        <?php echo $this->Form->input('SeoUrl.header', array('type' => 'textarea', 'label' => __d('seo_tools', 'Header'))); ?>
        <?php echo $this->Form->input('SeoUrl.footer', array('type' => 'textarea', 'label' => __d('seo_tools', 'Footer'))); ?>
    <?php echo $this->Html->useTag('fieldsetend'); ?>

    <?php echo $this->Form->input(__d('seo_tools', 'Save url'), array('type' => 'submit')); ?>
<?php echo $this->Form->end(); ?>