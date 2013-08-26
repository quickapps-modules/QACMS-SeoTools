<?php echo $this->Form->create('Tool'); ?>
	<?php
		echo $this->Form->input('site_robots',
			array(
				'type' => 'textarea',
				'label' => false,
				'value' => Cache::read('robots', 'seo_tools_optimized_url')
			)
		);
	?>
<?php echo $this->Form->end(__d('seo_tools', 'Save')); ?>