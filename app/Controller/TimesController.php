<?php

App::uses('AppController', 'Controller');
App::uses('TkHelper', 'Helper');

/**
 * Times Controller
 *
 * @property Time $Time
 */
class TimesController extends AppController {
    
    public $helpers = array('Tk');
	
	public $components = array('Report');

    public $userId;
	
	/**
	 * The Task Model
	 *
	 * @var obj
	 */
	protected $Task; 

	public function beforeFilter() {
		$this->Auth->allow('duplicateTimeRow');
		$this->Task = ClassRegistry::init('Task');

        parent::beforeFilter();
//		$this->Auth->allow('index', 'view');
//        $this->Auth->allow();
    }

    /**
     * index method standard bake
     *
     * @return void
     */
    public function index() {
        $this->Time->recursive = 0;
        $this->paginate = array(
            'order' => array(
                'Time.created' => 'desc'
            )
        );
        $this->set('times', $this->paginate());
    }

    /**
     * view method standard bake
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Time->exists($id)) {
            throw new NotFoundException(__('Invalid time'));
        }
        $options = array('conditions' => array('Time.' . $this->Time->primaryKey => $id));
        $this->set('time', $this->Time->find('first', $options));
    }

    /**
     * add method standard bake
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Time->create();
            if ($this->Time->save($this->request->data)) {
                $this->Session->setFlash(__('The time has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The time could not be saved. Please, try again.'));
            }
        }
//		$users = $this->Time->User->find('list');
//		$projects = $this->Time->Project->find('list');
        $this->set(compact('users', 'projects'));
    }

    /**
     * edit method standard bake
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null, $info = FALSE) {
		$saved = FALSE;
        if (!$this->Time->exists($id)) {
            throw new NotFoundException(__('Invalid time'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Time->save($this->request->data)) {
                $this->Session->setFlash(__('The time has been saved'));
				if (!$info) {
					// redirect for normal CRUD successful save
					$this->redirect(array('action' => 'index'));
				} else {
					// successful ajax save sets flag and falls through
					$saved = TRUE;
				}
            } else {
				// failed save, fall through to normal or ajax re-render
                $this->Session->setFlash(__('The time could not be saved. Please, try again.'));
            }
        } else {
			// not a post/put. just a rendering fall-through
            $options = array('conditions' => array('Time.' . $this->Time->primaryKey => $id));
            $this->request->data = $this->Time->find('first', $options);
        }
		// first visit, failed normal save, succesful of failed ajax save all run through here
		$this->setUiSelects();
		
		if ($info) {
			// This runs if the info button was clicked on the track page
			$this->layout = 'ajax';
			if ($saved) {
				$index = $this->request->data['Time']['id'];
				$this->request->data = array($index => $this->Time->find('first', array(
					'conditions' => array('Time.id' => $index),
					'contain' => FALSE)));
				$this->set('index', $index);
				$this->render('/Elements/track_row');
			} else {
				$this->render('/Elements/info');
			}
		}
    }

    /**
     * delete method standard bake
     *
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Time->id = $id;
        if (!$this->Time->exists()) {
            throw new NotFoundException(__('Invalid time'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Time->delete()) {
            $this->Session->setFlash(__('Time deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Time was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

	/**
	 * Main ui
	 */
    public function track($days = 1) {
        $this->userId = $this->Session->read('Auth.User.id');
		
        $this->request->data = $this->Time->openRecords($this->userId, $days);
        $this->request->data = $this->Time->reindex($this->request->data);
//		dmDebug::ddd($this->Time->reportData, 'report data');
		
		$this->set('report', 
				isset($this->Time->reportData['Time']) 
				? $this->Report->summarizeUsers($this->Time->reportData['Time']) 
				: array());
		$this->setUiSelects('jobs');
    }

	/**
	 * Request for new time record from main ui
	 */
    public function newTimeRow() {
        $this->layout = 'ajax';
        $this->request->data('Time.user_id', $this->Auth->user('id'))
                ->data('Time.time_in', date('Y-m-d H:i:s'))
                ->data('Time.time_out', date('Y-m-d H:i:s'))
                ->data('Time.project_id', NULL)
                ->data('Time.duration', '00:00')
                ->data('Time.status', OPEN);
        $this->Time->create($this->request->data);
        $result = $this->Time->save($this->request->data);
        $this->request->data = array($result['Time']['id'] => $result);
		
        $this->set('userId', $result['Time']['user_id']);
		$this->set('index', $result['Time']['id']);
		$this->setUiSelects('jobs');
		
        $this->render('/Elements/track_row');
    }
    
