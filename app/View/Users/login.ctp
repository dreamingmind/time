<?php
	echo $this->Html->tag('h2', 'Login');
	echo $this->Form->create('User', array('action' => 'login'));
	echo $this->Form->inputs(array(
		'legend' => __('Login'),
		'username',
		'password'
	));
	echo $this->Form->end('Login');