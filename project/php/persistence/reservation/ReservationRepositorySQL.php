<?php
require_once "util/DbConnectionCreator.php";

class ReservationRepositorySQL implements ReservationRepository
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function getAvailableRooms($reservedFrom, $reservedTo)
    {
        $sql = "SELECT room.type, room.roomNumber, room.buildingName from room left join (select * from reservation where
              '$reservedFrom' > reservedFrom AND 
              '$reservedFrom' < reservedTo OR
              '$reservedTo' > reservedFrom AND
              '$reservedTo' < reservedTo) reservedRoom
               ON room.roomNumber = reservedRoom.roomNumber
               AND room.buildingName = reservedRoom.buildingName
               WHERE reservedFrom is NULL";
        $test = 'SELECT * from room';
       return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    }

    function removeReservation($roomNumber, $buildingName, $reservedFrom, $reservedTo)
    {
        $sql  = "DELETE from reservation WHERE '$roomNumber' = roomNumber AND '$buildingName' = buildingName
                AND STR_TO_DATE('$reservedFrom', '%Y-%m-%d %H:%i:%s') = reservedFrom
                AND STR_TO_DATE('$reservedTo', '%Y-%m-%d %H:%i:%s') = reservedTo";

        return $this->conn->query($sql)->execute();
    }

    function addReservation($reservation)
    {
        $reservedFrom = $reservation->reservedFrom;
        $reservedTo = $reservation->reservedTo;
        $buildingName = $reservation->buildingName;
        $roomNumber = $reservation->roomNumber;
        $personWhoReserved = $reservation->personWhoReserved;
        $subject = $reservation->subject;

        $sql = "INSERT INTO reservation(buildingName, roomNumber, reservedFrom, reservedTo, personWhoReserved, subject) VALUES (?, ?, ?, ?, ?,?)";

        try {
            $this->conn->prepare($sql)->execute([$buildingName,$roomNumber, $reservedFrom, $reservedTo, $personWhoReserved, $subject]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return false;
            } else {
                throw $e;
            }
        }

        return true;
    }
}

