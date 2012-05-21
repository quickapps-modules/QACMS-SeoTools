<?php if (!isset($results)): ?>
	<?php echo $this->Form->create(false); ?>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td align="left" valign="top"><b><?php echo __d('seo_tools', 'Enter Your URL'); ?>:</b></td>
			</tr>

			<tr>
				<td align="left" valign="top"><input type="text" name="data[Tool][url]" value="<?php echo Configure::read('ModSeo.Config.seo_site_url'); ?>" class="text" style="width:100%;" /></td>
			</tr>

			<tr>
				<td align="left" valign="top">
					<input type="submit" value="<?php echo __d('seo_tools', 'Continue'); ?>" class="primary_lg" />
				</td>
			</tr>
		</table>
	<?php echo $this->Form->end(); ?>
<?php else: ?>
	<style>
	   .url_tn img { width:202px; height:152px; float:left; }
	   
		span.imageDouble { width:225px; padding:5px; float:left; display:block; }
		span.imageDouble a { text-decoration:none; }
	</style>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td align="left" valign="top" width="250">
					<script type="text/javascript" src="http://www.websnapr.com/js/websnapr.js"></script>

					<div class="url_tn">
						<script type="text/javascript">wsr_snapshot('<?php echo $this->data['Tool']['url']; ?>', '<?php echo Configure::read('Modules.SeoTools.settings.websnapr_key'); ?>', 't');</script>
					</div>
				</td>

				<td align="left" valign="top">
					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/domain-name.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
						<?php echo __d('seo_tools', 'Domain Name'); ?>: <b><?php echo substr($results['url'], 0, 15); echo strlen($results['url']) > 15 ? '...' : ''; ?></b>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/google.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
						<?php echo __d('seo_tools', 'Google Pagerank'); ?>: <?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/pr/pr{$results['pagerank']}.gif", array('border' => 0, 'align' => 'absmiddle') ); ?>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/alexa.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
						<?php echo __d('seo_tools', 'Alexa Rank'); ?>: <a href="http://www.alexa.com/siteinfo/<?php echo $results['url'] ?>" target="_blank"><b><?php echo $results['alexarank']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/dmoz.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
						<?php echo __d('seo_tools', 'DMOZ Directory'); ?>: <a href="http://www.dmoz.org/search?q=<?php echo $results['url'] ?>" target="_blank"><b><?php echo $results['dmoz'] ? __d('seo_tools', 'Yes') : __d('seo_tools', 'No'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/domain-age.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Domain Age'); ?>: <a href="http://www.who.is/whois/<?php echo $results['url']; ?>" target="_blank"><b><?php echo is_array($results['age']) ? sprintf(__d('seo_tools', '%s years, %s days'), $results['age']['years'], $results['age']['days']) : __d('seo_tools', 'Unknow'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/google-backlink.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Google Backlinks'); ?>: <a href="http://www.google.com/search?q=link:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['backlinksGoogle']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/alexa.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Alexa Backlinks'); ?>: <a href="http://www.alexa.com/siteinfo/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['alexabacklink']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/yahoo.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Yahoo Directory'); ?>: <a href="http://search.yahoo.com/search/dir?p=<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['yahooDirectory'] ? __d('seo_tools', 'Yes') : __d('seo_tools', 'No'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/google.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Google Indexed Pages'); ?>: <a href="http://www.google.com/search?q=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['googleindexed']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/yahoo-indexed.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Yahoo Indexed Pages'); ?>: <a href="http://search.yahoo.com/search?p=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['yahooindexed']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/bing.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Bing Indexed Pages'); ?>: <a href="http://www.bing.com/search?mkt=en-US&q=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['bingindexed']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/digg.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Digg Links'); ?>: <a href="http://digg.com/search?q=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['digglinks']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/delicious.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Delicious Links'); ?>: <a href="http://www.delicious.com/url/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['deliciouslinks']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/technorati.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Technorati (Blog) Rank'); ?>: <a href="http://technorati.com/blogs/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['technoratirank']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/compete.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Compete Rank'); ?>: <a href="http://siteanalytics.compete.com/m/profiles/site/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['competerank']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/site-value.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Site Value'); ?>: <a href="http://www.websiteoutlook.com/<?php echo strpos($results['url'], 'www.') !== false ? '' : 'www.'; echo $results['url']; ?>" target="_blank"><b><?php echo ($results['sitevalue'] != false) ? $results['sitevalue'] : __d('seo_tools', 'No data'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/w3c.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'W3C Validator'); ?>: <a href="http://validator.w3.org/check?uri=<?php echo $results['url']; ?>" target="_blank"><b><?php echo __d('seo_tools', 'Details'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/archive.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Internet Archive'); ?>: <a href="http://web.archive.org/web/*/<?php echo $results['url']; ?>" target="_blank"><b><?php echo __d('seo_tools', 'Details'); ?></b></a>
					</span>

					<span class="imageDouble" style="width:300px;">
						<?php echo $this->Html->image("/seo_tools/img/seo-stats-icons/google-bot.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Google Bot Last Visit'); ?>: <a href="" target="_blank"><b><?php echo $results['googlebot']; ?></b></a>
					</span>
				</td>
			</tr>
		</tbody>
	</table>
<?php endif; ?>