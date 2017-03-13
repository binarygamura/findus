(function(){
    function updateRacesList(speciesId){
        return new Promise(function(resolve, reject){
            $.ajax({
                type: "GET",
                url: "?module=GetRaces",
                data: {"species_id": speciesId},
                success: function(e){
                    resolve(JSON.parse(e));
                },
                error: function(e){
                    reject(e);
                }
            });
        });
         $.get(
            "?module=GetRaces", {
                "species_id": speciesId
            },
            function (e) {
                var parsedData = JSON.parse(e);
                var raceSelect = $("#animal\\[race\\]");
                raceSelect.empty();
                raceSelect.append("<option value=\"-1\">--&gt; bitte auswählen &lt;--</option>");
                parsedData.data.forEach(function (element) {
                    raceSelect.append("<option value=\"" + element.id + "\">" + element.name + "</option>");
                }
            );}
        );
    }

    function renderRacesList(raceslistResponse){
        var raceSelect = $("#animal\\[race\\]");
        raceSelect.empty();
        raceSelect.append("<option value=\"-1\">--&gt; bitte auswählen &lt;--</option>");
        raceslistResponse.data.forEach(function (element) {
            raceSelect.append("<option value=\"" + element.id + "\">" + element.name + "</option>");
        });
    }

    function updateSpeciesList(){
        return new Promise(function(resolve, reject){
            $.ajax({
                type: "GET",
                url: "?module=GetSpecies",
                success: function(e){
                    resolve(JSON.parse(e));
                },
                error: function(e){
                    reject(e);
                }
            });
        });
    }
    
    function renderSpeciesList(speciesResponse){
        var speciesSelect = $("#animal\\[species\\]").empty();
        speciesSelect.append("<option value=\"-1\">--&gt; bitte auswählen &lt;--</option>");
        speciesResponse.data.forEach(function (element) {
            speciesSelect.append("<option value=\"" + element.id + "\">" + element.name + "</option>");
        });
    }

    $(document).ready(function () {
        $("#animal\\[species\\]").change(function (event) {
            var selected = parseInt($("#animal\\[species\\]").val(), 10);
            if (selected > 0) {
                $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                updateRacesList(selected).then(renderRacesList);
            }
        });

        $('#create_button').click(function (e) {
            $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
            $.ajax({
                type: "POST",
                url: "?module=AddAnimal",
                data: $("#add_animal_form").serialize(),
                success: function (e) {
                    var response = JSON.parse(e);
                    $("<div>\n\Tier wurde erfolgreich erfasst und mit der ID <strong>"+response.id+"</strong> ins System eingetragen.</div>").dialog({
                        modal: true,
                        title: "Tier wurde erfasst",
                        buttons: {
                            "okay": function(){
                                $(this).dialog("destroy");
                                location.reload();
                            }
                        }
                    });
                },
                error: function (e) {
                    $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                    $(".error").removeClass("error");
                    var errors = JSON.parse(e.responseText);
                    var errorList = $("#error_list").empty();
                    $.each(errors, function(key, value){
                        $("#animal\\["+key+"\\]").addClass("error");
                        errorList.append("<li>"+value+"</li>");
                    });
                }
            })
            e.preventDefault();
        });

        $('#add_species_button').click(function (e) {
            e.preventDefault();
            $.get("./templates/add_species.htpl", function (data) {
                $(data).dialog({
                    title: "Tierart hinzufügen",
                    modal: true,
                    buttons: {
                        "erstellen": function () {
                            $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                            var speciesName = $("#species_name", this).val();
                            var self = this;
                            $.ajax({
                                type: "POST",
                                url: "?module=AddSpecies",
                                data: {"species_name": speciesName},
                                success: function (e) {
                                    var data = JSON.parse(e);
                                    updateSpeciesList().then(renderSpeciesList).then(function(){
                                        //TODO: dont trigger... just reload the list with en empty array.
                                        $("#animal\\[species\\]").val(data.id).trigger("change");
                                    });
                                    $(self).dialog("destroy");
                                },
                                error: function (e) {
                                    var error = JSON.parse(e.responseText);
                                    showErrorDialog("Fehler", error.message);
                                }
                            });
                        },
                        "abbrechen": function () {
                            $(this).dialog("close").dialog("destroy");
                        }
                    }
                });
            });
        });

        $('#add_race_button').click(function (e) {
            e.preventDefault();
            var currentSpecies = $("#animal\\[species\\]").val();
            if(currentSpecies >= 0) {
                $.get("./templates/add_race.htpl", function (data) {
                    $(data).dialog({
                        title: "Tierrasse hinzufügen",
                        modal: true,
                        buttons: {
                            "erstellen": function () {
                                $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                                var self = this;
                                $.ajax({
                                    type: "POST",
                                    url: "?module=AddRace",
                                    data: {
                                        species_id: currentSpecies,
                                        race_name: $("#race_name", self).val()
                                    },
                                    success: function (response) {
                                        var data = JSON.parse(response);
                                        $(self).dialog("destroy");
                                        updateRacesList(currentSpecies).then(renderRacesList).then(function(){
                                            $("#animal\\[race\\]").val(data.id);
                                        });
                                    },
                                    error: function (e) {
                                        var error = JSON.parse(e.responseText);
                                        showErrorDialog("Fehler", error.message);
                                    }});
                            },
                            "abbrechen": function () {
                                $(this).dialog("close").dialog("destroy");
                            }
                        }
                    });
                });
            }
        });
    });
})();