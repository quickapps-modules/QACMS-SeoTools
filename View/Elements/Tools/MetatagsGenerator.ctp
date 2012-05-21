<?php if (!isset($results)) : ?>
	<?php echo $this->Form->create(false); ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td width="50%" align="left" valign="top"><b><?php echo __d('seo_tools', 'Title'); ?>:</b></td>
				<td width="50%" align="left" valign="top"><b><?php echo __d('seo_tools', 'Description'); ?>:</b></td>
			</tr>

			<tr>
				<td align="left" valign="top"><input type="text" name="data[Tool][metas][title]" value="" class="text" style="width:100%;" /></td>
				<td rowspan="9" align="left" valign="top"><textarea name="data[Tool][metas][description]" style="width:100%; height:220px;" wrap="on"></textarea></td>
			</tr>

			<tr>
				<td align="left" valign="top"><b><?php echo __d('seo_tools', 'Keywords'); ?></b></td>
			</tr>

			<tr>
				<td align="left" valign="top"><input type="text" name="data[Tool][metas][keywords]" value="" class="text" style="width:100%;" /></td>
			</tr>

			<tr>
				<td align="left" valign="top"><b><?php echo __d('seo_tools', 'Author'); ?></b></td>
			</tr>

			<tr>
				<td align="left" valign="top"><input type="text" name="data[Tool][metas][author]" value="" class="text" style="width:100%;" /></td>
			</tr>

			<tr>
				<td align="left" valign="top"><b><?php echo __d('seo_tools', 'Owner'); ?></b></td>
			</tr>

			<tr>
				<td align="left" valign="top"><input type="text" name="data[Tool][metas][owner]" value="" class="text" style="width:100%;" /></td>
			</tr>

			<tr>
				<td align="left" valign="top"><b><?php echo __d('seo_tools', 'Copyright'); ?></b></td>
			</tr>

			<tr>
				<td align="left" valign="top"><input type="text" name="data[Tool][metas][copyright]" value="" class="text" style="width:100%;" /></td>
			</tr>

			<tr>
				<td colspan="2" align="right" valign="top"><input type="submit" value="<?php echo __d('seo_tools', 'Continue'); ?>" class="primary_lg" /></td>
			</tr>
		</table>
	<?php echo $this->Form->end(); ?>
<?php else: ?>
	<h1><?php echo __d('seo_tools', 'Meta Tags Generator'); ?></h1>
	<textarea style="width:100%; height:250px;" wrap="off"><?php echo $results; ?></textarea>
<?php endif; ?>