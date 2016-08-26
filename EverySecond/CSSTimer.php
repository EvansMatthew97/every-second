<?php

require_once 'Fwigger.php';

// Creates a timer using only CSS and HTML. Matthew Evans 2016
class CSSTimer {
	function __construct($config) { 
		$this->setConfig($config);
	}

	// setters and getters

	public function setConfig($config) {
		$defaults = [
			'id' => 'everySecondItem',
			'title' => 'EverySecond Item',
			'delay' => 60.0,
			'transitionTime' => 0.2,
			'showDuration' => 2.5,
			'restingCSS' => [],
			'showingCSS' => [],
			'template' => '
			<div class="es-timer">
				<div class="es-timer__body" style="animation: animation_<?=$id?> <?=round($delay, 2)?>s infinite;">
					<h2 class="es-timer__title">
						<?=$title?>
					</h2>
					<div class="es-loading-bar es-timer__loading-bar" style="animation-duration: <?=round($delay, 2)?>s; animation-delay: <?=$showTimeDelay?>s;">
						<div class="es-loading-bar__text">Every <?=round($delay, 2)?>s</div>
					</div>
				</div>
			</div>'
		];

		$this->config = array_merge($defaults, $config);

		foreach($this->config as $key => $value) {
			if (is_numeric($value)) {
				$value = round($value, 2);
			}
			$this->{$key} = $value;
		}
	}
	public function getConfig() {
		return $this->config;
	}

	// rendering functions

	public function renderCss($styleTags = true) {
		$id = $this->id;

		$showDurationPercent = round($this->showDuration / $this->delay * 100, 2);
		
		$showStartPercent = round($showDurationPercent / 2, 2);
		$showEndPercent = round(100 - $showDurationPercent / 2, 2);

		$transitionRunPercent = round($this->transitionTime / $this->delay * 100, 2);
		
		$transitionStartPercent = round($showStartPercent + $transitionRunPercent, 2);
		$transitionEndPercent = round($showEndPercent - $transitionRunPercent, 2);

		$this->config['showTimeDelay'] = $this->delay - (($this->showDuration + $this->transitionTime * 2) / 2);

		$fwigger = new Fwigger();
		$this->config['renderedRestingCSS'] = $fwigger->parseCSSArray($this->restingCSS, $this->config);
		$this->config['renderedShowingCSS'] = $fwigger->parseCSSArray($this->showingCSS, $this->config);

		$css = '@keyframes animation_' . $this->id . ' {
					0%, 100%, ' . $showStartPercent . '%, ' . $showEndPercent . '% {
						' . $this->config['renderedShowingCSS'] . '
					}
					' . $transitionStartPercent . '%, ' . $transitionEndPercent . '% {
						' . $this->config['renderedRestingCSS'] . '
					}
				}';
		
		if ($styleTags) { $css = '<style>' . $css . '</style>'; }

		return $css;
	}

	public function renderTemplate() {
		$fwigger = new Fwigger();
		$self = $this;
		return $fwigger->parse($this->template, $this->config);
	}

	public function render() {

		echo $this->renderCSS();
		
		echo $this->renderTemplate();
	}
}