<?php
require_once "persistence/room/RoomRepository.php";
require_once "persistence/room/RoomRepositorySQL.php";

require_once "persistence/reservation/ReservationRepository.php";
require_once "persistence/reservation/ReservationRepositorySQL.php";

require_once "util/DbConnectionCreator.php";


header('Content-Type: text/csv; charset=UTF-8');

$importedFile = fopen($_FILES["file"]["tmp_name"], "r");

//skip the first line
fgetcsv($importedFile);

$conn = DbConnectionCreator::createConnection();
//Disable autocommit and execute a transaction for performance improvements in case of huge imports
$conn->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
$conn->beginTransaction();

$roomRepository = new RoomRepositorySQL($conn);
$reservationRepository = new ReservationRepositorySQL($conn);

while (($line = fgetcsv($importedFile, 1000, ";")) !== FALSE) {
    $roomNumber = $line[0];
    $buildingName = $line[1];
    $reservedFrom = $line[2];
    $reservedTo = $line[3];
    $reservedBy = $line[4];
    $course = $line[5];

    $reservation = (object)[
        'roomNumber' => $roomNumber,
        'buildingName' => $buildingName,
        'reservedFrom' => $reservedFrom,
        'reservedTo' => $reservedTo,
        'reservedBy' => $reservedBy,
        'course' => $course,
    ];

    try {
        $result = $reservationRepository->addReservation($reservation);
        if (!$result) {
            echo 'Reservation already exists for ' . implode(" ", $line);
        }
    } catch (PDOException $e) {
        echo 'Failed to import ' . implode(" ", $line) . '. Reason: ' . $e->getMessage();
    }
}

$conn->commit();

fclose($importedFile);

echo "success";