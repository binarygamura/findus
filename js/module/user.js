
$(document).ready(function () {

     var userTable = initTable("#user_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {
                data: "user",
                render: function (data, type, row, meta) {
                    return "<a class=\"delete_user\" href=\"\">löschen</a>&nbsp;<a class=\"edit_user\" href=\"\">bearbeiten</a>";
                }
            }
        ]
    });

    function initClickHandler() {
        $('#user_table tbody tr').click(function (e) {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                userTable.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('a.edit_user').click(function(e){
            e.preventDefault();
            initClickHandler();
            var selectedUser = userTable.row($(this).parent().parent()).data();
            var userId = selectedUser.id;
            var userName = selectedUser.name;
            var userPassword = selectedUser.password;
            var userRole = selectedUser.role;
            $.get("./templates/user/add_user.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Benutzer \""+selectedUser.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                    "speichern": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=user\\UpdateUser",
                            data: {
                                "user_name": $("#user_name", self).val(),
                                "user_id":userId,
                                "user_password": $("#user_password", self).val(),
                                "user_role": $("#user_role", self).val()                                
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
                $("#user_name", content).val(selectedUser.name);
                $("#user_id", content).val(selectedUser.id);
                $("#user_password", content).val(selectedUser.password);
                $("#user_role", content).val(selectedUser.role);                
            });
        });
         
         
        $('a.delete_user').click(function (e) {
            e.preventDefault();
            initClickHandler();
            var data = userTable.row($(this).parent().parent()).data();
            $("<div>Wollen Sie wirklich " + data.name + " entfernen?</div>").dialog({
                modal: true,
                title: "Benutzer entfernen?",
                buttons: {
                    "ja": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=user\\DeleteUser",
                            data: {"user_id": data.id},
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

    $('#add_user_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/user/add_user.htpl", function (data) {
            $(data).dialog({
                title: "Benutzer hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
                        var userName = $("#user_name", this).val();
                        var userPassword = $("#user_password", this).val();
                        var userRole = $("#user_role", this).val();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=user\\AddUser",
                            data: {
                                "user_name": userName,
                                "user_password": userPassword,
                                "user_role": userRole
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
    