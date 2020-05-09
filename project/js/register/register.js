const ROOT_DIR = "FMI-Room-Reservation-WEB-Project/project";

$(document).ready(function () {
    fillBuildingsSelect();
    fillFeaturesSelect();
});

$("#features").mousedown(function (e) {
    e.preventDefault();

    var select = this;
    var scroll = select.scrollTop;

    e.target.selected = !e.target.selected;

    setTimeout(() => select.scrollTop = scroll, 0);
    $(select).focus();
}).mousemove(e => e.preventDefault());

function registerRoom() {
    const buildingNamesSelect = document.getElementById("building-names");
    const buildingName = buildingNamesSelect.options[buildingNamesSelect.selectedIndex].value;
    const roomNumber = document.getElementById("room-number").value;
    const type = document.getElementById("type").value;
    const seats = document.getElementById("seats").value;
    const features = $('#features').val();
    const responsiblePerson = document.getElementById("responsible-person").value;

    $.ajax({
        url: "../php/registerRoom.php",
        context: document.body,
        type: "post",
        data: {
            room: JSON.stringify({
                buildingName: buildingName,
                roomNumber: roomNumber,
                type: type,
                seats: seats,
                features: features,
                responsiblePerson: responsiblePerson
            })
        },
        success: function () {
            alert("Успешно добавена стая!");
        },
        statusCode: {
            409: function () {
                alert('Грешка! Стаята вече съществува.');
            }
        }
    });
}
