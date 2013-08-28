<?php
/**
 * Seo View Hooks
 *
 * PHP version 5
 *
 * @package  QuickApps.Modules.Seo.View.Helper
 * @version  1.0
 * @author   Christopher Castro <chris@quickapps.es>
 * @link     http://cms.quickapps.es
 */
class SeoToolsHookHelper extends AppHelper {
    private $__url = array(
        'url' => false,
        'title' => false,
        'description' => false,
        'keywords' => false,
        'header' => false,
        'footer' => false,
        'redirect' => false,
        'status' => 1
    );

    public function beforeLayout() {
        // urls toolbar:
        if (isset($this->request->params['admin']) &&
            $this->request->params['plugin'] == 'seo_tools'
        ) {
            $this->_View->Block->push(array('body' => $this->_View->element('toolbar') . '<!-- SeoToolsHookHelper -->' ), 'toolbar');
        }

		$this->__optimize();

        return true;
    }

    private function __optimize() {
		if (QuickApps::is('view.frontpage')) {
			$_url = '/';
		} else {
			$_url = empty($this->_View->request->url) ? '/' : $this->_View->request->url;
			$_url = str_replace('//', '/', "/{$_url}");
		}

        $cache = Cache::read('seo_url_' . md5($_url), 'seo_tools_optimized_url');

        if ($cache && $cache['status']) {
            $this->__url = array_merge($this->__url, $cache);
            $this->__url['url'] = $_url;

            if ($this->__url['redirect']) {
				header('HTTP/1.1 301 Moved Permanently'); 
                header('Location: ' . $this->__url['redirect']);
                die();
            }

            if ($this->__url['description']) {
                $this->_View->viewVars['Layout']['meta']['description'] = $this->__url['description'];
            }

            if ($this->__url['keywords']) {
                $this->_View->viewVars['Layout']['meta']['keywords'] = $this->__url['keywords'];
            }

            if ($this->__url['header']) {
                $this->_View->viewVars['Layout']['header'][] = $this->__url['header'];
            }

            if ($this->__url['footer']) {
                $this->_View->viewVars['Layout']['footer'][] = $this->__url['footer'];
            }
        }

		$ga = Configure::read('Modules.SeoTools.settings.google_analytics');
		$gm = Configure::read('Modules.SeoTools.settings.google_meta');
		$bm = Configure::read('Modules.SeoTools.settings.bing_meta');
		$am = Configure::read('Modules.SeoTools.settings.alexa_meta');

		if (!empty($ga)) {
			$this->_View->viewVars['Layout']['footer'][] = $ga;
		}

		if (!empty($gm)) {
			$this->_View->viewVars['Layout']['header'][] = '<meta name="google-site-verification" content="' . $gm . '"/>';
		}

		if (!empty($bm)) {
			$this->_View->viewVars['Layout']['header'][] = '<meta name="msvalidate.01" content="' . $bm . '"/>';
		}

		if (!empty($am)) {
			$this->_View->viewVars['Layout']['header'][] = '<meta name="alexaVerifyID" content="' . $am . '"/>';
		}		
    }

    public function layout_title_alter(&$title) {
        if ($this->__url['title']) {
            $title = $this->__url['title'];
        }
    }
}