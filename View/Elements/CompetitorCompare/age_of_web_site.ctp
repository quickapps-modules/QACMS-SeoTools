<fieldset>
	<legend id="age_of_web_site"><?php echo __d('seo_tools', 'Age of web site'); ?> (<?php echo __d('seo_tools', 'Very Important'); ?>)</legend>
	<em><?php echo __d('seo_tools', 'Spam sites often come and go quickly. For this reason, search engines tend to trust a web site that has been around for a long time over one that is brand new. The age of the domain is seen as a sign of trustworthiness because it cannot be faked. The data is provided by Alexa.com.'); ?></em>

	<hr />

	<div class="alert alert-info"><?php echo __d('seo_tools', 'Dates of the domain registration or of the first contents'); ?></div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th align="left"><?php echo __d('seo_tools', 'Web Site'); ?></th>
				<th align="left"><?php echo __d('seo_tools', 'URL'); ?></th>
				<th align="center"><?php echo __d('seo_tools', 'Registration Date'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($data['sites'] as $row): ?>
			<tr>
				<td align="left"><?php echo $row['site_name']; ?></td>
				<td align="left"><?php echo $row['url']; ?></td>
				<td align="center"><?php echo $row['age']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<div class="alert alert-<?php echo $data['class']; ?>">
		<?php echo $data['message']; ?>
	</div>
</fieldset>