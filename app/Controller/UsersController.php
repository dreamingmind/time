<?php
App::uses('AppController', 'Controller');
App::uses('ReportComponent', 'Controller/Component');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
    
	public $components = array('Report');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
	
	public function initAuth() {
		$group = $this->User->Group;

		// Allow admins to everything
		$group->id = 1;
		$this->Acl->allow($group, 'controllers');

		// allow managers to posts and widgets
		$group->id = 2;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Times');
		$this->Acl->allow($group, 'controllers/Projects');
		$this->Acl->allow($group, 'controllers/Tasks');
		$this->Acl->allow($group, 'controllers/Clients');

		// allow users to only add and edit on posts and widgets
		$group->id = 4;
		$this->Acl->deny($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Times/add');
		$this->Acl->allow($group, 'controllers/Times/edit');
		$this->Acl->allow($group, 'controllers/Times/timekeep');
		$this->Acl->allow($group, 'controllers/Times/insert');

		// allow basic users to log out
		$this->Acl->allow($group, 'controllers/users/logout');

		// we add an exit to avoid an ugly "missing views" error message
		echo "all done";
		exit;
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null, $scope = 'all') {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
        switch ($scope) {
            case 'day':
                $this->User->hasMany_TimeLastDay();
                break;
            
            case 'week':
                $this->User->hasMany_TimeLastWeek();
                break;

            case 'month':
                $this->User->hasMany_TimeLastMonth();
                break;
            
            default:
                break;
        }
		$options = array(
            'conditions' => array(
                'User.' . $this->User->primaryKey => $id
                ),
            'contain' => array(
                'Group',
                'Time'
            ));
        $user = $this->User->find('first', $options);
//        dmDebug::ddd($user, 'user');
//        die;
		if (isset($user['Time'])) {
			$this->Report->summarizeUsers($user['Time']);
		}
		$this->set('userTime', $this->Report->userTime());
		$this->set('user', $user);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
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
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function login() {
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash('You are logged in!');
			return $this->redirect('/');
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			}
			$this->Session->setFlash(__('Your username or password was incorrect.'));
		}
	}

	public function logout() {
		$this->Session->setFlash('Good-Bye');
		$this->redirect($this->Auth->logout());
	}

}
