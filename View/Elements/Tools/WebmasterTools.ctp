<?php echo $this->Form->create('Tool'); ?>
	<?php
		echo $this->Form->input('google_meta',
			array(
				'type' => 'text',
				'label' => __d('seo_tools', '<a href="%s" target="_blank">Google Webmaster Tools:</a>', 'https://www.google.com/webmasters/tools/dashboard?hl=en&siteUrl=' . Router::url('/', true)),
				'value' => Configure::read('Modules.SeoTools.settings.google_meta')
			)
		);

		echo $this->Form->input('bing_meta',
			array(
				'type' => 'text',
				'label' => __d('seo_tools', '<a href="%s" target="_blank">Microsoft Bing Webmaster Tools:</a>', 'http://www.bing.com/webmaster/?rfp=1#/Dashboard/?url=localhost/wp'),
				'value' => Configure::read('Modules.SeoTools.settings.bing_meta')
			)
		);

		echo $this->Form->input('alexa_meta',
			array(
				'type' => 'text',
				'label' => __d('seo_tools', '<a href="%s" target="_blank">Alexa Verification ID:</a>', 'http://www.alexa.com/pro/subscription'),
				'value' => Configure::read('Modules.SeoTools.settings.alexa_meta')
			)
		);
	?>
<?php echo $this->Form->end(__d('seo_tools', 'Save')); ?>