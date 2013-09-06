$(function() {$("ul" )
    .sortable({connectWith: "ul"})
    .sortable({placeholder: ".placehold"})
    .sortable({update: function(event, ui){
	change.line = ui.item.attr("id");
	change.sibling = ui.item.prev().attr("id");
	change.parent = $(this).parent().attr("id");
	}})
.sortable({stop:
$("p#splash").load("/time/times/tree_jax/"+ change.line + "/" + change.sibling + "/" + change.parent,
    "line = " + change.line + " prev sibling = " + change.sibling + " parent = " + change.parent,
    function(response){$("p#splash").html(response)} )})
    .disableSelection();});