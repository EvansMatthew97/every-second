<?php
require_once 'assets/EverySecond.php';
require_once 'data.php';
global $data;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
	<title>Every Second</title>

	<link rel="stylesheet" href="./assets/css/style.css">
</head>
<body id="page">
	<div class="header">
		<h1>Every Second</h1>
	</div>

	<div class="c">
		<?php
		if (isset($_GET['s'])) {
			echo '<a href="index.php" class="backbtn">Back</a>';
			include 'page.php';
		}
		else {
			$esSpawner = new EverySecond([], $data);
			$esSpawner->render();
		}

		?>
	</div>

	<div class="footer">
		<p>Content descriptions are from wikipedia.org</p>
		<p>Time statistics are from the World Health Organisation</p>
		<p>All other content is copyright Matthew Evans <?=date('Y')?></p>
	</div>

	<div id="m" class="m-c">
		<div class="m__bg" id="m_bg"></div>
		<div id="m_main" class="m">
			<div class="m__h" id="m_header">
				<h2 class="m__t" id="m_title"></h2>
				<a href="#" class="m__close" id="m_close">x</a>
			</div>
			<div class="m__b" id="m_body"></div>
		</div>
	</div>
	<script src="./assets/js/es.js"></script>
</body>
</html>