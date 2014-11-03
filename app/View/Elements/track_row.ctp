<?php

$actionButtons = '<ul class="button-bar">
<li><a href="" bind="timeStop"><i class="icon-stop blue timestop"></i></a></li>
<li><a href=""><i class="icon-pause timepause"></i></a></li>
<li><a href=""><i class="icon-backward timeback"></i></a></li>
</ul>';
echo $this->Form->input('Time.id', array('type' => 'hidden'));
echo $this->Form->input('Time.time_out', array('type' => 'hidden'));
echo $this->Form->input('Time.user_id', array('type' => 'hidden', 'value' => $userId));
echo $this->Html->tableCells(array(
    array(
//        $projectInList[$record['Time']['project_id']],
        $this->Form->input('Time.project_id', array(
            'options' => $projects
        )),
        $this->Time->format($record['Time']['time_in'], '%m.%d.%y --- %I:%M %p'),
        $record['Time']['duration'],
        $this->Form->input('Time.activity'),
//        $record['Time']['activity'],
        $actionButtons)
));
