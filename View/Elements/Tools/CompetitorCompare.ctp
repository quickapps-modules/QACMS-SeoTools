<?php if (!isset($results)): ?>

<form action="" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td align="left" valign="top"><b><?php echo __t('Enter Your URL'); ?>:</b></td>
        </tr>

        <tr>
            <td align="left" valign="top"><input type="text" name="data[Tool][url]" value="<?php echo Configure::read('ModSeo.Config.seo_site_url'); ?>" class="text" style="width:100%;" /></td>
        </tr>

        <tr>
            <td align="left" valign="top"><b><?php echo __t('Criteria'); ?>:</b></td>
        </tr>

        <tr>
            <td align="left" valign="top"><input type="text" name="data[Tool][criteria]" value="" class="text" style="width:100%;" /></td>
        </tr>

        <tr>
            <td align="left" valign="top"><b><?php echo __t('Seach Engine'); ?>:</b></td>
        </tr>

        <tr>
            <td align="left" valign="top">
                <select name="data[Tool][engine]" id="select">
                    <option value="google.com" selected="selected">Google.com</option>
                    <option value="google.es">Google.es</option>
                    <option value="google.as">Google.as</option>
                    <option value="google.at">Google.at</option>
                    <option value="google.be">Google.be</option>
                    <option value="google.ca">Google.ca</option>
                    <option value="google.ch">Google.ch</option>
                    <option value="google.cl">Google.cl</option>
                    <option value="google.co.cr">Google.co.cr</option>
                    <option value="google.co.il">Google.co.il</option>
                    <option value="google.con.in">Google.co.in</option>
                    <option value="google.co.jp">Google.co.jp</option>
                    <option value="google.co.kr">Google.co.kr</option>
                    <option value="google.co.nz">Google.co.nz</option>
                    <option value="google.co.th">Google.co.th</option>
                    <option value="google.co.uk">Google.co.uk</option>
                    <option value="google.co.ve">Google.co.ve</option>
                    <option value="google.co.za">Google.co.za</option>
                    <option value="google.com.ar">Google.com.ar</option>
                    <option value="google.com.au">Google.com.au</option>
                    <option value="google.com.br">Google.com.br</option>
                    <option value="google.com.co">Google.com.co</option>
                    <option value="google.com.gr">Google.com.gr</option>
                    <option value="google.com.hk">Google.com.hk</option>
                    <option value="google.com.mx">Google.com.mx</option>
                    <option value="google.com.my">Google.com.my</option>
                    <option value="google.com.pe">Google.com.pe</option>
                    <option value="google.com.ph">Google.com.ph</option>
                    <option value="google.com.sg">Google.com.sg</option>
                    <option value="google.com.tr">Google.com.tr</option>
                    <!--<option value="yahoo.com">Yahoo.com</option>-->
                </select>
            </td>
        </tr>

        <tr>
            <td align="left" valign="top">
                <input type="submit" value="<?php echo __t('Continue'); ?>" class="primary_lg" />
            </td>
        </tr>
    </table>
</form>

<?php else: ?>

