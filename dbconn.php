<?php 

$servername = "localhost";
$username = "root";
$password = "";

try{
    $conn = new PDO("mysql:host=$servername;dbname=todolist",$username,$password); // connect to db
}
catch(PDOEXCEPTION $e){
	echo "unknown credential. please enter valid data";
}

?>