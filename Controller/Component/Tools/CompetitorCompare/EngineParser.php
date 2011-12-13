<?php
class EngineParser {
    public $Engine = false;
    public $domain;

    public function loadEngine($engine) {
        $this->domain = strtolower($engine);
        $engine = explode('.', $engine);
        $className = Inflector::camelize($engine[0]);
        $class = dirname(__FILE__) . DS  . 'SearchEngine' . DS . $className . '.php';

        if (file_exists($class)) {
            require $class;

            $this->Engine = new $className;
            $this->Engine->BaseTools = $this->BaseTools;

            return true;
        }

        return false;
    }

    public function parse($criteria, $limit = 10, $domain = false) {
        if (!$this->Engine) {
            return false;
        }

        $domain = !$domain ? $this->domain : $domain;
        $snippets = $this->Engine->main($criteria, $domain, $limit);

        return (array)$snippets;
    }
}