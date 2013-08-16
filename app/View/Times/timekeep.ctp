<?php
$empty = array('Time' => array(
    'id' => '',
    'user' => '',
    'project' => '',
    'activity' => '',
    'time_in' => '',
    'time_out' => '0000-00-00 00:00:00'
));
if ($open){
    foreach ($open as $time) {
	echo $this->element('timeblock', array(
	    'user' => $time['Time']['user'],
	    'time' => $time));
	unset($users[$time['Time']['user']]);
    }
}
if (isset($users)) {
    foreach ($users as $user) {
	echo $this->element('timeblock', array(
	    'user' => $user,
	    'time' => $empty));
    }
}
?>