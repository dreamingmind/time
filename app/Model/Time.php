<?php
App::uses('AppModel', 'Model');
/**
 * Time Model
 *
 * @property User $User
 * @property Project $Project
 */
class Time extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'project' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	var $names = false;

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
//	public $belongsTo = array(
//		'User' => array(
//			'className' => 'User',
//			'foreignKey' => 'user_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
//		'Project' => array(
//			'className' => 'Project',
//			'foreignKey' => 'project_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
//	);
	
	function getNames(){
	    if (!$this->names){
		$this->names = $this->find('list',array('fields' => array('Time.user', 'Time.user')));
	    }
	    return $this->names;
	}
	
	function getTimeTotals(){
	    $this->getNames();
	    $this->duration = array();
	    foreach ($this->names as $name) {
		$duration = $this->find('all', array(
		    'fields' => array('SUM(duration)'),
		    'conditions' => array('user' => $name)));
		$this->duration[$name] = $duration[0][0]['SUM(duration)'];
	    }
	    $duration = $this->find('all', array(
		'fields' => array('SUM(duration)')));
	    $this->duration['total'] = $duration[0][0]['SUM(duration)'];
	    
	    return $this->duration;		
	}
	
	function getOpenRecord(){
	    $open = $this->find('all', array('conditions' => array('Time.time_out <' => '1')));
	    return $open;
	}
	
	function saveTime($data){
	    $inputs = $data['Time'];
	    if ( isset($inputs['time_in']) && isset($inputs['time_out'])) {
//		unset($inputs['time_in']['meridian']);
//		unset($inputs['time_out']['meridian']);
		$in = strtotime($inputs['time_in']);
		$out = strtotime($inputs['time_out']);
		if ($in > 0 && $out > 0) {
		    $data['Time']['duration'] = ($out - $in)/HOUR;
		}
	    }
	    $this->save($data);
	}
}
