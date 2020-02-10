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

// function getRoomSchedule() {
//     const roomNumber = document.getElementById('roomNumber').value;
//     const buildingName = document.getElementById('buildingName').value;
//     $.ajax({
//         url: "php/getRoomSchedule.php",
//         context: document.body,
//         type: "get",
//         data: {
//             roomNumber: roomNumber,
//             buildingName: buildingName
//         },
//         success: function (response) {
//             const scheduleDiv = document.getElementById('schedule-div');
//             //scheduleDiv.innerHTML = '<select id=\"schedule-select\"></select>';
//             // var select = document.getElementById("schedule-select");
//             let places = JSON.parse(response);
//             // select.setAttribute("size", places.length);
//             // for (let i = 0; i < places.length; i++) {
//             //     var option = new Option();
//             //     option.innerHTML = places[i]["roomNumber"] + "  " + places[i]["buildingName"] + places[i]["reservedFrom"]
//             //         + places[i]["reservedTo"] + places[i]["personWhoReserved"] + places[i]["subject"];
//             //     option.setAttribute("value", places[i]["roomNumber"]);
//             //     select.options[select.options.length] = option;
//             //}
//
// /*
//             var table = document.createElement('table');
//             table.setAttribute('border','1');
//             table.setAttribute('width','100%');
//             table.setAttribute('border-collapse', 'collapse');
//
//             var HTML = "<table border=1 width=100%><tr>";
//             HTML += "<br><br>";
//             HTML += "<table style= \"border:1px solid black; border-collapse: collapse; width: 100%; text-align: center;\" id=\"tableWithData\">";
//             HTML += "<tr>";
//             HTML += "<th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Room</th>";
//             HTML += "<th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Building</th>";
//             HTML += "<th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">From</th>";
//             HTML += "<th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">To</th>";
//             HTML += "<th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Person</th>";
//             HTML += "<th style=\"border:1px solid black; background-color: #4CAF50; color: white;\">Subject</th>";
//             HTML += "</tr>";
//             for (let i = 0; i < places.length; i++) {
//                 document.getElementById('roomNumber') = places[i]['roomNumber'];
//                 HTML += "<tr style=\"border:1px solid black\">";
//                 HTML += "<td id = \"roomNumber\" style=\"border:1px solid black\">  </td>";
//                 HTML += "<td id = \"buildingName\" style=\"border:1px solid black\">  </td>";
//                 HTML += "<td id = \"reservedFrom\" style=\"border:1px solid black\">  </td>";
//                 HTML += "<td id = \"reservedTo\"style=\"border:1px solid black\">  </td>";
//                 HTML += "<td id = \"personWhoReserved\"style=\"border:1px solid black\">  </td>";
//                 HTML +="<td id = \"subject\" style=\"border:1px solid black\">   </td>";
//                 HTML += "</tr>";
//             }
//             HTML += "</table>";
//             scheduleDiv.innerHTML = HTML;
//
//         }
//     });
//
//  */
// }


$("#features-select").mousedown(function (e) {
    e.preventDefault();

    var select = this;
    var scroll = select.scrollTop;

    e.target.selected = !e.target.selected;

    setTimeout(() => select.scrollTop = scroll, 0);
    $(select).focus();
}).mousemove(e => e.preventDefault());

