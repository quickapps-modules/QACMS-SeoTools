<fieldset>
	<legend id="factors_that_could_prevent_your_top_ranking"><?php echo __d('seo_tools', 'Factors that could prevent your top ranking'); ?></legend>
	<em><?php echo __d('seo_tools', 'Some ranking factors cannot be measured because the search engines do not reveal the necessary data, or it would be extremely time-consuming to measure the data. Make sure you pay attention to the following factors because they could prevent a top ranking for <b>%s</b> on <b>%s</b>.', $this->data['Tool']['url'], $this->data['Tool']['engine']); ?></em>

	<hr />

	<h2><?php echo __d('seo_tools', 'Advice'); ?></h2>

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