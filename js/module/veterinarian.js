
$(document).ready(function () {

     var veterinarianTable = initTable("#veterinarian_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "description"},
            {
                data: null,
                render: function (data, type, row, meta) {
                    return "<a class=\"delete_veterinarian\" href=\"\">löschen</a>&nbsp;<a class=\"edit_veterinarian\" href=\"\">bearbeiten</a>";
                }
            }
        ]
    });

    function initClickHandler() {
        $('#veterinarian_table tbody tr').click(function (e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                veterinarianTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('a.edit_veterinarian').click(function(e){
            e.preventDefault();
            initClickHandler();
            //the following gets data for the currently selected row.
            var selectedVeterinarian = veterinarianTable.row($(this).parent().parent()).data();
            var veterinarianId = selectedVeterinarian.id;
            $.get("./templates/veterinarian/add_veterinarian.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Tierarzt \""+selectedVeterinarian.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                    "speichern": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=veterinarian\\UpdateVeterinarian",
                            data: {
                                //get the name currently typed into the name field of the dialog.
                                veterinarian_name: $("#veterinarian_name", self).val(),
                                //the id is immutable.
                                veterinarian_id:veterinarianId,
                                veterinarian_description: $("#veterinarian_description", self).val()
                            },
                            success: function (e) {
                                $(self).dialog("destroy");
                                location.reload();
                            },
                            error: function (e) {
                                var error = JSON.parse(e.responseText);
                                showErrorDialog("Fehler", error.message);
                            }
                        });
                        
                    },
                        "abbrechen": function(){
                            $(this).dialog("destroy");
                        }
                    }
                });
                //prefill all the fields of the form with data from the previously selected
                //row.
                $("#veterinarian_name", content).val(selectedVeterinarian.name);
                $("#veterinarian_id", content).val(selectedVeterinarian.id);
                $("#veterinarian_description", content).val(selectedVeterinarian.description);
            });
        });
        
        $('a.delete_veterinarian').click(function (e) {
            e.preventDefault();
            initClickHandler();
            var data = veterinarianTable.row($(this).parent().parent()).data();
            $("<div>Wollen Sie wirklich " + data.name + " entfernen?</div>").dialog({
                modal: true,
                title: "Tierarzt entfernen?",
                buttons: {
                    "ja": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=veterinarian\\DeleteVeterinarian",
                            data: {veterinarian_id: data.id},
                            success: function (e) {
                                $(self).dialog("destroy");
                                location.reload();
                            },
                            error: function (e) {
                                var error = JSON.parse(e.responseText);
                                showErrorDialog("Fehler", error.message);
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

    initClickHandler();

    $('#add_veterinarian_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/veterinarian/add_veterinarian.htpl", function (data) {
            $(data).dialog({
                title: "Tierarzt hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var veterinarianName = $("#veterinarian_name", this).val();
                        var veterinarianDescription = $("#veterinarian_description", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=veterinarian\\AddVeterinarian",
                            data: {
                                veterinarian_name: veterinarianName,
                                veterinarian_description: veterinarianDescription,
                            },
                            success: function (e) {
                                $(self).dialog("destroy");
                                location.reload();
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
});
    
