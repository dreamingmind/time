<?php
echo $this->Form->create('Time');
    echo $this->Html->tag('Table', NULL, array('class' => 'striped tight sortable'));
        echo $this->Html->tableHeaders(array('Project', 'Task', 'Time In', 'Duration', 'Activity', 'Tools'), array('class' => 'thead'));
        if (!empty($this->request->data)) {
            foreach ($this->request->data as $index => $record) {
				$task = $this->Tk->task($record, $tasks);
                echo $this->element('track_row', array(
					'task' => $task,
                    'projects' => $projectInList,
                    'index' => $index
                ));
            }
        }
    echo '</table>';
echo '</form>';

echo $this->Form->button($this->Html->tag('i', '', array('class' => 'icon-plus-sign')) . ' New', array('class' => 'orange', 'bind' => 'click.newTimeRow'));
?>