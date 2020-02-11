<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";
$port = 3306;

$conn = mysqli_connect($servername,$username,$password,$dbname,$port);

// Check connection
if (mysqli_connect_errno()) 
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

?>