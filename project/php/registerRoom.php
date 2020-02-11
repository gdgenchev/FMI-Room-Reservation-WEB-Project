<?php
require_once "persistence/room/RoomRepository.php";
require_once "persistence/room/RoomRepositorySQL.php";
require_once "util/DbConnectionCreator.php";

$conn = DbConnectionCreator::createConnection();

$room = json_decode($_POST['room']);

$roomRepository = new RoomRepositorySQL($conn);

if ($roomRepository->addRoom($room) == true)
{
    http_response_code(200);
}
else
{
    http_response_code(409);
}
