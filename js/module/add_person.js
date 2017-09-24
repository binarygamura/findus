(function(){

    
    $(document).ready(function () {
        
        $('#create_button1').click(function (e) {
            e.preventDefault();
            FindusUtil.blockUI();
            $.ajax({
                type: "POST",
                url: "?module=person\\AddPerson",
                data: $("#add_person_form").serialize(),
                success: function (e) {
                    var response = JSON.parse(e);
                    $("<div>\n\Person wurde erfolgreich erfasst und mit der ID <strong>"+response.id+"</strong> ins System eingetragen.</div>").dialog({
                        modal: true,
                        title: "Person wurde erfasst",
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
                        $("#person\\["+key+"\\]").addClass("error");
                        errorList.append("<li>"+value+"</li>");
                    });
                }
            });
            
        });

    });
})();