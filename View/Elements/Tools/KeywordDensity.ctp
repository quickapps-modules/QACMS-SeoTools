<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<h1><?php printf(__d('seo_tools', '%s analysed words'), count($results)); ?></h1>
	<table class="table table-bordered table-hover tablesorter">
		<thead>
			<tr>
				<th><?php echo __d('seo_tools', 'Keyword'); ?></th>
				<th><?php echo __d('seo_tools', 'Percent'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($results as $word => $percent): ?>
			<tr>
				<td><?php echo $word; ?></td>
				<td><?php echo $percent; ?>%</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<script>
		$(document).ready(function () {
			$.extend($.tablesorter.themes.bootstrap, {
				table: 'table table-bordered',
				header: 'bootstrap-header',
				sortAsc: 'icon-chevron-up',
				sortDesc: 'icon-chevron-down'
			});

			$('table.tablesorter').tablesorter({
				theme: 'bootstrap',
				widthFixed: true,
				filter_columnFilters: false,
				headerTemplate: '{content} {icon}',
				widgets : ['uitheme', 'filter']
			});
		});
	</script>	
<?php endif; ?>