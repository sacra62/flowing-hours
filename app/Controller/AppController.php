<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
App::uses('Controller', 'Controller');
App::uses('ConnectionManager', 'Model');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array('Auth', 'DebugKit.Toolbar', 'Session');

    function beforeFilter() {
        //for some odd reason if we dont unlock this action it fails completely. this is an ajax request.
        //i tried adding it to auth->allow method in the Users controller but it did not work! silly cakephp
        @$this->Security->unlockedActions = array('saveSettings');
        //$this->Session = new SessionHandler();
        //change the language

        $ses_lang = $this->Session->read('Config.language');
        $lang = isset($this->request->query['lang']) ? $this->request->query['lang'] : (!empty($ses_lang) ? $ses_lang : "en");
        Configure::write('Config.language', $lang);
        $this->Session->write('Config.language', $lang);


        //get user settings
        $db = ConnectionManager::getDataSource("default");
        $userid = $this->Session->read('Auth.User.id');
        if(!empty($userid)){
        $settings = $db->fetchAll("SELECT settings FROM users WHERE id='" . $userid . "'");

       
        //if settings exist -json decode
        $settings = $settings[0]['users']['settings'];
        $settings = !empty($settings) ? (array)json_decode($settings) : array();
        }
        else $settings = array("app_theme"=>"scenica");
        
        $this->set('user_settings', $settings);
    }

}
