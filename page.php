<?php
require_once 'data.php';
global $data;

function getPageData($arr) {
	foreach ($arr->query->pages as $el) {
		return $el;
	}
}

if (isset($_GET['s'])) {
	$page = $_GET['s'];
	echo '<p>';
	if (strlen($page)) {

		$link = 'http://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro=&explaintext=&titles=' . $page;

		$conn = curl_init($link);
		curl_setopt($conn, CURLOPT_NOBODY, true);
		curl_exec($conn);
		$errCode = curl_getinfo($conn, CURLINFO_HTTP_CODE);
		curl_close($conn);

		if ($errCode != 404 && $errCode != 0) {

			$pageData = file_get_contents($link);
			$pageData = json_decode($pageData);

			//$pageData = $pageData['batchcomplete'];
			$pageData = getPageData($pageData);

			if (isset($pageData->extract)) {	
				$extractLen = 1450;
				echo strlen($pageData->extract) > $extractLen ? substr($pageData->extract, 0, $extractLen) . '...' : $pageData->extract;
				echo ' <a href="https://en.wikipedia.org/wiki/' . $page . '" target="_blank">Continue reading on Wikipedia</a>';
			}
			else {
				echo 'Page not found.';
			}
		}
		else {
			echo 'An error has occurred on our side.';
		}
	}
	else {
		echo 'Page not specified.';
	}
	echo '</p>';
}