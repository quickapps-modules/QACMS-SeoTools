<?php echo $this->Form->create('Tool'); ?>
	<?php
		echo $this->Form->input('google_analytics',
			array(
				'type' => 'textarea',
				'label' => __d('seo_tools', '<a href="%s" target="_blank">Google Analytics Tracking Code:</a>', 'http://www.google.com/analytics/'),
				'value' => Configure::read('Modules.SeoTools.settings.google_analytics')
			)
		);
	?>
<?php echo $this->Form->end(__d('seo_tools', 'Save')); ?>