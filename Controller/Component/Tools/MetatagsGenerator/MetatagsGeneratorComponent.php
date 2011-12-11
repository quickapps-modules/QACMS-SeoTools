<?php 
class MetatagsGeneratorComponent extends Component {

    public function main(&$Controller) {
        if (!isset($Controller->data['Tool']['metas'])) {
            return false;
        }

		$default = array(
			'title' => '',
			'description' => '',
			'keywords' => '',
			'author' => '',
			'owner' => '',
			'copyright' => ''
		);
		$data = array_merge($default, $Controller->data['Tool']['metas']);
		$out = '';

		foreach ($data as $name => $content) {
			if (empty($content)) {
				continue;
            }

			$content = str_replace('"', "'", $content);
			$name = str_replace('"', "'", $name);
			$out .= "<meta name=\"{$name}\" content=\"{$content}\" />\n";
		}

		return $out;
    }
}