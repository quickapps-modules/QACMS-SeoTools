<?php if ( !isset($results) ) : ?>
<div style="width:100%;">
	<form id="toolForm" action="" method="post" onsubmit="tool_exe(600); return false;">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td align="left" valign="top"><b><?php echo __t('Enter Your IP'); ?>:</b></td>
				</tr>
			<tr>
			  <td align="left" valign="top"><input type="text" name="data[Tool][ip]" value="" class="text" style="width:100%;" /></td>
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
	<h1><?php echo __t('Ping Domain/IP'); ?></h1>
	<div style="width:100%; height:200px; overflow:auto;">
		<?php echo nl2br($results); ?>
	</div>
</div>
<?php endif; ?>