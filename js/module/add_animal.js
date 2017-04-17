(function(){
    function updateRacesList(speciesId){
        return new Promise(function(resolve, reject){
            $.ajax({
                type: 'GET',
                url: '?module=species\\GetRaces',
                data: {"species_id": speciesId},
                success: function(e){
                    resolve(JSON.parse(e));
                },
                error: function(e){
                    reject(e);
                }
            });
        });
         $.get(
            "?module=species\\GetRaces", {
                "species_id": speciesId
            },
            function (e) {
                var parsedData = JSON.parse(e);
                var raceSelect = $('#animal\\[race\\]');
                raceSelect.empty();
                raceSelect.append('<option value=\"-1\">--&gt; bitte auswählen &lt;--</option>');
                parsedData.data.forEach(function (element) {
                    raceSelect.append('<option value=\"' + element.id + '\">' + element.name + '</option>');
                }
            );}
        );
    }

    function renderRacesList(raceslistResponse){
        var raceSelect = $('#animal\\[race\\]');
        raceSelect.empty();
        raceSelect.append('<option value=\"-1\">--&gt; bitte auswählen &lt;--</option>');
        raceslistResponse.data.forEach(function (element) {
            raceSelect.append('<option value=\"' + element.id + '\">' + element.name + '</option>');
        });
    }

    function updateSpeciesList(){
        return new Promise(function(resolve, reject){
            $.ajax({
                type: 'GET',
                url: '?module=species\\GetSpecies',
                success: function(e){
                    resolve(JSON.parse(e));
                },
                error: function(e){
                    reject(e);
                }
            });
        });
    }
    
    function renderSpeciesList(speciesResponse){
        var speciesSelect = $('#animal\\[species\\]').empty();
        speciesSelect.append('<option value=\"-1\">--&gt; bitte auswählen &lt;--</option>');
        speciesResponse.data.forEach(function (element) {
            speciesSelect.append('<option value=\"' + element.id + '\">' + element.name + '</option>');
        });
    }
    
    $(document).ready(function () {
        
        $(".cat_spinner").slick({
            dots: true
        });
        
        $('.cat_spinner_nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.cat_spinner',
            dots: true,
            centerMode: true,
            focusOnSelect: true
          });
        
        $('#delete_portrait_button').click(function(e){            
            var currentSlide = $('.cat_spinner').slick('slickCurrentSlide');
            if(currentSlide || currentSlide === 0){
                FindusUtil.blockUI();
                var formData = new FormData();
                var fileName = $(".slick-current input[type='checkbox']").val();
                console.log("deleting "+fileName);
                formData.append('filename', fileName);
                $.ajax({
                    url: 'index.php?module=animal\\DeletePicture', 
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    type: 'POST',
                    success: function(e){
                        $('.cat_spinner').slick('slickRemove', currentSlide);
                    },
                    error: function(e){
                        FindusUtil.showErrorDialog('Fehler beim Löschen eines Bildes.', 
                        'Es ist ein Fehler beim Löschen des Bildes aufgetreten.');
                    }
                 });
            }
        });
        
        
        $('#portrait_select').on('change', function() {
            if($('#portrait_select').prop('files').length > 0){
                FindusUtil.blockUI();
                var bundleId = $("#animal\\[bundle_id\\]").val();
                var formData = new FormData();                      
                formData.append('file', $('#portrait_select').prop('files')[0]);
                $.ajax({
                    url: 'index.php?module=animal\\UploadPicture&bundleId='+bundleId, 
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,                         
                    type: 'POST',
                    success: function(e){
                        var result = JSON.parse(e);
                        $('#animal\\[bundle_id\\]').val(result.id);
                        var lastImage = result.ownImage[result.ownImage.length - 1];
                        $context = $('.cat_spinner').slick('slickAdd','<div>\n\
                            <img class="portrait" src="./images/portraits/'+lastImage.name+'"/>\n\
                            <input type="checkbox" class=\"selected_portrait\" value="'+lastImage.name+'" name="animal[portrait]">Portrait?</input></div>');
                        $('.selected_portrait').on('change', function() {
                            $('.selected_portrait').not(this).prop('checked', false);
                        });                    
                    },
                    error: function(e){
                        FindusUtil.showErrorDialog("Fehler beim Hochladen des Bildes.", 
                        "Es ist ein Fehler beim Hochladen des Bildes aufgetreten.");
                    }
                 });
             }
             else {
                $("#portrait").attr("src", "");
                $("#animal\\[portrait\\]").val("");
             }
        });
        
        
        $("#animal\\[species\\]").change(function (event) {
            var selected = parseInt($("#animal\\[species\\]").val(), 10);
            if (selected > 0) {
                FindusUtil.blockUI();
                updateRacesList(selected).then(renderRacesList);
            }
        });

        $('#create_button1').click(function (e) {
            e.preventDefault();
            FindusUtil.blockUI();
//            $("animal[portrait]").val($('.selected_portrait:checked').val());
            $.ajax({
                type: "POST",
                url: "?module=animal\\AddAnimal",
                data: $("#add_animal_form").serialize(),
                success: function (e) {
                    var response = JSON.parse(e);
                    $("<div>\n\Tier wurde erfolgreich erfasst und mit der ID <strong>"+response.id+"</strong> ins System eingetragen.</div>").dialog({
                        modal: true,
                        title: "Tier wurde erfasst",
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
                        $("#animal\\["+key+"\\]").addClass("error");
                        errorList.append("<li>"+value+"</li>");
                    });
                }
            });
            
        });

        $('#add_species_button').click(function (e) {
            e.preventDefault();
            $.get("./templates/species/add_species.htpl", function (data) {
                $(data).dialog({
                    title: "Tierart hinzufügen",
                    modal: true,
                    buttons: {
                        "erstellen": function () {
                            FindusUtil.blockUI();
                            var speciesName = $("#species_name", this).val();
                            var self = this;
                            $.ajax({
                                type: "POST",
                                url: "?module=species\\AddSpecies",
                                data: {"species_name": speciesName},
                                success: function (e) {
                                    var data = JSON.parse(e);
                                    updateSpeciesList().then(renderSpeciesList).then(function(){
                                        //TODO: dont trigger... just reload the list with en empty array.
                                        $("#animal\\[species\\]").val(data.id).trigger("change");
                                    });
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

        $('#add_race_button').click(function (e) {
            e.preventDefault();
            var currentSpecies = $("#animal\\[species\\]").val();
            if(currentSpecies >= 0) {
                $.get("./templates/species/add_race.htpl", function (data) {
                    $(data).dialog({
                        title: "Tierrasse hinzufügen",
                        modal: true,
                        buttons: {
                            "erstellen": function () {
                                FindusUtil.blockUI();
                                var self = this;
                                $.ajax({
                                    type: "POST",
                                    url: "?module=species\\AddRace",
                                    data: {
                                        species_id: currentSpecies,
                                        race_name: $("#race_name", self).val()
                                    },
                                    success: function (response) {
                                        var data = JSON.parse(response);
                                        $(self).dialog("destroy");
                                        updateRacesList(currentSpecies).then(renderRacesList).then(function(){
                                            $("#animal\\[race\\]").val(data.id);
                                        });
                                    },
                                    error: function (e) {
                                        var error = JSON.parse(e.responseText);
                                        FindusUtil.showErrorDialog("Fehler", error.message);
                                    }});
                            },
                            "abbrechen": function () {
                                $(this).dialog("close").dialog("destroy");
                            }
                        }
                    });
                });
            }
        });
    });
})();