<?php
require_once "util/DbConnectionCreator.php";

class BuildingRepositorySQL implements BuildingRepository
{
    private $conn;

    function __construct()
    {
        $this->conn = DbConnectionCreator::createConnection();
    }


    function getBuildingsNames()
    {
        return $this->conn->query('SELECT buildingName FROM building')->fetchAll(PDO::FETCH_COLUMN);
    }
}