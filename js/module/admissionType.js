
$(document).ready(function () {

     var admissionTypeTable = initTable("#admissionType_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "description"},
            {
                data: null,
                render: function (data, type, row, meta) {
                    return "<a class=\"delete_admissionType\" href=\"\">löschen</a>&nbsp;<a class=\"edit_admissionType\" href=\"\">bearbeiten</a>";
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
            var selectedAdmissionType = admissionTypeTable.row($(this).parent().parent()).data();
            var admissionTypeId = selectedAdmissionType.id;
            var admissionTypeName = selectedAdmissionType.name;
            var admissionTypeDescription = selectedAdmissionType.description;
            ////TODO: FRED! bitte . danke...
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
                                admissionType_name: admissionTypeName,
                                admissionType_id:admissionTypeId,
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
                        "abbrechen": function(){
                            $(this).dialog("destroy");
                        }
                    }
                });
                $("#admissionType_name", content).val(selectedAdmissionType.name);
                $("#admissionType_id", content).val(selectedAdmissionType.id);
                $("#admissionType_description", content).val(selectedAdmissionType.description);
            });
        });
        
        $('a.delete_admissionType').click(function (e) {
            e.preventDefault();
            initClickHandler();
            var data = admissionTypeTable.row($(this).parent().parent()).data();
            $("<div>Wollen Sie wirklich " + data.name + " entfernen?</div>").dialog({
                modal: true,
                title: "Eingangsart entfernen?",
                buttons: {
                    "ja": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=admission\\DeleteAdmissionType",
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
    