$('.custom-file-input').on('change', function () {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});

$(document).ready(function () {

    $("#search_button").click(function () {
        $("#myform").submit(function () {
            var info = $("#info").val().split(" ");
            var obj = {};
            for (var i = 0; i < info.length; i++) {
                obj[i.toString()] = info[i];
            }
            $("#mytable").load("../php/getInfo.php", obj);
            return false;
        });
    });

    $("#import_button").click(function () {
        $("#myform").submit(function () {
            var file = $("#imported_file")[0].files[0];
            var extension = $("#imported_file").val().split('.').pop();
            console.log(extension);
            if (document.getElementById("imported_file").files[0].size > 0 && extension.localeCompare("csv") === 0) {
                var formData = new FormData();
                formData.append('file', file);
                $.ajax({
                    type: "POST",
                    url: "../php/import.php",
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: formData,

                    success: function (response) {
                        if (response === "success") {
                            alert("File is successfully uploaded!");
                        } else {
                            alert(response);
                        }
                    }
                });
            }
            return false;
        });
    });

    $("#export_button").click(function () {
        $("#myform").submit(function () {

            $.ajax({
                type: "POST",
                url: "../php/export.php"
            });

            return false;
        });
    });

});