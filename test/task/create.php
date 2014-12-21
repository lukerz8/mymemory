<?php
//header('Content-Type: application/json');

// testing sql stuff
$servername = "localhost";
$username = "mymemory";
$password = "8!57aC#4";
$dbname = "mymemory";

// create test connection 
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connection_error) {
	die("Connection failed: ".$conn->connection_error);
	echo "error!";
} else {
 echo "database connected";
}


// this works too! :
//$postData = $_POST;

$postData->id = 0;
$postData->name	= '';
$postData->created = 0;

//if (isset($_POST["id"])) {
//	$postData->id = $_POST["id"];
//}

if (isset($_POST["name"])) {
	$postData->name = $_POST["name"];
}

//if (isset($_POST["created"])) {
//	$postData->created = $_POST["created"];
//}

//$postData->phpNow =  (new \DateTime())->format('Y-m-d H:i:s');

$sql = sprintf("INSERT INTO mymemory (name) VALUES(%s)", $postData->name);

echo $sql;

if($conn->query($sql) === TRUE) {
	//echo json_encode($postData);
	echo var_dump($postData);
}

echo "done!";

$conn->close();