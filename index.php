<?php

header("Content-Type: application/json");
ob_start();
$requestBody = file_get_contents('php://input'); 
$json = json_decode($requestBody, true);

$text = $json['result']['resolvedQuery'];

if (strpos(strtolower($text), "ram") !== false) {
	$displayText = "Hello Ram, this is from php.";
}
else {
	$displayText = "Hello Ram, this is else part.";
}

$response = json_encode(array(
           		"source" => "webhook",
           		"speech" => $displayText,
           		"displayText" => $displayText,
           		"contextOut" => array()
       		));

ob_end_clean();
echo $response;

?>


