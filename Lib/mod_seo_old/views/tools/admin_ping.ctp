<?php if ( !isset($results) ) : ?>
<div style="width:100%; height:100px; overflow-y:auto;">
	<form id="toolForm" action="<?php echo $this->Html->url("/{$this->plugin}/tools/{$this->params['action']}"); ?>" method="post" onsubmit="tool_exe(600); return false;">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td align="left" valign="top"><b><?phpecho __t('Enter Your Domain/Ip'); ?>:</b></td>
				</tr>
			<tr>
			  <td align="left" valign="top"><input type="text" name="data[Tool][url]" value="" class="text" style="width:100%;" /></td>
		  </tr>
			<tr>
				<td align="left" valign="top">
					<input type="submit" value="<?phpecho __t('Continue'); ?>" class="primary_lg" />
				</td>
			</tr>
		</table>
	</form>
</div>
<?php else: ?>
<div style="width:100%; height:auto; overflow-y:auto; overflow-x:hidden;">
	<h1><?phpecho __t('Ping Domain/IP'); ?></h1>
	<div style="width:100%; height:200px; overflow:auto;">
		<?php echo nl2br($results); ?>
	</div>
</div>
<?php endif; ?>