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

    var $layout = null;
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
            $this->loadModel('Task');

            $user = $this->Session->read('Auth');
            $this->request->data['users_id'] = $user['User']['id'];


            //date time needs to be fixed
            $this->request->data['start_date'] = date("Y-m-d h:i", strtotime(str_replace(",", "", $this->request->data['start_date'])));
            $this->request->data['end_date'] = date("Y-m-d h:i", strtotime(str_replace(",", "", $this->request->data['end_date'])));
            $this->Task->create();
            try {
                if ($this->Task->save($this->request->data)) {
                    //prepare new task html and send it back
                    $this->request->data['id'] = $this->Task->getLastInsertId();
                    $output = array_key_exists("dontoutput", $this->request->data) ? false : true;
                    if ($output) {
                        $view = new View($this, false);
                        echo $view->element('prepare_new_task', array("task" => $this->request->data, "edit" => true));
                        exit;
                    }
                    return true;
                }
            } catch (Exception $e) {
                return "Field missing";
            }
        }
    }

    function saveList() {
        if ($this->request->is('ajax') && count($this->request->data)) {
            $this->loadModel('TaskList');

            $user = $this->Session->read('Auth');
            $this->request->data['users_id'] = $user['User']['id'];
            //date time needs to be fixed
            $this->request->data['title'] = $this->request->data['newlist_title'];
            //To Do //get the latest ordering and add one to it
            $this->request->data['ordering'] = 0;
            $this->TaskList->create();
            try {
                if ($this->TaskList->save($this->request->data)) {

                    //prepare new task html and send it back
                    $this->request->data['id'] = $this->TaskList->getLastInsertId();
                    $output = array_key_exists("dontoutput", $this->request->data) ? false : true;
                    if ($output) {
                        $view = new View($this, false);
                        echo $view->element('prepare_new_list', array("tasklist" => $this->request->data, "edit" => true));
                        exit;
                    }
                    return true;
                }
            } catch (Exception $e) {
                return "Field missing";
            }
        }
    }

    function calculateWeeklyHours() {
        if ($this->request->is('ajax') && count($this->request->data)) {
            $this->loadModel('Task');

            $user = $this->Session->read('Auth');
            $this->request->data['users_id'] = $user['User']['id'];
            //date time needs to be fixed
            //////////////
            $startdate = date("Y-m-d", strtotime(str_replace(",", "", $this->request->data['start_date'])));
            $weeknumber = date("W", strtotime($startdate)); //1
            $year = date("Y", strtotime($startdate)); //2014
            $stardate1 = date('Y-m-d', strtotime($year . "W" . $weeknumber . 1));
            $stardate2 = date('Y-m-d', strtotime($year . "W" . $weeknumber . 7));

            $db = ConnectionManager::getDataSource("default");
            $query = 'SELECT SUM(estimated_hours) as estimatdhours FROM tasks WHERE users_id="' . $user['User']['id'] . '" AND start_date BETWEEN "' . $stardate1 . '" AND "' . $stardate2 . '"';
            $totalhours = $db->fetchAll($query);

            echo $totalhours[0][0]['estimatdhours'];
            exit;
        }
    }

    function updateEnergy() {

        if ($this->request->is('ajax') && count($this->request->data)) {

            $user = $this->Session->read('Auth');
            //date time needs to be fixed
            $this->loadModel('User');
            $olduser = $this->User->findById($user['User']['id']);

            //update settings
            $settings = $this->saveSettings($user['User']['id'], array("energy_hours" => $this->request->data['energy_hours']));
            $olduser['User']['settings'] = $settings;
            if ($olduserupdated = $this->User->save($olduser)) {
                die("1"); //something went wrong
            }
        }
        die("0");
    }

    /**
     * takes userid, and a single setting value pair
     */
    function saveSettings($userid, $dupsetting) {

        $User = $this->loadModel('User');
        $olduser = $this->User->findById($userid);
        $settings = $olduser['User']['settings'];
        $settings = !empty($settings) ? $settings : array();

        //updating
        $settings = (array) json_decode($settings);
        foreach ($dupsetting as $key => $set) {
            $settings[$key] = $set;
        }


        return json_encode($settings);
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
                $newtask['Task']['title'] = $task['task']['title'];
                $view = new View($this, false);
                echo $view->element('prepare_new_task', array("task" => $newtask['Task'], "edit" => true));
                exit;
            }
            die("0"); //something went wrong
        }
    }

    function updateTaskListBelonging() {

        if ($this->request->is('ajax') && count($this->request->data)) {

            $task = $this->Task->findById($this->request->data['id']);
            if (!$task) {
                die("task not found"); //something went wrong
            }

            $user = $this->Session->read('Auth');
            $this->request->data['users_id'] = $user['User']['id'];
            try {
                if ($this->Task->save($this->request->data)) {
                    die("1");
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
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

            $userdata = $this->Task->find("all", array('conditions' => array('Task.users_id =' => $user['User']['id'])));
            foreach ($userdata as &$task) {
                $task['Task']['start_date'] = date('j F, Y G:i', strtotime($task['Task']['start_date']));
                $task['Task']['end_date'] = date('j F, Y G:i', strtotime($task['Task']['end_date']));
            }
            echo json_encode($userdata);

            die();
        }
        die("snooping around?");
    }

    function setEditTaskIdInSession() {
        if ($this->request->is('ajax')) {
            $this->Session->write('Tasks.editTaskId', $this->request->data['editTaskId']);
            die("1");
        }
    }

    function destoryEditTaskIdInSession() {
        if ($this->request->is('ajax')) {
            $this->Session->delete('Tasks.editTaskId');
            die("1");
        }
    }

    function getUserPref() {
        //user prefs
        $array = array("g_punctual" => "0");
        echo json_encode($array);
        die();
    }
    function beforeFilter() {
        
        parent::beforeFilter();
        
    }
}

?>
