
$(document).ready(function () {
    $("#animal\\[species\\]").change(function (event) {
        var selected = parseInt($("#animal\\[species\\]").val(), 10);
        if (selected > 0) {
            $.blockUI({message: '<h1 class="loading"><img src="./images/animal.gif" /> Bitte warten...</h1>'});
            $.get(
                "?module=GetRaces", {
                    "species_id": selected
                },
                function (e) {
                    var parsedData = JSON.parse(e);
                    var raceSelect = $("#animal\\[race\\]");
                    raceSelect.empty();
                    raceSelect.append("<option value=\"-1\">--&gt; bitte auswählen &lt;--</option>");
                    parsedData.data.forEach(function(element){
                        raceSelect.append("<option value=\""+element.id+"\">"+element.name+"</option>");
                    });
                }
            );
        }
    });
});