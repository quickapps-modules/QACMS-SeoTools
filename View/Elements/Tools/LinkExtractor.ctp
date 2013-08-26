<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php printf(__d('seo_tools', 'Extracted %s links'), count($results)); ?></h1>
	<div style="width:100%; height:360px; overflow:auto; white-space:nowrap;">
		<?php echo implode('<br>', $results); ?>
	</div>
<?php endif; ?>