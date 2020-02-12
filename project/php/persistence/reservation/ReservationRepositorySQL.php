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
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['startDateTime' => $startDateTime, 'endDateTime' => $endDateTime]);
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $featureRepository = new FeatureRepositorySQL($this->conn);
        foreach ($rooms as &$room) {
            $buildingName = $room["buildingName"];
            $roomNumber = $room["roomNumber"];
            $room["features"] = $featureRepository->getResourceIconsForRoom($buildingName, $roomNumber);
        }

        return $rooms;
    }
}

