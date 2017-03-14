
$(document).ready(function () {

     var therapyTypeTable = initTable("#therapyType_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "description"},
            {
                data: null,
                render: function (data, type, row, meta) {
                    return "<a class=\"delete_therapyType\" href=\"\">löschen</a>&nbsp;<a class=\"edit_therapyType\" href=\"\">bearbeiten</a>";
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
            initClickHandler();
            var selectedTherapyType = therapyTypeTable.row($(this).parent().parent()).data();
            var therapyTypeId = selectedTherapyType.id;
            var therapyTypeName = selectedTherapyType.name;
            var therapyTypeDescription = selectedTherapyType.description;
            $.get("./templates/therapy/add_therapyType.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Behandlungsart \""+selectedTherapyType.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                    "speichern": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=therapy\\UpdateTherapyType",
                            data: {
                                therapyType_name: therapyTypeName,
                                therapyType_id:therapyTypeId,
                                therapyType_description: therapyTypeDescription,
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
                $("#therapyType_name", content).val(selectedTherapyType.name);
                $("#therapyType_id", content).val(selectedTherapyType.id);
                $("#therapyType_description", content).val(selectedTherapyType.description);
            });
        });
        
        $('a.delete_therapyType').click(function (e) {
            e.preventDefault();
            initClickHandler();
            var data = therapyTypeTable.row($(this).parent().parent()).data();
            $("<div>Wollen Sie wirklich " + data.name + " entfernen?</div>").dialog({
                modal: true,
                title: "Behandlungsart entfernen?",
                buttons: {
                    "ja": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=therapy\\DeleteTherapyType",
                            data: {therapyType_id: data.id},
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

    $('#add_therapyType_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/therapy/add_therapyType.htpl", function (data) {
            $(data).dialog({
                title: "Behandlungsart hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var therapyTypeName = $("#therapyType_name", this).val();
                        var therapyTypeDescription = $("#therapyType_description", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=therapy\\AddTherapyType",
                            data: {
                                therapyType_name: therapyTypeName,
                                therapyType_description: therapyTypeDescription,
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
    