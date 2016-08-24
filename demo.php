<?php
require_once './EverySecond/EverySecond.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>EverySecond</title>

	<link rel="stylesheet" href="EverySecond/css/everysecond.css">
</head>
<body>
	<div class="container">
		<h1>EverySecond</h1>
		<?php
		$everySecondGenerator = new EverySecond([
			'id' => 'everySecond',
			'title' => 'Every Second',
			'dataFile' => 'data.json',
			'per' => 'Y',
			'transitionTime' => 0.2,
			'showTime' => 2,
			'restingCSS' => [
				'transform' => 'translate(0,0) scale(1)',
				'opacity' => 0.5
			],
			'showingCSS' => [
				'transform' => 'translate(0, 5px) scale(1.0253)',
				'opacity' => 1,
				'box-shadow' => '0 25px 50px -20px rgba(0,0,0,0.2)'
			],
			'template' =>'<div class="es-timer">
				<div class="es-timer__body" style="animation: animation_{{ id }} {{ delay }}s infinite; background: {{ colour }};">
					<div class="es-timer__title">
						{{ title }}
					</div>
					<div class="es-loading-bar es-timer__loading-bar" style="animation-duration: {{ delay }}s;">
						<div class="es-loading-bar__text">Every {{ delay | round($v, 2) }}s</div>
					</div>
				</div>
			</div>'
		]);
		$everySecondGenerator->render([
			'title' => 0,
			'delay' => 1,
			'colour' => 2,
		], true);
		?>
	</div>
</body>
</html>