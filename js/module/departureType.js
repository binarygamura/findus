
$(document).ready(function () {

     var departureTypeTable = FindusUtil.initTable("#departureType_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "description"},
            {
                data: "state",
                orderable: false,
                render: function (data, type, row, meta) {
                    if(data==='DEACTIVE'){
                        return "<a class=\"switch_departureTypeState\" href=\"\"><img src=\"./images/accept_button.png\" title=\"aktivieren\" alt=\"aktivieren\" /></a>";
                    } else {
                        return "<a class=\"switch_departureTypeState\" href=\"\"><img src=\"./images/cancel.png\" title=\"deaktivieren\" alt=\"deaktivieren\"/></a>&nbsp;<a class=\"edit_departureType\" href=\"\"><img src=\"./images/toolbar_edit.png\" title=\"bearbeiten\" alt=\"bearbeiten\"/></a>";
                    }
                }
            }
        ]
    });

    function initClickHandler() {
        $('#departureType_table tbody tr').click(function (e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                departureTypeTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('a.edit_departureType').click(function(e){
            e.preventDefault();
            //the following gets data for the currently selected row.
            var selectedDepartureType = departureTypeTable.row($(this).parent().parent()).data();
            var departureTypeId = selectedDepartureType.id;
            $.get("./templates/departure/add_departureType.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Abgangsart \""+selectedDepartureType.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                        "speichern": function () {
                            FindusUtil.blockUI();
                            var self = this;
                            var data = {
                                //get the name currently typed into the name field of the dialog.
                                departureType_name: $("#departureType_name", self).val(),
                                //the id is immutable.
                                departureType_id: departureTypeId,
                                departureType_description: $("#departureType_description", self).val(),
                            };
                            $.ajax({
                                type: "POST",
                                url: "?module=departure\\UpdateDepartureType",
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
                $("#departureType_name", content).val(selectedDepartureType.name);
                $("#departureType_id", content).val(selectedDepartureType.id);
                $("#departureType_description", content).val(selectedDepartureType.description);
            });
        });
        
        $('a.switch_departureTypeState').click(function (e) {
            e.preventDefault();
            var data = departureTypeTable.row($(this).parent().parent()).data();
            if (data.state === 'ACTIVE') {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " deaktivieren?</div>")
                $title = "Abgangsart entfernen?";
            } else {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " reaktivieren?</div>")
                $title = "Abgangsart hinzufügen?";
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
                            url: "?module=departure\\SwitchDepartureTypeState",
                            data: {departureType_id: data.id},
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

    $('#add_departureType_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/departure/add_departureType.htpl", function (data) {
            $(data).dialog({
                title: "Abgangsart hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        FindusUtil.blockUI();
                        var departureTypeName = $("#departureType_name", this).val();
                        var departureTypeDescription = $("#departureType_description", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=departure\\AddDepartureType",
                            data: {
                                departureType_name: departureTypeName,
                                departureType_description: departureTypeDescription,
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
    
