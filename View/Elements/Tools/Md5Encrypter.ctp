<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.text', array('type' => 'textarea', 'label' => __d('seo_tools', 'Enter Your Text'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php echo __d('seo_tools', 'MD5 Encrypter'); ?></h1>
	<textarea style="width:100%; height:50px;"><?php echo $results; ?></textarea>
<?php endif; ?>