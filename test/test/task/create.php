<?php
header('Content-Type: application/json');

// this works too! :
//$postData = $_POST;

$postData->id = 0;
$postData->name	= '';
$postData->created = 0;

if (isset($_POST["id"])) {
	$postData->id = $_POST["id"];
}

if (isset($_POST["name"])) {
	$postData->name = $_POST["name"];
}

if (isset($_POST["created"])) {
	$postData->created = $_POST["created"];
}

$postData->phpNow =  (new DateTime());

echo json_encode($postData);