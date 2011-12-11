<?php if ( !isset($results) ) : ?>
<div style="width:100%; height:100px; overflow-y:auto; overflow-x:hidden;">
	<form id="toolForm" action="<?php echo $this->Html->url("/{$this->plugin}/tools/{$this->params['action']}"); ?>" method="post" onsubmit="tool_exe(550); return false;">
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
<div style="width:100%; height:380px; overflow-y:auto; overflow-x:hidden;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<td align="left" valign="top">
					<div class="seo_stats_snippet">
						<img class="url_tn" src="<?php echo $results['thumb']; ?>" />
						<div class="right-blk">
							<span>
								<?php echo $this->Html->image("/{$this->plugin}/img/icons/domain-name.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
								<?phpecho __t('Domain Name'); ?>: <b><?php echo substr($results['url'], 0, 15); echo strlen($results['url']) > 15 ? '...' : ''; ?></b>
							</span>
							
							<span>
								<?php echo $this->Html->image("/{$this->plugin}/img/icons/google.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
								<?phpecho __t('Google Pagerank'); ?>: <?php echo $this->Html->image("/{$this->plugin}/img/icons/pr/pr{$results['pagerank']}.gif", array('border' => 0, 'align' => 'absmiddle') ); ?>
							</span>
							
							<span>
								<?php echo $this->Html->image("/{$this->plugin}/img/icons/alexa.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
								<?phpecho __t('Alexa Rank'); ?>: <a href="http://www.alexa.com/siteinfo/<?php echo $results['url'] ?>" target="_blank"><b><?php echo $results['alexarank']; ?></b></a>
							</span>
							
							<span>
								<?php echo $this->Html->image("/{$this->plugin}/img/icons/yahoo.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
								<?phpecho __t('Yahoo Backlinks'); ?>: <a href="http://siteexplorer.search.yahoo.com/search?p=<?php echo $results['url'] ?>" target="_blank"><b><?php echo $results['backlinksYahoo']; ?></b></a>
							</span>
							
							<span>
								<?php echo $this->Html->image("/{$this->plugin}/img/icons/dmoz.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
								<?phpecho __t('DMOZ Directory'); ?>: <a href="http://www.dmoz.org/search?q=<?php echo $results['url'] ?>" target="_blank"><b><?php echo $results['dmoz'] ?echo __t('Yes') :echo __t('No'); ?></b></a>
							</span>
						</div>
					</div>
					
					<br/>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/domain-age.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Domain Age'); ?>: <a href="http://www.who.is/whois/<?php echo $results['url']; ?>" target="_blank"><b><?php echo is_array($results['age']) ? sprintf(__t('%s years, %s days'), $results['age']['years'], $results['age']['days']) :echo __t('Unknow'); ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/google-backlink.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Google Backlinks'); ?>: <a href="http://www.google.com/search?q=link:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['backlinksGoogle']; ?></b></a>
					</span>					
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/alexa.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Alexa Backlinks'); ?>: <a href="http://www.alexa.com/siteinfo/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['alexabacklink']; ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/yahoo.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Yahoo Directory'); ?>: <a href="http://search.yahoo.com/search/dir?p=<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['yahooDirectory'] ?echo __t('Yes') :echo __t('No'); ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/google.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Google Indexed Pages'); ?>: <a href="http://www.google.com/search?q=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['googleindexed']; ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/yahoo-indexed.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Yahoo Indexed Pages'); ?>: <a href="http://siteexplorer.search.yahoo.com/search?p=<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['yahooindexed']; ?></b></a>
					</span>
										
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/bing.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Bing Indexed Pages'); ?>: <a href="http://www.bing.com/search?mkt=en-US&q=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['bingindexed']; ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/digg.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Digg Links'); ?>: <a href="http://digg.com/search?q=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['digglinks']; ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/delicious.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Delicious Links'); ?>: <a href="http://www.delicious.com/url/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['deliciouslinks']; ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/technorati.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Technorati (Blog) Rank'); ?>: <a href="http://technorati.com/blogs/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['technoratirank']; ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/compete.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Compete Rank'); ?>: <a href="http://siteanalytics.compete.com/m/profiles/site/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['competerank']; ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/site-value.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Site Value'); ?>: <a href="http://www.websiteoutlook.com/<?php echo strpos($results['url'], 'www.') !== false ? '' : 'www.'; echo $results['url']; ?>" target="_blank"><b><?php echo ($results['sitevalue'] != false) ? $results['sitevalue'] :echo __t('No data'); ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/w3c.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('W3C Validator'); ?>: <a href="http://validator.w3.org/check?uri=<?php echo $results['url']; ?>" target="_blank"><b><?phpecho __t('Details'); ?></b></a>
					</span>
					
					<span class="imageDouble">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/archive.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Internet Archive'); ?>: <a href="http://web.archive.org/web/*/<?php echo $results['url']; ?>" target="_blank"><b><?phpecho __t('Details'); ?></b></a>
					</span>
					
					
					
					
					
					<span class="imageDouble" style="width:300px;">
						<?php echo $this->Html->image("/{$this->plugin}/img/icons/google-bot.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?phpecho __t('Google Bot Last Visit'); ?>: <a href="" target="_blank"><b><?php echo $results['googlebot']; ?></b></a>
					</span>					
				</td>
		  </tr>
			<tr>
				<td width="100%" align="left" valign="top">&nbsp;</td>
			</tr>
		</thead>
		
		<tbody>
		</tbody>
	</table>
</div>
<?php endif; ?>