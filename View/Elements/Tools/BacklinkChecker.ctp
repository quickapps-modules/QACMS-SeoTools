<?php if (!isset($results)) : ?>
	<?php echo $this->Form->create(false); ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td align="left" valign="top"><b><?php echo __d('seo_tools', 'Enter Your URL'); ?>:</b></td>
			</tr>

			<tr>
				<td align="left" valign="top"><input type="text" name="data[Tool][url]" value="<?php echo Configure::read('ModSeo.Config.seo_site_url'); ?>" class="text" style="width:100%;" /></td>
			</tr>

			<tr>
				<td align="left" valign="top">
					<input type="submit" value="<?php echo __d('seo_tools', 'Continue'); ?>" class="primary_lg" />
				</td>
			</tr>
		</table>
	<?php echo $this->Form->end(); ?>
<?php else: ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<td width="71%" align="left" valign="top"><b><?php echo __d('seo_tools', 'URL'); ?></b></td>
				<td width="13%" align="center" valign="top"><b><?php echo __d('seo_tools', 'BL Alexa'); ?></b></td>
				<td width="16%" align="center" valign="top"><b><?php echo __d('seo_tools', 'BL Google'); ?></b></td>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td align="left" valign="top"><?php echo $this->data['Tool']['url']; ?></td>
				<td align="center" valign="top"><?php echo $results['alexa']; ?></td>
				<td align="center" valign="top"><?php echo $results['google']; ?></td>
			</tr>
		</tbody>
	</table>
<?php endif; ?>