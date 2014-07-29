<?php
	echo $this->Form->create('Time');
	echo $this->Html->tag('Table', NULL, array('class' => 'striped tight sortable'));
	echo $this->Html->tableHeaders(array('Project', 'Time In', 'Duration', 'Activity', 'Tools'));
	$actionButtons = '<ul class="button-bar">
<li><a href="" bind="timeStop"><i class="icon-stop blue timestop"></i></a></li>
<li><a href=""><i class="icon-pause timepause"></i></a></li>
<li><a href=""><i class="icon-backward timeback"></i></a></li>
</ul>';
	if(!empty($openRecords)){
		foreach ($openRecords as $key => $record) {
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
		}
	}
	echo '</table>';
	echo '</form>';
	?>
	<a class="button orange" href=""><i class="icon-plus-sign"></i> New</a>