<?php echo $this->Form->create('Module'); ?>
    <?php echo $this->Html->useTag('fieldsetstart', __d('seo_tools', 'Site Settings')); ?>
		<?php
			echo $this->Form->input('Module.settings.canonical_domain',
				array(
					'type' => 'radio',
					'legend' => __d('seo_tools', 'Preferrer domain'),
					'options' => array(
						'www' => 'WWW',
						'non-www' => 'NON-WWW',
						'' => 'Ignore'
					),
					'helpBlock' => __d('seo_tools', "The preferred domain is the one that you would liked used to index your site's pages.")
				)
			);
		?>

		<?php echo $this->Html->useTag('fieldsetstart', __d('seo_tools', 'Sitewide <code>meta</code> settings')); ?>
			<?php
				echo $this->Form->input('Module.settings.use_meta_keywords',
					array(
						'type' => 'checkbox',
						'label' => __d('seo_tools', 'Use meta keywords tag?'),
						'helpBlock' => __d('seo_tools', "I don't know why you'd want to use meta keywords, but if you want to, check this box.")
					)
				);
	
				echo $this->Form->input('Module.settings.noodp',
					array(
						'type' => 'checkbox',
						'label' => __d('seo_tools', 'Add <code>noodp</code> meta robots tag sitewide'),
						'helpBlock' => __d('seo_tools', 'Prevents search engines from using the DMOZ description for pages from this site in the search results.')
					)
				);

				echo $this->Form->input('Module.settings.noydir',
					array(
						'type' => 'checkbox',
						'label' => __d('seo_tools', 'Add <code>noydir</code> meta robots tag sitewide'),
						'helpBlock' => __d('seo_tools', 'Prevents search engines from using the Yahoo! directory description for pages from this site in the search results.')
					)
				);
			?>
		<?php echo $this->Html->useTag('fieldsetend'); ?>

		<?php echo $this->Html->useTag('fieldsetstart', __d('seo_tools', 'Development & Tracking')); ?>
			<?php
				echo $this->Form->input('Module.settings.google_analytics',
					array(
						'type' => 'textarea',
						'label' => __d('seo_tools', '<a href="" target="_blank">Google Analytics Tracking Code</a>', 'http://www.google.com/analytics/'),
						'helpBlock' => __d('seo_tools', 'Copy & Paste your Google Analytics tracking code here, it will be used on every page of your site.')
					)
				);

				echo $this->Form->input('Module.settings.site_robots',
					array(
						'type' => 'textarea',
						'label' => __d('seo_tools', '<a href="%s" target="_blank">Site robots.txt</a>', 'https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt'),
						'helpBlock' => __d('seo_tools', "Type in your site's robot.txt file.")
					)
				);
			?>
			<hr />
			<?php
				echo $this->Form->input('Module.settings.google_meta',
					array(
						'type' => 'text',
						'label' => __d('seo_tools', '<a href="%s" target="_blank">Google Webmaster Tools:</a>', 'https://www.google.com/webmasters/tools/dashboard?hl=en&siteUrl=' . Router::url('/', true)),
						'helpBlock' => __d('seo_tools', 'Verify your site on <b>Google Webmaster Tools</b>, if your site is already verified, you can just forget about this.')
					)
				);

				echo $this->Form->input('Module.settings.bing_meta',
					array(
						'type' => 'text',
						'label' => __d('seo_tools', '<a href="%s" target="_blank">Microsoft Bing Webmaster Tools:</a>', 'http://www.bing.com/webmaster/?rfp=1#/Dashboard/?url=' . Router::url('/', true)),
						'helpBlock' => __d('seo_tools', 'Verify your site on <b>Bing Webmaster Tools</b>, if your site is already verified, you can just forget about this.')
					)
				);

				echo $this->Form->input('Module.settings.alexa_meta',
					array(
						'type' => 'text',
						'label' => __d('seo_tools', '<a href="%s" target="_blank">Alexa Verification ID:</a>', 'http://www.alexa.com/pro/subscription'),
						'helpBlock' => __d('seo_tools', 'Verify your site on <b>Alexa Webmaster Tools</b>, if your site is already verified, you can just forget about this.')
					)
				);
			?>
		<?php echo $this->Html->useTag('fieldsetend'); ?>
    <?php echo $this->Html->useTag('fieldsetend'); ?>

    <?php echo $this->Form->input(__d('seo_tools', 'Save'), array('type' => 'submit')); ?>
<?php echo $this->Form->end(); ?>