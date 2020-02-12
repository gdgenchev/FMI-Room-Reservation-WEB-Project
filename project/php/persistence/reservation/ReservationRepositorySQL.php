<?php
require_once "util/DbConnectionCreator.php";

class ReservationRepositorySQL implements ReservationRepository
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function getAvailableRooms($startDateTime, $endDateTime)
    {
        $sql = "SELECT room.type, room.roomNumber, room.buildingName from room left join (select * from reservation where
              :startDateTime > reservedFrom AND 
              :startDateTime < reservedTo OR
              :endDateTime > reservedFrom AND
              :endDateTime < reservedTo) reservedRoom
               ON room.roomNumber = reservedRoom.roomNumber
               AND room.buildingName = reservedRoom.buildingName
               WHERE reservedFrom is NULL";

       return $this->conn->prepare($sql)
           ->execute(['startDateTime' => $startDateTime, 'endDateTime' => $endDateTime])
           ->fetchAll(PDO::FETCH_ASSOC);
    }
}

