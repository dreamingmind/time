<?php
App::uses('CakeNumber', 'Utility');

$this->start('css');
	echo $this->Html->css('report');
$this->end();
$this->start('script');
	echo $this->Html->script('report');
$this->end();
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

<div id="report">
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
		'user' => ucwords($val['User']['username']),
		'project' => $val['Project']['name'],
		'task' => $val['Task']['name'],
		'time' => $time,
		'activity' => $val['Time']['activity'],
		'id' => $val['Time']['id']
	];
}

function timeLine($time) {
	$id = array_pop($time);
	$activity = array_pop($time);
	$seconds = array_pop($time);
	$time['summaryvalue'] = CakeNumber::precision($seconds/HOUR, 2);
	$pattern = <<<PAT
		<span class=\"%s\">%s</span>

PAT;
	$spans = array_map(function($vals, $keys) {
		return sprintf("\t\t<span class=\"%s\">%s</span>\n", $keys, $vals);
	}, $time, array_keys($time));
	$pattern = <<<PAT
<div id="time-%s" class="time" data-seconds="%s">
	<aside class="keys">
%s	</aside>
	<p class="activity">%s</p>
</div>\n
PAT;
	return sprintf($pattern, $id, $seconds, (implode('', $spans)), $activity);
}

// </editor-fold>
