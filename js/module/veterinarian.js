
$(document).ready(function () {

     var veterinarianTable = FindusUtil.initTable("#veterinarian_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "description"},
            {
                data: "state",
                orderable: false,
                render: function (data, type, row, meta) {
                    if(data==='DEACTIVE'){
                        return "<a class=\"switch_veterinarianState\" href=\"\">aktivieren</a>";
                    } else {
                        return "<a class=\"switch_veterinarianState\" href=\"\"><img src=\"./images/cancel.png\" title=\"löschen\" alt=\"löschen\"/></a>&nbsp;<a class=\"edit_veterinarian\" href=\"\"><img src=\"./images/toolbar_edit.png\" title=\"bearbeiten\" alt=\"bearbeiten\"/></a>";
                    }
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
            //the following gets data for the currently selected row.
            var selectedVeterinarian = veterinarianTable.row($(this).parent().parent()).data();
            var veterinarianId = selectedVeterinarian.id;
            $.get("./templates/veterinarian/add_veterinarian.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Tierarzt \""+selectedVeterinarian.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                    "speichern": function () {
                        FindusUtil.blockUI();
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
                                FindusUtil.showErrorDialog("Fehler", error.message);
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
        
        $('a.switch_veterinarianState').click(function (e) {
            e.preventDefault();
            var data = veterinarianTable.row($(this).parent().parent()).data();
            if (data.state === 'ACTIVE') {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " deaktivieren?</div>")
                $title = "Tierarzt entfernen?";
            } else {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " reaktivieren?</div>")
                $title = "Tierarzt hinzufügen?";
            }
                $msg.dialog({
                modal: true,
                title: $title,
                buttons: {
                    "ja": function () {
                        FindusUtil.blockUI();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=veterinarian\\SwitchVeterinarianState",
                            data: {veterinarian_id: data.id},
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
                        FindusUtil.blockUI();
                        var veterinarianName = $("#veterinarian_name", this).val();
                        var veterinarianDescription = $("#veterinarian_description", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=veterinarian\\AddVeterinarian",
                            data: {
                                veterinarian_name: veterinarianName,
                                veterinarian_description: veterinarianDescription
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
    
