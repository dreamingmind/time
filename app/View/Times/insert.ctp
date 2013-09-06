<ul id="list99" class="connect">
    <li id="Category_1"><span class="in">=></span>list99 Jake Category_1
        <ul id="list3" class="connect">
        </ul>
    </li>
    <li id="Category_2"><span class="in">=></span>Jim Category_2
        <ul id="list22" class="connect">
            <li id="Category_6"><span class="in">=></span>list22 Carrol Category_6</li>
            <li id="Category_7"><span class="in">=></span>Karrl Category_7</li>
            <li id="Category_8"><span class="in">=></span>Karren Category_8</li>
            <li id="Category_9"><span class="in">=></span>Crathy Category_9</li>
            <li id="Category_10"><span class="in">=></span>Chruck Category_10
                <ul id ="list77">
                    <li id="Category_771"><span class="in">=></span>Jason Category_771</li>
                    <li id="Category_772"><span class="in">=></span>Jason Category_772</li>
                    <li id="Category_773"><span class="in">=></span>Jason Category_773
                        <ul id ="list78">
                            <li id="Category_781"><span class="in">=></span>Jason Category_781</li>
                            <li id="Category_782"><span class="in">=></span>Jason Category_782</li>
                            <li id="Category_783"><span class="in">=></span>Jason Category_783</li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li id="Category_12"><span class="in">=></span>Jrim Category_12
            </li>
        </ul>
    </li>
    <li id="Category_333"><span class="in">=></span>JJulie Category_333</li>
    <li id="Category_433"><span class="in">=></span>JJoyce Category_433</li>
    <li id="Category_533"><span class="in">=></span>JJamalia Category_533</li>
    <li id="Category_1133"><span class="in">=></span>JJake Category_1133
        <ul id="list35" class="connect">
        </ul>
    </li>
    <li id="Category_123"><span class="in">=></span>Jim Category_123
        <ul id="list26" class="connect Category_12">
            <li id="Category_136"><span class="in">=></span>list26 Caarol Category_136</li>
            <li id="Category_137"><span class="in">=></span>Kaarl Category_137</li>
            <li id="Category_138"><span class="in">=></span>Kaaren Category_138</li>
            <li id="Category_139"><span class="in">=></span>Caathy Category_139</li>
            <li id="Category_2330"><span class="in">=></span>Chauck Category_2330</li>
        </ul>
    </li>
    <li id="Category_143"><span class="in">=></span>Jhulie Category_143</li>
    <li id="Category_144"><span class="in">=></span>Jhoyce  Category_144</li>
    <li id="Category_145"><span class="in">=></span>Jhamalia Category_145</li>
</ul>
<div id="list">
    <p id='showthis'>reveal</p>
    <p id='splash'>x</p>
    <?php
    echo $this->Form->create('Time');
    echo $this->Form->end('Submit');
//foreach ($sequence as $count => $set) {
//    echo $this->Html->para('', "Number  : $count");
//    echo $this->Html->para('', "L: {$set['low']}<br />T: {$set['tween']}<br />H: {$set['high']}<br />");
//}
    ?>
</div>
<?php
//$this->Js->get('.my-list');
//$this->Js->sortable(array(
//	'complete' => '$.post("/times/reorder", $(function() {$("#list1, #list2" ).sortable({connectWith: ".connect"}).disableSelection();});)',
//	));
$this->Js->buffer('var change = new Object();');
$this->Js->buffer('$(function() {$("ul" )
    .sortable({connectWith: "ul"})
    .sortable({placeholder: ".placehold"})
    .sortable({update: function(event, ui){
	change.line = ui.item.attr("id");
	change.sibling = ui.item.prev().attr("id");
	change.parent = $(this).parent().attr("id");
//	showme();
//	$("p#splash").load("/time/times/tree_jax/"+ change.line + "/" + change.sibling + "/" + change.parent,
//    "line = " + change.line + " prev sibling = " + change.sibling + " parent = " + change.parent,
//    function(response){$("p#splash").html(response)} );
	}})
//    .sortable({receive: function(){showme()}})
.sortable({stop:function(event, ui){
$("p#splash").load("/time/times/tree_jax/"+ change.line + "/" + change.sibling + "/" + change.parent,
    "line = " + change.line + " prev sibling = " + change.sibling + " parent = " + change.parent,
    function(response){$("p#splash").html(response)} )}})
    .disableSelection();});');
$this->Js->buffer(
        'function showme(){
    alert("line = " + change.line + " prev sibling = " + change.sibling + " parent = " + change.parent);
    }
    function hitme(){
    alert("hit me");
    }');
$this->Js->buffer('$("#showthis").bind("click", showme);');
//$this->Js->buffer('$("#list99").menu();');
echo $this->Js->writeBuffer();

//$this->Js->buffer('$(function() {$("ul" )
//    .sortable({connectWith: "ul"})
//    .sortable({placeholder: ".placehold"})
//    .sortable({update: function(event, ui){
//	//alert(ui.item.attr("id"));
//	change.line = ui.item.attr("id");
//	change.sibling = ui.item.prev().attr("id");
//	change.parent = ($(this).parent().attr("id"));
//	//$.post("/cake23/times/tree_jax", "line = " + change.line + " prev sibling = " + change.sibling + " parent = " + change.parent, function(response){$("splash").html(response)} );
//	}})
//    //.sortable({receive: function(){showme()}})
//    .disableSelection();});');
?>
