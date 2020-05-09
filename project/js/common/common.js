function fillBuildingsSelect() {
    function fillBuildingsSelectFromSessionStorage() {
        var buildingsSelect = document.getElementById("building-names");
        let buildingsNames = JSON.parse(sessionStorage.getItem('buildings'));
        if (buildingsNames !== null) {
            for (let i = 0; i < buildingsNames.length; i++) {
                buildingsSelect.options[buildingsSelect.options.length] = new Option(buildingsNames[i]);
            }
        }
    }

    if (sessionStorage.getItem('buildings') === null) {
        $.ajax({
            url: "../php/getBuildings.php",
            context: document.body,
            success: function (response) {
                sessionStorage.setItem('buildings', response);
                fillBuildingsSelectFromSessionStorage();
            }
        });
    } else {
        fillBuildingsSelectFromSessionStorage();
    }
}

function fillFeaturesSelect() {
    function fillFeaturesSelectFromSessionStorage() {
        var featuresSelect = document.getElementById("features");
        let features = JSON.parse(sessionStorage.getItem('features'));
        featuresSelect.setAttribute("size", features.length);
        for (let i = 0; i < features.length; i++) {
            var option = new Option();
            option.innerHTML = features[i]["iconCode"] + " " + features[i]["featureName"];
            option.setAttribute("value", features[i]["featureName"]);
            featuresSelect.options[featuresSelect.options.length] = option;
        }
    }

    if (sessionStorage.getItem('features') === null) {
        $.ajax({
            url: "../php/getFeatures.php",
            context: document.body,
            success: function (response) {
                sessionStorage.setItem('features', response);
                fillFeaturesSelectFromSessionStorage();
            }
        });
    } else {
        fillFeaturesSelectFromSessionStorage();
    }
}
