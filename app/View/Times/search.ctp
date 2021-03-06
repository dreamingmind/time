<?php
	$this->Html->script('report');
	$this->Html->css('report');
?>
<div class="times form">
<?php echo $this->Form->create('Time'); ?>
	<fieldset>
		<legend><?php echo __('Edit Time'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('time_in');
		echo $this->Form->input('time_out');
		echo $this->Form->input('activity');
//		echo $this->Form->input('user');
		echo $this->Form->input('project_id', ['empty' => true]);
		echo $this->Form->input('task_id', ['empty' => true]);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div>
	<?php
		echo $this->Tk->nestedList($report, array('class' => 'timereport'));
	?>
</div>
<div>
	<?php
		$result = array_map('synthTime', $times);
		echo implode('', array_map('timeLine', $result)); 
	?>
</div>
<?php

	// <editor-fold defaultstate="collapsed" desc="MAP FUNCTIONS">
// MAP FUNCTIONS
function synthTime($val) {
	list($h, $m, $s) = explode(':', $val['Time']['duration']);
	$time = ($h * HOUR) + ($m * MINUTE) + $s;
	return [
		'time' => $time,
		'duration' => $val['Time']['duration'],
		'user' => ucwords($val['User']['username']),
		'project' => $val['Project']['name'],
		'task' => $val['Task']['name'],
		'activity' => $val['Time']['activity']
	];
}

function timeLine($time) {
	$activity = array_pop($time);
	$pattern = <<<PAT
		<span class=\"%s\">%s</span>

PAT;
	$spans = array_map(function($vals, $keys) {
		return sprintf("\t\t<span class=\"%s\">%s</span>\n", $keys, $vals);
	}, $time, array_keys($time));
	$pattern = <<<PAT
<div>
	<aside>
%s	</aside>
	<p class="activity">%s</p>
</div>\n
PAT;
	return sprintf($pattern, implode('', $spans), $activity);
}

// </editor-fold>
