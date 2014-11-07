<div class="projects form">
<?php echo $this->Form->create('Project'); ?>
	<fieldset>
		<legend><?php echo __('Edit Project'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('client_id');
		echo $this->Form->input('name');
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
