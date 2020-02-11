<?php
require_once "util/DbConnectionCreator.php";

class FeatureRepositorySQL implements FeatureRepository
{
    private $conn;

    function __construct()
    {
        $this->conn = DbConnectionCreator::createConnection();
    }


    function getResources()
    {
        return $this->conn->query('SELECT * FROM feature')->fetchAll(PDO::FETCH_ASSOC);
    }
}