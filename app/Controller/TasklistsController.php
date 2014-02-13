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
class TasklistsController extends Controller {

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

    function saveList() {
        if ($this->request->is('ajax') && count($this->request->data)) {
            $this->loadModel('TaskList');

            $user = $this->Session->read('Auth');
            $this->request->data['users_id'] = $user['User']['id'];
            //date time needs to be fixed
            $this->request->data['title'] = $this->request->data['newlist_title'];
            //To Do //get the latest ordering and add one to it
            $this->request->data['ordering'] = 0;
            $this->Tasklist->create();
            try {
                if ($this->Tasklist->save($this->request->data)) {
                    //prepare new task html and send it back
                    $this->request->data['id'] = $this->Tasklist->getLastInsertId();
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

    function saveListTitle() {
        if ($this->request->is('ajax') && count($this->request->data)) {
            $this->loadModel('TaskList');
            $user = $this->Session->read('Auth');
            $this->request->data['users_id'] = $user['User']['id'];

            $tasklist = $this->Tasklist->findById($this->request->data['tasklist_id']);
            $tasklist['Tasklist']['title'] = $this->request->data['newlist_title'];
            try {
                if ($this->Tasklist->save($tasklist)) {
                    die("1");
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }
            die("something went wrong");
        }
    }

    function deleteList() {
        if ($this->request->is('ajax') && count($this->request->data)) {
            $tasklist = $this->Tasklist->findById($this->request->data['id']);
            print_r($tasklist);exit;
            if (!$tasklist) {
                die("No such list"); //something went wrong
            }
            try {
                if ($this->Tasklist->delete($this->request->data['id'])) {
                    die("1");
                }
            } catch (Exception $e) {
                die($e->getMessage());
            }

            die("1"); //all good
        }
    }

}

?>
