<?php

class TasksFixture extends CakeTestFixture {

//    public $import = array('model' => 'Tasks', 'records' => true);
    public $name = 'Tasks';
    public $table = 'tasks';

    public function init() {

        parent::init();
    }

    public $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'users_id' => array('type' => 'string'),
        'tasklists_id' => array('type' => 'integer'),
        'title' => array(
            'type' => 'string',
            'length' => 255,
            'null' => false
        ),
        'desc' => 'text',
        'status' => 'integer',
        'estimated_hours' => 'integer',
        'reported_hours' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    );
}

?>
