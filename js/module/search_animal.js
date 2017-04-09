(function(){
      
    function fillAnimalTable(){
//        location.reload();
//       $('#animal_table').bootstrapTable('refresh');
    }    

    function updateRacesList(speciesId){
        return new Promise(function(resolve, reject){
            $.ajax({
                type: "GET",
                url: "?module=species\\GetRaces",
                data: {"species_id": speciesId},
                success: function(e){
                    fillAnimalTable();
                },
                error: function(e){
                    reject(e);
                }
            });
        });
         $.get(
            "?module=species\\GetRaces", {
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
   
    function renderSpeciesList(speciesResponse){
        var speciesSelect = $("#animal\\[species\\]").empty();
        speciesSelect.append("<option value=\"-1\">--&gt; bitte auswählen &lt;--</option>");
        speciesResponse.data.forEach(function (element) {
            speciesSelect.append("<option value=\"" + element.id + "\">" + element.name + "</option>");
        });
    }
    
    function updateAnimalTable(speciesId, raceId, color, sex){
        return new Promise(function(resolve, reject){
            $.ajax({
                type: "GET",
                url: "?module=animal\\SearchAnimalByFilter",
                data: {"species_id": speciesId,
                    "race_id": raceId,
                    "color":color,
                    "sex":sex
                },
                success: function(e){
                    fillAnimalTable();
                },
                error: function(e){
                    reject(e);
                }
            });
        });
         $.get(
            "?module=animal\\SearchAnimalByFilter", {
                "species_id": speciesId,
                    "race_id": raceId,
                    "sex":sex,
                    "color":color
            },
            function (e) {
                    fillAnimalTable();
            }
        );        
    }
    


$(document).ready(function () {

        var animalTable = FindusUtil.initTable("#animal_table", {
            columns: [
                {data: "id"},
                {data: "name"},
                {data: "age"},
                {
                    data: "state",
                    render: function (data, type, row, meta) {
                            return "<a class=\"edit_animal\" href=\"\">bearbeiten</a>";
                    }
                }
            ]
        });
        
    function initClickHandler() {
        $('#animal_table tbody tr').click(function (e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                animalTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('a.edit_animal').click(function(e){
            e.preventDefault();
            initClickHandler();
            var selectedTherapyType = animalTable.row($(this).parent().parent()).data();
            var animalId = selectedTherapyType.id;
            $.get("./templates/animal/add_animal.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Tier \""+selectedTherapyType.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                    "speichern": function () {
                        FindusUtil.blockUI();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=animal\\AddAnimal",
                            data: {
                                animal_name: $("#animal_name", self).val(),
                                animal_id:animalId,
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
                $("#animal_name", content).val(selectedTherapyType.name);
                $("#animal_id", content).val(selectedTherapyType.id);
            });
        });
    }

       $("#animal\\[species\\]").change(function (event) {
            var selected = parseInt($("#animal\\[species\\]").val(), 10);
            if (selected > 0) {
                FindusUtil.blockUI();
                updateRacesList(selected).then(renderRacesList);
             }
//            FindusUtil.blockUI();
//            updateAnimalTable(parseInt($("#animal\\[species\\]").val(), 10), parseInt($("#animal\\[race\\]").val(), 10),"#animal\\[color\\]","#animal\\[sex\\]");
        });
    
    $("#animal\\[races\\]").change(function (event) {
//            FindusUtil.blockUI();
            updateAnimalTable(parseInt($("#animal\\[species\\]").val(), 10), parseInt($("#animal\\[race\\]").val(), 10),"#animal\\[color\\]","#animal\\[sex\\]");
        });

    $("#animal\\[color\\]").change(function (event) {
//            FindusUtil.blockUI();
            updateAnimalTable(parseInt($("#animal\\[species\\]").val(), 10), parseInt($("#animal\\[race\\]").val(), 10),"#animal\\[color\\]","#animal\\[sex\\]");
        });

    $("#animal\\[sex\\]").change(function (event) {
//            FindusUtil.blockUI();
            updateAnimalTable(parseInt($("#animal\\[species\\]").val(), 10), parseInt($("#animal\\[race\\]").val(), 10),"#animal\\[color\\]","#animal\\[sex\\]");
        });

    initClickHandler();
    
    renderRacesList();

    renderSpeciesList();

    $('#add_animal_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/animal/add_animal.htpl", function (data) {
            $(data).dialog({
                title: "Tier hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        FindusUtil.blockUI();
                        var animalName = $("#animal_name", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=animal\\AddAnimal",
                            data: {
                                animal_name: animalName,
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
                    "abbrechen": function () {
                        $(this).dialog("close").dialog("destroy");
                    }
                }
            });
        });
    });
    });
})();
    