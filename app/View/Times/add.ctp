<div class="times form">
<?php echo $this->Form->create('Time'); ?>
	<fieldset>
		<legend><?php echo __('Add Time'); ?></legend>
	<?php
//		echo $this->Form->input('user_id');
//		echo $this->Form->input('project_id');
		echo $this->Form->input('time_in');
		echo $this->Form->input('time_out');
		echo $this->Form->input('activity');
		echo $this->Form->input('user');
		echo $this->Form->input('project');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Times'), array('action' => 'index')); ?></li>
	</ul>
</div>