<script type="text/javascript" src="http://www.websnapr.com/js/websnapr.js"></script>
<div class="report" id="top10_report">
    <?php 
        $keywords = Set::extract('Analysis.title', $results); 
        $keywords = array_keys($keywords); 
    ?>

    <fieldset>
        <legend id="report_overview"><?php echo __t('Report overview'); ?></legend>
        <em><?php echo __t('This report helps you to optimize the web page "<b>http://%s/</b>" for a high ranking on <b>%s</b> for the search term "<b>%s</b>".', $this->data['Tool']['url'], $this->data['Tool']['engine'], $this->data['Tool']['criteria']); ?></em>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                  <td colspan="2" align="left" valign="top"><b><?php echo __t('Your Web Page'); ?></b></td>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td align="center" valign="middle" width="10%">
                        <script type="text/javascript">wsr_snapshot('<?php echo $this->data['Tool']['url']; ?>', '<?php echo Configure::read('Modules.SeoTools.settings.websnapr_key'); ?>', 't');</script>
                    </td>
                    <td align="left" valign="top" width="90%">
                        <a href="http://<?php $this->data['Tool']['url']; ?>" target="_blank"><?php echo $this->data['Tool']['url']; ?></a><br/><br/>
                        <b><?php echo __t('Title'); ?>:</b> <?php echo $results['Data']['Site']['title']; ?><br/><br/>
                        <b><?php echo __t('Description'); ?>: </b> <?php echo isset($results['Data']['Site']['tags']['description']) ? $results['Data']['Site']['tags']['description'] : __t('[No meta description available.]'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <td colspan="3" align="left" valign="top"><b><?php __t('Your competitors for the search term "%s" on %s', $this->data['Tool']['criteria'], $this->data['Tool']['engine']); ?></b></td>
                </tr>
            </thead>
            
            <tbody>
                <?php 
                    $i = 0;

                    foreach($results['Data']['Competitors'] as $competitor) {
                        $i++;
                 ?>
                    <tr>
                        <td align="center" valign="middle" width="3%"><b><?php echo $i; ?></b></td>
                        <td align="center" valign="middle" width="10%">
                            <script type="text/javascript">wsr_snapshot('<?php echo $competitor['url']; ?>', '<?php echo Configure::read('Modules.SeoTools.settings.websnaper_key'); ?>', 't');</script>
                        </td>
                        <td align="left" valign="top" width="87%">
                            <a href="<?php echo $competitor['url']; ?>" target="_blank"><?php echo $competitor['url']; ?></a><br/><br/>
                            <b><?php echo __t('Title'); ?>:</b> <?php echo $competitor['title']; ?><br/><br/>
                            <b><?php echo __t('Description'); ?>: </b> <?php echo isset($competitor['tags']['description']) ? $competitor['tags']['description'] : __t('[No meta description available.]'); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>    

        <div id="chart"><!-- RESULTS --></div>

        <table width="100%" border="0" cellspacing="0" cellpadding="0"><!-- table of contents -->
            <thead>
                <tr>
                  <td colspan="2" align="left" valign="top"><b><?php echo __t('Table of contents'); ?></b></td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td width="33%" height="20" align="left">1. <a href="#report_overview"><?php echo __t('Report overview'); ?></a></td>
                    <td width="33%" height="20" align="left">6. <a href="#aspect_h1"><?php echo __t('Keyword use in H1 headline texts'); ?></a></td>
                </tr>

                <tr>
                    <td align="left" valign="middle">2. <a href="#aspect_title"><?php echo __t('Keyword use in document title'); ?></a></td>
                    <td align="left" valign="middle">7. <a href="#aspect_url"><?php echo __t('Keyword use in page URL'); ?></a></td>
                </tr>

                <tr>
                    <td align="left" valign="middle">3. <a href="#aspect_backlinks"><?php echo __t('Global link popularity of web site'); ?></a></td>
                    <td align="left" valign="middle">8. <a href="#aspect_alexa_rank"><?php echo __t('Number of visitors to the site'); ?></a></td>
                </tr>

                <tr>
                    <td align="left" valign="middle">4. <a href="#aspect_body"><?php echo __t('Keyword use in body text'); ?></a></td>
                    <td align="left" valign="middle">9. <a href="#report_tags/description"><?php echo __t('Keyword use in meta description'); ?></a></td>
                </tr>

                <tr>
                    <td align="left" valign="middle">5. <a href="#aspect_age"><?php echo __t('Age of web site'); ?></a></td>
                    <td align="left" valign="middle">10. <a href="#other_factors"><?php echo __t('Factors that could prevent your top ranking'); ?></a></td>
                </tr>
            </tbody>
        </table>
    </fieldset>

<?php 
    $titles = array(
        'title' => array(
            'title' => __t('Keyword use in document title'), 
            'importance' => __t('Essential'), 
            'info' => __t("The document title is the text within the &lt;title&gt;...&lt;/title&gt; tags in the HTML code of your web page. This chapter tries to find out how to use the search term '%s' in the document title and if it's important for %s", $this->data['Tool']['url'],    $this->data['Tool']['engine'])
        ),
        'body' => array(
            'title' => __t('Keyword use in body text'), 
            'importance' => __t('Essential'), 
            'info' => __t('The body text is the text on your web page that can be seen by people in their web browsers. It does not include HTML commands, comments, etc. The more visible text there is on a web page, the more a search engine can index. The calculations include spaces and punctuation marks')
        ),
        'backlinks' => array(
            'title' => __t('Global link popularity of web site'), 
            'importance' => __t('Essential'), 
            'info' => __t('The global link popularity measures how many web pages link to your site. The number of web pages linking to your site is not as important as the quality of the web pages that link to your site')
        ),
        'h1' => array(
            'title' => __t('Keyword use in H1 headline texts'), 
            'importance' => __t('Very Important'), 
            'info' => __t('H1 headline texts are the texts that are written between the &lt;h1&gt;...&lt;/h1&gt; tags in the HTML code of a web page. Some search engines give extra relevance to search terms that appear in the headline texts')
        ),
        'age' => array(
            'title' => __t('Age of web site'), 
            'importance' => __t('Very Important'), 
            'info' => __t('Spam sites often come and go quickly. For this reason, search engines tend to trust a web site that has been around for a long time over one that is brand new. The age of the domain is seen as a sign of trustworthiness because it cannot be faked. The data is provided by Alexa.com')
        ),
        'alexa_rank' => array(
            'title' => __t('Number of visitors to the site'), 
            'importance' => __t('Important'), 
            'info' => __t('Search engines might look at web site usage data, such as the number of visitors to your site, to determine if your site is reputable and contains popular contents. The Alexa.com traffic rank is based on three months of aggregated traffic data from millions of Alexa Toolbar users and is a combined measure of page views and number of site visitors')
        ),
        'url' => array(
            'title' => __t('Keyword use in page URL'), 
            'importance' => __t('Important'), 
            'info' => __t('The page URL is the part after the domain name in the web page address. This chapter tries to find out if Google.es  (la Web) gives extra relevance to search terms within the page URL. Separate your search terms in the page URL with slashes, dashes or underscores')
        ),
        'tags/description' => array(
            'title' => __t('Keyword use in meta description'), 
            'importance' => __t('Important'), 
            'info' => __t('The Meta Description tag allows you to describe your web page. This chapter tries to find out if %s takes the Meta Description tag into account. Some search engines display the text to the user in the search results.<br/> Example: &lt;meta name="description" content= "This sentence describes the contents of your web site."&gt;<br/> Even if the Meta Description tag might not be important for ranking purposes, you should use the Meta Description tag to make sure that your web site is displayed with an attractive description in the search results', $this->data['Tool']['engine'])
        )
    );

    foreach ($results['Analysis'] as $aspect => $data): ?>
    <fieldset>
        <legend id="aspect_<?php echo $aspect; ?>">
            <?php echo $titles[$aspect]['title']; ?><br/>
            <em><?php echo $titles[$aspect]['importance']; ?></em>
        </legend>
        <em><?php echo $titles[$aspect]['info']; ?></em>
        
        <?php 
            // 'pagerank', 'backlinks', 'alexa_rank', 'dmoz_directory', 'yahoo_directory', 'age'
            if (in_array($aspect, array('backlinks', 'alexa_rank', 'age'))) {
                echo $this->element('competitor_compare/' . $aspect, compact('aspect', 'titles', 'results', 'data'));

            } else {
                if ($aspect != 'h1') {
                    echo $this->element('competitor_compare/h1', compact('aspect', 'titles', 'results', 'data', 'keywords')); 
                }
        ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                  <td align="left" valign="top" colspan="3"><b><?php echo __t('Your Content'); ?></b></td>
                </tr>
            </thead>

            <?php if ($aspect != 'h1') { ?>
                <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">
                        <?php 
                            $your_content = Set::extract("/{$aspect}", $results['Data']['Site']);

                            echo !empty($your_content[0]) ? $this->CC->emphasize_keywords($your_content[0], $keywords) : __t('Content not found');
                        ?>
                        </td>
                    </tr>
                    <?php if ($aspect == 'body'): ?>
                    <tr>
                        <td width="21%" align="left" valign="top">&nbsp;</td>
                        <td width="46%" align="left" valign="top"><b><?php echo __t('Competitors'); ?></b></td>
                        <td width="33%" align="left" valign="top"><b><?php echo __t('Your Site'); ?></b></td>
                    </tr>
                    <?php 
                        $competitor_wc = Set::extract('Analysis.body.{s}.competitors.words_count', $results);
                        $site_wc = Set::extract('Analysis.body.{s}.site.words_count', $results);
                    ?>
                    <tr class="advice_color_<?php echo $this->CC->advice_color($competitor_wc[0], $site_wc[0], $aspect); ?>">
                        <td align="left" valign="top"><?php echo __t('Number of words'); ?></td>
                        <td align="left" valign="top"><?php echo $this->CC->competitor_average($competitor_wc[0]); ?></td>
                        <td align="left" valign="top"><?php echo $site_wc[0]; ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            <?php } else { #H1 SITE LISTING ?> 
                <tbody>
                    <tr>
                        <td width="3%" align="left" valign="top"><b><?php echo __t('No.'); ?></b></td>
                        <td width="97%" align="left" valign="top" colspan="2"><b><?php echo __t('H1 Heading Text'); ?></b></td>
                    </tr>
                    
                    <?php 
                        $i=0; 
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
                      <td colspan="3" align="left" valign="top"><b><?php echo __t('Search Term'); ?>: "<?php echo $keyword; ?>"</b></td>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td width="21%" align="left" valign="top">&nbsp;</td>
                        <td width="40%" align="left" valign="top"><b><?php echo __t('Competitors'); ?></b></td>
                        <td width="39%" align="left" valign="top"><b><?php echo __t('Your Site'); ?></b></td>
                    </tr>
                    <tr class="advice_color_<?php echo $this->CC->advice_color($analysis['competitors']['quantity'], $analysis['site']['quantity'], $aspect); ?>">
                        <td align="left" valign="top"><?php echo __t('Quantity'); ?></td>
                        <td align="left" valign="top"><?php echo $this->CC->competitor_average($analysis['competitors']['quantity']); ?></td>
                        <td align="left" valign="top"><?php echo $analysis['site']['quantity']; ?></td>
                    </tr>
                    <tr class="advice_color_<?php echo $this->CC->advice_color($analysis['competitors']['density'], $analysis['site']['density'], $aspect); ?>">
                        <td align="left" valign="top"><?php echo __t('Density'); ?></td>
                        <td align="left" valign="top"><?php echo $this->CC->competitor_average($analysis['competitors']['density'], 'percent'); ?></td>
                        <td align="left" valign="top"><?php echo $analysis['site']['density']; ?>%</td>
                    </tr>

                    <?php if ($aspect != 'h1') { ?>
                    <tr class="advice_color_<?php echo $this->CC->advice_color($analysis['competitors']['position'], $analysis['site']['position'], $aspect); ?>">
                        <td align="left" valign="top"><?php echo __t('Position'); ?></td>
                        <td align="left" valign="top"><?php echo $this->CC->competitor_average($analysis['competitors']['position']); ?></td>
                        <td align="left" valign="top"><?php echo $analysis['site']['position']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        <?php } ?>
    </fieldset>
<?php endforeach; ?>

    <fieldset>
        <legend id="aspect_other_factors"><?php echo __t('Factors that could prevent your top ranking'); ?></legend>
        <em><?php echo __t('Some ranking factors cannot be measured because the search engines do not reveal the necessary data, or it would be extremely time-consuming to measure the data. Make sure you pay attention to the following factors because they could prevent a top ranking for <b>%s</b> on <b>%s</b>.', $this->data['Tool']['url'], $this->data['Tool']['engine']); ?></em>
        <h1><?php echo __t('Advice'); ?></h1>

        <p class="questions">
            <b><?php echo __t('Ibound links to your web page'); ?></b><br/>

            <font><?php echo __t('Are the web pages linking to your web page relevant to the search term "%s"?', $this->data['Tool']['criteria']); ?></font><br/>
            <font><?php echo __t('How fast does your web page get new links pointing to it?'); ?></font><br/>
            <font><?php echo __t('Do the web sites which link to your page belong to the same content category?'); ?></font><br/>
            <font><?php echo __t('Since when do the links to your page exist?'); ?></font><br/>
            <font><?php echo __t('Is the text surrounding the link to your page relevant to the search term "%s"?', $this->data['Tool']['criteria']); ?></font>
        </p>

        <p class="questions">
            <b><?php echo __t('Your web page'); ?></b><br/>

            <font><?php echo __t('How many important links from your other pages point to your web page?'); ?></font><br/>
            <font><?php echo __t('Do the links on your web page point to high quality, topically-related pages?'); ?></font><br/>
            <font><?php echo __t('How often and how many changes do you make to your web page over time? Is your content up-to-date?'); ?></font><br/>
            <font><?php echo __t('How often and how many web pages do you add to your web site?'); ?></font><br/>
            <font><?php echo __t('How long do your visitors spend time on your web page?'); ?></font>
        </p>

        <p class="questions">
            <b><?php echo __t('Search engine result page'); ?></b><br/>

            <font><?php echo __t('Do your competitors on the search engine result page get a manual ranking boost by %s, for example Amazon or Wikipedia?', $this->data['Tool']['engine']); ?></font><br/>
            <font><?php echo __t('How many visitors of the search engine result pages click through to your page?'); ?></font><br/>
            <font><?php echo __t('How often do search engine visitors search for your company name or web page URL on %s?', $this->data['Tool']['engine']); ?></font>
        </p>

        <p class="questions">
            <b><?php echo __t('Negative ranking factors (you should be able to say "no" to all the following questions)'); ?></b><br/>

            <font><?php echo __t('Is your content very similar or a duplicate of existing content?'); ?></font><br/>
            <font><?php echo __t('Is your server often down when search engine crawlers try to access it?'); ?></font><br/>
            <font><?php echo __t('Do you link to web sites that do not deserve a link?'); ?></font><br/>
            <font><?php echo __t('Do you use the same title or meta tags for many web pages?'); ?></font><br/>
            <font><?php echo __t('Do you overuse the same keyword or key phrase?'); ?></font><br/>
            <font><?php echo __t('Do you participate in link schemes?'); ?></font><br/>
            <font><?php echo __t('Do you actively sell links on your web page?'); ?></font><br/>
            <font><?php echo __t('Do a majority of your inbound links come from low quality or spam sites?'); ?></font><br/>
            <font><?php echo __t('Does your web page have any spelling or grammar mistakes?'); ?></font>
        </p>
    </fieldset>
</div>

<div id="chart_results" style="display:none;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0"><!-- chart -->
        <thead>
            <tr>
                <td colspan="4" align="left" valign="top"><b><?php echo __t('Search engine ranking factors performance'); ?></b></td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td width="29%" rowspan="4" align="center" valign="middle">
                    <img src="http://chart.apis.google.com/chart?cht=p3&chs=250x250&chd=t:<?php echo $this->CC->green; ?>,<?php echo $this->CC->red; ?>&chdl=<?php urlencode(__t('Passed factors')); ?>|<?php urldecode(__t('Failed factors')); ?>&chco=99CC00,EA4D5C&noCache=<?php echo rand(0,9999); ?>" width="250" height="250" />
                </td>
                <td width="42%" height="20" align="right"><b><?php echo __t('Ranking Factor Importance'); ?></b></td>
                <td width="17%" height="20" align="center"><b><?php echo __t('Factors Passed'); ?></b></td>
                <td width="12%" height="20" align="center"><b><?php echo __t('Factors Failed'); ?></b></td>
            </tr>

            <tr>
                <td align="right" valign="middle"><?php echo __t('Essential'); ?></td>
                <td align="center" valign="middle"><?php echo $this->CC->essential_passed; ?></td>
                <td align="center" valign="middle"><?php echo $this->CC->essential_failed; ?></td>
            </tr>

            <tr>
                <td align="right" valign="middle"><?php echo __t('Very Important'); ?></td>
                <td align="center" valign="middle"><?php echo $this->CC->very_important_passed; ?></td>
                <td align="center" valign="middle"><?php echo $this->CC->very_important_failed; ?></td>
            </tr>

            <tr>
                <td align="right" valign="middle"><?php echo __t('Important'); ?></td>
                <td align="center" valign="middle"><?php echo $this->CC->important_passed; ?></td>
                <td align="center" valign="middle"><?php echo $this->CC->important_failed; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        $('div#chart').html($('div#chart_results').html());
    });
</script>
<?php endif; ?>