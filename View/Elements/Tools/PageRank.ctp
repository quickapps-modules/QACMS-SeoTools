<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php echo __d('seo_tools', 'Page rank: <b>%d</b>', $results); ?></h1>
	<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/pr/pr{$results}.gif"); ?>
<?php endif; ?>