<?php
require_once "util/DbConnectionCreator.php";

class ReservationRepositorySQL implements ReservationRepository
{
    private $conn;

    function __construct()
    {
        $this->conn = DbConnectionCreator::createConnection();
    }

    function getAvailableRooms($startDateTime, $endDateTime)
    {
        $sql = "SELECT room.type, room.roomNumber, room.buildingName from room left join (select * from reservation where
              '$startDateTime' > reservedFrom AND 
              '$startDateTime' < reservedTo OR
              '$endDateTime' > reservedFrom AND
              '$endDateTime' < reservedTo) reservedRoom
               ON room.roomNumber = reservedRoom.roomNumber
               AND room.buildingName = reservedRoom.buildingName
               WHERE reservedFrom is NULL";
        $test = 'SELECT * from room';
       return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    }



}

