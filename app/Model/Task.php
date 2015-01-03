<?php
App::uses('AppModel', 'Model');
/**
 * Task Model
 *
 * @property Project $Project
 */
class Task extends AppModel {

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

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function groupedTaskList($type = 'all') {
		$conditions = $this->typeConditions($type);
		return $this->find('list', array('fields' => array('Task.id', 'Task.name', 'Task.project_id'), 'conditions' => $conditions));
	}
	
	public function projectTasks($projectId) {
		$task = $this->find('list', array('conditions' => array('project_id' => $projectId)));
		$task = array('newtask' => 'New task') + $task;
		return $task;
	}
}
