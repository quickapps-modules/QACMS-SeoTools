<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.ip', array('value' => env('SERVER_ADDR'), 'label' => __d('seo_tools', 'Enter Your IP'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php echo __d('seo_tools', 'Ping Domain/IP'); ?></h1>
	<pre><?php echo $results; ?></pre>
<?php endif; ?>