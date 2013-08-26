<?php if (!isset($results)): ?>
	<?php echo $this->Form->create('Tool'); ?>
		<?php echo $this->Form->input('Tool.url', array('label' => __d('seo_tools', 'Enter Your URL'))); ?>
	<?php echo $this->Form->end(__d('seo_tools', 'Continue')); ?>
<?php else: ?>
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