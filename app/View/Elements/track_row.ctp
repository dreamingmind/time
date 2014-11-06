<?php
$duration = $this->Html->tag('span', substr($this->request->data[$index]['Time']['duration'],0,5), array(
    'id' => $index.'duration', 
    'class' => 'toggle'));
$duration .= $this->Form->input("$index.Time.duration", array(
    'class' => $index.'duration hide', 
    'label' => FALSE, 
    'bind' => 'change.saveField',
    'fieldName' => 'duration',
    'index' => $index));
$rowAttr = array('id' => 'row_'.$index);
switch ($this->request->data("$index.Time.status")) {
    case OPEN:
        $rowAttr['class'] = 'open';
        break;
    case CLOSED:
        $rowAttr['class'] = 'closed';
        break;
    case REVIEW:
        $rowAttr['class'] = 'review';
        break;
    case PAUSED:
        $rowAttr['class'] = 'paused';
        break;
    default:
        break;
}
//dmDebug::ddd($this->request->data('{n}.Time.status'), 'status');

echo $this->Html->tableCells(array(
    array(
        $this->Form->input("$index.Time.id", array('type' => 'hidden')) .
        $this->Form->input("$index.Time.time_out", array('type' => 'hidden')) .
        $this->Form->input("$index.Time.user_id", array('type' => 'hidden')) .
        $this->Form->input("$index.Time.project_id", array(
            'options' => $projects,
            'label' => FALSE,
            'div' => FALSE,
            'bind' => 'change.saveField',
            'empty' => 'Choose a project',
            'fieldName' => 'project_id',
            'index' => $index
        ))
        . '&nbsp;' 
        . $this->Tk->setProjectDefaultButton($this->request->data[$index]['Time']['project_id']),
        $this->Time->format($this->request->data[$index]['Time']['time_in'], '%m.%d.%y --- %I:%M %p'),
        $duration,
        $this->Form->input("$index.Time.activity", array(
            'label' => FALSE,
            'div' => FALSE,
            'bind' => 'change.saveField',
            'fieldName' => 'activity',
            'index' => $index
        )),
        $this->Tk->timeFormActionButtons($index, $this->request->data("$index.Time.status")))
), $rowAttr, $rowAttr);
