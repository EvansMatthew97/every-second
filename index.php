<?php
require_once 'EverySecond/EverySecond.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>EverySecond</title>

	<link rel="stylesheet" href="EverySecond/css/everysecond.css">
	<!--[if lte IE 9]><link rel="stylesheet" href="EverySecond/css/everysecond-old.css"><![endif]-->
	<!--[if lte IE 7]><link rel="stylesheet" href="EverySecond/css/everysecond-older.css"><![endif]-->
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
				'transform' => 'translateY(0)',
				'opacity' => 0.5
			],
			'showingCSS' => [
				'transform' => 'translateY(-3px)',
				'opacity' => 1,
				'box-shadow' => '0 25px 50px -20px rgba(0,0,0,0.2)'
			],
			'template' =>'<div class="es-timer">
				<div class="es-timer__body" style="animation: animation_<?=$id?> <?=round($delay, 2)?>s infinite; background: <?=$colour?>;">
					<h2 class="es-timer__title">
						<?=$title?>
					</h2>
					<div class="es-loading-bar es-timer__loading-bar" style="animation-duration: <?=round($delay, 2)?>s; animation-delay: <?=$showTimeDelay?>s;">
						<div class="es-loading-bar__text">Every <?=round($delay, 2)?>s</div>
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