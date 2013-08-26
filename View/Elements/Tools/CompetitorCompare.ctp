<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php
			echo $this->Form->input('Tool.url',
				array(
					'label' => __d('seo_tools', 'Enter Your URL')
				)
			);

			echo $this->Form->input('Tool.criteria',
				array(
					'label' => __d('seo_tools', 'Criteria')
				)
			);

			echo $this->Form->input('Tool.engine',
				array(
					'type' => 'select',
					'label' => __d('seo_tools', 'Search Engine'),
					'options' => array(
						'google.com' => 'Google.com',
						'google.es' => 'Google.es',
						'google.as' => 'Google.as',
						'google.at' => 'Google.at',
						'google.be' => 'Google.be',
						'google.ca' => 'Google.ca',
						'google.ch' => 'Google.ch',
						'google.cl' => 'Google.cl',
						'google.co.cr' => 'Google.co.cr',
						'google.co.il' => 'Google.co.il',
						'google.con.in' => 'Google.co.in',
						'google.co.jp' => 'Google.co.jp',
						'google.co.kr' => 'Google.co.kr',
						'google.co.nz' => 'Google.co.nz',
						'google.co.th' => 'Google.co.th',
						'google.co.uk' => 'Google.co.uk',
						'google.co.ve' => 'Google.co.ve',
						'google.co.za' => 'Google.co.za',
						'google.com.ar' => 'Google.com.ar',
						'google.com.au' => 'Google.com.au',
						'google.com.br' => 'Google.com.br',
						'google.com.co' => 'Google.com.co',
						'google.com.gr' => 'Google.com.gr',
						'google.com.hk' => 'Google.com.hk',
						'google.com.mx' => 'Google.com.mx',
						'google.com.my' => 'Google.com.my',
						'google.com.pe' => 'Google.com.pe',
						'google.com.ph' => 'Google.com.ph',
						'google.com.sg' => 'Google.com.sg',
						'google.com.tr' => 'Google.com.tr'
					)
				)
			);
		?>
		<em><?php echo __d('seo_tools', 'This may take a few minutes, please be patient and wait.'); ?></em><br />
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<div class="report" id="top10_report">
		<?php 
			$keywords = Set::extract('Analysis.title', $results); 
			$keywords = array_keys($keywords); 
		?>

		<fieldset>
			<legend id="report_overview"><?php echo __d('seo_tools', 'Report overview'); ?></legend>
			<em><?php echo __d('seo_tools', 'This report helps you to optimize the web page "<b>http://%s/</b>" for a high ranking on <b>%s</b> for the search term "<b>%s</b>".', $this->data['Tool']['url'], $this->data['Tool']['engine'], $this->data['Tool']['criteria']); ?></em>

			<!-- your site overview -->
			<div class="web-snippet">
				<img src="http://immediatenet.com/t/m?Size=1024x768&URL=<?php echo $this->data['Tool']['url']; ?>" class="web-tn" />
				<a href="http://<?php $this->data['Tool']['url']; ?>" target="_blank" class="title"><?php echo $results['Data']['Site']['title']; ?></a><br />
				<a href="http://<?php $this->data['Tool']['url']; ?>" target="_blank" class="url"><?php echo String::truncate("http://{$this->data['Tool']['url']}", 80); ?></a>
				<p class="description"><?php echo isset($results['Data']['Site']['tags']['description']) ? $results['Data']['Site']['tags']['description'] : __d('seo_tools', '[No meta description available.]'); ?></p>
			</div>

			<p class="versus">
				<?php echo $this->Html->image('/seo_tools/img/up-arrow-green.png'); ?><br />
				<?php echo __d('seo_tools', 'Your Web Page'); ?>
				<br />
				<?php echo __d('seo_tools', 'Your Competitors'); ?><br />
				<?php echo $this->Html->image('/seo_tools/img/down-arrow-red.png'); ?>
			</p>

			<!-- competitors overview -->
			<h2><?php __d('seo_tools', 'Your competitors for the search term "%s" on %s', $this->data['Tool']['criteria'], $this->data['Tool']['engine']); ?></h2>
			<?php $i = 0; foreach($results['Data']['Competitors'] as $competitor): $i++; ?>
				<div class="web-snippet">
					<span class="rank">#<?php echo $i; ?></span>
					<img src="http://immediatenet.com/t/m?Size=1024x768&URL=<?php echo $competitor['url']; ?>" class="web-tn" />
					<a href="<?php echo $competitor['url']; ?>" target="_blank" class="title"><?php echo $competitor['title']; ?></a><br />
					<a href="<?php echo $competitor['url']; ?>" target="_blank" class="url"><?php echo String::truncate($competitor['url'], 80); ?></a>
					<p class="description"><?php echo isset($competitor['tags']['description']) ? $competitor['tags']['description'] : __d('seo_tools', '[No meta description available.]'); ?></p>
				</div>
			<?php endforeach; ?>

			<div id="chart"><!-- RESULTS --></div>

			<!-- table of contents -->
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td colspan="2" align="left" valign="top"><b><?php echo __d('seo_tools', 'Table of contents'); ?></b></td>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td width="33%" height="20" align="left">1. <a href="#report_overview"><?php echo __d('seo_tools', 'Report overview'); ?></a></td>
						<td width="33%" height="20" align="left">6. <a href="#aspect_h1"><?php echo __d('seo_tools', 'Keyword use in H1 headline texts'); ?></a></td>
					</tr>

					<tr>
						<td align="left" valign="middle">2. <a href="#aspect_title"><?php echo __d('seo_tools', 'Keyword use in document title'); ?></a></td>
						<td align="left" valign="middle">7. <a href="#aspect_url"><?php echo __d('seo_tools', 'Keyword use in page URL'); ?></a></td>
					</tr>

					<tr>
						<td align="left" valign="middle">3. <a href="#aspect_backlinks"><?php echo __d('seo_tools', 'Global link popularity of web site'); ?></a></td>
						<td align="left" valign="middle">8. <a href="#aspect_alexa_rank"><?php echo __d('seo_tools', 'Number of visitors to the site'); ?></a></td>
					</tr>

					<tr>
						<td align="left" valign="middle">4. <a href="#aspect_body"><?php echo __d('seo_tools', 'Keyword use in body text'); ?></a></td>
						<td align="left" valign="middle">9. <a href="#report_tags/description"><?php echo __d('seo_tools', 'Keyword use in meta description'); ?></a></td>
					</tr>

					<tr>
						<td align="left" valign="middle">5. <a href="#aspect_age"><?php echo __d('seo_tools', 'Age of web site'); ?></a></td>
						<td align="left" valign="middle">10. <a href="#other_factors"><?php echo __d('seo_tools', 'Factors that could prevent your top ranking'); ?></a></td>
					</tr>
				</tbody>
			</table>
		</fieldset>

		<?php 
			$titles = array(
				'title' => array(
					'title' => __d('seo_tools', 'Keyword use in document title'), 
					'importance' => __d('seo_tools', 'Essential'), 
					'info' => __d('seo_tools', "The document title is the text within the &lt;title&gt;...&lt;/title&gt; tags in the HTML code of your web page. This chapter tries to find out how to use the search term '%s' in the document title and if it's important for %s", $this->data['Tool']['url'],    $this->data['Tool']['engine'])
				),
				'body' => array(
					'title' => __d('seo_tools', 'Keyword use in body text'), 
					'importance' => __d('seo_tools', 'Essential'), 
					'info' => __d('seo_tools', 'The body text is the text on your web page that can be seen by people in their web browsers. It does not include HTML commands, comments, etc. The more visible text there is on a web page, the more a search engine can index. The calculations include spaces and punctuation marks')
				),
				'backlinks' => array(
					'title' => __d('seo_tools', 'Global link popularity of web site'), 
					'importance' => __d('seo_tools', 'Essential'), 
					'info' => __d('seo_tools', 'The global link popularity measures how many web pages link to your site. The number of web pages linking to your site is not as important as the quality of the web pages that link to your site')
				),
				'h1' => array(
					'title' => __d('seo_tools', 'Keyword use in H1 headline texts'), 
					'importance' => __d('seo_tools', 'Very Important'), 
					'info' => __d('seo_tools', 'H1 headline texts are the texts that are written between the &lt;h1&gt;...&lt;/h1&gt; tags in the HTML code of a web page. Some search engines give extra relevance to search terms that appear in the headline texts')
				),
				'age' => array(
					'title' => __d('seo_tools', 'Age of web site'), 
					'importance' => __d('seo_tools', 'Very Important'), 
					'info' => __d('seo_tools', 'Spam sites often come and go quickly. For this reason, search engines tend to trust a web site that has been around for a long time over one that is brand new. The age of the domain is seen as a sign of trustworthiness because it cannot be faked. The data is provided by Alexa.com')
				),
				'alexa_rank' => array(
					'title' => __d('seo_tools', 'Number of visitors to the site'), 
					'importance' => __d('seo_tools', 'Important'), 
					'info' => __d('seo_tools', 'Search engines might look at web site usage data, such as the number of visitors to your site, to determine if your site is reputable and contains popular contents. The Alexa.com traffic rank is based on three months of aggregated traffic data from millions of Alexa Toolbar users and is a combined measure of page views and number of site visitors')
				),
				'url' => array(
					'title' => __d('seo_tools', 'Keyword use in page URL'), 
					'importance' => __d('seo_tools', 'Important'), 
					'info' => __d('seo_tools', 'The page URL is the part after the domain name in the web page address. This chapter tries to find out if Google.es  (la Web) gives extra relevance to search terms within the page URL. Separate your search terms in the page URL with slashes, dashes or underscores')
				),
				'tags/description' => array(
					'title' => __d('seo_tools', 'Keyword use in meta description'), 
					'importance' => __d('seo_tools', 'Important'), 
					'info' => __d('seo_tools', 'The Meta Description tag allows you to describe your web page. This chapter tries to find out if %s takes the Meta Description tag into account. Some search engines display the text to the user in the search results.<br/> Example: &lt;meta name="description" content= "This sentence describes the contents of your web site."&gt;<br/> Even if the Meta Description tag might not be important for ranking purposes, you should use the Meta Description tag to make sure that your web site is displayed with an attractive description in the search results', $this->data['Tool']['engine'])
				)
			);
		?>
		<?php foreach ($results['Analysis'] as $aspect => $data) { ?>
		<fieldset>
			<legend id="aspect_<?php echo $aspect; ?>">
				<?php echo $titles[$aspect]['title']; ?><br/>
				<em><?php echo $titles[$aspect]['importance']; ?></em>
			</legend>
			<em><?php echo $titles[$aspect]['info']; ?></em>

			<?php 
				if (in_array($aspect, array('backlinks', 'alexa_rank', 'age'))) {
					echo $this->element('SeoTools.competitor_compare/' . $aspect, compact('aspect', 'titles', 'results', 'data'));
				} else {
					if ($aspect != 'h1') {
						// body
						echo $this->element('SeoTools.competitor_compare/h1', compact('aspect', 'titles', 'results', 'data', 'keywords')); 
					}
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td align="left" valign="top" colspan="3"><b><?php echo __d('seo_tools', 'Your Content'); ?></b></td>
					</tr>
				</thead>

				<?php if ($aspect != 'h1') { ?>
					<tbody>
						<tr>
							<td align="left" valign="top" colspan="3">
							<?php 
								$your_content = Set::extract("/{$aspect}", $results['Data']['Site']);

								echo !empty($your_content[0]) ? $this->CC->emphasize_keywords($your_content[0], $keywords) : __d('seo_tools', 'Content not found');
							?>
							</td>
						</tr>
						<?php if ($aspect == 'body') {?>
						<tr>
							<td width="21%" align="left" valign="top">&nbsp;</td>
							<td width="46%" align="left" valign="top"><b><?php echo __d('seo_tools', 'Competitors'); ?></b></td>
							<td width="33%" align="left" valign="top"><b><?php echo __d('seo_tools', 'Your Site'); ?></b></td>
						</tr>
						<?php 
							$competitor_wc = Hash::extract($results, 'Analysis.body.{s}.competitors.words_count');
							$site_wc = Set::extract($results, 'Analysis.body.{s}.site.words_count');
						?>
						<tr class="advice_color_<?php echo $this->CC->advice_color($competitor_wc, $site_wc, $aspect); ?>">
							<td align="left" valign="top"><?php echo __d('seo_tools', 'Number of words'); ?></td>
							<td align="left" valign="top"><?php echo $this->CC->competitor_average($competitor_wc); ?></td>
							<td align="left" valign="top"><?php echo $site_wc; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				<?php } else { ?>
				<!-- H1 SITE LISTING -->
					<tbody>
						<tr>
							<td width="3%" align="left" valign="top"><b><?php echo __d('seo_tools', 'No.'); ?></b></td>
							<td width="97%" align="left" valign="top" colspan="2"><b><?php echo __d('seo_tools', 'H1 Heading Text'); ?></b></td>
						</tr>

						<?php 
							$i = 0;

							foreach ((array)$results['Data']['Site']['h1_array'] as $h1) { 
								$i++;
						?>
						<tr>
							<td align="left" valign="top"><?php echo $i; ?></td>
							<td align="left" valign="top"><?php echo htmlentities($h1); ?></td>
						</tr>
						<?php } ?>
					</tbody>
			<?php } ?>
			</table>

			<br/><hr/><br/>

			<?php foreach ($data as $keyword => $analysis) { ?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
						  <td colspan="3" align="left" valign="top"><b><?php echo __d('seo_tools', 'Search Term'); ?>: "<?php echo $keyword; ?>"</b></td>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td width="21%" align="left" valign="top">&nbsp;</td>
							<td width="40%" align="left" valign="top"><b><?php echo __d('seo_tools', 'Competitors'); ?></b></td>
							<td width="39%" align="left" valign="top"><b><?php echo __d('seo_tools', 'Your Site'); ?></b></td>
						</tr>
						<tr class="advice_color_<?php echo $this->CC->advice_color($analysis['competitors']['quantity'], $analysis['site']['quantity'], $aspect); ?>">
							<td align="left" valign="top"><?php echo __d('seo_tools', 'Quantity'); ?></td>
							<td align="left" valign="top"><?php echo $this->CC->competitor_average($analysis['competitors']['quantity']); ?></td>
							<td align="left" valign="top"><?php echo $analysis['site']['quantity']; ?></td>
						</tr>
						<tr class="advice_color_<?php echo $this->CC->advice_color($analysis['competitors']['density'], $analysis['site']['density'], $aspect); ?>">
							<td align="left" valign="top"><?php echo __d('seo_tools', 'Density'); ?></td>
							<td align="left" valign="top"><?php echo $this->CC->competitor_average($analysis['competitors']['density'], 'percent'); ?></td>
							<td align="left" valign="top"><?php echo $analysis['site']['density']; ?>%</td>
						</tr>
						<?php if ($aspect != 'h1') { ?>
						<tr class="advice_color_<?php echo $this->CC->advice_color($analysis['competitors']['position'], $analysis['site']['position'], $aspect); ?>">
							<td align="left" valign="top"><?php echo __d('seo_tools', 'Position'); ?></td>
							<td align="left" valign="top"><?php echo $this->CC->competitor_average($analysis['competitors']['position']); ?></td>
							<td align="left" valign="top"><?php echo $analysis['site']['position']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
			<?php } ?>
		</fieldset>
	<?php } ?>

		<fieldset>
			<legend id="aspect_other_factors"><?php echo __d('seo_tools', 'Factors that could prevent your top ranking'); ?></legend>
			<em><?php echo __d('seo_tools', 'Some ranking factors cannot be measured because the search engines do not reveal the necessary data, or it would be extremely time-consuming to measure the data. Make sure you pay attention to the following factors because they could prevent a top ranking for <b>%s</b> on <b>%s</b>.', $this->data['Tool']['url'], $this->data['Tool']['engine']); ?></em>
			<h1><?php echo __d('seo_tools', 'Advice'); ?></h1>

			<p class="questions">
				<b><?php echo __d('seo_tools', 'Inbound links to your web page'); ?></b><br/>

				<font><?php echo __d('seo_tools', 'Are the web pages linking to your web page relevant to the search term "%s"?', $this->data['Tool']['criteria']); ?></font><br/>
				<font><?php echo __d('seo_tools', 'How fast does your web page get new links pointing to it?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Do the web sites which link to your page belong to the same content category?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Since when do the links to your page exist?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Is the text surrounding the link to your page relevant to the search term "%s"?', $this->data['Tool']['criteria']); ?></font>
			</p>

			<p class="questions">
				<b><?php echo __d('seo_tools', 'Your web page'); ?></b><br/>

				<font><?php echo __d('seo_tools', 'How many important links from your other pages point to your web page?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Do the links on your web page point to high quality, topically-related pages?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'How often and how many changes do you make to your web page over time? Is your content up-to-date?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'How often and how many web pages do you add to your web site?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'How long do your visitors spend time on your web page?'); ?></font>
			</p>

			<p class="questions">
				<b><?php echo __d('seo_tools', 'Search engine result page'); ?></b><br/>

				<font><?php echo __d('seo_tools', 'Do your competitors on the search engine result page get a manual ranking boost by %s, for example Amazon or Wikipedia?', $this->data['Tool']['engine']); ?></font><br/>
				<font><?php echo __d('seo_tools', 'How many visitors of the search engine result pages click through to your page?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'How often do search engine visitors search for your company name or web page URL on %s?', $this->data['Tool']['engine']); ?></font>
			</p>

			<p class="questions">
				<b><?php echo __d('seo_tools', 'Negative ranking factors (you should be able to say "no" to all the following questions)'); ?></b><br/>

				<font><?php echo __d('seo_tools', 'Is your content very similar or a duplicate of existing content?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Is your server often down when search engine crawlers try to access it?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Do you link to web sites that do not deserve a link?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Do you use the same title or meta tags for many web pages?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Do you overuse the same keyword or key phrase?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Do you participate in link schemes?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Do you actively sell links on your web page?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Do a majority of your inbound links come from low quality or spam sites?'); ?></font><br/>
				<font><?php echo __d('seo_tools', 'Does your web page have any spelling or grammar mistakes?'); ?></font>
			</p>
		</fieldset>
	</div>

	<div id="chart_results" style="display:none;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0"><!-- chart -->
			<thead>
				<tr>
					<td colspan="4" align="left" valign="top"><b><?php echo __d('seo_tools', 'Search engine ranking factors performance'); ?></b></td>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td width="29%" rowspan="4" align="center" valign="middle">
						<img src="http://chart.apis.google.com/chart?cht=p3&chs=250x250&chd=t:<?php echo $this->CC->green; ?>,<?php echo $this->CC->red; ?>&chdl=<?php urlencode(__d('seo_tools', 'Passed factors')); ?>|<?php urldecode(__d('seo_tools', 'Failed factors')); ?>&chco=99CC00,EA4D5C&noCache=<?php echo rand(0,9999); ?>" width="250" height="250" />
					</td>
					<td width="42%" height="20" align="right"><b><?php echo __d('seo_tools', 'Ranking Factor Importance'); ?></b></td>
					<td width="17%" height="20" align="center"><b><?php echo __d('seo_tools', 'Factors Passed'); ?></b></td>
					<td width="12%" height="20" align="center"><b><?php echo __d('seo_tools', 'Factors Failed'); ?></b></td>
				</tr>

				<tr>
					<td align="right" valign="middle"><?php echo __d('seo_tools', 'Essential'); ?></td>
					<td align="center" valign="middle"><?php echo $this->CC->essential_passed; ?></td>
					<td align="center" valign="middle"><?php echo $this->CC->essential_failed; ?></td>
				</tr>

				<tr>
					<td align="right" valign="middle"><?php echo __d('seo_tools', 'Very Important'); ?></td>
					<td align="center" valign="middle"><?php echo $this->CC->very_important_passed; ?></td>
					<td align="center" valign="middle"><?php echo $this->CC->very_important_failed; ?></td>
				</tr>

				<tr>
					<td align="right" valign="middle"><?php echo __d('seo_tools', 'Important'); ?></td>
					<td align="center" valign="middle"><?php echo $this->CC->important_passed; ?></td>
					<td align="center" valign="middle"><?php echo $this->CC->important_failed; ?></td>
				</tr>
			</tbody>
		</table>
	</div>

	<script>
		$(document).ready(function () {
			$('div#chart').html($('div#chart_results').html());
			$('.body-text').width($('.ref-width').width());

			// refresh websnaps
			setInterval(function() { 
				$('img.web-tn').each(function () {
					$(this).attr('src', $(this).attr('src'));
				});
			}, 10000);
		});
	</script>
<?php endif; ?>