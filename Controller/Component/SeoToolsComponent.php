<?php
class SeoToolsComponent extends Component {
    protected $_tools = array();

/**
 * Controller reference
 *
 * @var Controller
 */
	protected $_controller = null;

/**
 * Constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings.
 */
	public function initialize($Controller) {
		$this->_controller = $Controller;
        $Folder = new Folder(CakePlugin::path('SeoTools') . 'Controller' . DS . 'Component' . DS . 'Tools');
        $__tools = $Folder->read(true, false, true);
        $__tools = $__tools[0];
        $tools = array();
        $__yaml = array(
            'name' => '--Unknow Tool--',
            'description' => '',
            'category' => 'Unknow',
            'version' => '--',
            'author' => 'Anonymous'
        );

        foreach ($__tools as $path) {
            $name = basename($path);
            $yaml = array();

            if (file_exists($path . DS . "{$name}.yaml")) {
                $yaml = Spyc::YAMLLoad($path . DS . "{$name}.yaml");
                $yaml['author'] = @htmlentities($yaml['author']);
            } else {
				continue;
			}
            
            $yaml = Set::merge($__yaml, $yaml);
            $yaml['path'] = str_replace(DS . DS, DS, $path . DS);
            $tools[$name] = $yaml;
        }

        $this->_tools = $tools;
	}

	public function unrelativizeLink($link, $parent) {
		if (preg_match('/^(\.|\/)/', $link)) {
			$link = $parent . $link;
		} elseif(preg_match('/^(javascript:|mailto:|skype:)/i', $link)) {
			return false;
		} elseif (!preg_match('/^https?:\/\//i', $link)) {
			$link = "{$parent}/{$link}";
		}

		$link = preg_replace('/([^:])(\/{2,})/', '$1/', $link);

		return $this->toUTF8($link);
	}

    public function toolsList() {
        return $this->_tools;
    }

    public function toolInfo($tool) {
        return $this->_tools[Inflector::camelize($tool)];
    }

    public function loadTool($tool) {
        $tool = Inflector::camelize($tool);

        if (!isset($this->_tools[$tool])) {
            return false;
        }

        if (!file_exists("{$this->_tools[$tool]['path']}{$tool}Component.php")) {
            return false;
        }

        include_once "{$this->_tools[$tool]['path']}{$tool}Component.php";

        $class = $tool . 'Component';
        $component = new $class($this->_controller->Components);

        if (method_exists($component, 'initialize')) {
            $component->initialize($this->_controller);
        }

        if (method_exists($component, 'startup')) {
            $component->startup($this->_controller);
        }

        $component->BaseTools = $this;

        return $component;        
    }

	public function toInt($string) {
		return preg_replace('#[^0-9]#si', '', $string);
	}

	function getPage($url) {
		if (function_exists('curl_init')) {
			$ch = curl_init($url);
			$options = array(
				CURLOPT_RETURNTRANSFER => true,     // return web page
				CURLOPT_HEADER         => false,    // don't return headers
				CURLOPT_FOLLOWLOCATION => true,     // follow redirects
				CURLOPT_ENCODING       => "",       // handle all encodings
				CURLOPT_USERAGENT      => env('HTTP_USER_AGENT'), // who am i
				CURLOPT_AUTOREFERER    => true,     // set referer on redirect
				CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
				CURLOPT_TIMEOUT        => 120,      // timeout on response
				CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			);

			@curl_setopt_array($ch, $options);

			return curl_exec($ch);
		} else {
			$opts = array(
				'http'=>array(
					'follow_location' => true,
					'method'=> 'GET',
					'header'=>
						'User-Agent: ' . env('HTTP_USER_AGENT') . '\r\n'
				)
			);
			$context = stream_context_create($opts);

			return @file_get_contents($url, false, $context);
		}
	}

	public function parseUrl($url) {
		$parse = parse_url('http://' . preg_replace('/http\:\/\//', '', $url));
		$parse['full'] = 'http://' . preg_replace('/http\:\/\//', '', $url);

        return $parse;
	}

	public function ping($domain, $reverse = false) {
		$parseUrl = $this->parseUrl($domain);
		$host = $parseUrl['host'];
		$response = '';

        ob_start();

        if (strpos(strtoupper(php_uname('s')), 'WIN') !== false) {
			$cmd = $reverse ? "ping -a -n 4 {$host}" : "ping -n 4 {$host}";

			system($cmd);
		} else {
			$cmd = $reverse ? "dig +noall +answer -x {$host}" : "ping -c4 -w4 {$host}";

			system($cmd);
			system("killall ping");
		}

		$response = ob_get_contents();

        ob_end_clean();

		return $this->toUTF8($response);
	}

	public function html2text($s, $keep  = '', $expand = 'script|style|noframes|select|option|noscript') {
        $s = ' ' . $s;
        $k = array();

        if (strlen($keep) > 0) {
            $k = explode('|',$keep);

            for ($i=0;$i<count($k);$i++) {
                $s = str_replace('<' . $k[$i],'[{(' . $k[$i],$s);
                $s = str_replace('</' . $k[$i],'[{(/' . $k[$i],$s);
            }
        }

        while(stripos($s,'<!--') > 0) {
            $pos[1] = stripos($s,'<!--');
            $pos[2] = stripos($s,'-->', $pos[1]);
            $len[1] = $pos[2] - $pos[1] + 3;
            $x = substr($s,$pos[1],$len[1]);
            $s = str_replace($x,'',$s);
        }

        if (strlen($expand) > 0) {
            $e = explode('|',$expand);

            for ($i = 0; $i < count($e); $i++) {
                while(stripos($s,'<' . $e[$i]) > 0) {
                    $len[1] = strlen('<' . $e[$i]);
                    $pos[1] = stripos($s,'<' . $e[$i]);
                    $pos[2] = stripos($s,$e[$i] . '>', $pos[1] + $len[1]);
                    $len[2] = $pos[2] - $pos[1] + $len[1];
                    $x = substr($s,$pos[1],$len[2]);
                    $s = str_replace($x,'',$s);
                }
            }
        }

        while(stripos($s,'<') > 0) {
            $pos[1] = stripos($s,'<');
            $pos[2] = stripos($s,'>', $pos[1]);
            $len[1] = $pos[2] - $pos[1] + 1;
            $x = substr($s,$pos[1],$len[1]);
            $s = str_replace($x,'',$s);
        }

        for ($i=0;$i<count($k);$i++) {
            $s = str_replace('[{(' . $k[$i],'<' . $k[$i],$s);
            $s = str_replace('[{(/' . $k[$i],'</' . $k[$i],$s);
        }

		$s = preg_replace(
			array(
			"/[\n\t]+/",
			'/\r/',
			'/[ ]{2,}/'
			),
			array(
			' ',
			' ',
			' '
			)
		, $s);

        return trim($s);
	}

	public function toUTF8($text) {
        $detect_pattern = '%(?:[\xC2-\xDF][\x80-\xBF]|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF]|\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2})+%xs';

        if (!preg_match($detect_pattern, $text)) {
			return utf8_encode($text);
		} else	{
			return $text;
		}
	}
}