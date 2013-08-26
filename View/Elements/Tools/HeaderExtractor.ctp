<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php echo __d('seo_tools', 'HTTP Header Extractor'); ?></h1>
	<textarea style="width:100%; height:200px;" wrap="off"><?php echo $results; ?></textarea>
<?php endif; ?>