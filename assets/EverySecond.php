<?php

class EverySecond {
	private $data = [];

	function __construct($config = [], $data) {
		$this->setConfig($config);
		$this->data = $data;
	}

	public function setConfig($config = []) {
		$defaults = [
			'id' => 'everySecond',
			'dataFile' => 'data.json',
			'per' => 365 * 86400,
		];

		$config = array_merge($defaults, $config);

		foreach ($config as $key => $value) {
			$this->{$key} = $value;
		}
	}

	public function render($random = false) {
		$data = $this->data;
		
		if ($random) {
			shuffle($data);
		}

		echo '<div id="' . $this->id . '">';

		foreach ($data as $timerIndex => $timerData) {
			$timerData['id'] = $this->id . $timerIndex;
			$timerData['per'] = $this->per;
			$timer = new Timer($timerData);
			$timer->render();
		}

		echo '</div>';
	}
};

class Timer {
	private $data = [];
	function __construct($data) {
		foreach($data as $key => $value) {
			$this->{$key} = $value;
		}
	}

	public function render() {
		$per = round(1 / (1000000 * $this->num / $this->per), 2);
		$death = true;
		if (isset($this->death)) {
			$death = $this->death;
		}
		echo '<div class="et" ';

		echo 'e="' . $per . '"';

		echo '><div class="et__b"><em></em>';

		echo '<div class="et__bg" style="background: ' . $this->colour . ';"></div>';

		echo '<h2 class="et__t">' . $this->title . '</h2>';
		echo '<div class="et__bar">' . ($death ? 'Death' : '') . ' every ' . $per . 's</div>';
		echo '<a href="?s=' . str_replace(' ', '%20', $this->url) . '" class="et__l">More Info</a>';

		echo '<i></i></div></div>';
	}

};