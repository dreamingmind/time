<?php
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
    echo $this->Form->input('time_in', array(
	'value' => $time['Time']['time_in']
    ));
    echo $this->Form->input('time_out', array(
	'value' => $time['Time']['time_out']
    ));
    echo $this->Form->end('Submit');
?>