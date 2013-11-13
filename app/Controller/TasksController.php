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
    var $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'index'),
            'authError' => "You can't access that page",
            'authorize' => array('Controller')
        )); 
    public function isAuthorized($user) {
        return true;
    }
    function saveTask(){
        if($this->request->is('ajax') && count($this->request->data)){
            $user = $this->Session->read('Auth');
            $this->request->data['users_id'] =  $user['User']['id'];
            $this->Task->create();
            if ($this->Task->save($this->request->data)) {
                //prepare new task html and send it back
                $this->request->data['id'] = $this->Task->getLastInsertId();
                $view = new View($this, false);
                echo $view->element('prepare_new_task', array("task" => $this->request->data));
                exit;
            }
            die("0");//something went wrong
        }
    }
}
?>
