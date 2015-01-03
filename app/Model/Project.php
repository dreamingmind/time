<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 * @property Client $Client
 * @property Time $Time
 */
class Project extends AppModel {
	
	public $actsAs = array('WorkList');

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'name' => array(
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

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'Time' => array(
			'className' => 'Time',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	/**
	 * Get a filtered list of jobs
	 * 
	 * jobs, active, maintenance, inactive, all|NULL
	 * jobs = active || maintenance
	 * 
	 * @param string $type 
	 * @return array The list as id => project_name or project_name => id
	 */
	public function selectList($type = 'all') {
		$conditions = $this->typeConditions($type);
		return $this->find('list', array(
			'conditions' => $conditions,
			'field' => array('id', 'name')
		));
	}
	
	/**
	 * Get a filtered list of jobs
	 * 
	 * jobs, active, maintenance, inactive, all|NULL
	 * jobs = active || maintenance
	 * 
	 * @param string $type 
	 * @return array The list as project_name => id
	 */
	public function inList($type = 'all') {
		$conditions = $this->WorkList->typeConditions($type);
		return $this->find('list', array(
			'conditions' => $conditions,
			'field' => array('name', 'id')
		));
		
	}
	
}
