<?php
	include 'dbConnection.php';

	header('Content-Encoding: UTF-8');
	header('Content-Disposition: attachment');
	header('Content-type: text/csv; charset=UTF-8');
	header('Pragma: no-cache');
	header('Expires: 0');

	$delimiter = ",";
	$output = fopen("../downloadedContent.csv","w");

	fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

	fputcsv($output, array("Номер на стая","Сграда","От","До","Лектор","Предмет"),$delimiter);
	$query = "select roomNumber, buildingName, reservedFrom, reservedTo, reservedBy, course  from reservation order by buildingName, roomNumber ";
	$result = mysqli_query($conn,$query);
	
	while($line = mysqli_fetch_assoc($result))
	{

		$lineWithConvertedDate = array($line['roomNumber'],$line['buildingName'],
			$line['reservedFrom'], $line['reservedTo'], $line['reservedBy'],$line['course']);
		
		fputcsv($output,$lineWithConvertedDate,$delimiter);
	}

	fclose($output);

?>