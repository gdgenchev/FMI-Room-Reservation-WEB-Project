function displaySchedule() {
    $("#search-form").submit(function () {
        var info = $("#info").val().split(" ");
        var obj = {};

        for (var i = 0; i < info.length; i++) {
            obj[i.toString()] = info[i];
        }

        $("#schedule-table").load("../php/getInfo.php", obj);

        return false;
    });
};