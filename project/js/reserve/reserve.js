const ROOT_DIR = "FMI-Room-Reservation-WEB-Project/project";

function getAvailableRooms() {
    const date = $('#date').val();
    const startingTime =  $('#starting-time').val();
    const endingTime =  $('#ending-time').val();


    const reservedFrom = date + " " + startingTime;
    const reservedTo = date + " " + endingTime;

    $.ajax({
        url: "../php/getAvailableRooms.php",
        context: document.body,
        type: "post",
        data: {
            reservedFrom: reservedFrom,
            reservedTo: reservedTo,
        },
        success: function (response) {
            $('.dynamic').remove();
            var reservationForm = $('#reservation-form');
            reservationForm.append(
                '<div class="form-group dynamic">' +
                '  <label>Available Rooms:</label>' +
                '  <div class="input-group">' +
                '    <select id="available-rooms"  class="form-control">' +
                '      <option selected disabled hidden>Choose Room</option>' +
                '  </div>' +
                '</div>');

            var availableRoomsSelect = $('#available-rooms');

            let availableRooms = JSON.parse(response);
            availableRoomsSelect.attr("size", availableRooms.length);
            for (let i = 0; i < availableRooms.length; i++) {
                var option = new Option();
                option.innerHTML = availableRooms[i]["type"] + " " + availableRooms[i]["roomNumber"] + "  "
                    + availableRooms[i]["buildingName"] + " " + availableRooms[i]["features"] + " " + availableRooms[i]["message"];
                option.setAttribute("value", availableRooms[i]['buildingName'] + "," + availableRooms[i]["roomNumber"]);
                availableRoomsSelect.append(option);
            }
            if (availableRooms.length === 0) {
                $('.dynamic').remove();
                alert("Няма свободни стаи за избраното време.");
                return;
            }

            //TODO: This is bad code here I guess. Probably will become better when we switch to React
            reservationForm.append(
                '<div class="form-group dynamic">' +
                '    <label>Reserved By:</label>' +
                '    <div class="input-group">' +
                '        <span class="input-group-prepend">' +
                '            <div class="input-group-text bg-white border-right-0">' +
                '                <i class="fas fa-user"></i>' +
                '            </div>' +
                '        </span>' +
                '        <input id="reservedBy" class="form-control border-left-0" type="text" placeholder="Teacher name">' +
                '    </div>' +
                '</div>');

            reservationForm.append(
                '<div class="form-group dynamic">' +
                '    <label>Course:</label>' +
                '    <div class="input-group">' +
                '        <span class="input-group-prepend">' +
                '            <div class="input-group-text bg-white border-right-0">' +
                '                <i class="fas fa-book-open"></i>' +
                '            </div>' +
                '        </span>' +
                '        <input id="course" class="form-control border-left-0" type="text" placeholder="Course name">' +
                '    </div>' +
                '</div>');

            reservationForm.append('<input class="dynamic" type="button" value="Reserve Room" onclick="reserveRoom()">');
        }
    });
}

function reserveRoom() {
    const date = $('#date').val();
    const startingTime =  $('#starting-time').val();
    const endingTime =  $('#ending-time').val();


    const reservedFrom = date + " " + startingTime;
    const reservedTo = date + " " + endingTime;

    const availableRoomsSelect = document.getElementById('available-rooms');
    const availableRoom = availableRoomsSelect.options[availableRoomsSelect.selectedIndex].value;
    const reservedBy = $('#reservedBy').val();
    const course =$('#course').val();
    const array = availableRoom.split(",");
    const buildingName = array[0];
    const roomNumber = array[1];

    $.ajax({
        url: "../php/reserveRoom.php",
        context: document.body,
        type: "post",
        data: {
            reservation: JSON.stringify({
                reservedFrom: reservedFrom,
                reservedTo: reservedTo,
                buildingName: buildingName,
                roomNumber: roomNumber,
                reservedBy: reservedBy,
                course: course
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


$('#date').datepicker({
    orientation: 'bottom left',
    weekStart: 1,
    daysOfWeekHighlighted: "0,6",
    todayHighlight: true,
    startDate: 'now',
    format: "dd/mm/yyyy",
    autoclose: true
});

$('#starting-time, #ending-time').clockpicker({
    placement: 'bottom',
    default: 'now',
    autoclose: 'true'
});
