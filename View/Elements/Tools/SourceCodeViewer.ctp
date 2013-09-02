<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php echo __d('seo_tools', 'Source Code Viewer'); ?></h1>
	<pre class="code" lang="html"><?php echo htmlentities($results); ?></pre>

	<script type="text/javascript">
		$(document).ready(function(){
			$('pre.code').highlight({
				source: true,
				zebra: false,
				indent:'space',
				list:'ol'
			});
		});
	</script>
<?php endif; ?>