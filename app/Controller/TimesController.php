<?php

App::uses('AppController', 'Controller');

/**
 * Times Controller
 *
 * @property Time $Time
 */
class TimesController extends AppController {

    public $userId;

    public function beforeFilter() {
        parent::beforeFilter();
//		$this->Auth->allow('index', 'view');
        $this->Auth->allow();
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
    public function edit($id = null) {
        if (!$this->Time->exists($id)) {
            throw new NotFoundException(__('Invalid time'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Time->save($this->request->data)) {
                $this->Session->setFlash(__('The time has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The time could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Time.' . $this->Time->primaryKey => $id));
            $this->request->data = $this->Time->find('first', $options);
        }
//		$users = $this->Time->User->find('list');
//		$projects = $this->Time->Project->find('list');
        $this->set(compact('users', 'projects'));
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
     * Main time keeping interface
     * 
     * Shows one record for each user.
     * A record with time_in and time_out == 0 will be loaded if it exists
     * An empty record presented if no partial (open) record exists
     */
    public function timekeep() {
        // Save data if some is posted
        $message = 'No save attempted.';
        if ($this->request->is('post')) {
            $message = $this->Time->saveTime($this->request->data);
        }
        // get array of total project and individual time
        $duration = $this->Time->getTimeTotals();
        // get any open records
        $open = $this->Time->getOpenRecord();
        // get a list of all projects
        $projects = $this->Time->find('list', array('fields' => array('Time.project', 'Time.project')));
        // get a list of all users
        $users = $this->Time->getNames();

        // send all the vars to the view
        $this->set(compact('open', 'projects', 'users', 'duration'));
        debug($message);
    }

    public function insert() {
        $sequence = array();
        $low = 1;
        $high = 2;
        for ($i = 0; $i < 41; $i++) {
            $sequence[$i]['low'] = $low;
            $sequence[$i]['tween'] = $low + (($high - $low) / 2);
            $sequence[$i]['high'] = $high;
            $low = $sequence[$i]['tween'];
        }
        $this->set('sequence', $sequence);
    }

    public function tree_jax($line, $sibling, $parent) {
        $this->layout = 'ajax';
        $this->set(compact('line', 'sibling', 'parent'));
    }

    public function track() {
        $this->userId = $this->Session->read('Auth.User.id');
        $openRecords = $this->Time->openRecords($this->userId);
        if (!empty($openRecords)) {
            $pList = array();
            foreach ($openRecords as $key => $record) {
                $p = array($record['Time']['project_id'] => $record['Time']['project_id']);
                $pList = array_merge($p, $pList);
            }
            $projectInList = $this->Time->Project->projectsInList($pList);
        }
        $userId = $this->userId;
        $this->set(compact('openRecords', 'projectInList', 'userId'));
    }

    public function newTime() {
        if ($this->request->is('post')) {
            $this->Time->create();
            $this->request->data['Time']['time_in'] = date('Y-m-d H:i:s');
            $this->request->data['Time']['time_out'] = date('Y-m-d H:i:s');
            $this->request->data['Time']['status'] = OPEN;
//            dmDebug::ddd($this->request->data, 'trd');
//            die;
            if ($this->Time->save($this->request->data)) {
                $this->Session->setFlash(__('The time has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The time could not be saved. Please, try again.'));
            }
        }
        $users = $this->Time->User->fetchList($this->Auth->user('id'));
        $projects = $this->Time->Project->fetchList($this->Auth->user('id'));
        $this->set(compact('users', 'projects'));
    }

    public function newTimeRow() {
        $this->layout = 'ajax';
        $this->Time->create();
        $this->request->data['Time']['user_id'] = $this->Auth->user('id');
        $this->request->data['Time']['time_in'] = date('Y-m-d H:i:s');
        $this->request->data['Time']['time_out'] = date('Y-m-d H:i:s');
        $this->request->data['Time']['status'] = OPEN;
        $record = $this->Time->save($this->request->data);
//            dmDebug::ddd($this->request->data, 'trd');
//            die;
//        if ($this->Time->save($this->request->data)) {
//            $this->Session->setFlash(__('The time has been saved'));
//            $this->redirect(array('action' => 'index'));
//        } else {
//            $this->Session->setFlash(__('The time could not be saved. Please, try again.'));
//        }
        $users = $this->Time->User->fetchList($this->Auth->user('id'));
        $projects = $this->Time->Project->fetchList($this->Auth->user('id'));
        $this->set(compact('users', 'projects', 'record'));
        $this->render('/Elements/track_row');
    }

}
