<?php if (!isset($results)): ?>
<?php echo $this->Form->create(false); ?>
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
<?php echo $this->Form->end(); ?>

<?php else: ?>

<h1><?php printf(__t('%s analysed words'), count($results)); ?></h1>
<div style="width:100%; white-space: nowrap;">
    <?php foreach($results as $word => $percent): ?>
        <?php echo $word; ?>: <?php echo $percent; ?>% <br/>
    <?php endforeach; ?>
</div>

<?php endif; ?>