<?php 
class UrlsController extends SeoToolsAppController {
    public $uses = array('SeoTools.SeoUrl');

    public function admin_index() {
        $this->set('results', $this->paginate('SeoUrl'));
    }
    
    public function admin_add() {
        if (isset($this->data['SeoUrl'])) {
            $this->SeoUrl->save($this->data['SeoUrl']);
        }
    }

    public function admin_edit($id) {
        $results = $this->SeoUrl->findById($id);
        $this->data = $results;
    }
 
    public function admin_delete($id) {
        $this->SeoUrl->delete($id);
        $this->redirect($this->referer());
    }

    private function __prepareDump($sql) {
        $sql = trim($sql);
        $sql = preg_replace("/\n#[^\n]*\n/", "\n", $sql);
        $sql = preg_replace('/^\-\-(.*)/im', '', $sql);
        $sql = preg_replace("/\n{2,}/m", "\n", $sql);

        return $sql;
    }
}