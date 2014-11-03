<?php
echo $this->Form->create('Time');
echo $this->Html->tag('Table', NULL, array('class' => 'striped tight sortable'));
echo $this->Html->tableHeaders(array('Project', 'Time In', 'Duration', 'Activity', 'Tools'), array('class' => 'thead'));
if (!empty($this->request->data)) {
    foreach ($this->request->data as $index => $record) {
        echo $this->element('track_row', array(
            'projects' => $projectInList,
            'index' => $index
        ));
    }
}
echo '</table>';
echo '</form>';
?>
<a class="button orange" bind="click.newTimeRow" href=""><i class="icon-plus-sign"></i> New</a>