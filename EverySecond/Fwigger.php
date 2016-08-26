<?php

// A very simple class for template parsing. Matthew Evans 2016.
class Fwigger {
	function __construct() {}

	public function parse($html, $context) {
		extract($context);
		eval('?> '. $html);
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