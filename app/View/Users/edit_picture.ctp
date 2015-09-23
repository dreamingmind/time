<?php echo $this->Form->create('User', array('type' => 'file')); ?>
<?php echo $this->Form->input('User.id'); ?>
<?php echo $this->Form->input('User.username'); ?>
<?php echo $this->Form->input('User.photo', array('type' => 'file')); ?>
<?php echo $this->Form->end('Submit'); ?>