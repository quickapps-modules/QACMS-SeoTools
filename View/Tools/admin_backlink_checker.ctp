<?php if ( !isset($results) ) : ?>
<div style="width:100%;">
	<form id="toolForm" action="" method="post" onsubmit="tool_exe(600); return false;">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td align="left" valign="top"><b><?php echo __t('Enter Your URL'); ?>:</b></td>
				</tr>
			<tr>
			  <td align="left" valign="top"><input type="text" name="data[Tool][url]" value="<?php echo Configure::read('ModSeo.Config.seo_site_url'); ?>" class="text" style="width:100%;" /></td>
		  </tr>
			<tr>
				<td align="left" valign="top">
					<input type="submit" value="<?php echo __t('Continue'); ?>" class="primary_lg" />
				</td>
			</tr>
		</table>
	</form>
</div>
<?php else: ?>
<div style="width:100%; height:80px; overflow-y:auto;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablekit">
		<thead>
			<tr>
				<td width="59%" align="left" valign="top"><b><?php echo __t('URL'); ?></b></td>
				<td width="13%" align="center" valign="top"><b><?php echo __t('BL Alexa'); ?></b></td>
				<td width="16%" align="center" valign="top"><b><?php echo __t('BL Google'); ?></b></td>
				<td width="12%" align="center" valign="top"><b><?php echo __t('BL Yahoo'); ?></b></td>
			</tr>
		</thead>
		
		<tbody>
			<tr>
				<td align="left" valign="top"><?php echo $this->data['Tool']['url']; ?></td>
				<td align="center" valign="top"><?php echo $results['alexa']; ?></td>
				<td align="center" valign="top"><?php echo $results['google']; ?></td>
				<td align="center" valign="top"><?php echo $results['yahoo']; ?></td>
			</tr>
		</tbody>
	</table>
</div>
<?php endif; ?>