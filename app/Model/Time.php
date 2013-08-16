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