	/**
	 * Duplicate a recor for a new time record
	 */
    public function duplicateTimeRow($id) {
        $this->layout = 'ajax';
		$this->request->data = $this->Time->find('first', array('conditions' => array('Time.id' => $id)));
        $this->request->data('Time.user_id', $this->Auth->user('id'))
				->data('Time.id', NULL)
                ->data('Time.time_in', date('Y-m-d H:i:s'))
                ->data('Time.time_out', date('Y-m-d H:i:s'))
                ->data('Time.duration', '00:00')
                ->data('Time.status', OPEN);
        $this->Time->create($this->request->data);
        $result = $this->Time->save($this->request->data);
        $this->request->data = array($result['Time']['id'] => $result);
		
        $this->set('userId', $result['Time']['user_id']);
		$this->set('index', $result['Time']['id']);
		$this->setUiSelects('jobs');
		
        $this->render('/Elements/track_row');
    }
    
    public function deleteRow($id) {
        $this->layout = 'ajax';
        $result = $this->Time->delete($id);
        $this->set('result', array('result' => $result));
        $this->render('/Elements/json_return');
    }
    
    public function saveField() {
        $result = array();
        $this->layout = 'ajax';
        $this->Time->id = $this->request->data['id'];
        if($this->request->data['fieldName'] == 'duration'){
            $this->saveDuration();
        } else {
            $this->saveStandard();
        }
        $result['result'] = $this->Time->save($this->request->data);
        $result['duration'] = substr($this->Time->field('Time.duration', array('Time.id' => $this->request->data['Time']['id'])),0,5);
        $this->set('result', $result);
        $this->render('/Elements/json_return');
    }
    
    private function saveDuration() {
        $time = explode(':', $this->request->data['value']);
        if (count($time) == 1) {
            $durSeconds = ($time[0] * MINUTE);
        }  else {
            $durSeconds = ($time[0] * HOUR + $time[1] * MINUTE);
        }      
        $timeIn = date('Y-m-d H:i:s', time() - $durSeconds);
        $timeOut = date('Y-m-d H:i:s', time());
        $this->request->data= array(
            'Time' => array(
                'id' => $this->request->data['id'],
                'time_in' => $timeIn,
                'time_out' => $timeOut
            )
        );
    }
    
    private function saveStandard() {
        $this->request->data = array(
            'Time' => array(
                'id' => $this->request->data['id'],
                $this->request->data['fieldName'] => $this->request->data['value']
        ));
    }
    
	/**
	 * Close a time record
	 * 
	 * Same as pause, but with a different state
	 * 
	 * @param string $id
	 * @param int $state
	 */
    public function timeStop($id, $state = CLOSED) {
        $this->layout = 'ajax';
        $time = date('Y-m-d H:i:s');
        if($this->Time->getRecordStatus($id) != PAUSED){
            $this->request->data('Time.time_out', $time);
        }
        $this->request->data('Time.id', $id)
                ->data('Time.status', $state);
        $element = $this->saveTimeChange($id);
        $this->render($element);
    }
    
	/**
	 * Pause a time record
	 * 
	 * @param string $id
	 */
    public function timePause($id) {
		$this->timeStop($id, PAUSED);
    }
    
	/**
	 * Restart a stopped or paused time record
	 * 
	 * @param string $id
	 */
    public function timeRestart($id) {
        $this->layout = 'ajax';
        $duration = $this->Time->field('duration', array('Time.id' => $id));
        $this->request->data('id', $id)
                ->data('value', $duration);
        $this->saveDuration();
        $this->request->data('Time.status', OPEN);
        $element = $this->saveTimeChange($id);
        $this->render($element);
    }
    
	/**
	 * Save time record and choose prepare view based on save result
	 * 
	 * @param string $id
	 * @return string The element to render
	 */
    private function saveTimeChange($id) {
        if(!$this->Time->save($this->request->data)){
            $this->Session->setFlash('The record update failed, please try again.');
            $element = '/Elements/ajax_flash';
        } else {
            $this->request->data[$id] = $this->Time->find('first', array('conditions' => array('Time.id' => $id)));
            $this->set('index', $id);
			$this->setUiSelects('jobs');
            $element = '/Elements/track_row';
        }
        return $element;
    }
	
	/**
	 * Set the users, projects and tasks viewVars for UI forms
	 * 
	 * @param string $type filtering desired for project/task lists
	 */
	private function setUiSelects($type = 'all') {
	    $users = $this->Time->User->fetchList();
		$projects = $this->Time->Project->selectList($type);
		$tasks = $this->Task->groupedTaskList($type);
        $this->set(compact('users', 'projects', 'tasks'));
		
	}
}
