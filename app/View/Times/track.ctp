<?php
echo $this->Form->create('Time');
echo $this->Html->tag('Table', NULL, array('class' => 'striped tight sortable'));
echo $this->Html->tableHeaders(array('Project', 'Time In', 'Duration', 'Activity', 'Tools'));
if (!empty($openRecords)) {
    foreach ($openRecords as $key => $record) {
        echo $this->element('track_row', array(
            'record' => $record,
            'projects' => $projectInList
        ));
    }
}
echo '</table>';
echo '</form>';
?>
<a class="button orange" href=""><i class="icon-plus-sign"></i> New</a>