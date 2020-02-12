<?php

require_once "util/DbConnectionCreator.php";
$roomNumber = $_POST['roomNumber'];
$buildingName = $_POST['buildingName'];

$sql = "select * from reservation where roomNumber = \"$roomNumber\" and buildingName= \"$buildingName\" ";
$conn = DbConnectionCreator::createConnection();
$result = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

if(count($result) > 0)
{
    echo
    "<br><br>
	 	  <table style= \"border:1px solid black; border-collapse: collapse; width: 100%; text-align: center;\" id=\"tableWithData\">
	 	  <tr>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">От</th>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">До</th>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Лектор</th>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Предмет</th>
	      </tr>";

    foreach($result as $row)
    {
        echo "<tr style=\"border:1px solid black\">";
        echo "<td style=\"border:1px solid black\">" . $row["reservedFrom"] . "</td>";
        echo "<td style=\"border:1px solid black\">" . $row["reservedTo"] . "</td>";
        echo "<td style=\"border:1px solid black\">" . $row["personWhoReserved"] . "</td>";
        echo "<td style=\"border:1px solid black\">" . $row["subject"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
else
{
    echo "Залата все още няма график.";
}
?>