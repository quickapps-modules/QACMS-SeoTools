<?php echo $javascript->link("tablekit.js")."\n"; ?>

<div align="center" class="centermain">

	<!-- navigation bar -->
	<table width="100%" class="navigation-menu" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="50%" align="left" valign="middle" class="left-col">
				<?php echo $html->bread_crumb(); ?>
			</td>
		
			<td align="right" valign="middle" class="right-col">
				<?php echo $this->element('nav_bar'); ?>
			</td>
		</tr>
	</table>
	<!-- end navigation bar -->

	<h1 class="main-title"><?php __e("URLs List"); ?></h1>
	
	<div class="main">
		<form id="addCourse-form" action="<?php echo $this->Html->url("/{$this->plugin}/urls/add"); ?>" method="post" style="display:none;">
			<table width="100%">

			  <tr>
				<td width="45%">&nbsp;</td>
				<td align="right" >
					<input type="text" class="text" name="data[Url][url]" id="CourseTitle" value="<?php __e('http://'); ?>" onFocus="if(this.value == '<?php __e('http://');?>'){this.value = ''}" onBlur="if(this.value == ''){this.value = '<?php __e('http://');?>'}" />
					&nbsp;
					<input type="submit" class="primary_lg" value="<?php __e('Add'); ?>" />
				</td>
			  </tr>
			</table>
		</form><!-- add form -->


		
	<div id="tabs">
	<div class="tab"><a href="#" onclick="Effect.toggle('searchForms', 'slide'); return false;"	style="cursor: pointer;"><?php __e('Quick Search'); ?></a></div>
	</div>
	<div class="module">
		<div class="module-head">&nbsp;</div>
		<div class="module-wrap" id="searchForms" style="<?php echo $this->Session->check('Posts.index') ? '' : 'display: none;'; ?>">

			<form method="post" action="">
				<table width="100%" cellspacing="5">
					<tr>
						<td width="14%" align="left"><b><?php __e('Filter By'); ?>:</b></td>
						<td width="17%" align="left">
						<?php 
							echo $form->select('Url.search.field', 
								array(
									_('Filter By') => 
										array(
											'url' => _('URL'),
											'title' => _('Page Title'),
											'description' => _('Meta Description'),
											'kewords' => _('Meta Keywords'),
											'header' => _('Header'),
											'footer' => _('Footer')
										)
								)
							);
						?>							
						</td>
						<td align="left">
							<?php echo $form->text('Url.search.value', array('class' => 'text', 'style' => 'width: 165px') ); ?>
						</td>
					</tr>
					<tr>
					  <td colspan="3" align="right"><input class="primary_lg" type="submit" value="<?php __e('Search'); ?>" /></td>
					</tr>
				</table>

			</form>
		</div>
		<div class="module-footer">
		<div>&nbsp;</div>
		</div>
	</div><!-- search -->				
		
		
		
		
		
		
		


		

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="left" valign="top"><b><?php __e('With Selected'); ?>:</b>&nbsp;
				<select name="actions_select" id="actions_select"	onChange="actions_select(this);">
					<option value="0"><?php __e('Select Action'); ?></option>
					<option value="urls/delete" text="<?php __e('Delete all selected urls'); ?>"><?php __e('Delete'); ?></option>
					<option value="urls/activate" text="<?php __e('Activate all selected urls'); ?>"><?php __e('Activate'); ?></option>
					<option value="urls/desactivate" text="<?php __e('Desactivate all selected urls'); ?>"><?php __e('Desactivate'); ?></option>
				</select>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top">
					<div id="items_list"><?php echo $this->element('urls_list'); ?></div>
				</td>
			</tr>
		</table>

	</div>
</div>