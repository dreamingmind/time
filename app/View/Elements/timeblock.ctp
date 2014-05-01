<?php

// Each record is in its own form
// so even though multiple records show on a page,
// they submit independent of each other

echo $this->Form->create('Time', array('class' => 'time col_5 vertical', 'controller' => 'times', 'action' => 'timekeep'));
echo $this->Html->para('', 'id: ' . (($time['Time']['id'] < 1) ? 'new' : $time['Time']['id']));
echo $this->Form->input('id', array(
    'type' => 'hidden',
    'value' => $time['Time']['id']
));
echo $this->Form->input('user', array(
    'type' => 'text',
    'value' => $user
));
echo $this->Form->input('project', array(
    'type' => 'select', 'options' => $projects
));
echo $this->Form->input('activity', array(
    'value' => $time['Time']['activity'],
    'rows' => '1'
));

// set these to type text to prevent the 
// crazy drop-down lists. That lets us get 
// 0000-00-00 00:00:00 values in time_out
// to satisfy the 'open time record' concept
echo $this->Form->input('time_in', array(
    'value' => $time['Time']['time_in'],
    'type' => 'text'
));
//echo $this->Form->input('time_out', array(
//    'value' => $time['Time']['time_out'],
//    'type' => 'text'
//));

//Setup the field set and legend for the adjustment buttons
//As well as the buttons themselves
$buttonset=$this->Html->tag(
    'legend','Time Out Options');

$buttonset.=$this->Form->button('Out Now', array(
    'id' => 'OutNowButton',
    'class' => 'HorizButtons small col_3',
	'bind' => 'click.OutNow'
));
    $options = array(
    '-60' => 'Minus 60 Min',
     '-30' => 'Minus 30 Min',
     '-10' => 'Minus 10 Min',
     '0' => 'Now'
        );
$buttonset.=$this->Form->select('Adjustment',$options,array(
    'id' => 'OutTimeAdjust',
    'class' => 'HorizButtons',
	'label' => FALSE,
    'empty' => 'Out Time Adjustment',
	'bind' => 'change.AdjustSelect'
));
$buttonset.=$this->Form->input('time_out', array(
    'value' => $time['Time']['time_out'],
    'type' => 'text'
));

//Echo the entire fieldset
echo $this->Html->tag(
        'fieldset',
        $buttonset,
        array(
            'label'=>'Time Out Options'
        ));


echo $this->Html->para('', "$duration hours");
echo $this->Form->button('Submit', array(
    'id' => 'Submit',
    'class' => 'HorizButtons small col_3'
));
echo $this->Form->end();
?>
<div class="col_1"></div>