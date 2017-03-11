$(document).ajaxStop($.unblockUI);
$(document).ready(function(){
    initTable("table.default")
    $(".tabs").tabs();
    $(document ).tooltip({
      position: {
        my: "center bottom-20",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
});

function blockUi(message) {
    if(!message){
        message = "Bitte warten...";
    }
    $.blockUI({
        theme: true,
        baseZ: 2000,
        css: {
            backgroundColor: '#f00', 
            color: '#000'
        },
        message: '<h1 class="loading"><img src="./images/animal.gif" /> '+message+'</h1>'
    });
}

function initTable(selector, options) {
    var table = $(selector);
    var coreOptions = {
        language: {
            url: './js/german.json'
        }//,
//        sScrollY: "200px"
//        fnDrawCallback: function() {
//        table.dataTable()._fnScrollDraw();        
//        table.closest(".dataTables_scrollBody").height(200);
//   }
    };
    if (options) {
        coreOptions = $.extend(coreOptions, options);
    }

    var dataTable = table.DataTable(coreOptions);
    return dataTable;
}

function showErrorDialog(title, message) {
    $("<div>" + message + "</div>").dialog({
        "modal": true,
        "title": title
    });
}