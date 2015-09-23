<div class="times form">
<?php echo $this->Form->create('Time'); ?>
	<fieldset>
		<legend><?php echo __('Edit Time'); ?></legend>
	<?php
		echo $this->Form->input('id');
//		echo $this->Form->input('user_id');
//		echo $this->Form->input('project_id');
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
//	foreach ($times as $time) {
//		list($time, $user, $project, $task) = [$time['Time'], $time['User'], $time['Project'], $time['Task']];
//		printf("<p>%s :: %s<br />%s</p>\n", $user['name'], $time['duration'], $time['activity']);
//	}
	?>
</div>
