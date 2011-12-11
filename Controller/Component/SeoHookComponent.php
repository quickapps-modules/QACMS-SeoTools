<?php
class SeoHookComponent extends Component {
	var $Controller = null;
	var $components = array('Hook');

	function initialize(&$Controller){
		$this->Controller = $Controller;
	}
}