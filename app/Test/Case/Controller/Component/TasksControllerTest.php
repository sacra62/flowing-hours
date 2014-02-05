<?php

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class TasksControllerTest extends ControllerTestCase {

    public $fixtures = array('app.tasks');
    var $layout = null;
    var $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'index'),
            'authError' => "You can't access that page",
            'authorize' => array('Controller')
            ));
    var $data = array(
        'data' => array(
            'title' => 'TEST Case',
            'desc' => 'TEST Case description',
            'estimated_hours' => 2,
            'start_date' => '23 January, 2014 14:43',
            'end_date' => '24 January, 2014 14:43',
            'tasklists_id' => 1,
            'reported_hours' => 0,
            'dontoutput'=>1
        )
    );
    /*
     * setting up the test case
     */

    public function setUp() {
        parent::setUp();
    }

    function testsaveTask() {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        //to see output uncomment the line below
        //unset($this->data['data']['dontoutput']);
        $result = $this->testAction(
                '/tasks/saveTask', array('data' => $this->data, 'method' => 'post')
        );
        
        debug($result);
    }

    function testsaveTaskNoAjaxCheck() {
        $expected = null; //request did not get throgh
        $result = $this->testAction(
                '/tasks/saveTask', array('data' => $this->data, 'method' => 'post')
        );
        $this->assertEquals($expected, $result);
        debug($result);
    }

    function testsaveTaskNoTitleCheck() {
        //$expected = "0"; //fields missing or invalid - also set the title to null to check
        $expected = "Field missing";
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $this->data['data']['title'] = null;
        $result = $this->testAction(
                '/tasks/saveTask', array('data' => $this->data, 'method' => 'post')
        );
        $this->assertEquals($expected, $result);
        $result = $expected==$result ? true : false;
        debug($result);
    }

}

?>
