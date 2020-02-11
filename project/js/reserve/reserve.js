const ROOT_DIR = "FMI-Room-Reservation-WEB-Project/project";


function getAvailableRooms() {
    const startDateTime = document.getElementById('startDateTime').value;
    const endDateTime = document.getElementById('endDateTime').value;
    // const reservedBy = document.getElementById('reservedBy').value;
    // const subject = document.getElementById('subject').value;
    $.ajax({
        url: "php/getAvailableRooms.php",
        context: document.body,
        type: "get",
        data: {
            startDateTime: startDateTime,
            endDateTime: endDateTime,
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
                option.setAttribute("value", availableRooms[i]["roomNumber"]);
                availableRoomsSelect.append(option);
            }
            if (availableRooms.length === 0) {
                alert("Няма свободни стаи за избраното време.");
                return;
            }
            const reservationForm = $('#reservation-form');
            reservationForm.append('<br><br>');
            reservationForm.append('На име: <input type="text" id="reservedBy">');
            reservationForm.append('Предмет: <input type="text" id="subject">');
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
        type: "get",
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

$("#features-select").mousedown(function (e) {
    e.preventDefault();

    var select = this;
    var scroll = select.scrollTop;

    e.target.selected = !e.target.selected;

    setTimeout(() => select.scrollTop = scroll, 0);
    $(select).focus();
}).mousemove(e => e.preventDefault());

