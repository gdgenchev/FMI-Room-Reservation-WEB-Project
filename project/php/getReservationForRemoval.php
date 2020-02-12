<?php
require_once "persistence/reservation/ReservationRepository.php";
require_once "persistence/reservation/ReservationRepositorySQL.php";
require_once "util/DbConnectionCreator.php";

$roomNumber = $_POST['roomNumber'];
$buildingName = $_POST['buildingName'];
$reservedFrom = $_POST['reservedFrom'];
$reservedTo = $_POST['reservedTo'];


$conn = DbConnectionCreator::createConnection();
$reservationRepository = new ReservationRepositorySQL($conn);
$availableRooms= $reservationRepository->removeReservation($roomNumber,$buildingName,$reservedFrom,$reservedTo);
echo (json_encode($availableRooms));

