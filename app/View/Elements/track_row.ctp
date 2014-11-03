<?php

echo $this->Html->tableCells(array(
    array(
        $this->Form->input('Time.id', array('type' => 'hidden')) .
        $this->Form->input('Time.time_out', array('type' => 'hidden')) .
        $this->Form->input('Time.user_id', array('type' => 'hidden', 'value' => $userId)) .
        $this->Form->input('Time.project_id', array(
            'options' => $projects,
            'label' => FALSE,
            'div' => FALSE,
            'empty' => 'Choose a project'
        )) . '&nbsp;' . $this->Tk->setProjectDefaultButton($record['Time']['project_id']),
        $this->Time->format($record['Time']['time_in'], '%m.%d.%y --- %I:%M %p'),
        $record['Time']['duration'],
        $this->Form->input('Time.activity', array(
            'label' => FALSE,
            'div' => FALSE
        )),
        $this->Tk->timeFormActionButtons())
));
