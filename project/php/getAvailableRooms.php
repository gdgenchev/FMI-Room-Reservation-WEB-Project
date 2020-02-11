<?php
require_once "persistence/reservation/ReservationRepository.php";
require_once "persistence/reservation/ReservationRepositorySQL.php";

$startDateTime = $_GET['startDateTime'];
$endDateTime = $_GET['endDateTime'];

$reservationRepository = new ReservationRepositorySQL();
$availableRooms= $reservationRepository->getAvailableRooms($startDateTime,$endDateTime);
echo (json_encode($availableRooms));

