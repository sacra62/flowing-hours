<?php

App::uses('Model', 'Model');

class TasklistsModel extends Model {

    public $name = 'TaskLists';
    public $hasMany = array(
        'Tasks' => array(
            'className' => 'Tasks',
            'order' => 'Tasks.ordering ASC'
        )
    );
    public $findMethods = array(
        'search' => true,
        'findalldead' => true
    );

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
    }

    //test function
    protected function _findAllDead($state, $query, $results = array()) {
        if ($state === 'before') {
            $query['conditions']['Tasklist.published'] = false;
            return $query;
        }
        return $results;
    }

    public function view($slug = null, $field = 'id') {
        $user = $this->find('first', array(
            'contain' => array(),
            'conditions' => array(
                'OR' => array(
                    $this->alias . '.' . $field => $slug,
                    $this->alias . '.' . $this->primaryKey => $slug),
                $this->alias . '.active' => 1,
                $this->alias . '.email_verified' => 1)));

        if (empty($user)) {
            throw new NotFoundException(__d('users', 'The user does not exist.'));
        }

        return $user;
    }

}
