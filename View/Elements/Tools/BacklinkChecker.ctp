<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
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