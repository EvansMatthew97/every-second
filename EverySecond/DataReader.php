<?php

// Reads in JSON objects and formats them. Can be expanded upon to support databases. Matthew Evans 2016.
class DataReader {
	function __construct() {}

	public function read($path) {
		$returnArray = [];
		
		$dataFileContents = file_get_contents($path);
		$dataFileArray = json_decode($dataFileContents);

		foreach ($dataFileArray as $dataObject => $dataObjectContents) {
			$returnArray[$dataObject] = $dataObjectContents;
		}

		return $returnArray;
	}
};