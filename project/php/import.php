<?php

	//header('Content-Encoding: UTF-8');
	header('Content-Type: text/csv; charset=UTF-8');
	
	include 'dbConnection.php';

	$importedFile = fopen($_FILES["file"]["tmp_name"],"r");
	
	//skip the first line
	fgetcsv($importedFile);

	while(($line = fgetcsv($importedFile,1000,";")) !== FALSE)
	{
		$roomNumber = $line[0]; 
		$buildingName = $line[1];
		$reservedFrom = DateTime::createFromFormat("j.n.Y H:i",$line[2])->format("Y.n.j H:i");
		$reservedTo = DateTime::createFromFormat("j.n.Y H:i",$line[3])->format("Y.n.j H:i");
		$personWhoReserved = $line[4];
		$subject = $line[5];

		
		$query = "INSERT IGNORE INTO reservation(roomNumber, buildingName,reservedFrom,reservedTo,personWhoReserved,subject) VALUES('$roomNumber', '$buildingName','$reservedFrom','$reservedTo','$personWhoReserved','$subject')";
		$result = mysqli_query($conn, $query);

	}
	fclose($importedFile);

	echo "success";

?>