<table width="100%" id="table_list" class="tablekit">
	<thead>
		<tr>
			<th width="2%" align="center" class="nosort"><input type="checkbox" id="checkAll" onClick="chkAll(this);"></th>
			<th width="49%" align="left" class="text"><?php __e("URL"); ?></th>
			<th width="42%" align="left" class="number"><?php __e("Title"); ?></th>
			<th width="7%" align="center" class="text"><?php __e("Status"); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php 
		if ( count($results) > 0){
			foreach ($results as $item) {
		?>
		<tr	class="content <?php echo ($item['Url']['status']) ? 'active' : 'inactive'; ?>">
			<td align="center"><input type="checkbox" name="data[Items][id][]" value="<?php echo $item['Url']['id']; ?>" /></td>
			<td align="left" valign="top"><a href="<?php echo $this->Html->url("/{$this->plugin}/urls/edit/{$item['Url']['id']}"); ?>"><?php echo Configure::read('ModSeo.Config.seo_site_url') . $item['Url']['url']; ?></a></td>
			<td align="left" valign="middle"><?php echo $item['Url']['title']; ?></td>
			<td align="center" valign="middle"><!--<?php echo $item['Url']['status']; ?>--><?php echo $this->Html->image("{$item['Url']['status']}_ico.gif"); ?></td>
		</tr>
		<?php
			}

		}else{	?>
		<tr>
			<td align="center" colspan="4"><br />
			<?php __e('You have no urls.'); ?><br />
			</td>
		</tr>
		<?php }?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="4" align="center">
				<span class="paginator">
					<?php $paginator->options( array( 'url'=> $this->passedArgs ) ); ?>
					<?php echo $paginator->prev('«', null, null, array('class' => 'disabled') ); ?>
					<?php echo $paginator->numbers( array('separator' => ' ') ); ?>
					<?php echo $paginator->next('»', null, null, array('class' => 'disabled')); ?>
				</span>
			</th>
		</tr>

		<tr>
			<td colspan="4" align="center">
			<form action="" method="post"><?php __e("Rows per Page"); ?>: 
				<input name="rows_per_page" type="text" id="rows_per_page" value="<?php echo Configure::read('rows_per_page') ?>" size="3" />
			</form>
			</td>
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
	TableKit.unloadTable('table_list');
	TableKit.Sortable.init('table_list');
</script>
