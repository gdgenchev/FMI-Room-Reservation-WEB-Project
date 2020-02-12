<?php
require_once "util/DbConnectionCreator.php";
require_once "persistence/feature/FeatureRepository.php";
require_once "persistence/feature/FeatureRepositorySQL.php";

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
              STR_TO_DATE(:reservedFrom, '%Y-%m-%d %H:%i:%s') > reservedFrom AND 
              STR_TO_DATE(:reservedFrom, '%Y-%m-%d %H:%i:%s') < reservedTo OR
              STR_TO_DATE(:reservedTo, '%Y-%m-%d %H:%i:%s') > reservedFrom AND
              STR_TO_DATE(:reservedTo, '%Y-%m-%d %H:%i:%s') < reservedTo) reservedRoom
               ON room.roomNumber = reservedRoom.roomNumber
               AND room.buildingName = reservedRoom.buildingName
               WHERE reservedFrom is NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['reservedFrom' => $reservedFrom, 'reservedTo' => $reservedTo]);
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $featureRepository = new FeatureRepositorySQL($this->conn);
        foreach ($rooms as &$room) {
            $buildingName = $room["buildingName"];
            $roomNumber = $room["roomNumber"];
            $room["features"] = $featureRepository->getResourceIconsForRoom($buildingName, $roomNumber);
        }

        return $rooms;


    }

    function removeReservation($roomNumber, $buildingName, $reservedFrom, $reservedTo)
    {
        $sql  = "DELETE from reservation WHERE :roomNumber = roomNumber AND :buildingName = buildingName
                AND STR_TO_DATE(:reservedFrom, '%Y-%m-%d %H:%i:%s') = reservedFrom
                AND STR_TO_DATE(:reservedTo, '%Y-%m-%d %H:%i:%s') = reservedTo";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['roomNumber' => $roomNumber, 'buildingName' => $buildingName, 'reservedFrom' => $reservedFrom, 'reservedTo' => $reservedTo]);
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rooms;
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

