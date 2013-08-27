<ul id="list1" class="connect">
    <li id="Category_1"><span class="in">=></span>Jake
	<ul id="list3" class="connect">
	</ul>
    </li>
    <li id="Category_2"><span class="in">=></span>Jim
	<ul id="list2" class="connect">
	    <li id="Category_6"><span class="in">=></span>Carol</li>
	    <li id="Category_7"><span class="in">=></span>Karl</li>
	    <li id="Category_8"><span class="in">=></span>Karen</li>
	    <li id="Category_9"><span class="in">=></span>Cathy</li>
	    <li id="Category_10"><span class="in">=></span>Chuck</li>
	    <li id="Category_12"><span class="in">=></span>Jim
		<ul id="list2" class="connect">
		    <li id="Category_26"><span class="in">=></span>Carol</li>
		    <li id="Category_127"><span class="in">=></span>Karl</li>
		    <li id="Category_28"><span class="in">=></span>Karen</li>
		    <li id="Category_29"><span class="in">=></span>Cathy</li>
		    <li id="Category_21"><span class="in">=></span>Chuck	
			<ul id="list2" class="connect">
			    <li id="Category_16"><span class="in">=></span>Carol</li>
			    <li id="Category_17"><span class="in">=></span>Karl</li>
			    <li id="Category_18"><span class="in">=></span>Karen</li>
			    <li id="Category_19"><span class="in">=></span>Cathy<ul id="list2" class="connect">
				    <li id="Category_16"><span class="in">=></span>Carol</li>
				    <li id="Category_17"><span class="in">=></span>Karl</li>
				    <li id="Category_18"><span class="in">=></span>Karen</li>
				    <li id="Category_19"><span class="in">=></span>Cathy</li>
				    <li id="Category_20"><span class="in">=></span>Chuck</li>
				</ul></li>
			    <li id="Category_20"><span class="in">=></span>Chuck</li>
			</ul>
		    </li>
		</ul>
	    </li>
	</ul>
    </li>
    <li id="Category_3"><span class="in">=></span>Julie</li>
    <li id="Category_4"><span class="in">=></span>Joyce</li>
    <li id="Category_5"><span class="in">=></span>Jamalia</li>
    <li id="Category_11"><span class="in">=></span>Jake
	<ul id="list3" class="connect">
	</ul>
    </li>
    <li id="Category_12"><span class="in">=></span>Jim
	<ul id="list2" class="connect Category_12">
	    <li id="Category_16"><span class="in">=></span>Carol</li>
	    <li id="Category_17"><span class="in">=></span>Karl</li>
	    <li id="Category_18"><span class="in">=></span>Karen</li>
	    <li id="Category_19"><span class="in">=></span>Cathy</li>
	    <li id="Category_20"><span class="in">=></span>Chuck</li>
	</ul>
    </li>
    <li id="Category_13"><span class="in">=></span>Julie</li>
    <li id="Category_14"><span class="in">=></span>Joyce</li>
    <li id="Category_15"><span class="in">=></span>Jamalia</li>
</ul>
<div id="list">
    <?php
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
$this->Js->buffer('$(function() {$("#list1, #list2, #list3" ).sortable({connectWith: "ul"}).sortable({placeholder: ".placehold"}).sortable({update: function(){alert("change!")}}).disableSelection();});');
echo $this->Js->writeBuffer();
?>
