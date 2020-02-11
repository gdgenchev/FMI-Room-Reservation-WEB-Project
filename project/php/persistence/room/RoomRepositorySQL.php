<?php
require_once "util/DbConnectionCreator.php";
require_once "persistence/feature/FeatureRepository.php";
require_once "persistence/feature/FeatureRepositorySQL.php";

class RoomRepositorySQL implements RoomRepository
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function addRoom($room)
    {
        $buildingName = $room->buildingName;
        $roomNumber = $room->roomNumber;
        $type = $room->type;
        $seats = $room->seats;
        $features = $room->features;
        $responsiblePerson = $room->responsiblePerson;

        $sql = "INSERT INTO room(buildingName, roomNumber, type, seats, responsiblePerson) VALUES (?, ?, ?, ?, ?)";

        try {
            $this->conn->prepare($sql)->execute([$buildingName, $roomNumber, $type, $seats, $responsiblePerson]);
        } catch (PDOException $e) {
            if ($e->getCode() == 1062) {
                return false;
            } else {
                throw $e;
            }
        }

        $featureRepository = new FeatureRepositorySQL($this->conn);
        $featureRepository->addFeaturesForRoom($buildingName, $roomNumber, $features);

        return true;
    }
}