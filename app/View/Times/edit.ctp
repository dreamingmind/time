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
		echo $this->Form->input('user');
		echo $this->Form->input('project');
		echo $this->Form->input('Tasks.name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
