const ROOT_DIR = "FMI-Room-Reservation-WEB-Project/project";

$.ajax({
    url: "php/getBuildings.php",
    context: document.body,
    success: function (response) {
        var buildingsSelect = document.getElementById("building-names");
        let buildingsNames = JSON.parse(response);
        for (let i = 0; i < buildingsNames.length; i++) {
            buildingsSelect.options[buildingsSelect.options.length] = new Option(buildingsNames[i]);
        }
    }
});





function addMessage() {
    const buildingNamesSelect = document.getElementById("building-names");
    const buildingName = buildingNamesSelect.options[buildingNamesSelect.selectedIndex].value;
    const roomNumber = document.getElementById("room-number").value;
    const message = document.getElementById("message").value;

    $.ajax({
        url: "php/messageAboutRoom.php",
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
            alert("Успешно добавено съобщение!");
        },
        statusCode: {
            409: function () {
                alert('Съобщението за тази зала съществува.');
            }
        }
    });
}