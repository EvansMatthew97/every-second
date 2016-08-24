<?php

require_once 'DataReader.php';
require_once 'CSSTimer.php';

// creates a list/grid of CSSTimers, all sharing similar properties. Matthew Evans 2016.
class EverySecond {
	function __construct($config) {
		$this->setConfig($config);
	}

	public function setConfig($config) {
		$defaults = [
			'id' => 'everySecond',
			'dataFile' => 'data.json',
			'per' => 'Y',
			'transitionTime' => 0.2,
			'showDuration' => 2.5,
			'restingCSS' => [],
			'showingCSS' => []
		];

		$this->config = array_merge($defaults, $config);

		foreach ($this->config as $key => $value) {
			$this->{$key} = $value;
		}

		$this->setTimeFunction($this->per);
		$this->loadData();
	}

	public function getConfig() {
		return $this->config;
	}

	private function setTimeFunction($per) {
		$DAY = 86400;
		$YEAR = $DAY * 365;

		switch ($per) {
			case 'D':
				$this->timeFunction = $DAY;
				break;
			default:
			case 'Y':
				$this->timeFunction = $YEAR;
				break;
		}
	}

	private function loadData() {
		$dataReader = new DataReader();
		$this->data = $dataReader->read($this->dataFile);		
	}

	public function render($customKeys = [], $random = false) {
		$data = $this->data;
		
		if ($random) {
			shuffle($data);
		}

		foreach ($data as $timerIndex => $timerData) {
			$timerConfig = [
				'id' => $this->id . $timerIndex
			];

			$defaultCustomKeys = [
				'title' => 0,
				'delay' => 1
			];

			$customKeys = array_merge($defaultCustomKeys, $customKeys);

			foreach ($customKeys as $customKey => $customKeyValue) {
				$timerConfig[$customKey] = $timerData[$customKeyValue];
			}

			$timerConfig['title'] = $timerData[$customKeys['title']];
			$timerConfig['delay'] = 1 / ($timerData[$customKeys['delay']] / $this->timeFunction);

			$timerConfig = array_merge($this->config, $timerConfig);

			$timer = new CSSTimer($timerConfig);
			$timer->render();
		}
	}

	
};