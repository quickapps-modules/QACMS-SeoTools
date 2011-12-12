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
            if ($execute = $Tool->main($this)) {
                $this->set('results', $execute);
            } else {
                $this->redirect('/admin/seo_tools/tools/execute/' . $tool);
            }
        } else {
            $data['Tool']['url'] = Router::url('/', true);
            $this->data = $data;
        }

        $this->set('tool', $tool);
        $this->set('tool_info', $this->SeoTools->toolInfo($tool));
    } 
}