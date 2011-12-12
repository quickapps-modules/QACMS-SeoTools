<?php 
class ToolsController extends SeoToolsAppController {
    public $components = array('SeoTools.SeoTools');

    public function admin_index() {
        $this->Layout['stylesheets']['all'][] = '/seo_tools/css/styles.css';

        $this->set('tools', $this->SeoTools->toolsList());
    }

    public function admin_execute($tool) {
        $Tool = $this->SeoTools->loadTool($tool);

        if (!empty($this->data)) {
            $this->set('results', $Tool->main($this));
        } else {
            $data['Tool']['url'] = Router::url('/', true);
            $this->data = $data;
        }

        $this->set('tool', $tool);
        $this->set('tool_info', $this->SeoTools->toolInfo($tool));
    } 
}