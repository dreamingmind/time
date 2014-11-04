<?php
$duration = $this->Html->tag('span',  $this->request->data[$index]['Time']['duration'], array('id' => $index.'duration', 'class' => 'toggle'));
$duration .= $this->Form->input("$index.Time.duration", array('class' => $index.'duration hide', 'label' => FALSE));

echo $this->Html->tableCells(array(
    array(
        $this->Form->input("$index.Time.id", array('type' => 'hidden')) .
        $this->Form->input("$index.Time.time_out", array('type' => 'hidden')) .
        $this->Form->input("$index.Time.user_id", array('type' => 'hidden')) .
        $this->Form->input("$index.Time.project_id", array(
            'options' => $projects,
            'label' => FALSE,
            'div' => FALSE,
            'empty' => 'Choose a project',
            'fieldName' => 'project_id',
            'index' => $index
        )) . '&nbsp;' . $this->Tk->setProjectDefaultButton($this->request->data[$index]['Time']['project_id']),
        $this->Time->format($this->request->data[$index]['Time']['time_in'], '%m.%d.%y --- %I:%M %p'),
        $duration,
        $this->Form->input('$index.Time.activity', array(
            'label' => FALSE,
            'div' => FALSE,
            'fieldName' => 'activity',
            'index' => $index
        )),
        $this->Tk->timeFormActionButtons($index))
));
