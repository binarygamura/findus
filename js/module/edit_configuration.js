(function(){
    
        $('#update_button').click(function (e) {
            e.preventDefault();
            FindusUtil.blockUI();
            $.ajax({
                type: "POST",
                url: "?module=configuration\\UpdateConfiguration",
                data: $("#edit_configuration_form").serialize(),
                success: function (e) {
                    var response = JSON.parse(e);
                    $("<div>\n\Konfiguration wurde erfolgreich geändert.</div>").dialog({
                        modal: true,
                        title: "Konfiguration wurde angepasst",
                        buttons: {
                            "okay": function(){
                                $(this).dialog("destroy");
                                location.reload();
                            }
                        }
                    });
                },
                error: function (e) {
                    FindusUtil.blockUI();
                    $(".error").removeClass("error");
                    var errors = JSON.parse(e.responseText);
                    var errorList = $("#error_list").empty();
                    $.each(errors, function(key, value){
                        $("#configuration\\["+key+"\\]").addClass("error");
                        errorList.append("<li>"+value+"</li>");
                    });
                }
            });
            
        });

})();