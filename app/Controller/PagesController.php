<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array('Tasks');
    var $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'index'),
            'authError' => "You can't access that page",
            'authorize' => array('Controller')
        )
            //'Cookie' => array('name' => 'CookieMonster')
    );

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     * @throws NotFoundException When the view file could not be found
     * 	or MissingViewException in debug mode.
     */
    public function display() {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

//determines what logged in users have access to
    public function isAuthorized($user) {
        //TO DO - security, check the users_id of the task and the logged in user
        return true;
    }

    function beforeFilter() {
        $this->Auth->allow('index', 'view');
        $user = $this->Session->read('Auth');

        //load user tasks
        if (isset($user['User'])) {
            $this->loadTasks($user['User']);
        }
        
        
        //change the language
        $ses_lang =  $this->Session->read('Config.language');
        $lang = isset($this->request->query['lang']) ? $this->request->query['lang'] : (!empty($ses_lang)? $ses_lang : "en_us");
        Configure::write('Config.language', $lang);
        $this->Session->write('Config.language',$lang);
        
    }

    function loadTasks($user) {
        $this->loadModel('Tasklist');
        $userdata = $this->Tasklist->query("SELECT tasklist.*,task.* FROM tasklists tasklist LEFT  JOIN tasks task ON (tasklist.users_id=task.users_id AND task.tasklists_id=tasklist.id AND tasklist.users_id = '".$user['id']."') WHERE tasklist.users_id='".$user['id']."' ORDER BY tasklist.ordering ASC");
 
        $this->set('data', $userdata);

        //count the number of total lists
        $total = $this->Tasklist->find('count', array(
        'conditions' => array('Tasklist.users_id' => $user['id'])
    ));
        $this->set('listcount', $total);
        
        
        //get user settings
        $this->loadModel('Tasks');
        $settings = $this->Tasks->query("SELECT settings FROM users WHERE id='".$user['id'] . "'");
   
      //if settings exist -json decode
        $settings = $settings[0]['users']['settings'];
        $settings = !empty($settings) ? json_decode($settings) : array();
        
        $this->set('settings', $settings);
        
//        
//        $this->loadModel('Tasks');
//        //$userdata = $this->Tasks->findAllByUsersId($user['id']);
////                    $userdata = $this->Tasks->find("all",array(
////                        'conditions' => array('Tasks.users_id =' => $user['id'])
////                       // ,'group'=>   array('Tasks.tasklists_id')
////                        ));
//        

    }
    
}
