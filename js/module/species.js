
$(document).ready(function () {

    var speciesTable = FindusUtil.initTable('#species_table');

    var racesTable = FindusUtil.initTable("#races_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {
                data: null,
                orderable: false,
                render: function (data, type, row, meta) {
                    return "<a class=\"delete_race\" href=\"\"><img src=\"./images/cancel.png\" title=\"löschen\" alt=\"löschen\"/></a>&nbsp;<a class=\"rename_race\" href=\"\"><img src=\"./images/toolbar_edit.png\" title=\"umbenennen\" alt=\"umbenennen\"/></a>";
                }
            }
        ]
    });

    function fillRacesTables(speciedId) {
        $.get(
            "?module=species\\GetRaces",{
                "species_id": speciedId
            }, 
            function (e) {
                var parsedData = JSON.parse(e);
                racesTable.clear();
                racesTable.rows.add(parsedData.data);
                racesTable.draw();
                initClickHandler();
            }
        );
    }

    function initClickHandler() {
        $('#races_table tbody tr').click(function (e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                racesTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('a.rename_race').click(function(e){
            e.preventDefault();
            var selectedRace = racesTable.row($(this).parent().parent()).data();
            var raceId = selectedRace.id;
            $.get("./templates/species/add_race.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Tierrasse \""+selectedRace.name+"\" umbenennen",
                    modal: true,
                    buttons: {
                        "umbenennen": function(){
                        FindusUtil.blockUI();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=species\\UpdateRace",
                            data: {
                                //get the name currently typed into the name field of the dialog.
                                race_name: $("#race_name", self).val(),
                                //the id is immutable.
                                race_id:raceId
                            },
                            success: function (e) {
                                $(self).dialog("destroy");
                                location.reload();
                            },
                            error: function (e) {
                                var error = JSON.parse(e.responseText);
                                FindusUtil.showErrorDialog("Fehler", error.message);
                            }
                        });
                            
                        },
                        "abbrechen": function(){
                            $(this).dialog("destroy");
                        }
                    }
                });
                $("#race_name", content).val(selectedRace.name);
            });
        });
        
        $('a.delete_race').click(function (e) {
            e.preventDefault();
            var data = racesTable.row($(this).parent().parent()).data();
            $("<div>Wollen Sie wirklich " + data.name + " entfernen?</div>").dialog({
                modal: true,
                title: "Tierrasse entfernen?",
                buttons: {
                    "ja": function () {
                        FindusUtil.blockUI();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=species\\DeleteRace",
                            data: {"race_id": data.id},
                            success: function (e) {
                                $(self).dialog("destroy");
                                var speciesData = speciesTable.row(".selected").data();
                                fillRacesTables(speciesData[0]);
                            },
                            error: function (e) {
                                var error = JSON.parse(e.responseText);
                                FindusUtil.showErrorDialog("Fehler", error.message);
                            }
                        });
                    },
                    "nein": function () {
                        $(this).dialog("destroy");
                    }
                }
            });
        });
    }

    $('#species_table tbody tr').click(function (e) {
        var data = speciesTable.row(this).data();
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            speciesTable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            FindusUtil.blockUI();
            fillRacesTables(data[0]);
        }
    });
    initClickHandler();

    $('#add_race_button').click(function (e) {
        e.preventDefault();
        var currentSpecies = speciesTable.row(".selected").data();
        if (currentSpecies) {
            $.get("./templates/species/add_race.htpl", function (data) {
                $(data).dialog({
                    title: "Tierrasse hinzufügen",
                    modal: true,
                    buttons: {
                        "erstellen": function () {
                            FindusUtil.blockUI();
                            var self = this;
                            $.ajax({
                                type: "POST",
                                url: "?module=species\\AddRace",
                                data: {
                                    species_id: currentSpecies[0],
                                    race_name: $("#race_name", self).val()
                                },
                                success: function (e) {
                                    fillRacesTables(currentSpecies[0]);
                                    $(self).dialog("destroy");


                                },
                                error: function (e) {
                                    var error = JSON.parse(e.responseText);
                                    FindusUtil.showErrorDialog("Fehler", error.message);
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

    $('#add_species_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/species/add_species.htpl", function (data) {
            $(data).dialog({
                title: "Tierart hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        FindusUtil.blockUI();
                        var speciesName = $("#species_name", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=species\\AddSpecies",
                            data: {"species_name": speciesName},
                            success: function (e) {
                                $(self).dialog("destroy");
                                location.reload();
                            },
                            error: function (e) {
                                var error = JSON.parse(e.responseText);
                                FindusUtil.showErrorDialog("Fehler", error.message);
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
});