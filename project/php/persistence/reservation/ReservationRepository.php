<?php

interface ReservationRepository{
    function getAvailableRooms($reservedFrom, $reservedTo);
    function removeReservation($roomNumber, $buildingName, $reservedFrom, $reservedTo);
    function addReservation($reservation);
}
