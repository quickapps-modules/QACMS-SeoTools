<?php if ( !isset($results) ) : ?>
<div style="width:100%; height:auto; overflow-y:auto;">
	<form id="toolForm" action="" method="post" onsubmit="tool_exe(400); return false;">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td align="left" valign="top"><b><?php echo __t('Enter Your URL'); ?>:</b></td>
				</tr>
			<tr>
			  <td align="left" valign="top">
				<textarea style="width:100%; height:250px;" name="data[Tool][text]"></textarea>
			  </td>
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
	<h1><?php echo __t('MD5 Encrypter'); ?></h1>
	<textarea style="width:100%; height:50px;"><?php echo $results; ?></textarea>
</div>
<?php endif; ?>