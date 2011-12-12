<p>
    <?php echo $this->Html->image('/seo_tools/img/' . $tool . '.gif', array('class' => 'tool-icon', 'align' => 'left')); ?>
    <h3><?php echo $tool_info['name']; ?></h3>
    <em><?php echo $tool_info['description']; ?></em>
</p>

<p><?php echo $this->element('Tools' . DS . $tool); ?></p>