const ROOT_DIR = "FMI-Room-Reservation-WEB-Project/project";

$(document).ready(function () {
    fillBuildingsSelect();
});

function addMessage() {
    const buildingNamesSelect = document.getElementById("building-names");
    const buildingName = buildingNamesSelect.options[buildingNamesSelect.selectedIndex].value;
    const roomNumber = document.getElementById("room-number").value;
    const message = document.getElementById("message").value;

    $.ajax({
        url: "../php/messageForRoom.php",
        context: document.body,
        type: "post",
        data: {
            message: JSON.stringify({
                buildingName: buildingName,
                roomNumber: roomNumber,
                message: message
            })
        },
        success: function () {
            alert("Successfully added message!");
        },
        statusCode: {
            409: function () {
                alert('The message for this room already exists');
            }
        }
    });
}