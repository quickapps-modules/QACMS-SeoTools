<fieldset>
	<legend id="keyword_use_in_document_title"><?php echo __d('seo_tools', 'Global link popularity of web site'); ?> (<?php echo __d('seo_tools', 'Essential'); ?>)</legend>
	<em><?php echo __d('seo_tools', 'The global link popularity measures how many web pages link to your site. The number of web pages linking to your site is not as important as the quality of the web pages that link to your site.'); ?></em>

	<hr />

	<div class="alert alert-info"><?php echo __d('seo_tools', 'Number of inbound links according to these search engines <b>(the more the better)</b>.'); ?></div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th align="left"><?php echo __d('seo_tools', 'Web Site'); ?></th>
				<th><?php echo __d('seo_tools', 'Alexa'); ?></th>
				<th><?php echo __d('seo_tools', 'Google.com'); ?></th>
				<th><?php echo __d('seo_tools', 'Yahoo.com'); ?></th>
				<th><?php echo __d('seo_tools', 'Peak Value'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($data['sites'] as $row): ?>
			<tr>
				<td align="left"><?php echo $row['site_name']; ?></td>
				<td><?php echo $row['alexa']; ?></td>
				<td><?php echo $row['google']; ?></td>
				<td><?php echo $row['yahoo']; ?></td>
				<td><?php echo $row['peak']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<div class="alert alert-<?php echo $data['class']; ?>">
		<?php echo $data['message']; ?>
	</div>
</fieldset>