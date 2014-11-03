<?php
echo $this->Html->tableCells(array(
    array(
        $this->Form->input("$index.Time.id", array('type' => 'hidden')) .
        $this->Form->input("$index.Time.time_out", array('type' => 'hidden')) .
        $this->Form->input("$index.Time.user_id", array('type' => 'hidden')) .
        $this->Form->input("$index.Time.project_id", array(
            'options' => $projects,
            'label' => FALSE,
            'div' => FALSE,
            'empty' => 'Choose a project'
        )) . '&nbsp;' . $this->Tk->setProjectDefaultButton($this->request->data[$index]['Time']['project_id']),
        $this->Time->format($this->request->data[$index]['Time']['time_in'], '%m.%d.%y --- %I:%M %p'),
        $this->request->data[$index]['Time']['duration'],
        $this->Form->input('$index.Time.activity', array(
            'label' => FALSE,
            'div' => FALSE
        )),
        $this->Tk->timeFormActionButtons($index))
));
