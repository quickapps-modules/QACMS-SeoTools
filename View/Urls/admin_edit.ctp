<?php echo $this->Form->create('SeoUrl'); ?>
    <?php echo $this->Html->useTag('fieldsetstart', __d('seo_tools', 'Editing URL')); ?>
        <?php echo $this->Form->input('SeoUrl.id'); ?>

		<div class="snippet-container">
			<?php echo __d('seo_tools', 'Snippet Preview'); ?>:
			<br/>
			<div id="preview-snippet">
				<a href="#" class="title"></a>
				<br />
				<a href="#" class="url"><?php echo $base_url; ?><span class="url"></span></a>
				<p class="description"></p>
			</div>
		</div>		

		<div style="float:left; clear:left; width:100%;">
			<?php echo $this->Form->input('SeoUrl.status', array('type' => 'checkbox', 'label' => __d('seo_tools', 'Optimization Active'))); ?>
			<?php
				echo $this->Form->input('SeoUrl.url',
					array(
						'between' => $base_url,
						'type' => 'text',
						'label' => 'URL *',
						'readonly' => 'readonly',
						'helpBlock' => __d('seo_tools', "The URL to optimize. The URL <code>/</code> represent your site's frontpage.")
					)
				);

				echo $this->Form->input('RedirectToggler',
					array(
						'id' => 'RedirectToggler',
						'type' => 'checkbox',
						'checked' => false,
						'label' => __d('seo_tools', '301 Redirect')
					)
				);
			?>

			<div class="redirect-url-input" style="display:none;">
				<?php
					echo $this->Form->input('SeoUrl.redirect',
						array(
							'type' => 'text',
							'label' => false,
							'placeholder' => 'http://www.example.com/',
							'helpBlock' => __d('seo_tools', 'The URL that this page should redirect to.')
						)
					);
				?>
			</div>

			<div class="nonredirect">
				<?php
					echo $this->Form->input('SeoUrl.title',
						array(
							'type' => 'text',
							'class' => 'input-xxlarge',
							'label' => __d('seo_tools', 'Page title'),
							'helpBlock' => __d('seo_tools', 'Title display in search engines is limited to 70 chars, <span class="title-chars-left">70</span> chars left.')
						)
					);

					echo $this->Form->input('SeoUrl.description',
						array(
							'type' => 'textarea',
							'label' => __d('seo_tools', 'Description'),
							'helpBlock' => __d('seo_tools', 'The <code>meta</code> description will be limited to 156 chars, <span class="desc-chars-left">156</span> chars left. If not given, your <a href="%s">site description</a> wil be used by default.', Router::url('/admin/system/configuration'))
						)
					);

					echo $this->Form->input('SeoUrl.keywords',
						array(
							'type' => 'text',
							'class' => 'input-xxlarge',
							'label' => __d('seo_tools', 'Keywords'),
							'helpBlock' => __d('seo_tools', 'Pick the main keyword or keyphrase that this page is about.')
						)
					);

					echo $this->Form->input('SeoUrl.header',
						array(
							'type' => 'textarea',
							'label' => __d('seo_tools', 'Header Code'),
							'helpBlock' => __d('seo_tools', 'Additional code to add right before <code>&lt;/header&gt;</code> tag.')
						)
					);

					echo $this->Form->input('SeoUrl.footer',
						array(
							'type' => 'textarea',
							'label' => __d('seo_tools', 'Footer Code'),
							'helpBlock' => __d('seo_tools', 'Additional code to add right before <code>&lt;/body&gt;</code> tag.')
						)
					);
				?>
			</div>
		</div>
    <?php echo $this->Html->useTag('fieldsetend'); ?>

    <?php echo $this->Form->input(__d('seo_tools', 'Save url'), array('type' => 'submit')); ?>
<?php echo $this->Form->end(); ?>