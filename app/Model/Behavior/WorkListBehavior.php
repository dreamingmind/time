<?php

/**
 * Project and Task states
 */
define("ACTIVE", 'active');
define("INACTIVE", 'inactive');
define("MAINTENANCE", 'maintenance');

/**
 * CakePHP WorkListBehavior
 * @author dondrake
 */
class WorkListBehavior extends ModelBehavior {

	public function setup(Model $model, $settings = array()) {
		$this->settings[$model->alias] = $settings;
	}

	public function cleanup(Model $model) {
		parent::cleanup($model);
	}

// <editor-fold defaultstate="collapsed" desc="unimplemented callbacks">
//	public function beforeFind($model, $query){
//
//	}

//	public function beforeValidate($model){
//
//	}
//	public function beforeSave($model){
//
//	}
//	public function afterSave($model, $created){
//
//	}
//	public function beforeDelete($model, $cascade = true){
//
//	}
//
//	public function afterFind(Model $model, $results, $primary) {
//		
//	}
//
//	public function afterDelete(Model $model) {
//		
//	}
//
//	public function onError(Model $model, $error) {
//		
//	}
// </editor-fold>


	/**
	 * Make the conditions to find projects/tasks at a state
	 * 
	 * @param string $type
	 * @return array conditions to find the desired states
	 */
	public function typeConditions(Model $model, $type = 'all') {
		switch ($type) {
			case 'jobs':
				$condition = array('OR' => array(
					array("$model->alias.state" => ACTIVE),
					array("$model->alias.state" => MAINTENANCE),
				));
				break;
			case 'active' :
				$condition = array("$model->alias.state" => ACTIVE);
				break;
			case 'inactive' :
				$condition = array("$model->alias.state" => INACTIVE);
				break;
			case 'maintenance' :
				$condition = array("$model->alias.state" => MAINTENANCE);
				break;
			default:
				$condition = array();
				break;
		}
		return $condition;
	}
	
}
