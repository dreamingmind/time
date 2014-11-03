<?php
echo $this->Form->create('Time');
echo $this->Html->tag('Table', NULL, array('class' => 'striped tight sortable'));
echo $this->Html->tableHeaders(array('Project', 'Time In', 'Duration', 'Activity', 'Tools'));
$actionButtons = '<ul class="button-bar">
<li><a href="" bind="timeStop"><i class="icon-stop blue timestop"></i></a></li>
<li><a href=""><i class="icon-pause timepause"></i></a></li>
<li><a href=""><i class="icon-backward timeback"></i></a></li>
</ul>';
if (!empty($openRecords)) {
    foreach ($openRecords as $key => $record) {
        echo $this->element('track_row', array(
            'record' => $record,
            'actionButtons' => $actionButtons,
            'projects' => $projectInList
        ));
    }
}
echo '</table>';
echo '</form>';
?>
<a class="button orange" href=""><i class="icon-plus-sign"></i> New</a>