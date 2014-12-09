<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP TkHelper
 * @author jasont
 */
class TkHelper extends AppHelper {

    public $helpers = array('Form', 'Html');
    
    public $index = '';

    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
    }

    public function beforeRender($viewFile) {
        
    }

    public function afterRender($viewFile) {
        
    }

    public function beforeLayout($viewLayout) {
        
    }

    public function afterLayout($viewLayout) {
        
    }

    public function setProjectDefaultButton($projectId = NULL) {
        $buttonOptions = array('class' => 'button small blue', 'title' => 'Set default project', 'bind' => 'click.setDefaultProject');
        if (empty($projectId)) {
            $buttonOptions['class'] = 'button small';
            $buttonOptions['disabled'] = TRUE;
        }
        return $this->Form->button($this->Html->tag('i', '', array('class' => 'icon-reply')), $buttonOptions);
    }

    public function timeFormActionButtons($index, $status) {
        $this->index = $index;
        $buttons = array(
            $this->actionButton('icon-info-sign', 'click.timeInfo')
        );
        if($status & CLOSED){
            $buttons[] = $this->actionButton('icon-refresh', 'click.timeReopen');
            $buttons[] = $this->actionButton('icon-trash', 'click.timeDelete');
        } else {
            $buttons[] = $this->actionButton('icon-stop', 'click.timeStop');
            $buttons[] = $this->pauseButton($status);
            $buttons[] = $this->actionButton('icon-trash', 'click.timeDelete');
        }
        return $this->Html->nestedList($buttons, array('class' => 'button-bar'));
    }
    
    private function actionButton($type, $bind = NULL) {
        $attributes = array(
            'escape' => FALSE, 
            'index' => $this->index);
        if($bind != NULL){
            $attributes['bind'] = $bind;
        }
        return $this->Html->link($this->Html->tag('i', '', array('class' => $type)), '', $attributes);
    }
    
    private function pauseButton($status) {
        if($status & OPEN){
            $button = $this->actionButton('icon-pause', 'click.timePause');
        } else {
            $button = $this->actionButton('icon-play', 'click.timeRestart');
        }
        return $button;
    }
    
//    $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-info-sign')), '', array('bind' => 'click.timeInfo', 'escape' => FALSE, 'index' => $index)),

	/**
	 * Extract the correct task list for a project
	 * 
	 * given a Time record (with project_id field) and 
	 * the full task list (grouped by project id), return the 
	 * tasks for the project with a 'New task' choice prepended. 
	 * Or return just the 'New task' choice if the project has no tasks.
	 * 
	 * @param array $record
	 * @param array $tasks
	 * @return array
	 */
	public function task($record, $tasks) {
		if ($record['Time']['project_id'] != '') {
			$task = (isset($tasks[$record['Time']['project_id']])) ? array_merge(array('newtask' => 'New task'), $tasks[$record['Time']['project_id']]) : array('newtask' => 'New task');
		} else {
			$task = array('newtask' => 'New task');
		}
		return $task;
	}
	
	/*
	 * 		echo $this->Form->input('task_id', array(
			'options' => $task,
			'empty' => 'Choose a task',
			'bind' => 'change.taskChoice',
			'project_id' => $this->request->data['Time']['project_id']
		));		

	 *
	 * 		$this->Form->input("$index.Time.task_id", array(
			'options' => $task,
			'label' => FALSE,
			'div' => FALSE,
			'empty' => 'Choose a task',
			'bind' => 'change.taskChoice',
			'project_id' => $this->request->data[$index]['Time']['project_id']
		)),

	 */
	
	public function taskSelect($field, $data, $options = FALSE){
		$projectId = $data['Time']['project_id'];
		$Task = ClassRegistry::init('Task');
		$task = $Task->projectTasks($projectId);
		$attributes = array(
			'options' => $task,
			'empty' => 'Choose a task',
			'bind' => 'change.taskChoice',
			'project_id' => $projectId
		);
		if ($options) {
			$attributes = array_merge($options, $attributes);
		}
		return $this->Form->input($field, $attributes);
	}

}
