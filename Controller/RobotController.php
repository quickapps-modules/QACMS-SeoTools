<?php 
class RobotController extends SeoToolsAppController {
	public $uses = array('System.Module');
    public function index() {
		header('Content-Type: text/plain');
		die(Cache::read('robots', 'seo_tools_optimized_url'));
    }
}