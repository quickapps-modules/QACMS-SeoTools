<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tbody>
			<tr>
				<td align="left" valign="top" width="250">
					<div class="url_tn">
						<img src="http://immediatenet.com/t/m?Size=1024x768&URL=<?php echo $this->data['Tool']['url']; ?>" class="web-tn" />
					</div>
				</td>

				<td align="left" valign="top">
					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/domain-name.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
						<?php echo __d('seo_tools', 'Domain Name'); ?>: <b><?php echo substr($results['url'], 0, 15); echo strlen($results['url']) > 15 ? '...' : ''; ?></b>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/google.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
						<?php echo __d('seo_tools', 'Google Pagerank'); ?>: <?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/pr/pr{$results['pagerank']}.gif", array('border' => 0, 'align' => 'absmiddle') ); ?>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/alexa.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
						<?php echo __d('seo_tools', 'Alexa Rank'); ?>: <a href="http://www.alexa.com/siteinfo/<?php echo $results['url'] ?>" target="_blank"><b><?php echo $results['alexarank']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/dmoz.png", array('border' => 0, 'align' => 'absmiddle') ); ?> 
						<?php echo __d('seo_tools', 'DMOZ Directory'); ?>: <a href="http://www.dmoz.org/search?q=<?php echo $results['url'] ?>" target="_blank"><b><?php echo $results['dmoz'] ? __d('seo_tools', 'Yes') : __d('seo_tools', 'No'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/domain-age.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Domain Age'); ?>: <a href="http://www.who.is/whois/<?php echo $results['url']; ?>" target="_blank"><b><?php echo is_array($results['age']) ? sprintf(__d('seo_tools', '%s years, %s days'), $results['age']['years'], $results['age']['days']) : __d('seo_tools', 'Unknow'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/google-backlink.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Google Backlinks'); ?>: <a href="http://www.google.com/search?q=link:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['backlinksGoogle']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/alexa.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Alexa Backlinks'); ?>: <a href="http://www.alexa.com/siteinfo/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['alexabacklink']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/yahoo.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Yahoo Directory'); ?>: <a href="http://search.yahoo.com/search/dir?p=<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['yahooDirectory'] ? __d('seo_tools', 'Yes') : __d('seo_tools', 'No'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/google.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Google Indexed Pages'); ?>: <a href="http://www.google.com/search?q=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['googleindexed']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/bing.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Bing Indexed Pages'); ?>: <a href="http://www.bing.com/search?mkt=en-US&q=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['bingindexed']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/digg.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Digg Links'); ?>: <a href="http://digg.com/search?q=site:<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['digglinks']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/delicious.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Delicious Links'); ?>: <a href="http://www.delicious.com/url/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['deliciouslinks']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/technorati.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Technorati (Blog) Rank'); ?>: <a href="http://technorati.com/blogs/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['technoratirank']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/compete.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Compete Rank'); ?>: <a href="http://siteanalytics.compete.com/m/profiles/site/<?php echo $results['url']; ?>" target="_blank"><b><?php echo $results['competerank']; ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/site-value.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Site Value'); ?>: <a href="http://www.websiteoutlook.com/<?php echo strpos($results['url'], 'www.') !== false ? '' : 'www.'; echo $results['url']; ?>" target="_blank"><b><?php echo ($results['sitevalue'] != false) ? $results['sitevalue'] : __d('seo_tools', 'No data'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/w3c.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'W3C Validator'); ?>: <a href="http://validator.w3.org/check?uri=<?php echo $results['url']; ?>" target="_blank"><b><?php echo __d('seo_tools', 'Details'); ?></b></a>
					</span>

					<span class="imageDouble">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/archive.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Internet Archive'); ?>: <a href="http://web.archive.org/web/*/<?php echo $results['url']; ?>" target="_blank"><b><?php echo __d('seo_tools', 'Details'); ?></b></a>
					</span>

					<span class="imageDouble" style="width:300px;">
						<?php echo $this->Html->image("/seo_tools/img/Tools/SeoStats/google-bot.png", array('border' => 0, 'align' => 'absmiddle') ); ?>
						<?php echo __d('seo_tools', 'Google Bot Last Visit'); ?>: <a href="" target="_blank"><b><?php echo $results['googlebot']; ?></b></a>
					</span>
				</td>
			</tr>
		</tbody>
	</table>

	<script>
		$(document).ready(function () {
			// refresh websnaps
			setInterval(function() { 
				$('img.web-tn').each(function () {
					$(this).attr('src', $(this).attr('src'));
				});
			}, 10000);
		});
	</script>
<?php endif; ?>