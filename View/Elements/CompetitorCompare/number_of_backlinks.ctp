<fieldset>
	<legend id="number_of_backlinks"><?php echo __d('seo_tools', 'Number of backlinks'); ?> (<?php echo __d('seo_tools', 'Essential'); ?>)</legend>
	<em><?php echo __d('seo_tools', 'This chapter measures how many web pages link to your website domain according to the data providers Alexa.com and SEOprofiler.com. The SEOprofiler service provides the number of unique linking domains, not the number of all linking pages.'); ?></em>

	<hr />

	<div class="alert alert-info"><?php echo __d('seo_tools', 'Keep in mind that the raw number of linking web pages is not as important as the quality of the web pages that link to your site.'); ?></div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th align="left"><?php echo __d('seo_tools', 'Web Site'); ?></th>
				<th><?php echo __d('seo_tools', 'Alexa'); ?></th>
				<th><?php echo __d('seo_tools', 'Google.com'); ?></th>
				<th><?php echo __d('seo_tools', 'SEOprofiler (unique backlinks)'); ?></th>
				<th><?php echo __d('seo_tools', 'Peak Value'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($data['sites'] as $row): ?>
			<tr>
				<td align="left"><?php echo $row['site_name']; ?></td>
				<td><?php echo $row['alexa']; ?></td>
				<td><?php echo $row['google']; ?></td>
				<td><?php echo $row['seoprofiler']; ?></td>
				<td><?php echo $row['peak']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<div class="alert alert-<?php echo $data['class']; ?>">
		<?php echo $data['message']; ?>
	</div>
</fieldset>