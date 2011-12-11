<?php if ( !isset($results) ) : ?>
<div style="width:100%; height:auto; overflow-y:auto;">
	<form id="toolForm" action="<?php echo $this->Html->url("/{$this->plugin}/tools/{$this->params['action']}"); ?>" method="post" onsubmit="tool_exe(600); return false;">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td align="left" valign="top"><b><?phpecho __t('Enter Your URL'); ?>:</b></td>
				</tr>
			<tr>
			  <td align="left" valign="top">
				<textarea style="width:100%; height:250px;" name="data[Tool][text]"></textarea>
			  </td>
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
	<h1><?phpecho __t('HTML Encrypter'); ?></h1>
	<textarea style="width:100%; height:250px; white-space: nowrap;"><?php echo $results; ?></textarea>
</div>
<?php endif; ?>