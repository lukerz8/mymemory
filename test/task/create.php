<?php
header('Content-Type: application/json');

$temp = array;

if (isset($_GET['id'])) {
    $str = $_GET['id'];
    $temp[] = $str;
}

if (isset($_GET['name'])) {
    $str = $_GET['name'];
     $temp[] = $str;
}

if (isset($_GET['created'])) {
    $str = $_GET['created'];
     $temp[] = $str;
}

else {
	$temp[] = "nothing";
}


echo json_encode($temp);

?> 
