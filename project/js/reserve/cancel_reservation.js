$(document).ready(function () {
    fillBuildingsSelect();
});

function cancelReservation() {
    const roomNumber = $('#room-number').val();
    const buildingNamesSelect = document.getElementById("building-names");
    const buildingName = buildingNamesSelect.options[buildingNamesSelect.selectedIndex].value;

    const date = $('#date').val();
    const startingTime =  $('#starting-time').val();
    const endingTime =  $('#ending-time').val();

    const reservedFrom = date + " " + startingTime;
    const reservedTo = date + " " + endingTime;

    $.ajax({
        url: "../php/getReservationForRemoval.php",
        context: document.body,
        type: "post",
        data: {
            roomNumber: roomNumber,
            buildingName: buildingName,
            reservedFrom: reservedFrom,
            reservedTo: reservedTo,
        },
        success: function () {
            alert("Reservation is canceled!");
        },
        statusCode: {
            409: function () {
                alert('Error! There is no reservation for the given data.');
            }
        }
    });
}

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
