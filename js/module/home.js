$(document).ready(function(){
    
    $(".cat_spinner").slick({
        dots: true,
        autoplay: true,
        autoplaySpeed: 2000
    });
    
    $.get("?module=animal\\GetLatestAnimals",[], function(data){
        var result = JSON.parse(data);
        console.log(result);
        var markup = "";
        result.forEach(function(animal){            
            markup += '<div><img class="portrait" src="./images/portraits/'+animal.bundle.ownImage[0].name+'"/>\
                <p style="text-align:center">'+animal.name+'</p>\
                </div>';
        });
        $('.cat_spinner').slick('slickAdd', markup);
    });
});
