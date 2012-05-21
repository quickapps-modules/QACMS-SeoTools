<?php 
class UrlsController extends SeoToolsAppController {
    public $uses = array('SeoTools.SeoUrl');

    public function admin_index() {
        if (isset($this->data['SeoUrl']['update']) && isset($this->data['Items'])) {
            foreach ($this->data['Items']['id'] as $id) {
                switch ($this->data['SeoUrl']['update']) {
                    case 'enable':
                        $this->admin_enable($id);
                    break;

                    case 'disable':
                        $this->admin_disable($id);
                    break;

                    case 'delete':
                        $this->admin_delete($id);
                    break;
                }
            }

            $this->redirect('/admin/seo_tools/urls/index');
        }

        $this->set('results', $this->paginate('SeoUrl'));
        $this->setCrumb(
            '/admin/seo_tools',
            array(__d('seo_tools', 'URL List'))
        );
    }

    public function admin_add() {
        if (isset($this->data['SeoUrl'])) {
            if ($url = $this->SeoUrl->save($this->data)) {
                $this->redirect('/admin/seo_tools/urls/edit/' . $url['SeoUrl']['id']);
            }
        }

        $this->setCrumb(
            '/admin/seo_tools', 
            array(__d('seo_tools', 'Add URL'))
        );
    }

    public function admin_edit($id) {
        $result = $this->SeoUrl->findById($id);

        if (!$result) {
            $this->redirect('/admin/seo_tools/urls/index');
        }

        if (isset($this->data['SeoUrl']) && $this->SeoUrl->save($this->data)) {
            $this->redirect('/admin/seo_tools/urls/edit/' . $result['SeoUrl']['id']);
        }

        $this->data = $result;
        $this->setCrumb('/admin/seo_tools');
    }

    public function admin_enable($id) {
        $this->SeoUrl->id = $id;
        return $this->SeoUrl->saveField('status', 1);
    }

    public function admin_disable($id) {
        $this->SeoUrl->id = $id;
        return $this->SeoUrl->saveField('status', 0);
    }

    public function admin_delete($id) {
        return $this->SeoUrl->delete($id);
    }
}