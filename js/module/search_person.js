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
                    return "<a class=\"edit_person\" href=\"\"><img src=\"./images/toolbar_edit.png\" title=\"bearbeiten\" alt=\"bearbeiten\"/></a>";
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
            $.get("./templates/person/add_Person2.htpl", function (data) {
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
                                    person_name: $("#person\\[name\\]", self).val(),
                                    //the id is immutable.
                                    person_id: personId,
                                    person_street: $("#person\\[street\\]", self).val(),
                                    person_city: $("#person\\[city\\]", self).val(),
                                    person_postalcode: $("#person\\[postalcode\\]", self).val(),
                                    person_phone: $("#person\\[phone\\]", self).val(),
                                    person_organization: $("#person\\[organization\\]").is(":checked") ? 1 : 0
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
                $("#person\\[name\\]", content).val(selectedPerson.name);
                $("#person\\[id\\]", content).val(selectedPerson.id);
                $("#person\\[organization\\]", content).val(selectedPerson.organization);
                $("#person\\[street\\]", content).val(selectedPerson.street);
                $("#person\\[postalcode\\]", content).val(selectedPerson.postalcode);
                $("#person\\[city\\]", content).val(selectedPerson.city);
                $("#person[phone]", content).val(selectedPerson.phone);
            });
        });

        $('#add_person_button').click(function (e) {
            e.preventDefault();
            $.get("./templates/person/add_person.htpl", function (data) {
                var context = $(data).dialog({
                    title: "Person hinzufügen",
                    modal: true,
                    buttons: {
                        "erstellen": function () {
                            FindusUtil.blockUI();
                            var personName = $("#person\\[name\\]", this).val();
                            var street = $("#person\\[street\\]", this).val();
                            var postalCode = $("#person\\[postalcode\\]", this).val();
                            var city = $("#person\\[city\\]", this).val();
                            var phone = $("#person\\[phone\\]", this).val();
                            var organization = $("#person\\[organization\\]").is(":checked") ? 1 : 0;
                            var self = this;
                            $.ajax({
                                type: "POST",
                                url: "?module=person\\AddPerson",
                                data: {
                                    person: {
                                        name: personName,
                                        street: street,
                                        postalcode: postalCode,
                                        organization: organization,
                                        phone: phone,
                                        city: city
                                    }
                                },
                                success: function (e) {
                                    $(self).dialog("destroy");
                                    updatePersonTable();
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
    