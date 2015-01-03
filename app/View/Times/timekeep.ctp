<?php
// Forms are output by the element timeblock

//echo $this->Html->para('', 'Total project time: '.intval($duration['total']));
//
//// provide defaut record data for the element
//// in case there is no open record
//$empty = array('Time' => array(
//    'id' => '',
//    'user' => '',
//    'project' => '',
//    'activity' => '',
//    'time_in' => date('Y-m-j G:i:s', time()),
//    'time_out' => '0000-00-00 00:00:00'
//));
//
//// walk through any open records
//if ($open){
//    foreach ($open as $time) {
//	echo $this->element('timeblock', array(
//	    'user' => $time['Time']['user'],
//	    'time' => $time,
//	    'duration' => intval($duration[$time['Time']['user']])));
//	
//	// take this user off the array of all users
//	unset($users[$time['Time']['user']]);
//    }
//}
//
//// walk through any remaining users
//// and make empty forms for them
//if (isset($users)) {
//    foreach ($users as $user) {
//	echo $this->element('timeblock', array(
//	    'user' => $user,
//	    'time' => $empty,
//	    'duration' => intval($duration[$user])));
//    }
//}
?>