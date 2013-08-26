<p>
    <h3><?php echo $this->Html->image("/seo_tools/img/Tools/{$tool}/tool-icon.gif", array('class' => 'tool-icon', 'align' => 'left')); ?> <?php echo $tool_info['name']; ?></h3>
    <em><?php echo $tool_info['description']; ?></em>
</p>

<hr />

<p><?php echo $this->element('Tools' . DS . $tool); ?></p>