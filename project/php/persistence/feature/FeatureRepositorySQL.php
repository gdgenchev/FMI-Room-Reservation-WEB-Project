<?php
require_once "util/DbConnectionCreator.php";

class FeatureRepositorySQL implements FeatureRepository
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function getResources()
    {
        return $this->conn->query('SELECT * FROM feature')->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * This function can be improved with multi insert.
     */
    function addFeaturesForRoom($buildingName, $roomNumber, $features)
    {
        $this->conn->beginTransaction();

        $sql = "INSERT INTO roomfeature(buildingName, roomNumber, featureName) VALUES (?, ?, ?)";

        foreach ($features as &$feature) {
            $this->conn->prepare($sql)->execute([$buildingName, $roomNumber, $feature]);
        }

        $this->conn->commit();
    }

    function getResourceIconsForRoom($buildingName, $roomNumber)
    {
        $sql = "SELECT iconCode FROM feature JOIN roomfeature ON feature.featureName = roomfeature.featureName
                WHERE buildingName = ? AND roomNumber = ?";

        return $this->conn->prepare($sql)->execute([$buildingName, $roomNumber])->fetchAll(PDO::FETCH_COLUMN);
    }
}