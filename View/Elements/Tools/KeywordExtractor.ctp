<?php if (!isset($results)) : ?>
<form action="" method="post">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
            <td align="left" valign="top"><b><?php echo __t('Enter Your URL'); ?>:</b></td>
            </tr>
        <tr>
          <td align="left" valign="top"><input type="text" name="data[Tool][url]" value="<?php echo Configure::read('ModSeo.Config.seo_site_url'); ?>" class="text" style="width:100%;" /></td>
      </tr>
        <tr>
            <td align="left" valign="top">
                <input type="submit" value="<?php echo __t('Continue'); ?>" class="primary_lg" />
            </td>
        </tr>
    </table>
</form>
<?php else: ?>
    <style>
        .words-column { float:left; width:30%; }
        .words-column ol { list-style-type:decimal; }
    </style>

    <div class="words-column">
        <h4>1 Word</h4>
        <ol>
            <?php 
                foreach (explode(', ', $results['words_1']) as $word):
                    if (empty($word)) {
                        continue;
                    }
            ?>
                <li><?php echo $word; ?></li>
            <?php endforeach; ?>
        <ol>
    </div>
    
    <div class="words-column">
        <h4>2 Word</h4>
        <ol>
            <?php 
                foreach (explode(', ', $results['words_2']) as $word):
                    if (empty($word)) {
                        continue;
                    }
            ?>
                <li><?php echo $word; ?></li>
            <?php endforeach; ?>
        <ol>
    </div>
    
    <div class="words-column">
        <h4>3 Word</h4>
        <ol>
            <?php 
                foreach (explode(', ', $results['words_3']) as $word):
                    if (empty($word)) {
                        continue;
                    }
            ?>
                <li><?php echo $word; ?></li>
            <?php endforeach; ?>
        <ol>
    </div>
<?php endif; ?>