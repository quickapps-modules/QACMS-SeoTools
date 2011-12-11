<?php if ( !isset($results) ) : ?>
<div style="width:100%; height:100px; overflow-y:auto;">
	<form id="toolForm" action="<?php echo $this->Html->url("/{$this->plugin}/tools/{$this->params['action']}"); ?>" method="post" onsubmit="tool_exe(600); return false;">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td align="left" valign="top"><b><?phpecho __t('Enter Your URL'); ?>:</b></td>
				</tr>
			<tr>
			  <td align="left" valign="top"><input type="text" name="data[Tool][url]" value="<?php echo Configure::read('ModSeo.Config.seo_site_url'); ?>" class="text" style="width:100%;" /></td>
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
	
	
	<?php
		$words_1 = explode(', ', $results['words_1']);
		$words_2 = explode(', ', $results['words_2']);
		$words_3 = explode(', ', $results['words_3']);
	?>
	<h1><?php printf(__t('%s total phrases extracted'), (count($words_1) + count($words_2) + count($words_3))  ); ?></h1>
	
	<h2 style="font-size:12px;"><?php printf(__t('One Word Phrases (%s total phrases)'), count($words_1) ); ?></h2>
	<div style="background:#fff; padding-left:5px; width:99%; height:80px; overflow:auto; white-space: nowrap;">
		<?php foreach($words_1 as $word): ?>
			<?php echo $word; ?><br/>
		<?php endforeach; ?>
	</div>
	
	<h2 style="font-size:12px;"><?php printf(__t('Two Word Phrases (%s total phrases)'), count($words_2) ); ?></h2>
	<div style="background:#fff; padding-left:5px; width:99%; height:80px; overflow:auto; white-space: nowrap;">
		<?php foreach($words_2 as $word): ?>
			<?php echo $word; ?><br/>
		<?php endforeach; ?>
	</div>
	
	<h2 style="font-size:12px;"><?php printf(__t('Three Word Phrases (%s total phrases)'), count($words_3) ); ?></h2>
	<div style="background:#fff; padding-left:5px; width:99%; height:80px; overflow:auto; white-space: nowrap;">
		<?php foreach($words_3 as $word): ?>
			<?php echo $word; ?><br/>
		<?php endforeach; ?>
	</div>



</div>

<?php endif; ?>