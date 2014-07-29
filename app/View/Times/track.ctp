<?php
	echo $this->Form->create('Time');
	echo $this->Html->tag('Table', NULL, array('class' => 'striped tight sortable'));
	echo $this->Html->tableHeaders(array('Project', 'Time In', 'Duration', 'Activity', 'Tools'));
	$actionButtons = '<ul class="button-bar">
<li><a href=""><i class="icon-stop"></i></a></li>
<li><a href=""><i class="icon-pause"></i></a></li>
<li><a href=""><i class="icon-backward"></i></a></li>
<li><a href=""><i class="icon-forward"></i></a></li>
</ul>';
	if(!empty($openRecords)){
		foreach ($openRecords as $key => $record) {
			echo $this->Html->tableCells(array(
				array($projectInList[$record['Time']['project_id']], $record['Time']['time_in'], $record['Time']['duration'], $record['Time']['activity'], $actionButtons)
			));
		}
	}
	echo '</table>';
	echo '</form>';