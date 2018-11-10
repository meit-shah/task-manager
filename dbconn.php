<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname="todolist";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password); // connect to db
}
catch(PDOEXCEPTION $e){
	echo "unknown credential. please enter valid data";
}

?>