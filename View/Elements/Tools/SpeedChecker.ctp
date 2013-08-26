<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
		<em><?php echo __d('seo_tools', 'This may take a few minutues, please be patient!'); ?></em><br />
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<?php if ($results): ?>
		<h2><?php echo __d('seo_tools', 'Overview'); ?></h2>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><?php echo __d('seo_tools', 'URL'); ?></th>
					<th><?php echo __d('seo_tools', 'Size'); ?></th>
					<th><?php echo __d('seo_tools', 'Load Time (s)'); ?></th>
					<th><?php echo __d('seo_tools', 'Download Speed'); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?php echo $this->Html->link(String::truncate($results['url'], 60), $results['url'], array('target' => '_blank', 'title' => $results['url'])); ?></td>
					<td><?php echo FieldFile::bytesToSize($results['size']); ?></td>
					<td><?php echo $results['time']; ?></td>
					<td><?php echo FieldFile::bytesToSize($results['size'] / $results['time']); ?>/s</td>
				</tr>
			</tbody>
		</table>

		<h2><?php echo __d('seo_tools', 'Images'); ?></h2>
		<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th class="filter-false {sorter: false}"><?php echo __d('seo_tools', '#'); ?></th>
					<th><?php echo __d('seo_tools', 'URL'); ?></th>
					<th><?php echo __d('seo_tools', 'Width (px)'); ?></th>
					<th><?php echo __d('seo_tools', 'Height (px)'); ?></th>
					<th><?php echo __d('seo_tools', 'Size'); ?></th>
					<th><?php echo __d('seo_tools', 'Load Time (s)'); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($results['resources']['img'] as $i => $img): ?>
				<tr>
					<td><?php echo $i + 1; ?></td>
					<td><?php echo $this->Html->link(String::truncate($img['link'], 60), $img['link'], array('target' => '_blank', 'title' => $img['link'])); ?></td>
					<td><?php echo $img['width']; ?></td>
					<td><?php echo $img['height']; ?></td>
					<td><?php echo FieldFile::bytesToSize($img['size']); ?></td>
					<td><?php echo $img['time']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h2><?php echo __d('seo_tools', 'CSS Files'); ?></h2>
		<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th class="filter-false {sorter: false}"><?php echo __d('seo_tools', '#'); ?></th>
					<th><?php echo __d('seo_tools', 'URL'); ?></th>
					<th><?php echo __d('seo_tools', 'Size'); ?></th>
					<th><?php echo __d('seo_tools', 'Load Time (s)'); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($results['resources']['css'] as $i => $css): ?>
				<tr>
					<td><?php echo $i + 1; ?></td>
					<td><?php echo $this->Html->link(String::truncate($css['link'], 60), $css['link'], array('target' => '_blank', 'title' => $css['link'])); ?></td>
					<td><?php echo FieldFile::bytesToSize($css['size']); ?></td>
					<td><?php echo $css['time']; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h2><?php echo __d('seo_tools', 'JavaScript Files'); ?></h2>
		<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th class="filter-false {sorter: false}"><?php echo __d('seo_tools', '#'); ?></th>
					<th><?php echo __d('seo_tools', 'URL'); ?></th>
					<th><?php echo __d('seo_tools', 'Size'); ?></th>
					<th><?php echo __d('seo_tools', 'Load Time (s)'); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($results['resources']['js'] as $i => $js): ?>
				<tr>
					<td><?php echo $i + 1; ?></td>
					<td><?php echo $this->Html->link(String::truncate($js['link'], 60), $js['link'], array('target' => '_blank', 'title' => $js['link'])); ?></td>
					<td><?php echo FieldFile::bytesToSize($js['size']); ?></td>
					<td><?php echo $js['time']; ?></td>
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
<?php endif; ?>