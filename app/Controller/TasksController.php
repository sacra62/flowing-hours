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
            //dates maybe empty
            if (!empty($this->request->data['start_date']))
                $this->request->data['start_date'] = date("Y-m-d G:i", strtotime(str_replace(",", "", $this->request->data['start_date'])));
            if (!empty($this->request->data['end_date']))
                $this->request->data['end_date'] = date("Y-m-d G:i", strtotime(str_replace(",", "", $this->request->data['end_date'])));
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
                //when doing unit testing - use the return statment 
                //return "Field missing";
                die("0");
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
            $query = 'SELECT SUM(estimated_hours) as estimateddhours FROM tasks WHERE users_id="' . $user['User']['id'] . '" AND start_date BETWEEN "' . $stardate1 . '" AND "' . $stardate2 . '"';
            $totalhours = $db->fetchAll($query);

            echo $totalhours[0][0]['estimatedhours'];
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
            //dates maybe empty
            if (!empty($this->request->data['start_date']))
                $this->request->data['start_date'] = date("Y-m-d G:i", strtotime(str_replace(",", "", $this->request->data['start_date'])));
            if (!empty($this->request->data['end_date']))
                $this->request->data['end_date'] = date("Y-m-d G:i", strtotime(str_replace(",", "", $this->request->data['end_date'])));

            if ($newtask = $this->Task->save($this->request->data)) {
                $newtask['Task']['title'] = $task['Task']['title'];
                $view = new View($this, false);
                echo $view->element('prepare_new_task', array("task" => $newtask['Task'], "edit" => true));
                exit;
            }
            die("0"); //something went wrong
        }
    }

    function updateTaskListBelonging() {

        if ($this->request->is('ajax') && count($this->request->data)) {
            $tasksordering = $this->request->data['tasks_ordering'];
            $user = $this->Session->read('Auth');
            $this->request->data['users_id'] = $user['User']['id'];
            unset($this->request->data['tasks_ordering']);
            if (is_array($tasksordering)) {
                foreach ($tasksordering as $key => $taskid) {
                    $this->request->data['id'] = $taskid;
                    $this->request->data['ordering'] = $key;

                    try {
                        $this->Task->save($this->request->data);
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                }
                die("1");
            }
        }
    }

    function deleteTask() {
        if ($this->request->is('ajax') && count($this->request->data)) {

            if ($this->Task->delete($this->request->data['id'])) {
                die("1");
            }
            die("0"); //something went wrong
        }
    }

    function loadTasks() {
        if ($this->request->is('ajax')) {
            $user = $this->Session->read('Auth');

            $userdata = $this->Task->find("all", array('conditions' => array('Task.users_id =' => $user['User']['id'], 'Task.status =' => 0)));
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
            $this->Session->write('Tasks.editTaskListId', $this->request->data['editTaskListId']);
            die("1");
        }
        die("0");
    }

    function destoryEditTaskIdInSession() {
        if ($this->request->is('ajax')) {
            $this->Session->delete('Tasks.editTaskId');
            $this->Session->delete('Tasks.editTaskListId');
            die("1");
        }
    }

    //called by feedback.js
    function getUserPref() {
        //user prefs
        App::uses('ConnectionManager', 'Model');
        $db = ConnectionManager::getDataSource("default");
        $userid = $this->Session->read('Auth.User.id');
        $settings = $db->fetchAll("SELECT settings FROM users WHERE id='" . $userid . "'");


        //if settings exist -json decode
        $settings = $settings[0]['users']['settings'];
        $settings = !empty($settings) ? (array) json_decode($settings) : array();

        $settings['cw_energy_hours'] = $settings['energy_hours'];
        unset($settings['energy_hours']);unset($settings['calendar_wallpaper']);
        unset($settings['app_theme']);
        $settings['cw_unfinished_hours'] = 0;
        $settings['cw_finished_hours'] = 0;
        $settings['cw_total_hours'] = 0;

        $settings['lfw_unfinished_hours'] = 0;
        $settings['lfw_finished_hours'] = 0;
        $settings['lfw_total_hours'] = 0;

        //get current weeks unfinished hours

        $currentdate = date("Y-m-d");
        $currentweeknumber = sprintf("%02s", date("W", strtotime($currentdate))); //this weeks number - must be like 09 and not 9
        $currentyear = date("Y", strtotime($currentdate)); //2014

        $stardate1 = date('Y-m-d', strtotime($currentyear . "W" . $currentweeknumber));
        $stardate2 = date('Y-m-d', strtotime($currentyear . "W" . $currentweeknumber . " +6 days"));



        $query = 'SELECT * FROM tasks WHERE users_id="' . $userid . '" AND start_date BETWEEN "' . $stardate1 . '" AND "' . $stardate2 . '"';
        $currentweekdata = $this->Task->query($query);
        if (is_array($currentweekdata)) {
            //see if they are finished or not
            foreach ($currentweekdata as $tas) {
               
                $reported = (int) $tas['tasks']['reported_hours'];
                $estimated = (int) $tas['tasks']['estimated_hours'];
                if ($tas['tasks']['status'] == 0 && $reported <= $estimated) {
                    $settings['cw_unfinished_hours'] += $estimated - $reported;
                }

                $settings['cw_finished_hours'] += $reported;
            }
            //these are total hours either worked or committed to work. if more than current week's energy, tell the 
            //user to calm down.
            $settings['cw_total_hours'] += $settings['cw_unfinished_hours'] + $settings['cw_finished_hours'];
        }
        //1 week ago

        $lastweekstartdate1 = date("Y-m-d", strtotime("-1 week", strtotime($stardate1))); //2014
        $lastweekstartdate2 = date("Y-m-d", strtotime("-1 week", strtotime($stardate2))); //2014

        $query = 'SELECT * FROM tasks WHERE users_id="' . $userid . '" AND start_date BETWEEN "' . $lastweekstartdate1 . '" AND "' . $lastweekstartdate2 . '"';
        $lastweekdata = $this->Task->query($query);
        if (is_array($lastweekdata)) {
            //see if they are finished or not
            foreach ($lastweekdata as $tas) {
                $reported = (int) $tas['tasks']['reported_hours'];
                $estimated = (int) $tas['tasks']['estimated_hours'];
                if ($tas['tasks']['status'] == 0 && $reported <= $estimated) {
                    $settings['lfw_unfinished_hours'] += $estimated - $reported;
                }

                $settings['lfw_finished_hours'] += $reported;
            }
            //these are total hours either worked or committed to work. if more than current week's energy, tell the 
            //user to calm down.
            $settings['lfw_total_hours'] += $settings['lfw_unfinished_hours'] + $settings['lfw_finished_hours'];
        }

        //get feedback messages
        
        $query = 'SELECT * FROM feedbacks';
        $feedbacks = $this->Task->query($query);
        $feedbacksreturn = array();
        //group by type
        foreach($feedbacks as $feed){
            $type = $feed['feedbacks']['type'];
            $feed['feedbacks']['message'] = __($feed['feedbacks']['message'],$settings['cw_unfinished_hours']);
            $feedbacksreturn[$type][] = $feed['feedbacks'];
        }
        $return['feedback'] = $feedbacksreturn;
        $return['settings'] = $settings;
        
        echo json_encode($return);
        die();
    }

    function beforeFilter() {

        parent::beforeFilter();
    }

    function getEnergyData() {
        
    }

}

?>
