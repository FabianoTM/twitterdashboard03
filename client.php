<?php
	
	header('Content-Type: application/json');
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://twitterrest03.mybluemix.net/tweets");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	curl_close($ch);
	
	echo json_encode($response);
?>