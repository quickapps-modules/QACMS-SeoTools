<?php if ( !isset($results) ) : ?>
<div style="width:100%; height:auto; overflow-y:auto;">
	<form id="toolForm" action="" method="post" onsubmit="tool_exe(950); return false;">
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
<div style="width:100%;">
	<h1><?php echo __t('CSS Validator'); ?></h1>
	<iframe src="http://jigsaw.w3.org/css-validator/validator?uri=<?php echo $this->data['Tool']['url']; ?>" style="width:100%; height:360px;"></iframe>
</div>
<?php endif; ?>

