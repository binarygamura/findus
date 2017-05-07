
$(document).ready(function () {

     var therapyTypeTable = FindusUtil.initTable("#therapyType_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "description"},
            {
                orderable: false,
                data: "state",
                render: function (data, type, row, meta) {
                    if(data==='DEACTIVE'){
                        return "<a class=\"switch_therapyTypeState\" href=\"\">aktivieren</a>";
                    } else {
                        return "<a class=\"switch_therapyTypeState\" href=\"\"><img src=\"./images/cancel.png\" title=\"löschen\" alt=\"löschen\"/></a>&nbsp;<a class=\"edit_therapyType\" href=\"\"><img src=\"./images/toolbar_edit.png\" title=\"bearbeiten\" alt=\"bearbeiten\"/></a>";
                    }
                }
            }
        ]
    });

    function initClickHandler() {
        $('#therapyType_table tbody tr').click(function (e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                therapyTypeTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('a.edit_therapyType').click(function(e){
            e.preventDefault();
            var selectedTherapyType = therapyTypeTable.row($(this).parent().parent()).data();
            var therapyTypeId = selectedTherapyType.id;
            $.get("./templates/therapy/add_therapyType.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Behandlungsart \""+selectedTherapyType.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                    "speichern": function () {
                        FindusUtil.blockUI();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=therapy\\UpdateTherapyType",
                            data: {
                                therapyType_name: $("#therapyType_name", self).val(),
                                therapyType_id:therapyTypeId,
                                therapyType_description: $("#therapyType_description", self).val()
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
                $("#therapyType_name", content).val(selectedTherapyType.name);
                $("#therapyType_id", content).val(selectedTherapyType.id);
                $("#therapyType_description", content).val(selectedTherapyType.description);
            });
        });
        
        $('a.switch_therapyTypeState').click(function (e) {
            e.preventDefault();
            var data = therapyTypeTable.row($(this).parent().parent()).data();
            if (data.state === 'ACTIVE') {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " deaktivieren?</div>");
                $title = "Behandlungsart entfernen?";
            } else {
                $msg = $("<div>Wollen Sie wirklich " + data.name + " reaktivieren?</div>");
                $title = "Behandlungsart hinzufügen?";
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
                            url: "?module=therapy\\SwitchTherapyTypeState",
                            data: {therapyType_id: data.id},
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

    $('#add_therapyType_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/therapy/add_therapyType.htpl", function (data) {
            $(data).dialog({
                title: "Behandlungsart hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        FindusUtil.blockUI();
                        var therapyTypeName = $("#therapyType_name", this).val();
                        var therapyTypeDescription = $("#therapyType_description", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=therapy\\AddTherapyType",
                            data: {
                                therapyType_name: therapyTypeName,
                                therapyType_description: therapyTypeDescription
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
    