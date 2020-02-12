const ROOT_DIR = "FMI-Room-Reservation-WEB-Project/project";


function getAvailableRooms() {
    const reservedFrom = document.getElementById('reservedFrom').value;
    const reservedTo = document.getElementById('reservedTo').value;

    $.ajax({
        url: "php/getAvailableRooms.php",
        context: document.body,
        type: "post",
        data: {
            reservedFrom: reservedFrom,
            reservedTo: reservedTo,
        },
        success: function (response) {
            //const availableRoomsSelect = document.getElementById('available-rooms');
            const availableRoomsSelect = $('#available-rooms');
            availableRoomsSelect.empty();
            let availableRooms = JSON.parse(response);
            availableRoomsSelect.attr("size", availableRooms.length);
            for (let i = 0; i < availableRooms.length; i++) {
                var option = new Option();
                option.innerHTML = availableRooms[i]["type"] + " " + availableRooms[i]["roomNumber"] + "  " + availableRooms[i]["buildingName"];
                option.setAttribute("value", availableRooms[i]['buildingName'] + "," + availableRooms[i]["roomNumber"]);
                availableRoomsSelect.append(option);
            }
            if (availableRooms.length === 0) {
                alert("Няма свободни стаи за избраното време.");
                return;
            }

            $('.dynamic').remove();
            $('#personWhoReserved').remove();
            $('#subject').remove();
            $('#subject').remove();

            const reservationForm = $('#reservation-form');
            reservationForm.append('<label class="dynamic">На име:</label> <input type="text" id="personWhoReserved">');
            reservationForm.append('<label class="dynamic">Предмет:</label> <input type="text" id="subject">');
            reservationForm.append('<input class="dynamic" type="button" value="Добави" onclick="reserveRoom()">')
        }
    });
}

function removeReservation() {
    const roomNumber = document.getElementById('roomNumber').value;
    const buildingName = document.getElementById('buildingName').value;
    const reservedFrom = document.getElementById('reservedFrom').value;
    const reservedTo = document.getElementById('reservedTo').value;

    $.ajax({
        url: "php/getReservationForRemoval.php",
        context: document.body,
        type: "post",
        data: {
            roomNumber: roomNumber,
            buildingName: buildingName,
            reservedFrom: reservedFrom,
            reservedTo: reservedTo,
        },
        success: function (response) {
            const reservationForm = $('#removal-form');
            reservationForm.append('<p> Резервацията е премахната.</p>');
        }
    });
}

function reserveRoom() {
    const reservedFrom = document.getElementById("reservedFrom").value;
    const reservedTo = document.getElementById("reservedTo").value;
    const availableRoomsSelect = document.getElementById("available-rooms");
    const availableRoom = availableRoomsSelect.options[availableRoomsSelect.selectedIndex].value;
    const personWhoReserved = document.getElementById("personWhoReserved").value;
    const subject = document.getElementById("subject").value;
    const array = availableRoom.split(",");
    const buildingName = array[0];
    const roomNumber = array[1];

    $.ajax({
        url: "php/reserveRoom.php",
        context: document.body,
        type: "post",
        data: {
            reservation: JSON.stringify({
                reservedFrom: reservedFrom,
                reservedTo: reservedTo,
                buildingName: buildingName,
                roomNumber: roomNumber,
                personWhoReserved: personWhoReserved,
                subject: subject
            })
        },
        success: function () {
            alert("Успешно добавена резервация!");
        },
        statusCode: {
            409: function () {
                alert('Грешка! Резервацията вече съществува.');
            }
        }
    });
}

$("#features-select").mousedown(function (e) {
    e.preventDefault();

    var select = this;
    var scroll = select.scrollTop;

    e.target.selected = !e.target.selected;

    setTimeout(() => select.scrollTop = scroll, 0);
    $(select).focus();
}).mousemove(e => e.preventDefault());

