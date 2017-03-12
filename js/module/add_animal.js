
function updateRacesList(speciesId){
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

function updateSpeciesList(){
    $.get(
        "?module=GetSpecies", 
        {},
        function (e) {
            var parsedData = JSON.parse(e);
            var speciesSelect = $("#animal\\[species\\]").empty();
            speciesSelect.append("<option value=\"-1\">--&gt; bitte auswählen &lt;--</option>");
            parsedData.data.forEach(function (element) {
                speciesSelect.append("<option value=\"" + element.id + "\">" + element.name + "</option>");
            }
        );}
    );
}

$(document).ready(function () {
    $("#animal\\[species\\]").change(function (event) {
        var selected = parseInt($("#animal\\[species\\]").val(), 10);
        if (selected > 0) {
            $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
            updateRacesList(selected);
        }
    });

    $('#create_button').click(function (e) {
        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
        $.ajax({
            type: "POST",
            url: "?module=Employee&subModule=AddAnimal",
            data: $("#add_animal_form").serialize(),
            success: function (e) {
                $("<div>Tier wurde erfolgreich erfasst.</div>").dialog({
                    modal: true,
                    title: "Tier wurde erfasst.",
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
                                updateSpeciesList();
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
                                success: function (e) {
                                    $(self).dialog("destroy");
                                    updateRacesList(currentSpecies);
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