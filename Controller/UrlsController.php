<?php 
class UrlsController extends SeoToolsAppController {
    public $uses = array('SeoTools.SeoUrl');

    public function admin_index() {
        $this->set('results', $this->paginate('SeoUrl'));
        $this->setCrumb('/admin/seo_tools');
        $this->setCrumb(array('URL List'));
    }

    public function admin_add() {
        if (isset($this->data['SeoUrl'])) {
            if ($url = $this->SeoUrl->save($this->data)) {
                $this->redirect('/admin/seo_tools/urls/edit/' . $url['SeoUrl']['id']);
            }
        }

        $this->setCrumb(
            '/admin/seo_tools', 
            array('Add URL')
        );
    }

    public function admin_edit($id) {
        $result = $this->SeoUrl->findById($id);

        if (!$result) {
            $this->redirect('/admin/seo_tools/urls');
        }

        if (isset($this->data['SeoUrl']) && $this->SeoUrl->save($this->data)) {
            $this->redirect('/admin/seo_tools/urls/edit/' . $result['SeoUrl']['id']);
        }

        $this->data = $result;
        $this->setCrumb('/admin/seo_tools');
    }

    public function admin_delete($id) {
        return $this->SeoUrl->delete($id);
    }
}