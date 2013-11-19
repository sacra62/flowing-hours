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
class TasksController extends Controller {
    var $layout = null ;
    var $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'index'),
            'authError' => "You can't access that page",
            'authorize' => array('Controller')
            ));

    public function isAuthorized($user) {
      //TO DO - security, check the users_id of the task and the logged in user

        return true;
    }

    function saveTask() {
        if ($this->request->is('ajax') && count($this->request->data)) {
            $user = $this->Session->read('Auth');
            
            $this->request->data['users_id'] = $user['User']['id'];
            //date time needs to be fixed
            $this->request->data['start_date'] = date("Y-m-d h:i", strtotime(str_replace(",", "", $this->request->data['start_date'])));
            $this->request->data['end_date'] = date("Y-m-d h:i", strtotime(str_replace(",", "", $this->request->data['end_date'])));

            $this->Task->create();
            if ($this->Task->save($this->request->data)) {
                //prepare new task html and send it back
                $this->request->data['id'] = $this->Task->getLastInsertId();
                $view = new View($this, false);
                echo $view->element('prepare_new_task', array("task" => $this->request->data, "edit" => true));
                exit;
            }
            die("0"); //something went wrong
        }
    }

    function updateTask() {
        if ($this->request->is('ajax') && count($this->request->data)) {

            $task = $this->Task->findById($this->request->data['id']);
            if (!$task) {
                die("0"); //something went wrong
            }

            $user = $this->Session->read('Auth');
            $this->request->data['users_id'] = $user['User']['id'];
            //date time needs to be fixed
            $this->request->data['start_date'] = date("Y-m-d G:i", strtotime(str_replace(",", "", $this->request->data['start_date'])));
            $this->request->data['end_date'] = date("Y-m-d G:i", strtotime(str_replace(",", "", $this->request->data['end_date'])));
            if ($newtask = $this->Task->save($this->request->data)) {
                $view = new View($this, false);
                echo $view->element('prepare_new_task', array("task" => $newtask['Task'], "edit" => true));
                exit;
            }
            die("0"); //something went wrong
        }
    }

    function deleteTask() {
        if ($this->request->is('ajax') && count($this->request->data)) {

            $task = $this->Task->findById($this->request->data['id']);
            if (!$task) {
                die("0"); //something went wrong
            }            
            if ($this->Task->delete($this->request->data['id'])) {
                die("1");
            }
            die("0"); //something went wrong
        }
    }
    function loadTasks() {
        if ($this->request->is('ajax')) {
            $user = $this->Session->read('Auth');
           
            $userdata = $this->Task->find("all",array('conditions' => array('Task.users_id =' => $user['User']['id'])));
            foreach($userdata as &$task){
                $task['Task']['start_date'] = date('j F, Y G:i', strtotime($task['Task']['start_date']));
                $task['Task']['end_date'] = date('j F, Y G:i', strtotime($task['Task']['end_date']));
            }
            echo json_encode($userdata);

            die();
        }
        die("snooping around?");
    }
    
    function setEditTaskIdInSession(){
        if ($this->request->is('ajax')) {
            $this->Session->write('Tasks.editTaskId', $this->request->data['editTaskId']);
            die("1");
        }
    }
    function destoryEditTaskIdInSession(){
        if ($this->request->is('ajax')) {
            $this->Session->delete('Tasks.editTaskId');
            die("1");
        }
    }
    

}

?>
