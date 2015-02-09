<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP IosApiController
 * @author dondrake
 */
class IosApiController extends AppController {

	public $useTable = 'times';
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('track');
	}
	
	public function index($id) {
		
	}

	/**
	 * Main ui
	 */
    public function track($days = 1) {
		$this->layout = 'ajax';
		$this->Time = ClassRegistry::init('Time');
        $this->userId = array(2, 3);
		
        $this->request->data = $this->Time->openRecords($this->userId, $days);
        $this->request->data = $this->Time->reindex($this->request->data);
		foreach($this->request->data as $record) {
			$found[] = $record['Time'];
		}
		$this->set('found', $found);
//		dmDebug::ddd($this->Time->reportData, 'report data');
		
//		$this->set('report', 
//				isset($this->Time->reportData['Time']) 
//				? $this->Report->summarizeUsers($this->Time->reportData['Time']) 
//				: array());
//		$this->setUiSelects('jobs');
    }

}
