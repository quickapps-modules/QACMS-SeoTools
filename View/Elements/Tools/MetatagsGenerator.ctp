<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.metas.title', array('label' => __d('seo_tools', 'Title'))); ?>
		<?php echo $this->Form->input('Tool.metas.description', array('type' => 'textarea', 'label' => __d('seo_tools', 'Description'))); ?>
		<?php echo $this->Form->input('Tool.metas.keywords', array('label' => __d('seo_tools', 'Keywords'))); ?>
		<?php echo $this->Form->input('Tool.metas.author', array('label' => __d('seo_tools', 'Author'))); ?>
		<?php echo $this->Form->input('Tool.metas.owner', array('label' => __d('seo_tools', 'Owner'))); ?>
		<?php echo $this->Form->input('Tool.metas.copyright', array('label' => __d('seo_tools', 'Copyright'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php echo __d('seo_tools', 'Meta Tags Generator'); ?></h1>
	<textarea style="width:100%; height:250px;" wrap="off"><?php echo $results; ?></textarea>
<?php endif; ?>