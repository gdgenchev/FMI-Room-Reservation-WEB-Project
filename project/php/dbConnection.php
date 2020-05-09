<?php

$servername = "project-database.c2wskskx2i3t.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "mnogoslojnaparola";
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