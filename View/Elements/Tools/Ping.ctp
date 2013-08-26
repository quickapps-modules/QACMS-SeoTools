<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your Domain/IP'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php echo __d('seo_tools', 'Ping Domain/IP'); ?></h1>
	<div style="width:100%; height:200px; overflow:auto;">
		<?php echo nl2br($results); ?>
	</div>
<?php endif; ?>