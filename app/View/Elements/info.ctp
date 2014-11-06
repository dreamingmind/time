<?php echo $this->Session->flash(); ?>
<div class="times form">
<?php echo $this->Form->create('Time'); ?>
	<fieldset>
		<legend><?php echo __('Edit Time'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('project_id');
		echo $this->Form->input('time_in');
		echo $this->Form->input('time_out');
		echo $this->Form->input('duration');
		echo $this->Form->input('activity');
	?>
	</fieldset>
<?php echo $this->Form->button(__('Cancel'), array('class' => 'small red', 'bind' => 'click.cancelTimeEdit')); ?>
<?php echo $this->Form->button(__('Submit'), array('class' => 'small green', 'bind' => 'click.saveTimeEdit')); ?>
<?php echo $this->Form->end(); ?>
	<style type="text/css">
/*<![CDATA[*/
div.times.form {
     background-color: grey;
     position: absolute;
     z-index: 3000;
	 left: 500px;
}

div.times.form label {
     padding-right: 8px;
     text-align: right;
     width: 100px;
}

/*]]>*/
	</style>
</div>
