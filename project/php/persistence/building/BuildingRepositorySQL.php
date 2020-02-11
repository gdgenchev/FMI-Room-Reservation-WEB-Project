<?php
class BuildingRepositorySQL implements BuildingRepository
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }


    function getBuildingsNames()
    {
        return $this->conn->query('SELECT buildingName FROM building')->fetchAll(PDO::FETCH_COLUMN);
    }
}