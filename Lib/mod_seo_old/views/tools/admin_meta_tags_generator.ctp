<?php if ( !isset($results) ) : ?>
<div style="width:100%; height:300px; overflow-y:auto;">
	<form id="toolForm" action="<?php echo $this->Html->url("/{$this->plugin}/tools/{$this->params['action']}"); ?>" method="post" onsubmit="tool_exe(700); return false;">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td width="50%" align="left" valign="top"><b><?phpecho __t('Title'); ?>:</b></td>
				<td width="50%" align="left" valign="top"><b><?phpecho __t('Description'); ?>:</b></td>
			</tr>
			<tr>
			  <td align="left" valign="top"><input type="text" name="data[Tool][metas][title]" value="" class="text" style="width:100%;" /></td>
			  <td rowspan="9" align="left" valign="top"><textarea name="data[Tool][metas][description]" style="width:100%; height:220px;" wrap="on"></textarea></td>
			</tr>
			<tr>
			  <td align="left" valign="top"><b>
			    <?phpecho __t('Keywords'); ?>
			  </b></td>
			</tr>
			<tr>
			  <td align="left" valign="top"><input type="text" name="data[Tool][metas][keywords]" value="" class="text" style="width:100%;" /></td>
		    </tr>
			<tr>
			  <td align="left" valign="top"><b>
			    <?phpecho __t('Author'); ?>
			  </b></td>
		    </tr>
			<tr>
			  <td align="left" valign="top"><input type="text" name="data[Tool][metas][author]" value="" class="text" style="width:100%;" /></td>
		    </tr>
			<tr>
			  <td align="left" valign="top"><b><?phpecho __t('Owner'); ?></b></td>
		    </tr>
			<tr>
			  <td align="left" valign="top"><input type="text" name="data[Tool][metas][owner]" value="" class="text" style="width:100%;" /></td>
		    </tr>
			<tr>
			  <td align="left" valign="top"><b>
			    <?phpecho __t('Copyright'); ?>
			  </b></td>
		  </tr>
			<tr>
			  <td align="left" valign="top"><input type="text" name="data[Tool][metas][copyright]" value="" class="text" style="width:100%;" /></td>
		  </tr>
			<tr>
				<td colspan="2" align="right" valign="top"><input type="submit" value="<?phpecho __t('Continue'); ?>" class="primary_lg" /></td>
			</tr>
		</table>
	</form>
</div>
<?php else: ?>
<div style="width:100%; height:auto; overflow-y:auto; overflow-x:hidden;">
	<h1><?phpecho __t('Meta Tags Generator'); ?></h1>
	<textarea style="width:100%; height:250px;" wrap="off"><?php echo $results; ?></textarea>
</div>
<?php endif; ?>