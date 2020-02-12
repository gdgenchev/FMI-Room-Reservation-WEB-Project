<?php
require_once "persistence/reservation/ReservationRepository.php";
require_once "persistence/reservation/ReservationRepositorySQL.php";
require_once "util/DbConnectionCreator.php";

$conn = DbConnectionCreator::createConnection();

$reservedFrom = $_POST['reservedFrom'];
$reservedTo = $_POST['reservedTo'];

$reservationRepository = new ReservationRepositorySQL($conn);
$availableRooms= $reservationRepository->getAvailableRooms($reservedFrom,$reservedTo);
echo (json_encode($availableRooms));

