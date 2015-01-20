<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');
App::uses('dmDebug', 'Lib');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		'DebugKit.Toolbar',
        'Acl',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
        ),
        'Session'
    );
	
    public $helpers = array('Html', 'Form', 'Session', 'Js');
    
    /**
	 * Session timeout limits
	 * 
	 * @var array The idle and warning limits 
	 */
	public $timerParams = array(
		'idleLimit' => 3600, //enter seconds (20 minutes)
		'warningLimit' => 3400 //enter seconds (2 minutes)
	);
    
    public $taskStates = array(
        'active' => 'active',
        'inactive' => 'inactive',
        'maintenance' => 'maintenance',
        'migrate' => 'migrate'
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->set('title_for_layout', 'DMTime');
		
        //Configure AuthComponent
        $this->Auth->loginAction = array(
          'controller' => 'users',
          'action' => 'login'
        );
        $this->Auth->logoutRedirect = array(
          'controller' => 'users',
          'action' => 'login'
        );
        $this->Auth->loginRedirect = array(
          'controller' => 'times',
          'action' => 'track'
        );
        
        //set the timerParams variable to property for automatic timeouts
		$this->set('timerParams', $this->timerParams);
        
        //set the taskStates variable for all pages
        $this->set('taskStates', $this->taskStates);
    }
	
	public function isPostPut() {
		return ($this->request->is('post') || $this->request->is('put'));
	}
}
