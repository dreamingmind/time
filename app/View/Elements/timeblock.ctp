<?php
// Each record is in its own form
// so even though multiple records show on a page,
// they submit independent of each other

    echo $this->Form->create('Time', array('class' => 'time'));
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
	'rows' => '2'
    ));
    
    // set these to type text to prevent the 
    // crazy drop-down lists. That lets us get 
    // 0000-00-00 00:00:00 values in time_out
    // to satisfy the 'open time record' concept
    echo $this->Form->input('time_in', array(
	'value' => $time['Time']['time_in'],
	'type' => 'text'
    ));
    echo $this->Form->input('time_out', array(
	'value' => $time['Time']['time_out'],
	'type' => 'text'
    ));
    echo $this->Html->para('', "$duration hours");
    echo $this->Form->end('Submit');
?>