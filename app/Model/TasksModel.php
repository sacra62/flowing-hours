<?php

App::uses('Model', 'Model');

class TasksModel extends Model {
    public $name = 'Tasks';
    public $findMethods = array(
		'search' => true
	);
    public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
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
