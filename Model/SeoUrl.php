<?php
class SeoUrl extends SeoToolsAppModel {
    private $__tmp;
    public $useTable = 'seo_tools_urls';

	public $validate = array(
		'url' => array('required' => true, 'allowEmpty' => false, 'rule' => array('isUnique'), 'message' => "Invalid URL"),
		'status' => array('required' => true, 'allowEmpty' => false, 'rule' => 'numeric', 'message' => "Invalid status"),
		'redirect' => array('required' => false, 'allowEmpty' => true, 'rule' => array('url', true), 'message' => "Invalid redirect URL")
	);

    public function beforeDelete() {
        $this->__tmp['url'] = $this->field('url');

        return true;
    }

    public function afterDelete() {
        if (isset($this->__tmp['url'])) {
            Cache::delete('seo_url_' . md5($this->__tmp['url']));
        }
    }

	public function afterSave(){
		if (isset($this->data['SeoUrl']['url'])) {
            Cache::write('seo_url_' . md5($this->data['SeoUrl']['url']), $this->data['SeoUrl']);
        }
	}
}