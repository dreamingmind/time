$(function() {
    $("#list1, #list2, #list3" )
	.sortable({connectWith: "ul"})
	.sortable({placeholder: ".placehold"})
	.sortable({update: function(e, ui){
	    var target  = $(this).attr("id");
	}})
	.disableSelection();

    var newParent = $(target).parent().attr("id");
    alert(target + ' - ' + newParent);
    });