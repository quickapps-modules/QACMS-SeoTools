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

	<h1 class="main-title"><?php __e("URL Editor"); ?></h1>


	<div class="main">
			<form action="" method="post" id="updateUrl" onSubmit="update_url(this); return false;">
				<?php echo $this->Form->hidden("Url.id", array('label' => false) ); ?>
				<?php echo $this->Form->hidden("Url.url", array('label' => false) ); ?>
				<div align="center" class="centermain">
				  <div class="main">
					<div id="tabs">
					  <div class="tab"><a href="#"><?php __e('URL Optimization'); ?></a></div>
					</div>
					<div class="module">
					  <div class="module-head">&nbsp;</div>
					  <div class="module-wrap">
					  
						<table width="100%" cellspacing="5">
						  <tr>
							<td width="15%" align="left" valign="top" nowrap="nowrap"><b><?php __e('URL'); ?>: </b></td>
							<td width="85%" align="left" valign="top"><?php echo Configure::read('ModSeo.Config.seo_site_url') . $this->data['Url']['url']; ?></td>
						  </tr>
						  
						  <tr>
							<td align="left" valign="top" nowrap="nowrap">
								<b><?php __e('Redirect to'); ?>:</b><br/>
								<em><?php __e('Leave empty for no redirection'); ?></em>
							</td>
							<td align="left" valign="top">
								<?php echo $this->Form->text("Url.redirect", array('label' => false, 'class' => 'text', 'style' => 'width:300px;') ); ?>
								<em><?php __e('Must be absolute, example: http://www.my-website.com'); ?></em>
							</td>
						  </tr>	
						  
						  <tr>
							<td width="15%" align="left" valign="top" nowrap="nowrap"><b><?php __e('Status'); ?>: </b></td>
							<td width="85%" align="left" valign="top"><?php echo $this->Form->radio('Url.status', array(0 => _e('Active'), 1 => _e('Inactive') ), array('legend' => false, 'separator' => ' | ')  ); ?></td>
						  </tr>						  

						  <tr>
							<td colspan="2" align="left"><hr/></td>
						  </tr>
						  
						  
						  <tr>
							<td width="15%" align="left" valign="top" nowrap="nowrap"><b><?php __e('Page Title'); ?>: </b></td>
							<td width="85%" align="left" valign="top">
								<?php echo $this->Form->text("Url.title", array('label' => false, 'class' => 'text', 'style' => 'width:300px;') ); ?>
							</td>
						  </tr>
						  
						  <tr>
							<td align="left" valign="top" nowrap="nowrap"><b><?php __e('Meta Description'); ?>: </b></td>
							<td align="left" valign="top">
								<?php echo $this->Form->textarea("Url.description", array('label' => false, 'class' => 'text', 'style' => 'width:99%;') ); ?>
							</td>
						  </tr>
	
						  <tr>
							<td align="left" valign="top" nowrap="nowrap">
								<b><?php __e('Meta Keywords'); ?>:</b><br/>
								<em><?php __e('Comma separated ","'); ?></em>
							</td>
							<td align="left" valign="top">
								<?php echo $this->Form->textarea("Url.keywords", array('label' => false, 'class' => 'text', 'style' => 'width:99%;') ); ?>
							</td>
						  </tr>
	
						  <tr>
							<td align="left" valign="top" nowrap="nowrap">
								<b><?php __e('Header Code'); ?>: </b><br/>
								<em><?php __e('Will be inserted betweeen &lt;head&gt;&lt;/head&gt; tags'); ?></em>
							</td>
							<td align="left" valign="top">
								<?php echo $this->Form->textarea("Url.header", array('label' => false, 'class' => 'text', 'style' => 'width:99%;') ); ?>
							</td>
						  </tr>
	
						  <tr>
							<td align="left" valign="top" nowrap="nowrap">
								<b><?php __e('Footer Code'); ?>:</b><br/>
								<em><?php __e('Will be inserted just before &lt;/body&gt; tag'); ?></em>
							</td>
							<td align="left" valign="top">
								<?php echo $this->Form->textarea("Url.header", array('label' => false, 'class' => 'text', 'style' => 'width:99%;') ); ?>
							</td>
						  </tr>
	
						  <tr>
							<td colspan="2" align="left">
								<input type="submit" class="primary_lg" value="<?php __e('Save'); ?>">
							</td>
						  </tr>
						</table>
					 
					  </div>
					  <div class="module-footer">
						<div>&nbsp;</div>
					  </div>
					</div>
				  </div>
				</div><!-- basic data -->
			</form>			
		
	</div>
</div>