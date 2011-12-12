<?php 
    $categories = array_unique(Set::extract('{s}.category', $tools));

    foreach ($categories as $category) {
?>
<div class="tools-box">
    <h2><?php echo $category; ?></h2>
    <ul>
        <?php 
            foreach ($tools as $folder => $tool) { 
                if ($tool['category'] != $category) {
                    continue;
                }
        ?>
        <li>
            <?php echo $this->Html->image('/seo_tools/img/' . $folder . '.gif', array('class' => 'tool-icon', 'align' => 'left')); ?>
            <?php echo $this->Html->link($tool['name'], '/admin/seo_tools/tools/execute/' . $folder); ?>
            <p><em><?php echo $tool['description']; ?></em></p>
        </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>