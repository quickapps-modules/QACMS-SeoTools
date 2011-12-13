<?php 
class ToolsController extends SeoToolsAppController {
    public $components = array('SeoTools.SeoTools');

    public function admin_index() {
        $this->Layout['stylesheets']['all'][] = '/seo_tools/css/styles.css';

        $this->set('tools', $this->SeoTools->toolsList());
        $this->setCrumb('/admin/seo_tools');
        $this->setCrumb(array('Tools'));
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

        $tool_info = $this->SeoTools->toolInfo($tool);

        $this->set('tool', $tool);
        $this->set('tool_info', $tool_info);
        $this->setCrumb(
            '/admin/seo_tools',
            array('Tools', '/admin/seo_tools/tools/'),
            array($tool_info['name'])
        );
    } 
}