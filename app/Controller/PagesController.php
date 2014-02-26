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


        parent::beforeFilter();
    }

    function sortTasks($taska, $taskb) {
        return $taska['task']['ordering'] - $taskb['task']['ordering'];
    }

    function loadTasks($user) {
        $this->loadModel('Tasklist');
        $tasklists = $this->Tasklist->query("SELECT tasklist.* FROM tasklists tasklist WHERE tasklist.users_id='" . $user['id'] . "' ORDER BY tasklist.ordering ASC");

//        echo "<pre>";
//        print_r($tasklists);exit;
        foreach ($tasklists as $key => $list) {
            $tasklists[$key]["tasks"] = $this->Tasklist->query("SELECT task.* FROM tasks task JOIN tasklists tasklist ON (tasklist.users_id=task.users_id AND task.tasklists_id=tasklist.id AND tasklist.users_id = '" . $user['id'] . "') WHERE task.users_id='" . $user['id'] . "' AND task.tasklists_id=" . $list['tasklist']['id'] . " ORDER BY task.ordering ASC, task.start_date ASC");
        }

        $this->set('data', $tasklists);

        //count the number of total lists
//        $total = $this->Tasklist->find('count', array(
//            'conditions' => array('Tasklist.users_id' => $user['id'])
//                ));
        $this->set('listcount', count($tasklists));

        $this->loadModel('Tasks');

        //get filters data
        $filterdata = $this->Tasks->query("SELECT * FROM tasks WHERE users_id='" . $user['id'] . "' order by start_date");
        $month = $year = $week = null;
        
        
        $monthly = array();
        foreach ($filterdata as $row) {
            $r_month = strtotime($row['tasks']['start_date']);
            if (empty($r_month)) {
                    $monthly["Uncategorized"][] = $row['tasks'];

            } else
            {
            if ($month != date('m', $r_month) || $year != date('Y', $r_month)) {
                $month = date('m', $r_month);
                $year = date('Y', $r_month);
            }
            $monthly[date('F Y', $r_month)][] = $row['tasks'];
            }
            

        }
        
        $month = $year = $week = null;
        $weekly = array();
        foreach ($filterdata as $row) {
            $r_month = strtotime($row['tasks']['start_date']);
            if (empty($r_month)) {
                    $weekly["Uncategorized"][] = $row['tasks'];

            } else
            {
            if ($week!= date('W', $r_month) || $month != date('m', $r_month) || $year != date('Y', $r_month)) {
                $month = date('m', $r_month);
                $year = date('Y', $r_month);
                $week = date('W', $r_month);
            }
            $title = "Week ".$week." ".date('F Y', $r_month);
            $weekly[$title][] = $row['tasks'];
            }
            

        }
        
        $yearly = array();
        $month = $year = $week = null;
        foreach ($filterdata as $row) {
            $r_month = strtotime($row['tasks']['start_date']);
            if (empty($r_month)) {
                    $yearly["Uncategorized"][] = $row['tasks'];

            } else
            {
            if ($year != date('Y', $r_month)) {
                $year = date('Y', $r_month);
            }
            $yearly[date('Y', $r_month)][] = $row['tasks'];
            }
            

        }
        $filtereddata = array("weekly"=>$weekly,"monthly"=>$monthly,"yearly"=>$yearly);
        //print_r($monthly);exit;
        $this->set('filtereddata', $filtereddata);
        //get user settings
        $settings = $this->Tasks->query("SELECT settings FROM users WHERE id='" . $user['id'] . "'");

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
