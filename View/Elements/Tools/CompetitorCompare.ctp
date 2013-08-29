<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<div class="processing" style="display:none;">
			<div style="text-align:center;">
				<?php echo $this->Html->image('/seo_tools/img/Tools/CompetitorCompare/process.gif'); ?>
			</div>

			<p class="task-start">
				<span class="label"><?php echo __d('seo_tools', 'Please Wait...'); ?></span>
				<?php echo __d('seo_tools', 'Validating information.'); ?>
			</p>

			<p class="task-get_site_page">
				<span class="label"><?php echo __d('seo_tools', 'Please Wait...'); ?></span>
				<?php echo __d('seo_tools', 'Downloading your web page.'); ?>
			</p>

			<p class="task-get_snippets">
				<span class="label"><?php echo __d('seo_tools', 'Please Wait...'); ?></span>
				<?php echo __d('seo_tools', 'Fetching search engine results.'); ?>
			</p>

			<p class="task-get_competitor_page">
				<span class="label"><?php echo __d('seo_tools', 'Please Wait...'); ?></span>
				<?php echo __d('seo_tools', 'Downloading competitor web pages.'); ?>
			</p>

			<p class="task-analize_competitor">
				<span class="label"><?php echo __d('seo_tools', 'Please Wait...'); ?></span>
				<?php echo __d('seo_tools', 'Analyzing competitors.'); ?>
			</p>

			<p class="task-analize_site">
				<span class="label"><?php echo __d('seo_tools', 'Please Wait...'); ?></span>
				<?php echo __d('seo_tools', 'Analyzing your web page.'); ?>
			</p>

			<p class="task-report">
				<span class="label"><?php echo __d('seo_tools', 'Please Wait...'); ?></span>
				<?php echo __d('seo_tools', 'Generating report.'); ?>
			</p>

			<hr />
		</div>

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

			/**
			 * EngineClass|options for EngineClass::main()
			 *
			 * example: Google|option1|option2|option3
			 * will invoke:
			 * Google::results($keywords, array('option1', 'option2', 'option3'))
			 *
			 */
			echo $this->Form->input('Tool.engine',
				array(
					'type' => 'select',
					'label' => __d('seo_tools', 'Search Engine'),
					'options' => array(
						'Google' => array(
							'Google|www.google.com.np' => 'Google ﻿नेपाल',
							'Google|www.google.dz' => 'Google Algérie',
							'Google|www.google.as' => 'Google American Samoa',
							'Google|www.google.ad' => 'Google Andorra',
							'Google|www.google.it.ao' => 'Google Angola',
							'Google|www.google.com.ai' => 'Google Anguilla',
							'Google|www.google.com.ag' => 'Google Antigua and Barbuda',
							'Google|www.google.com.ar' => 'Google Argentina',
							'Google|www.google.ac' => 'Google Ascension Island',
							'Google|www.google.com.au' => 'Google Australia',
							'Google|www.google.az' => 'Google Azərbaycan',
							'Google|www.google.be' => 'Google België',
							'Google|www.google.com.bz' => 'Google Belize',
							'Google|www.google.bj' => 'Google Bénin',
							'Google|www.google.bt' => 'Google Bhutan',
							'Google|www.google.com.bo' => 'Google Bolivia',
							'Google|www.google.ba' => 'Google Bosna i Hercegovina',
							'Google|www.google.co.bw' => 'Google Botswana',
							'Google|www.google.com.br' => 'Google Brasil',
							'Google|www.google.vg' => 'Google British Virgin Islands',
							'Google|www.google.com.bn' => 'Google Brunei',
							'Google|www.google.bf' => 'Google Burkina Faso',
							'Google|www.google.bi' => 'Google Burundi',
							'Google|www.google.cv' => 'Google Cabo Verde',
							'Google|www.google.cm' => 'Google Cameroun',
							'Google|www.google.ca' => 'Google Canada',
							'Google|www.google.cat' => 'Google Català',
							'Google|www.google.cf' => 'Google Centrafrique',
							'Google|www.google.cz' => 'Google Česká republika',
							'Google|www.google.cl' => 'Google Chile',
							'Google|www.google.com.co' => 'Google Colombia',
							'Google|www.google.co.ck' => 'Google Cook Islands',
							'Google|www.google.co.cr' => 'Google Costa Rica',
							'Google|www.google.ci' => 'Google Cote D’Ivoire',
							'Google|www.google.me' => 'Google Crna Gora',
							'Google|www.google.com.cu' => 'Google Cuba',
							'Google|www.google.dk' => 'Google Danmark',
							'Google|www.google.de' => 'Google Deutschland',
							'Google|www.google.dj' => 'Google Djibouti',
							'Google|www.google.dm' => 'Google Dominica',
							'Google|www.google.com.ec' => 'Google Ecuador',
							'Google|www.google.ee' => 'Google Eesti',
							'Google|www.google.com.sv' => 'Google El Salvador',
							'Google|www.google.es' => 'Google España',
							'Google|www.google.com.fj' => 'Google Fiji',
							'Google|www.google.fr' => 'Google France',
							'Google|www.google.ga' => 'Google Gabon',
							'Google|www.google.com.gh' => 'Google Ghana',
							'Google|www.google.com.gi' => 'Google Gibraltar',
							'Google|www.google.gl' => 'Google Grønlands',
							'Google|www.google.gp' => 'Google Guadeloupe',
							'Google|www.google.com.gt' => 'Google Guatemala',
							'Google|www.google.gg' => 'Google Guernsey',
							'Google|www.google.gy' => 'Google Guyana',
							'Google|www.google.ht' => 'Google Haïti',
							'Google|www.google.hn' => 'Google Honduras',
							'Google|www.google.hr' => 'Google Hrvatska',
							'Google|www.google.co.in' => 'Google India',
							'Google|www.google.co.id' => 'Google Indonesia',
							'Google|www.google.ie' => 'Google Ireland',
							'Google|www.google.is' => 'Google Ísland',
							'Google|www.google.im' => 'Google Isle of Man',
							'Google|www.google.it' => 'Google Italia',
							'Google|www.google.com.jm' => 'Google Jamaica',
							'Google|www.google.je' => 'Google Jersey',
							'Google|www.google.co.ke' => 'Google Kenya',
							'Google|www.google.ki' => 'Google Kiribati',
							'Google|www.google.lv' => 'Google Latvija',
							'Google|www.google.co.ls' => 'Google Lesotho',
							'Google|www.google.li' => 'Google Liechtenstein',
							'Google|www.google.lt' => 'Google Lietuvos',
							'Google|www.google.lu' => 'Google Luxemburg',
							'Google|www.google.mg' => 'Google Madagasikara',
							'Google|www.google.hu' => 'Google Magyarország',
							'Google|www.google.mw' => 'Google Malawi',
							'Google|www.google.com.my' => 'Google Malaysia',
							'Google|www.google.mv' => 'Google Maldives',
							'Google|www.google.ml' => 'Google Mali',
							'Google|www.google.com.mt' => 'Google Malta',
							'Google|www.google.co.ma' => 'Google Maroc',
							'Google|www.google.mu' => 'Google Mauritius',
							'Google|www.google.com.mx' => 'Google México',
							'Google|www.google.fm' => 'Google Micronesia',
							'Google|www.google.co.mz' => 'Google Moçambique',
							'Google|www.google.md' => 'Google Moldova',
							'Google|www.google.ms' => 'Google Montserrat',
							'Google|www.google.com.na' => 'Google Namibia',
							'Google|www.google.nr' => 'Google Nauru',
							'Google|www.google.nl' => 'Google Nederland',
							'Google|www.google.co.nz' => 'Google New Zealand',
							'Google|www.google.com.ni' => 'Google Nicaragua',
							'Google|www.google.com.ng' => 'Google Nigeria',
							'Google|www.google.ne' => 'Google Nijar',
							'Google|www.google.nu' => 'Google Niue',
							'Google|www.google.com.nf' => 'Google Norfolk Island',
							'Google|www.google.no' => 'Google Norge',
							'Google|www.google.co.uz' => 'Google O’zbekiston',
							'Google|www.google.at' => 'Google Österreich',
							'Google|www.google.com.pk' => 'Google Pakistan',
							'Google|www.google.com.pa' => 'Google Panamá',
							'Google|www.google.com.pg' => 'Google Papua New Guinea',
							'Google|www.google.com.py' => 'Google Paraguay',
							'Google|www.google.com.pe' => 'Google Perú',
							'Google|www.google.com.ph' => 'Google Pilipinas',
							'Google|www.google.pn' => 'Google Pitcairn Islands',
							'Google|www.google.pl' => 'Google Polska',
							'Google|www.google.pt' => 'Google Portugal',
							'Google|www.google.com.pr' => 'Google Puerto Rico',
							'Google|www.google.com.do' => 'Google República Dominicana',
							'Google|www.google.cd' => 'Google République démocratique du Congo',
							'Google|www.google.cg' => 'Google République du Congo',
							'Google|www.google.ro' => 'Google România',
							'Google|www.google.rw' => 'Google Rwanda',
							'Google|www.google.sh' => 'Google Saint Helena',
							'Google|www.google.com.vc' => 'Google Saint Vincent and the Grenadines',
							'Google|www.google.com.sl' => 'Google Salone',
							'Google|www.google.ws' => 'Google Samoa',
							'Google|www.google.sm' => 'Google San Marino',
							'Google|www.google.st' => 'Google São Tomé e Príncipe',
							'Google|www.google.ch' => 'Google Schweiz',
							'Google|www.google.sn' => 'Google Sénégal',
							'Google|www.google.sc' => 'Google Seychelles',
							'Google|www.google.al' => 'Google Shqipëri',
							'Google|www.google.com.sg' => 'Google Singapore',
							'Google|www.google.si' => 'Google Slovenija',
							'Google|www.google.sk' => 'Google Slovensko',
							'Google|www.google.com.sb' => 'Google Solomon Islands',
							'Google|www.google.so' => 'Google Soomaaliya',
							'Google|www.google.co.za' => 'Google South Africa',
							'Google|www.google.lk' => 'Google Sri Lanka',
							'Google|www.google.fi' => 'Google Suomi',
							'Google|www.google.se' => 'Google Sverige',
							'Google|www.google.com.tj' => 'Google Tajikistan',
							'Google|www.google.co.tz' => 'Google Tanzania',
							'Google|www.google.bs' => 'Google The Bahamas',
							'Google|www.google.gm' => 'Google The Gambia',
							'Google|www.google.tl' => 'Google Timor-Leste',
							'Google|www.google.tg' => 'Google Togo',
							'Google|www.google.tk' => 'Google Tokelau',
							'Google|www.google.to' => 'Google Tonga',
							'Google|www.google.tt' => 'Google Trinidad and Tobago',
							'Google|www.google.com.tr' => 'Google Türkiye',
							'Google|www.google.tm' => 'Google Türkmenistan',
							'Google|www.google.co.vi' => 'Google U.S. Virgin Islands',
							'Google|www.google.co.ug' => 'Google Uganda',
							'Google|www.google.co.uk' => 'Google United Kingdom',
							'Google|www.google.com' => 'Google United States',
							'Google|www.google.com.uy' => 'Google Uruguay',
							'Google|www.google.vu' => 'Google Vanuatu',
							'Google|www.google.co.ve' => 'Google Venezuela',
							'Google|www.google.com.vn' => 'Google Việt Nam',
							'Google|www.google.co.zm' => 'Google Zambia',
							'Google|www.google.co.zw' => 'Google Zimbabwe',
							'Google|www.google.gr' => 'Google Ελλάς',
							'Google|www.google.com.cy' => 'Google Κύπρος / Kıbrıs',
							'Google|www.google.com.by' => 'Google Беларусь',
							'Google|www.google.bg' => 'Google България',
							'Google|www.google.kg' => 'Google Кыргызстан',
							'Google|www.google.kz' => 'Google Қазақстан',
							'Google|www.google.mk' => 'Google Македонија',
							'Google|www.google.mn' => 'Google Монгол улс',
							'Google|www.google.ru' => 'Google Россия',
							'Google|www.google.rs' => 'Google Србија',
							'Google|www.google.com.ua' => 'Google Україна',
							'Google|www.google.am' => 'Google Հայաստան',
							'Google|www.google.ge' => 'Google საქართველო',
							'Google|www.google.co.il' => 'Google ישראל',
							'Google|www.google.com.af' => 'Google افغانستان',
							'Google|www.google.jo' => 'Google الأردن',
							'Google|www.google.ae' => 'Google الامارات العربية الم',
							'Google|www.google.com.bh' => 'Google البحرين',
							'Google|www.google.com.sa' => 'Google السعودية',
							'Google|www.google.iq' => 'Google العراق',
							'Google|www.google.com.kw' => 'Google ‫الكويت',
							'Google|www.google.td' => 'Google تشاد',
							'Google|www.google.com.tn' => 'Google تونس',
							'Google|www.google.com.om' => 'Google عُمان',
							'Google|www.google.ps' => 'Google فلسطين',
							'Google|www.google.com.qa' => 'Google قطر',
							'Google|www.google.com.lb' => 'Google لبنان',
							'Google|www.google.com.ly' => 'Google ليبيــا',
							'Google|www.google.com.eg' => 'Google مصر',
							'Google|www.google.com.bd' => 'Google বাংলাদেশ',
							'Google|www.google.co.th' => 'Google ประเทศไทย',
							'Google|www.google.la' => 'Google ລາວ',
							'Google|www.google.com.kh' => 'Google ព្រះរាជាណាចក្រកម្ពុជា',
							'Google|www.google.com.et' => 'Google ኢትዮጵያ',
							'Google|www.google.co.kr' => 'Google 한국',
							'Google|www.google.com.tw' => 'Google 台灣',
							'Google|www.google.co.jp' => 'Google 日本',
							'Google|www.google.com.hk' => 'Google 香港'
						),
						// http://antezeta.com/news/yahoo-search-domains
						'Yahoo' => array(
							'Yahoo|ar.search.yahoo.com|p' => 'Yahoo Argentina',
							'Yahoo|at.search.yahoo.com|p' => 'Yahoo Österreich',
							'Yahoo|au.search.yahoo.com|p' => 'Yahoo Australia',
							'Yahoo|br.search.yahoo.com|p' => 'Yahoo Brasil',
							'Yahoo|ca.search.yahoo.com|p' => 'Yahoo Canada',
							'Yahoo|qc.search.yahoo.com|p' => 'Yahoo Québec',
							'Yahoo|ch.search.yahoo.com|p' => 'Yahoo Schweiz',
							'Yahoo|chfr.search.yahoo.com|p' => 'Yahoo Suisse',
							'Yahoo|chit.search.yahoo.com|p' => 'Yahoo Svizzera',
							'Yahoo|cl.search.yahoo.com|p' => 'Yahoo Chile',
							'Yahoo|cn.search.yahoo.com|q' => 'Yahoo 中国 (cn.search.yahoo.com)',
							'Yahoo|yahoo.cn|q' => 'Yahoo 中国 (yahoo.cn)',
							'Yahoo|co.search.yahoo.com|p' => 'Yahoo Columbia',
							'Yahoo|espanol.search.yahoo.com|p' => 'Yahoo Estados Unidos',
							'Yahoo|search.yahoo.com|p' => 'Yahoo United States',
							'Yahoo|de.search.yahoo.com|p' => 'Yahoo Deutschland',
							'Yahoo|dk.search.yahoo.com|p' => 'Yahoo Danmark',
							'Yahoo|es.search.yahoo.com|p' => 'Yahoo España',
							'Yahoo|fi.search.yahoo.com|p' => 'Yahoo Suomi',
							'Yahoo|fr.search.yahoo.com|p' => 'Yahoo France',
							'Yahoo|gr.search.yahoo.com|p' => 'Yahoo Ελλάς',
							'Yahoo|hk.search.yahoo.com|p' => 'Yahoo 香港',
							'Yahoo|id.search.yahoo.com|p' => 'Yahoo Indonesia',
							'Yahoo|in.search.yahoo.com|p' => 'Yahoo India',
							'Yahoo|it.search.yahoo.com|p' => 'Yahoo Italia',
							'Yahoo|maktoob.search.yahoo.com|p' => 'Yahoo الأردن',
							'Yahoo|search.yahoo.co.jp|p' => 'Yahoo 日本',
							'Yahoo|kr.search.yahoo.com|p' => 'Yahoo Korea',
							'Yahoo|mx.search.yahoo.com|p' => 'Yahoo México',
							'Yahoo|malaysia.search.yahoo.com|p' => 'Yahoo Malaysia',
							'Yahoo|nl.search.yahoo.com|p' => 'Yahoo Nederland',
							'Yahoo|no.search.yahoo.com|p' => 'Yahoo Norge',
							'Yahoo|nz.search.yahoo.com|p' => 'Yahoo New Zealand',
							'Yahoo|pe.search.yahoo.com|p' => 'Yahoo Perú',
							'Yahoo|ph.search.yahoo.com|p' => 'Yahoo Pilipinas',
							'Yahoo|pl.search.yahoo.com|p' => 'Yahoo Polska',
							'Yahoo|ru.search.yahoo.com|p' => 'Yahoo Россия',
							'Yahoo|se.search.yahoo.com|p' => 'Yahoo Sverige',
							'Yahoo|sg.search.yahoo.com|p' => 'Yahoo Singapore',
							'Yahoo|th.search.yahoo.com|p' => 'Yahoo ประเทศไทย',
							'Yahoo|tr.search.yahoo.com|p' => 'Yahoo Türkiye',
							'Yahoo|tw.search.yahoo.com|p' => 'Yahoo 台灣',
							'Yahoo|uk.search.yahoo.com|p' => 'Yahoo UK & Ireland',
							'Yahoo|ve.search.yahoo.com|p' => 'Yahoo Venezuela',
							'Yahoo|vn.search.yahoo.com|p' => 'Yahoo Việt Nam',
							'Yahoo|za.search.yahoo.com|p' => 'Yahoo South Africa'
						)
					)
				)
			);
		?>
		<em><?php echo __d('seo_tools', 'This may take a few minutes, please be patient and wait.'); ?></em><br />
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
	<div class="report" id="top10_report">
		<fieldset>
			<legend id="report_overview"><?php echo __d('seo_tools', 'Report overview'); ?></legend>
			<em><?php echo __d('seo_tools', 'This report helps you to optimize the web page "<b>%s</b>" for a high ranking on <b>%s</b> for the search term "<b>%s</b>".', $this->data['Tool']['url'], $this->data['Tool']['engine']['class'], $this->data['Tool']['criteria']); ?></em>

			<!-- your site overview -->
			<div class="web-snippet">
				<img src="http://immediatenet.com/t/l?Size=1280x768&URL=<?php echo $this->data['Tool']['url']; ?>" class="web-tn" />
				<a href="<?php echo $results['site_data']['url']; ?>" target="_blank" class="title"><?php echo $results['site_data']['title']; ?></a><br />
				<a href="<?php echo $results['site_data']['url']; ?>" target="_blank" class="url"><?php echo String::truncate("http://{$results['site_data']['url']}", 80); ?></a>
				<p class="description"><?php echo isset($results['site_data']['meta_tags']['description']) ? $results['site_data']['meta_tags']['description'] : __d('seo_tools', '[No meta description available.]'); ?></p>
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
			<?php foreach($results['competitors_data'] as $i => $competitor): ?>
				<div class="web-snippet">
					<span class="rank">#<?php echo $i + 1; ?></span>
					<img src="http://immediatenet.com/t/l?Size=1280x768&URL=<?php echo $competitor['url']; ?>" class="web-tn" />
					<a href="<?php echo $competitor['url']; ?>" target="_blank" class="title"><?php echo $competitor['title']; ?></a><br />
					<a href="<?php echo $competitor['url']; ?>" target="_blank" class="url"><?php echo String::truncate($competitor['url'], 80); ?></a>
					<p class="description"><?php echo isset($competitor['meta_tags']['description']) ? $competitor['meta_tags']['description'] : __d('seo_tools', '[No meta description available.]'); ?></p>
				</div>
			<?php endforeach; ?>

			<div id="chart">
				<?php echo $this->element('CompetitorCompare/report_charts'); ?>
			</div>

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

		<?php echo $this->element('CompetitorCompare/keyword_use_in_document_title', array('data' => $results['keyword_use_in_document_title'])); ?>
		<?php echo $this->element('CompetitorCompare/global_link_popularity_of_web_site', array('data' => $results['global_link_popularity_of_web_site'])); ?>
		<?php echo $this->element('CompetitorCompare/keyword_use_in_body_text', array('data' => $results['keyword_use_in_body_text'])); ?>
		<?php echo $this->element('CompetitorCompare/age_of_web_site', array('data' => $results['age_of_web_site'])); ?>
		<?php echo $this->element('CompetitorCompare/keyword_use_in_h1_headline_texts', array('data' => $results['keyword_use_in_h1_headline_texts'])); ?>
		<?php echo $this->element('CompetitorCompare/keyword_use_in_page_url', array('data' => $results['keyword_use_in_page_url'])); ?>
		<?php echo $this->element('CompetitorCompare/number_of_visitors_to_the_site', array('data' => $results['number_of_visitors_to_the_site'])); ?>
		<?php echo $this->element('CompetitorCompare/keyword_use_in_meta_description', array('data' => $results['keyword_use_in_meta_description'])); ?>
		<?php echo $this->element('CompetitorCompare/factors_that_could_prevent_your_top_ranking'); ?>
	</div>

	<script>
		$(document).ready(function () {
			setInterval(function() { 
				$('img.web-tn').each(function () {
					$(this).attr('src', $(this).attr('src'));
				});
			}, 10000);
		});
	</script>
<?php endif; ?>