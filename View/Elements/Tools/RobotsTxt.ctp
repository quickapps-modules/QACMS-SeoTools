<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php
			echo $this->Form->input('Tool.url',
				array(
					'label' => __d('seo_tools', 'Enter Your URL'),
					'helpBlock' => __d('seo_tools', 'Can be any document on your website; will automatically download http://yoursite/robots.txt')
				)
			);
		?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php printf(__d('seo_tools', 'robots.txt file for %s'), $this->data['Tool']['url']); ?></h1>
	<textarea style="width:100%; height:360px;"><?php echo $results; ?></textarea>
<?php endif; ?>