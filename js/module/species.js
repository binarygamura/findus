
$.blockUI({
//    theme: true,
    baseZ: 2000,
    css: { backgroundColor: '#f00', color: '#000'}
})
$(document).ajaxStop($.unblockUI); 


function initRacesTable(){
    
}

$(document).ready(function(){
    var table = $('#species_table').DataTable({
            "language": {
                "url": './js/german.json'
            }
        });
        
    var racesTable = $("#races_table").DataTable({
        "language": {
                "url": './js/german.json'
            },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { 
                "data": null,
                "render": function(data, type, row, meta){
                    return "<a class=\"delete_species\" href=\"\">löschen</a>";
                }
            }
        ]
    });
        
    $('#species_table tbody tr').click(function(e){
        var data = table.row( this ).data();
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $.blockUI({ message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>' }); 
            $.get("?module=GetRaces", {"species_id": data[0]}, function(e){
                var parsedData = JSON.parse(e)
                racesTable.clear();
                racesTable.rows.add(parsedData.data);
                racesTable.draw();
                
                $('#races_table tbody tr').click(function(e){
                    var data = table.row( this ).data();
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }
                    else {
                        racesTable.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }        
                });
            });
        }        
    });
    
    $('#races_table tbody tr').click(function(e){
        var data = table.row( this ).data();
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }        
    });
    
    $('#add_species_button').click(function(e){
        e.preventDefault();
        $.get("./templates/add_species.htpl", function(data){            
            $(data).dialog({
                modal: true,
                buttons: {
                  "erstellen": function(){
                    $.blockUI({ message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>' }); 
                    var speciesName = $("#species_name", this).val();
                    var self = this;
                    $.ajax({
                        type: "POST",
                        url: "?module=AddSpecies",
                        data: {"species_name": speciesName},
                        success: function(e){
                            $(self).dialog("destroy");
                            location.reload();
                        },
                        error: function(e){
                            var error = JSON.parse(e.responseText);
                            $("<div>"+error.message+"</div>").dialog({
                                "modal": true,
                                "title": "Fehler"
                            });
                        }
                      });
                  },
                  "abbrechen": function() {
                    $(this).dialog("close").dialog("destroy");
                  }
                }
            });
        });
    });
});