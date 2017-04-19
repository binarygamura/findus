
$(document).ready(function () {

     var admissionTypeTable = FindusUtil.initTable("#admissionType_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "description"},
            {data: "spinner"},
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
            //the following gets data for the currently selected row.
            var selectedAdmissionType = admissionTypeTable.row($(this).parent().parent()).data();
            var admissionTypeId = selectedAdmissionType.id;
            $.get("./templates/admission/add_admissionType.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Eingangsart \""+selectedAdmissionType.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                        "speichern": function () {
                            FindusUtil.blockUI();
                            var self = this;
                            var data = {
                                //get the name currently typed into the name field of the dialog.
                                admissionType_name: $("#admissionType_name", self).val(),
                                //the id is immutable.
                                admissionType_id: admissionTypeId,
                                admissionType_description: $("#admissionType_description", self).val(),
    // TODO Fred anzeigen des Wertes
                                admissionType_spinner: $("#admissionType_spinner", self).is(':checked')
                            };
                            $.ajax({
                                type: "POST",
                                url: "?module=admission\\UpdateAdmissionType",
                                data: data,
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
                $("#admissionType_name", content).val(selectedAdmissionType.name);
                $("#admissionType_id", content).val(selectedAdmissionType.id);
                $("#admissionType_spinner", content).prop('checked', selectedAdmissionType.spinner === "1" ? true : false);
                $("#admissionType_description", content).val(selectedAdmissionType.description);
                console.log(selectedAdmissionType);
            });
        });
        
        $('a.switch_admissionTypeState').click(function (e) {
            e.preventDefault();
            initClickHandler();
            var data = admissionTypeTable.row($(this).parent().parent()).data();
            if (data.state === 'ACTIVE') {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " deaktivieren?</div>")
                $title = "Eingangsart entfernen?";
            } else {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " reaktivieren?</div>")
                $title = "Eingangsart hinzufügen?";
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
                            url: "?module=admission\\SwitchAdmissionTypeState",
                            data: {admissionType_id: data.id},
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

    $('#add_admissionType_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/admission/add_admissionType.htpl", function (data) {
            $(data).dialog({
                title: "Eingangsart hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        FindusUtil.blockUI();
                        var admissionTypeName = $("#admissionType_name", this).val();
                        var admissionTypeDescription = $("#admissionType_description", this).val();
                        var admissionTypeSpinner = $("#admissionType_spinner", this).is(":checked");
                        console.log(admissionTypeSpinner);
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=admission\\AddAdmissionType",
                            data: {
                                admissionType_name: admissionTypeName,
                                admissionType_description: admissionTypeDescription,
                                admissionType_spinner: admissionTypeSpinner
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
    
