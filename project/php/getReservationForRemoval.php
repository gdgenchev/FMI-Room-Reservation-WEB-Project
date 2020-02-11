<?php
require_once "persistence/reservation/ReservationRepository.php";
require_once "persistence/reservation/ReservationRepositorySQL.php";
require_once "util/DbConnectionCreator.php";

$roomNumber = $_GET['roomNumber'];
$buildingName = $_GET['buildingName'];
$reservedFrom = $_GET['reservedFrom'];
$reservedTo = $_GET['reservedTo'];


$conn = DbConnectionCreator::createConnection();
$reservationRepository = new ReservationRepositorySQL($conn);
$availableRooms= $reservationRepository->removeReservation($roomNumber,$buildingName,$reservedFrom,$reservedTo);
echo (json_encode($availableRooms));

