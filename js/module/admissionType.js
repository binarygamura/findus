
$(document).ready(function () {

     var admissionTypeTable = initTable("#admissionType_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "description"},
            {
                data: "state",
                render: function (data, type, row, meta) {
                    if(data==='DEACTIVE'){
                        return "<a class=\"switch_admissionTypeState\" href=\"\">aktivieren</a>";
                    } else {
                        return "<a class=\"switch_admissionTypeState\" href=\"\">entfernen</a>&nbsp;<a class=\"edit_admissionType\" href=\"\">bearbeiten</a>";
                    }
                }
            }
        ]
    });

    function initClickHandler() {
        $('#admissionType_table tbody tr').click(function (e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                admissionTypeTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('a.edit_admissionType').click(function(e){
            e.preventDefault();
            initClickHandler();
            //the following gets data for the currently selected row.
            var selectedAdmissionType = admissionTypeTable.row($(this).parent().parent()).data();
            var admissionTypeId = selectedAdmissionType.id;
            $.get("./templates/admission/add_admissionType.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Eingangsart \""+selectedAdmissionType.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                    "speichern": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=admission\\UpdateAdmissionType",
                            data: {
                                //get the name currently typed into the name field of the dialog.
                                admissionType_name: $("#admissionType_name", self).val(),
                                //the id is immutable.
                                admissionType_id:admissionTypeId,
                                admissionType_description: $("#admissionType_description", self).val()
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
                $("#admissionType_name", content).val(selectedAdmissionType.name);
                $("#admissionType_id", content).val(selectedAdmissionType.id);
                $("#admissionType_description", content).val(selectedAdmissionType.description);
            });
        });
        
        $('a.switch_admissionTypeState').click(function (e) {
            e.preventDefault();
            initClickHandler();
            var data = admissionTypeTable.row($(this).parent().parent()).data();
            if (data.state === 'ACTIVE') {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " deaktivieren?</div>")
                $title = "Eingangsart entfernen?"
            } else {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " reaktivieren?</div>")
                $title = "Eingangsart hinzufügen?"
            }
                $msg.dialog({
                modal: true,
                title: $title,
                buttons: {
                    "ja": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=admission\\SwitchAdmissionTypeState",
                            data: {admissionType_id: data.id},
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

    $('#add_admissionType_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/admission/add_admissionType.htpl", function (data) {
            $(data).dialog({
                title: "Eingangsart hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var admissionTypeName = $("#admissionType_name", this).val();
                        var admissionTypeDescription = $("#admissionType_description", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=admission\\AddAdmissionType",
                            data: {
                                admissionType_name: admissionTypeName,
                                admissionType_description: admissionTypeDescription,
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
    
