<?php

// A very simple class for template parsing. Matthew Evans 2016.
class Fwigger {
	function __construct() {}

	public function simpleParse($html, $context) {
		return preg_replace('/\{\{\s*(.*?)\s*\}\}/e', '$context["$1"]', $html);
	}

	public function parse($html, $context = []) {
		$html = preg_replace_callback('/\{\{\s*(.*?)\s*\|\s*(.*?)\((.*?)\)\s*\}\}/', function($matches) use($context) {
			$value = $context[$matches[1]];

			$params = preg_split('/[\s,]+/', $matches[3]);

			foreach ($params as $paramKey => $param) {
				if ($param == '$v') {
					$params[$paramKey] = $value;
					continue;
				}
				$params[$paramKey] = $this->simpleParse($param, $context);
			}

			return call_user_func_array($matches[2], $params);
		}, $html);

		$html = $this->simpleParse($html, $context);

		return $html;
	}

	public function parseCSSArray($cssArray) {
		$css = '';
		foreach ($cssArray as $property => $value) {
			if (gettype($value) == 'array') {
				foreach ($value as $subProperty => $subValue) {
					$css .= $property . '-' . $subProperty . ':' . $subValue . ';';
				}
			}
			else {
				$css .= $property . ':' . $value . ';';
			}
		}
		return $css;
	}
}

//abstract class Fwigger