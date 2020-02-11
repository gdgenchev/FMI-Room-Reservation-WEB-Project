<?php
require_once "persistence/reservation/ReservationRepository.php";
require_once "persistence/reservation/ReservationRepositorySQL.php";
require_once "util/DbConnectionCreator.php";

$conn = DbConnectionCreator::createConnection();

$startDateTime = $_GET['startDateTime'];
$endDateTime = $_GET['endDateTime'];

$reservationRepository = new ReservationRepositorySQL($conn);
$availableRooms= $reservationRepository->getAvailableRooms($startDateTime,$endDateTime);
echo (json_encode($availableRooms));

