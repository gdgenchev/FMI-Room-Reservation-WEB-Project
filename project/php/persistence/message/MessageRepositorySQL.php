<?php
require_once "util/DbConnectionCreator.php";

class MessageRepositorySQL implements MessageRepository
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function addMessage($message)
    {
        $buildingName = $message->buildingName;
        $roomNumber = $message->roomNumber;
        $message = $message->message;

        $sql = "INSERT INTO message(buildingName, roomNumber, message) VALUES (?, ?, ?)";

        try {
            $this->conn->prepare($sql)->execute([$buildingName,$roomNumber,$message]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return false;
            } else {
                throw $e;
            }
        }

        return true;
    }

    function getMessagesForRoom($buildingName, $roomNumber)
    {
        $sql = "SELECT message FROM message 
                WHERE buildingName = :buildingName AND roomNumber = :roomNumber";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["buildingName" => $buildingName, "roomNumber" => $roomNumber]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}