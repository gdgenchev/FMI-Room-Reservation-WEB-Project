<?php

	include 'dbConnection.php';

		$input = implode(" ", $_POST);

		$sql = "select * from reservation where subject = \"$input\" or personWhoReserved = \"$input\" ";

	 	$result = mysqli_query($conn,$sql);

	 	echo 
	 	 "<br><br>
	 	  <table style= \"border:1px solid black; border-collapse: collapse; width: 100%; text-align: center;\" id=\"tableWithData\">
	 	  <tr>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Room</th>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Building</th>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">From</th>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">To</th>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Person</th>
		   <th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Subject</th>
	      </tr>";


	 	if(mysqli_num_rows($result) > 0)
	 	{
	 		while($row = mysqli_fetch_assoc($result))
	 		{
	 		 echo "<tr style=\"border:1px solid black\">";
	 		 echo "<td style=\"border:1px solid black\">" . $row["roomNumber"] . "</td>";
	 		 echo "<td style=\"border:1px solid black\">" . $row["buildingName"] . "</td>";
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
	 		echo "No results found.";
	 	}
	?>