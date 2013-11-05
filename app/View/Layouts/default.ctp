<?php
/**
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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'Flowing Hours');
$user = $this->Session->read('Auth');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('cake.generic');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        if (isset($user['User'])) {
            ?>
            <!-- Include CSS for JQuery Frontier Calendar plugin (Required for calendar plugin) -->
            <link rel="stylesheet" type="text/css" href="css/frontierCalendar/jquery-frontier-cal-1.3.2.css" />

            <!-- Include CSS for color picker plugin (Not required for calendar plugin. Used for example.) -->
            <link rel="stylesheet" type="text/css" href="css/colorpicker/colorpicker.css" />

            <!-- Include CSS for JQuery UI (Required for calendar plugin.) -->
            <link rel="stylesheet" type="text/css" href="css/jquery-ui/smoothness/jquery-ui-1.8.1.custom.css" />

            <!--
            Include JQuery Core (Required for calendar plugin)
            ** This is our IE fix version which enables drag-and-drop to work correctly in IE. See README file in js/jquery-core folder. **
            -->
            <script type="text/javascript" src="js/jquery-core/jquery-1.4.2-ie-fix.min.js"></script>

            <!-- Include JQuery UI (Required for calendar plugin.) -->
            <script type="text/javascript" src="js/jquery-ui/smoothness/jquery-ui-1.8.1.custom.min.js"></script>

            <!-- Include color picker plugin (Not required for calendar plugin. Used for example.) -->
            <script type="text/javascript" src="js/colorpicker/colorpicker.js"></script>

            <!-- Include jquery tooltip plugin (Not required for calendar plugin. Used for example.) -->
            <script type="text/javascript" src="js/jquery-qtip-1.0.0-rc3140944/jquery.qtip-1.0.js"></script>

            <!--
                    (Required for plugin)
                    Dependancies for JQuery Frontier Calendar plugin.
                ** THESE MUST BE INCLUDED BEFORE THE FRONTIER CALENDAR PLUGIN. **
            -->
            <script type="text/javascript" src="js/lib/jshashtable-2.1.js"></script>

            <!-- Include JQuery Frontier Calendar plugin -->
            <script type="text/javascript" src="js/frontierCalendar/jquery-frontier-cal-1.3.2.min.js"></script>
            
            <!-- tooltip and drag - only when calendar is active-->
            <script type="text/javascript" src="js/frontierCalendar/tooltip.drag.js"></script>

            <?php
        }
        echo $this->Html->css('default.css');
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <h1 class="fleft">
                    <?php
                    echo $this->Html->link(
                            'Flowing Hours', '/', array('class' => 'marginLR10'));
                    ?></h1>
                <div class="fright"><?php
                    if (isset($user['User'])) {
                        //calling on the login bar element /view/elements/login_bar
                        echo $this->element('login_bar', array("user" => $user));
                    }
                    ?></div>
            </div>
            <div id="content">

                <?php echo $this->Session->flash(); ?>


                <?php
                //if the user is logged in - show his calendar-
                //pick up the css from default.css
                //for every layout make a different css - pages_default.css, pages_tasklist.css

                  
                    echo $this->fetch('content'); 
                   
                    ?>

                </div>
                <div id="footer">

                </div>
            </div>
            <?php
            //echo $this->element('sql_dump');  
            //@abrar
            //By default scripts are cached, and you must explicitly print out the cache. To do this at the end of each page, include this line just before the ending </body> tag:
            //echo $this->Js->writeBuffer(); // Write cached scripts
            ?>
    </body>
</html>
