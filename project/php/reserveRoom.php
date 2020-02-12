<?php
require_once "persistence/reservation/ReservationRepository.php";
require_once "persistence/reservation/ReservationRepositorySQL.php";
require_once "util/DbConnectionCreator.php";

$conn = DbConnectionCreator::createConnection();

$reservation = json_decode($_POST['reservation']);

$reservationRepository = new ReservationRepositorySQL($conn);

if ($reservationRepository->addReservation($reservation) == true)
{
    http_response_code(200);
}
else
{
    http_response_code(409);
}
