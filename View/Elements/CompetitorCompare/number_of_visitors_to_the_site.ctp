<fieldset>
	<legend id="number_of_visitors_to_the_site"><?php echo __d('seo_tools', 'Number of visitors to the site'); ?> (<?php echo __d('seo_tools', 'Very Important'); ?>)</legend>
	<em><?php echo __d('seo_tools', 'Search engines might look at web site usage data, such as the number of visitors to your site, to determine if your site is reputable and contains popular contents. The Alexa.com traffic rank is based on three months of aggregated traffic data from millions of Alexa Toolbar users and is a combined measure of page views and number of site visitors.'); ?></em>

	<hr />

	<div class="alert alert-info"><?php echo __d('seo_tools', 'Alexa.com Traffic Rank results <b>(the lower the better)</b>'); ?></div>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th align="left"><?php echo __d('seo_tools', 'Web Site'); ?></th>
				<th align="left"><?php echo __d('seo_tools', 'URL'); ?></th>
				<th align="center"><?php echo __d('seo_tools', 'Alexa Traffic Rank'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($data['sites'] as $row): ?>
			<tr>
				<td align="left"><?php echo $row['site_name']; ?></td>
				<td align="left"><?php echo $row['url']; ?></td>
				<td align="center"><?php echo $row['rank']; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<div class="alert alert-<?php echo $data['class']; ?>">
		<?php echo $data['message']; ?>
	</div>
</fieldset>