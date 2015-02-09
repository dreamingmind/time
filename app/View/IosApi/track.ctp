<?php
//dmDebug::ddd($this->request->data, 'trd');
//array(
//	(int) 819 => array(
//		'Time' => array(
//			'id' => '819',
//			'created' => '2015-02-06 07:34:18',
//			'modified' => '2015-02-06 08:02:58',
//			'user_id' => '2',
//			'project_id' => '29',
//			'time_in' => '2015-02-06 07:34:18',
//			'time_out' => '2015-02-06 08:02:58',
//			'activity' => 'Setup rollovers',
//			'user' => '',
//			'project' => '',
//			'group_id' => null,
//			'status' => '4',
//			'task_id' => '107',
//			'duration' => '00:28:40'
//		)
//	),
echo '{"resultCount": ' . count($found) . ', "results": ';
echo json_encode($found);
echo '}';