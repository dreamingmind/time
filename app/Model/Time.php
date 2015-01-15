<?php

App::uses('AppModel', 'Model');

/**
 * Time Model
 *
 * @property User $User
 * @property Project $Project
 */
class Time extends AppModel {
	
	/**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'user_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            ),
        )
    );

    /**
     * A list of all user names
     * 
     * array (name => name)
     *
     * @var array array of user names
     */
    var $names = false;

//These relationshops are for possible future expansion to multi table solution

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'project_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Task' => array(
            'className' => 'Task',
            'foreignKey' => 'task_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )

    );
    
//    public $virtualFields = array(
//        'duration' => 'TIMEDIFF(Time.time_out,Time.time_in)'
//    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
    }
    
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields['duration'] = "TIMEDIFF($this->alias.time_out, $this->alias.time_in)";
    }
    
    /**
     * Set an array property of all user names
     * 
     * array ( name => name)
     * 
     * @return array The property that contains all the user names
     */
    function getNames() {
        if (!$this->names) {
            $this->names = $this->find('list', array('fields' => array('Time.user', 'Time.user')));
        }
        return $this->names;
    }

    /**
     * Get individual and total project time
     * 
     * This does not account for multiple projects
     * array (
     * 	'total' => integer,
     * 	username => integer (one for each user, by name)
     * )
     * 
     * @return array Total and individual total time
     */
    function getTimeTotals() {
        // get a list of users
        $this->getNames();
        // walk through and get their summed time
        $this->duration = array();
        foreach ($this->names as $name) {
            $duration = $this->find('all', array(
                'fields' => array('SUM(duration)'),
                'conditions' => array('user' => $name)));
            $this->duration[$name] = $duration[0][0]['SUM(duration)'];
        }
        // now get total time
        $duration = $this->find('all', array(
            'fields' => array('SUM(duration)')));
        $this->duration['total'] = $duration[0][0]['SUM(duration)'];

        return $this->duration;
    }

    /**
     * Get open time records if they exist
     * 
     * @return array|false data or false if there are no open records
     */
    function getOpenRecord() {
        $open = $this->find('all', array('conditions' => array('Time.time_out <' => '1')));
        return $open;
    }

    /**
     * Save a time record (possibly with calculated duration)
     * 
     * Only works if time is entered in 24 hour format
     * Calc the duration if the record is being closed
     * Save the record 
     * 
     * @param array $data A record to save
     */
    function saveTime($data) {
        // make the array access shorter
        $inputs = $data['Time'];
        $message = '';
        // this if may be meaingless
        if (isset($inputs['time_in']) && isset($inputs['time_out'])) {
            $message .= "Time inputs are set.\r";
            $in = strtotime($inputs['time_in']);
            $out = strtotime($inputs['time_out']);
            // this if checks to see if the recor has both time_in and time_out set
            if ($in > 0 && $out > 0) {
                $message .= "Duration being caluculated.\r";
                // HOUR is a cake constant (3600)
                $data['Time']['duration'] = ($out - $in) / HOUR;
            }
        }
        if ($this->save($data)) {
            $message .= 'Successful save.';
        } else {
            $message .= 'Save failed';
        }
        return $message;
    }

    /**
     * Find and return an array of all open records belonging to the provided user id
     * 
     * @param int $userId
     * @return array
     */
    public function openRecords($userId, $days = 1) {
        $records = $this->find('all', array(
            'conditions' => array(
                'user_id' => $userId,
                'OR' => array(
                    'status' => OPEN,
                    'modified >' => date('Y:m:d H:i:s', time()-$days*DAY)
                )
            ),
            'recursive' => -1
        ));
        return $records;
    }
	
	/**
	 * Re-index a find(all) result onto Time.id
	 * 
	 * @param type $data EXPECTS!! [0][Alias][field] and [id] in the field set
	 */
	public function reindex($data) {
		$this->reportData = array();
		$result = array();
		foreach($data as $record) {
			if (isset($record['Time']['id'])) {
				$result[$record['Time']['id']] = $record;
				$this->reportData['Time'][] = $record['Time'];
			}			
		}
		if (empty($result)) {
			return $data;
		} else {
			return $result;
		}
	}

}
