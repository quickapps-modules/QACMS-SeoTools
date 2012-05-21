<table width="100%" border="0" cellspacing="0" cellpadding="0"><!-- alexa rank -->
    <thead>
        <tr>
          <td colspan="5" align="left" valign="top"><b><?php echo __d('seo_tools', 'Number of inbound links according to these search engines (the more the better)'); ?></b></td>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td width="10%" height="20" align="center">&nbsp;</td>
            <td width="23%" height="20" align="left"><b><?php echo __d('seo_tools', 'Alexa'); ?></b></td>
            <td width="23%" height="20" align="left"><b><?php echo __d('seo_tools', 'Google.com'); ?></b></td>
            <td width="23%" align="left"><b><?php echo __d('seo_tools', 'Yahoo.com'); ?></b></td>
            <td width="21%" align="left"><b><?php echo __d('seo_tools', 'Peak Value'); ?></b></td>
        </tr>

        <tr>
            <td align="center" valign="middle"><?php echo __d('seo_tools', 'Your Site'); ?></td>
            <td align="right" valign="middle"><?php echo $results['Data']['Site']['backlinks']['alexa']; ?></td>
            <td align="right" valign="middle"><?php echo $results['Data']['Site']['backlinks']['google']; ?></td>
            <td align="right" valign="middle"><?php echo $results['Data']['Site']['backlinks']['yahoo']; ?></td>
            <td align="right" valign="middle">
            <?php
                $s_peak = max(
                    array(
                        $this->CC->__str2int($results['Data']['Site']['backlinks']['alexa']),
                        $this->CC->__str2int($results['Data']['Site']['backlinks']['google']),
                        $this->CC->__str2int($results['Data']['Site']['backlinks']['yahoo'])
                    )
                );
                echo number_format($s_peak);
                $peaks = array();
            ?>
            </td>
        </tr>

        <?php foreach($results['Data']['Competitors'] as $index => $competitor){ ?>
        <tr>
            <td align="center" valign="middle"><?php echo __d('seo_tools', 'Top Site'); ?> <?php echo $index+1; ?></td>
            <td align="right" valign="middle"><?php echo $competitor['backlinks']['alexa']; ?></td>
            <td align="right" valign="middle"><?php echo $competitor['backlinks']['google']; ?></td>
            <td align="right" valign="middle"><?php echo $competitor['backlinks']['yahoo']; ?></td>
            <td align="right" valign="middle">
            <?php
                $peak = max(
                    array(
                        $competitor['backlinks']['alexa'],
                        $competitor['backlinks']['google'],
                        $competitor['backlinks']['yahoo']
                    )
                );
                $peaks[] = $peak;
                echo $peak;
            ?>
            </td>
        </tr>
        <?php } ?>

        <tr>
            <td align="center" valign="middle"><?php echo __d('seo_tools', 'Range'); ?></td>
            <td align="right" valign="middle"><?php echo $this->CC->competitor_average($results['Analysis']['backlinks']['alexa']); ?></td>
            <td align="right" valign="middle"><?php echo $this->CC->competitor_average($results['Analysis']['backlinks']['google']); ?></td>
            <td align="right" valign="middle"><?php echo $this->CC->competitor_average($results['Analysis']['backlinks']['yahoo']); ?></td>
            <td align="right" valign="middle"><?php echo $this->CC->competitor_average($peaks); ?></td>
        </tr>

        <tr class="advice_color_<?php echo $color = $this->CC->advice_color($peaks, $s_peak, $aspect);  ?>">
            <td align="left" valign="left" colspan="5">
                <?php
                    switch($color){
                        default: case 0:
                            $msg = __d('seo_tools', 'In average, less web pages link to your page than to the top ranked pages. The average link popularity of the top ranked pages is %s, the link popularity of your web page is %s. You must increase the number of web pages from different domains that link to your web site. Keep in mind that all search engines also evaluate the link texts and the quality of the web pages that link to your web site');
                            $msg = sprintf($msg, $this->CC->tmp[0], $this->CC->tmp[1]);
                        break;
                        case 1:
                            $msg = __d('seo_tools', 'Summing up all analyzed search engines, there are at least as many web pages linking to your page as to the top ranked pages. This meets the basic requirements for getting high rankings on %s. Keep in mind that all search engines also evaluate the link texts and the quality of the web pages that link to your web site');
                            $msg = sprintf($msg, $this->data['Tool']['engine']);
                        break;
                        case 2:
                            $msg = __d('seo_tools', 'Summing up all analyzed search engines, you have more web pages linking to your web page than the top ranking web pages. This is very good. However, %s also evaluates the link texts and the quality of the web pages that link to your web site');
                            $msg = sprintf($msg, $this->data['Tool']['engine']);
                        break;
                    }
                    echo $msg;
                ?>
            </td>
        </tr>
    </tbody>
</table>