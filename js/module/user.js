
$(document).ready(function () {

     var userTable = FindusUtil.initTable("#user_table", {
        columns: [
            {data: "id"},
            {data: "name"},
            {
                data: "role",
                render: function(data, type, row, meta){
                    switch(data){
                        case "0":
                        case "1":
                            return "Besucher";
                        case "3":
                            return "Mitarbeiter";
                        case "7":
                            return "Vorstand";
                        case "15":
                            return "Admin";
                        default: 
                            return "unbekannt ("+data+")";
                    }
                }
            },
            {
                data: "user",
                orderable: false,
                render: function (data, type, row, meta) {
                    return "<a class=\"delete_user\" href=\"\"><img src=\"./images/cancel.png\" title=\"löschen\" alt=\"löschen\"/></a>&nbsp;\n\
                            <a class=\"edit_user\" href=\"\"><img src=\"./images/toolbar_edit.png\" title=\"bearbeiten\" alt=\"bearbeiten\"/></a>\n\
                            <a class=\"set_password\" href=\"\"><img src=\"./images/change_password.png\" title=\"Passwort setzen\" alt=\"Passwort setzen\"/></a>";
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
            var selectedUser = userTable.row($(this).parent().parent()).data();
            var userId = selectedUser.id;
            $.get("./templates/user/add_user.htpl", function (data) {
                var content = $(data).dialog({
                    title: "Benutzer \""+selectedUser.name+"\" bearbeiten",
                    modal: true,
                    buttons: {
                    "speichern": function () {
                        FindusUtil.blockUI();
                        var self = this;
                        $.ajax({
                            type: "POST",
                            url: "?module=user\\UpdateUser",
                            data: {
                                "user_name": $("#user_name", self).val(),
                                "user_id":userId,
                                "user_role": $("#user_role", self).val()                                
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
                $("#user_password", content).parent().hide();
                $("#user_name", content).val(selectedUser.name);
                $("#user_id", content).parent().hide();
                $("#user_role", content).val(selectedUser.role);
            });
        });
         
        $('a.set_password').click(function (e) {
            e.preventDefault();
            var selected = userTable.row($(this).parent().parent()).data();
            $.get('./templates/user/set_password.htpl', function (data) {
                $(data).dialog({
                    title: 'Passwort für '+selected.name+' setzen',
                    modal: true,
                    buttons: {
                        "setzen": function () {
                            FindusUtil.blockUI();
                            var userPassword = $('#user_password', this).val();
                            var userPasswordRepeat = $('#user_password_repeat', this).val();
                            var userId = selected.id;
                            var self = this;
                            $.ajax({
                                type: 'POST',
                                url: '?module=user\\SetPassword',
                                data: {
                                    user_id: userId,
                                    user_password: userPassword,
                                    user_password_repeat: userPasswordRepeat
                                },
                                success: function (e) {
                                    $(self).dialog("destroy");
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
         
        $('a.delete_user').click(function (e) {
            e.preventDefault();
            var data = userTable.row($(this).parent().parent()).data();
            $("<div>Wollen Sie wirklich " + data.name + " entfernen?</div>").dialog({
                modal: true,
                title: "Benutzer entfernen?",
                buttons: {
                    "ja": function () {
                        FindusUtil.blockUI();
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

    $('#add_user_button').click(function (e) {
        e.preventDefault();
        $.get("./templates/user/add_user.htpl", function (data) {
            var content = $(data).dialog({
                title: "Benutzer hinzufügen",
                modal: true,
                buttons: {
                    "erstellen": function () {
                        FindusUtil.blockUI();
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
                                $.unblockUI();
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
            $("#user_id", content).parent().hide();
        });
    });
});
    