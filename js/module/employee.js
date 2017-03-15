
$(document).ready(function () {

     var employeeTable = initTable("#employee_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {data: "firstName"},
            {
                data: null,
                render: function (data, type, row, meta) {
                    return "<a class=\"delete_employee\" href=\"\">löschen</a>&nbsp;<a class=\"edit_employee\" href=\"\">bearbeiten</a>";
                }
            }
        ]
    });

    function initClickHandler() {
        $('#employee_table tbody tr').click(function (e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                employeeTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('a.edit_employee').click(function(e){
            e.preventDefault();
            initClickHandler();
            var selectedEmployee = employeeTable.row($(this).parent().parent()).data();
            var employeeId = selectedEmployee.id;
            var employeeName = selectedEmployee.name;
            var employeeDescription = selectedEmployee.firstName;
            $.get("./templates/employee/add_employee.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Vereinsmitglied \""+selectedEmployee.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                    "speichern": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=employee\\UpdateEmployee",
                            data: {
                                employee_name: employeeName,
                                employee_id:employeeId,
                                employee_firstName: employeeDescription,
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
                $("#employee_name", content).val(selectedEmployee.name);
                $("#employee_id", content).val(selectedEmployee.id);
                $("#employee_firstName", content).val(selectedEmployee.firstName);
            });
        });
        
        $('a.delete_employee').click(function (e) {
            e.preventDefault();
            initClickHandler();
            var data = employeeTable.row($(this).parent().parent()).data();
            $("<div>Wollen Sie wirklich " + data.name + " entfernen?</div>").dialog({
                modal: true,
                title: "Vereinsmitglied entfernen?",
                buttons: {
                    "ja": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=employee\\DeleteEmployee",
                            data: {employee_id: data.id},
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

    $('#add_employee_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/employee/add_employee.htpl", function (data) {
            $(data).dialog({
                title: "Vereinsmitglied hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var employeeName = $("#employee_name", this).val();
                        var employeeDescription = $("#employee_firstName", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=employee\\AddEmployee",
                            data: {
                                employee_name: employeeName,
                                employee_firstName: employeeDescription,
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
    