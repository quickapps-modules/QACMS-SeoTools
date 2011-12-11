<?php 
class SeoToolsController extends SeoToolsAppController {
    public function admin_index() {
       $this->redirect('/admin/seo_tools/urls');
    }
}