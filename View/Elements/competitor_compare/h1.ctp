<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
        <tr>
          <td colspan="2" align="left" valign="top"><b><?php echo __t('Their Content'); ?></b></td>
        </tr>

        <tr>
            <td width="3%" align="left" valign="top"><b><?php echo __t('Rank'); ?></b></td>
            <td align="center" valign="top" width="97%"><b><?php echo __t('Content'); ?></b></td>
        </tr>
        
    </thead>

    <tbody>
        <?php foreach($results['Data']['Competitors'] as $pos => $competitor): ?>
        <tr>
            <td align="left" valign="top" width="3%"><?php echo $pos+1; ?></td>
            <td align="center" valign="top" width="97%">
                <?php
                    $cd = Set::extract("/{$aspect}", $competitor); $cd = isset($cd[0]) ? $cd[0] : '';
                    $cd = !empty($cd) ? $cd : __t('Content not found');
                    $cd = $this->CC->emphasize_keywords($cd, $keywords);

                    if ($aspect == 'body') { 
                        echo '<div style="text-align:left; height:80px; overflow-x:hidden; overflow-y:auto;">'. $cd .'</div>';
                    } elseif ($aspect == 'title') {
                        echo '<a href="'. $results['Data']['Competitors'][$pos]['url'] . '" target="_blank">'. $cd . '</a>';
                    } else {
                        echo $cd;
                    }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>