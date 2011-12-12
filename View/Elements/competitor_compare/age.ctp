<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablekit"><!-- alexa rank -->
    <thead>
        <tr>
          <td colspan="3" align="left" valign="top"><b><?php echo __t('Dates of the domain registration or of the first contents'); ?></b></td>
        </tr>
    </thead>
    
    <tbody>
        <tr>
            <td width="10%" height="20" align="center">&nbsp;</td>
            <td width="63%" height="20" align="left"><b><?php echo __t('URL'); ?></b></td>
            <td width="27%" align="left"><b><?php echo __t('Registration Date'); ?></b></td>
        </tr>
        
        <tr>
            <td align="center" valign="middle"><?php echo __t('Your Site'); ?></td>
            <td align="left" valign="middle"><?php echo $results['Data']['Site']['url']; ?></td>
            <td align="left" valign="middle"><?php echo $this->CC->age($results['Data']['Site']['age']); ?></td>
        </tr>
        <?php $s_stamp = $this->CC->tmp; $c_stamp = array(); ?>
        <?php foreach($results['Data']['Competitors'] as $index => $competitor) { ?>
            <tr>
                <td align="center" valign="middle"><?php echo $index+1; ?></td>
                <td align="left" valign="middle"><?php echo $competitor['url']; ?></td>
                <td align="left" valign="middle"><?php echo $this->CC->age($competitor['age']); ?></td>
            </tr>
            <?php $c_stamp[] = $this->CC->tmp; ?>
        <?php } ?>
        <tr>
            <td align="center" valign="middle"><?php echo __t('Range'); ?></td>
            <td colspan="2" align="left" valign="middle">
                <?php 
                    $min = min($c_stamp);
                    $max = max($c_stamp);

                    echo __t('From %s to %s', date(__t('Y-m-d'), strtotime(date('Y-m-d'))-$min), date(__t('Y-m-d'), strtotime(date('Y-m-d'))-$max));
                ?>
            </td>
        </tr>
        
        <tr class="advice_color_<?php echo $color = $this->CC->advice_color($c_stamp, $s_stamp, $aspect);  ?>">
            <td align="left" valign="left" colspan="3">
                <?php 
                    switch($color){
                        default: case 0: 
                            $msg = __t('Your web site is less than 1 year old');
                        break;
                        
                        case 1:
                            $msg = __t('The web site age could not be determined or is newer than the newer of your competitors. In general, the older your web site, the better it is for your rankings on %s. If you have a young web site, you must compensate by improving the other search engine ranking factors');
                            $msg = sprintf($msg, $this->data['Tool']['engine']);
                        break;
                        
                        case 2:
                            $msg = __t('Your web site is about %s years old. This is very good because the older your web site, the better it is for your rankings on %s');
                            $msg = sprintf($msg, number_format($this->CC->tmp/31556926, 0), $this->data['Tool']['engine']);
                        break;
                    }
                    
                    echo $msg;
                
                ?>
            </td>
        </tr>
    </tbody>
</table>
