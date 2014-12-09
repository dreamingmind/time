<?php
App::uses('AppController', 'Controller');
/**
 * Tasks Controller
 *
 * @property Task $Task
 */
class TasksController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add');
	}

	/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Task->recursive = 0;
		$this->set('tasks', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Task->exists($id)) {
			throw new NotFoundException(__('Invalid task'));
		}
		$options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
		$this->set('task', $this->Task->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
//		dmDebug::ddd($this->request->data, 'trd');die;
		if ($this->request->is('post')) {
			$this->Task->create();
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				if (!$this->request->is('ajax')) {
					$this->redirect(array('action' => 'index'));
				}				
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		}
		if ($this->request->is('ajax')) {
			$tasks = $this->Task->groupedTaskList();
			$this->request->data['Time'] = $this->request->data['Task'];
			$this->set($task = $this->Task->projectTasks($this->request->data['Task']['project_id']));
			$this->layout = 'ajax';
			$this->render('/Elements/task_select');
//			exit();
		} else {
			$projects = $this->Task->Project->find('list');
			$this->set(compact('projects'));
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Task->exists($id)) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Task.' . $this->Task->primaryKey => $id));
			$this->request->data = $this->Task->find('first', $options);
		}
		$projects = $this->Task->Project->find('list');
		$this->set(compact('projects'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Task->delete()) {
			$this->Session->setFlash(__('Task deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Task was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
