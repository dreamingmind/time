<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP ReportComponent
 * @author dondrake
 */
class ReportComponent extends Component {

	public $components = array();
	

	/**
	 * The current time record of interest
	 * 
	 * This is a transient value. Be sure you set it when you need it. 
	 * Field names are first level indexes.
	 *
	 * @var array 
	 */
	private $time;
	
	private $userCumm;
		
	private $projectCumm;
	
	private $projects;
	
	private $users;
	
	private $tasks;

	public function initialize(Controller $controller) {
		
	}

	public function startup(Controller $controller) {
		
	}

	public function beforeRender(Controller $controller) {
		
	}

	public function shutDown(Controller $controller) {
		
	}

	public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true) {
		
	}

	public function summarize($timeEntries) {
		// build id=>name lookup properties;
		$this->initProperties();
		
		foreach ($timeEntries as $time) {
			$this->time = $time;
			$duration = $this->duration($time);
			$this->userCumm($duration);
			$this->projectCumm($duration);
			$this->projectUserCumm($duration);
			$this->taskCumm($duration);
			$this->taskUserCumm($duration);
		}
	}
	
	/**
	 * Return the current User Time summary
	 * 
	 * @return array
	 */
	public function userTime() {
		if (is_array($this->userCumm)) {
			return $this->userCumm;
		} else {
			return array();
		}
	}

	/**
	 * Return the current Project Time summary
	 * 
	 * @return array
	 */
	public function projectTime() {
		if (is_array($this->projectCumm)) {
			return $this->projectCumm;
		} else {
			return array();
		}
	}

	private function initProperties(){
		$project = ClassRegistry::init('Project');
		$user = ClassRegistry::init('User');
		$task = ClassRegistry::init('Task');
		$this->projects = $project->find('list');
		$this->users = $user->find('list');
		$this->tasks = $task->find('list');
	}

	private function userCumm($duration){
		if (!isset($this->userCumm[ $this->userName() ])) {
			$this->userCumm[ $this->userName() ] = 0;
		}
		$this->userCumm[ $this->userName() ] += $duration;
	}
	
	private function projectCumm($duration) {
		if (!isset($this->projectCumm['Project'][ $this->projectName() ])) {
			$this->projectCumm['Project'][ $this->projectName() ]['Time'] = 0;
		}
		$this->projectCumm['Project'][ $this->projectName() ]['Time'] += $duration;
	}
	
	private function taskCumm($duration){
		if (!isset($this->projectCumm['Project'][ $this->projectName() ]['Task'][ $this->taskName() ])) {
			$this->projectCumm['Project'][ $this->projectName() ]['Task'][ $this->taskName() ]['Time'] = 0;
		}
		$this->projectCumm['Project'][ $this->projectName() ]['Task'][ $this->taskName() ]['Time'] += $duration;
	}

	private function taskUserCumm($duration) {
		if (!isset($this->projectCumm['Project'][ $this->projectName() ]['Task'][ $this->taskName() ][ $this->userName() ])) {
			$this->projectCumm['Project'][ $this->projectName() ]['Task'][ $this->taskName() ][ $this->userName() ] = 0;
		}
		$this->projectCumm['Project'][ $this->projectName() ]['Task'][ $this->taskName() ][ $this->userName() ] += $duration;
	}
	
	private function projectUserCumm($duration) {
		if (!isset($this->projectCumm['Project'][ $this->projectName() ]['User'][ $this->userName() ]['Time'])) {
			$this->projectCumm['Project'][ $this->projectName() ]['User'][ $this->userName() ]['Time'] = 0;
		}
		$this->projectCumm['Project'][ $this->projectName() ]['User'][ $this->userName() ]['Time'] += $duration;
	}
	
	private function duration() {
		$dur = explode(':', $this->time['duration']);
//		return (($dur[0] * HOUR) + ($dur[1] * MINUTE) + $dur[2]) / HOUR;
		return number_format((($dur[0] * HOUR) + ($dur[1] * MINUTE) + $dur[2]) / HOUR , 2);
	}
	
	private function userName() {
		return  $this->users[$this->time['user_id']];
	}

	private function taskName() {
		if (is_null($this->time['task_id'])) {
			return ('un-named');
		}
		return  $this->tasks[$this->time['task_id']];
	}

	private function projectName() {
		return  $this->projects[$this->time['project_id']];
	}


}
