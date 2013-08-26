<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php printf(__d('seo_tools', '%s analysed words'), count($results)); ?></h1>
	<div style="width:100%; white-space:nowrap;">
		<?php foreach($results as $word => $percent): ?>
			<?php echo $word; ?>: <?php echo $percent; ?>% <br/>
		<?php endforeach; ?>
	</div>
<?php endif; ?>