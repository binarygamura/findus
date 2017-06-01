(function () {

    var personTable = FindusUtil.initTable("#person_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "street"},
            {data: "city"},
            {
                data: null,
                render: function (data, type, row, meta) {
                    return "<a class=\"edit_person\" href=\"\">bearbeiten</a>";
                }
            }
        ]
    });


    function updatePersonTable() {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: "GET",
                url: "?module=person\\SearchPersonByFilter",
                data: {"organization": parseInt($("#person\\[organization\\]").val(), 10),
                    "name": $("#person\\[name\\]").val(),
                    "street": $("#person\\[street\\]").val(),
                    "city": $("#person\\[city\\]").val()
                },
                success: function (e) {
                    resolve(JSON.parse(e));
                    var parsedData = JSON.parse(e);
                    personTable.clear();
                    personTable.rows.add(parsedData.data);
                    personTable.draw();
                },
                error: function (e) {
                    reject(e);
                }
            });
        });
        $.get(
                "?module=person\\SearchPersonByFilter", {
                    "organization": parseInt($("#person\\[organization\\]").val(), 10),
                    "name": $("#person\\[name\\]").val(),
                    "street": $("#person\\[street\\]").val(),
                    "city": $("#person\\[city\\]").val()
                },
                function (e) {
                    resolve(JSON.parse(e));
                }
        );
    }



    $(document).ready(function () {

        function initClickHandler() {
            $('#person_table tbody tr').click(function (e) {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    personTable.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });
        }

        $('a.edit_person').click(function (e) {
            e.preventDefault();
            initClickHandler();
            //the following gets data for the currently selected row.
            var selectedPerson = personTable.row($(this).parent().parent()).data();
            var personId = selectedPerson.id;
            $.get("./templates/person/add_Person.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Person \"" + selectedPerson.name + "\" bearbeiten",
                    modal: true,
                    buttons: {
                        "speichern": function () {
                            FindusUtil.blockUI();
                            var self = this;
                            $.ajax({
                                type: "POST",
                                url: "?module=person\\UpdatePerson",
                                data: {
                                    //get the name currently typed into the name field of the dialog.
                                    person_name: $("#person_name", self).val(),
                                    //the id is immutable.
                                    person_id: personId,
                                    person_street: $("#person_street", self).val(),
                                    person_city: $("#person_city", self).val(),
                                    person_postalcode: $("#person_postalcode", self).val(),
                                    person_phone: $("#person_phone", self).val(),
                                    person_organization: $("#person_organization", self).val()
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
                            $(this).dialog("destroy");
                        }
                    }
                });
                //prefill all the fields of the form with data from the previously selected
                //row.
                $("#person_name", content).val(selectedPerson.name);
                $("#person_id", content).val(selectedPerson.id);
                $("#person_organization", content).val(selectedPerson.organization);
                $("#person_street", content).val(selectedPerson.street);
                $("#person_city", content).val(selectedPerson.city);
                $("#person_phone", content).val(selectedPerson.phone);
            });
        });

        $('#add_person_button').click(function (e) {
            e.preventDefault();
            $.get("./templates/person/add_person2.htpl", function (data) {
                var context = $(data).dialog({
                    title: "Person hinzufügen",
                    modal: true,
                    buttons: {
                        "erstellen": function () {
                            FindusUtil.blockUI();
                            var personName = $("#person_name", this).val();
                            var self = this;
                            $.ajax({
                                type: "POST",
                                url: "?module=person\\AddPerson",
                                data: {
                                    person_name: personName,
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

        $("#person\\[organization\\]").change(function (event) {
            var selected = parseInt($("#person\\[organization\\]").val(), 10);
            FindusUtil.blockUI();
            updatePersonTable();
        });

        $("#person\\[name\\]").change(function (event) {
            FindusUtil.blockUI();
            updatePersonTable();
        });

        $("#person\\[street\\]").change(function (event) {
            FindusUtil.blockUI();
            updatePersonTable();
        });

        $("#person\\[city\\]").change(function (event) {
            FindusUtil.blockUI();
            updatePersonTable();
        });

        initClickHandler();

    });
})();
    