<fieldset>
	<legend id="keyword_use_in_body_text"><?php echo __d('seo_tools', 'Keyword use in body text'); ?> (<?php echo __d('seo_tools', 'Essential'); ?>)</legend>
	<em><?php echo __d('seo_tools', 'The body text is the text on your web page that can be seen by people in their web browsers. It does not include HTML commands, comments, etc. The more visible text there is on a web page, the more a search engine can index. The calculations include spaces and punctuation marks.'); ?></em>

	<hr />

	<h3><?php echo __d('seo_tools', 'Their Content'); ?></h3>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th align="left"><?php echo __d('seo_tools', 'Web Site'); ?></th>
				<th align="left"><?php echo __d('seo_tools', 'Content'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($data['their_content'] as $i => $content): ?>
			<tr>
				<td align="left"><a href="#competitor-<?php echo $i + 1; ?>">#<?php echo $i + 1; ?></a></td>
				<td align="left">
					<div class="body-text" style="text-align:left; height:110px; overflow-y:scroll; width:100%; margin:0; padding:0;">
						<?php echo $content ? $content : __d('seo_tools', '[No content was found for this web page.]'); ?>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<hr />

	<h3><?php echo __d('seo_tools', 'Your Content'); ?></h3>
	<div class="alert alert-info"><?php echo $data['your_content'] ? $data['your_content'] : __d('seo_tools', '[No content was found!]'); ?></div>

	<hr />

	<h3><?php echo __d('seo_tools', 'Keywords Statistics'); ?></h3>
	<?php foreach ($data['keywords_stats'] as $keyword => $stats): ?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th width="33%" align="left"><?php echo __d('seo_tools', 'Search Term'); ?>: "<?php echo $keyword; ?>"</th>
					<th width="33%" align="left"><?php echo __d('seo_tools', 'Competitors'); ?></th>
					<th align="left"><?php echo __d('seo_tools', 'Your Site'); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr class="<?php echo $stats['position']['class']; ?>">
					<td align="left"><?php echo __d('seo_tools', 'Quantity'); ?></td>
					<td align="left">
						<?php
							if ($stats['quantity']['min'] == $stats['quantity']['max']) {
								echo __d('seo_tools', 'all to %d', $stats['quantity']['min']);
							} else {
								echo __d('seo_tools', '%d to %d', $stats['quantity']['min'], $stats['quantity']['max']);
							}
						?>
					</td>
					<td align="left"><?php echo $stats['quantity']['site']; ?></td>
				</tr>

				<tr class="<?php echo $stats['density']['class']; ?>">
					<td align="left"><?php echo __d('seo_tools', 'Density'); ?></td>
					<td align="left">
						<?php
							if ($stats['density']['min'] == $stats['density']['max']) {
								echo __d('seo_tools', 'all to %.1f%%', $stats['density']['min']);
							} else {
								echo __d('seo_tools', '%.1f to %.1f%%', $stats['density']['min'], $stats['density']['max']);
							}
						?>
					</td>
					<td align="left"><?php echo $stats['density']['site']; ?>%</td>
				</tr>

				<tr class="<?php echo $stats['position']['class']; ?>">
					<td align="left"><?php echo __d('seo_tools', 'Position'); ?></td>
					<td align="left">
						<?php
							if ($stats['position']['min'] == $stats['position']['max']) {
								echo __d('seo_tools', 'all to %d', $stats['position']['min']);
							} else {
								echo __d('seo_tools', '%d to %d', $stats['position']['min'], $stats['position']['max']);
							}
						?>					
					</td>
					<td align="left"><?php echo $stats['position']['site']; ?></td>
				</tr>
			</tbody>
		</table>
	<?php endforeach; ?>
</fieldset>