<?php

echo $this->Form->input('Time.id', array('type' => 'hidden'));
echo $this->Form->input('Time.time_out', array('type' => 'hidden'));
echo $this->Form->input('Time.user_id', array('type' => 'hidden', 'value' => $userId));
echo $this->Html->tableCells(array(
    array(
        $projectInList[$record['Time']['project_id']],
        $this->Time->format($record['Time']['time_in'], '%m.%d.%y --- %I:%M %p'),
        $record['Time']['duration'],
        $record['Time']['activity'],
        $actionButtons)
));
