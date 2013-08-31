<fieldset>
	<legend id="keyword_use_in_h1_headline_texts"><?php echo __d('seo_tools', 'Keyword use in H1 headline texts'); ?> (<?php echo __d('seo_tools', 'Very Important'); ?>)</legend>
	<em><?php echo __d('seo_tools', 'H1 headline texts are the texts that are written between the &lt;h1&gt;...&lt;/h1&gt; tags in the HTML code of a web page. Some search engines give extra relevance to search terms that appear in the headline texts.'); ?></em>

	<hr />

	<h3><?php echo __d('seo_tools', 'Their Content'); ?></h3>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th align="left"><?php echo __d('seo_tools', 'Web Site'); ?></th>
				<th align="left"><?php echo __d('seo_tools', 'H1 Heading Text'); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($data['their_content'] as $i => $h1_list): ?>
			<tr>
				<td align="left"><a href="#competitor-<?php echo $i + 1; ?>">#<?php echo $i + 1; ?></a></td>
				<td align="left">
					<?php if (empty($h1_list)): ?>
						<?php echo __d('seo_tools', 'This site does not have H1 titles.'); ?>
					<?php else: ?>
						<ol>
							<?php foreach ($h1_list as $h1): ?>
								<li><?php echo $h1; ?></li>
							<?php endforeach; ?>
						</ol>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<hr />

	<h3><?php echo __d('seo_tools', 'Your Content'); ?></h3>
	<div class="alert alert-info">
		<?php if (empty($data['your_content'])): ?>
			<?php echo __d('seo_tools', 'Your web site does not have any H1 titles.'); ?>
		<?php else: ?>
			<ol>
				<?php foreach ($data['your_content'] as $h1): ?>
					<li><?php echo $h1; ?></li>
				<?php endforeach; ?>
			</ol>
		<?php endif; ?>
	</div>

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
				<tr class="<?php echo $stats['quantity']['class']; ?>">
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
			</tbody>
		</table>
	<?php endforeach; ?>
</fieldset>