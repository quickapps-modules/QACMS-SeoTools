<table width="100%" border="0" cellspacing="0" cellpadding="0"><!-- alexa rank -->
    <thead>
        <tr>
          <td colspan="3" align="left" valign="top"><b><?php echo __t('Alexa.com Traffic Rank results (the lower the better)'); ?></b></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="10%" height="20" align="center">&nbsp;</td>
            <td width="73%" height="20" align="left"><b><?php echo __t('URL'); ?></b></td>
            <td width="17%" height="20" align="right"><b><?php echo __t('Alexa Traffic Rank'); ?></b></td>
        </tr>

        <tr>
            <td align="center" valign="middle"><?php echo __t('Your Site'); ?></td>
            <td align="left" valign="middle"><?php echo $this->data['Tool']['url']; ?></td>
            <td align="right" valign="middle"><?php echo __t('Rank #'); ?> <?php echo $results['Data']['Site']['alexa_rank']; ?></td>
        </tr>

        <?php foreach($data as $index => $rank){ ?>
        <tr>
            <td align="center" valign="middle"><?php echo $index+1; ?></td>
            <td align="left" valign="middle"><?php echo $results['Data']['Competitors'][$index]['url']; ?></td>
            <td align="right" valign="middle"><?php echo __t('Rank #'); ?> <?php echo $rank; ?></td>
        </tr>
        <?php } ?>

        <tr>
            <td align="center" valign="middle"><?php echo __t('Range'); ?></td>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="right" valign="middle">&nbsp;</td>
        </tr>

        <tr class="advice_color_<?php echo $color = $this->CC->advice_color($data, $results['Data']['Site']['alexa_rank'], $aspect);  ?>">
            <td align="left" valign="middle" colspan="3">
            <?php
                if ( $this->CC->tmp[0] < $this->CC->tmp[1] && 170000 < $this->CC->tmp[1] ){
                    printf(__t("Although your web site %s appears to attract more visitors than the average of your competitors' sites, the absolute number of visitors is low. This could be disadvantageous to your rankings on %s"),
                        $this->data['Tool']['url'],
                        $this->data['Tool']['engine']
                    );
                } elseif (    ($this->CC->tmp[0] > $this->CC->tmp[1]) ||
                        ($this->CC->tmp[0] > 170000  && $this->CC->tmp[1] < $this->CC->tmp[0])
                ){
                    printf(
                        __t('Your web site %s does not appear to attract many visitors because your traffic trank is above #100,000 and you have less visitors than the average of your competitors. This could be disadvantageous to your rankings on %s'),
                        $this->data['Tool']['url'],
                        $this->data['Tool']['engine']
                        );
                } elseif ( $this->CC->tmp[0] < 170000){
                    printf(
                        __t('Your web site %s appears to attract a lot of visitors. This is very good and might be beneficial to your rankings on %s'),
                        $this->data['Tool']['url'],
                        $this->data['Tool']['engine']
                    );
                }
            ?>
            </td>
        </tr>
    </tbody>
</table>