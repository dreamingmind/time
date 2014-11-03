<?php
echo $this->Form->create();
echo $this->Form->input('user_id', array(
    'default' => $this->Session->read('Auth.User.id')
));
echo $this->Form->input('project_id');
echo $this->Form->input('activity');
echo $this->Form->button('Start');
echo $this->Form->end();