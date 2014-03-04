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
$apptheme = $user_settings['app_theme'];
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
            echo $this->Html->css('generic');
             echo $this->Html->css('app_theme/' . $apptheme . '/default');
            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
            if (isset($user['User']) && $this->params['controller'] == "pages") {
                ?>

            <script>
                //some translations
                var __unfinished="<?php echo __("Unfinished") ?>";
                var __done="<?php echo __("Done") ?>";

                //used by frontier calendar
                var __daysshort = new Array("<?php echo __("Sun") ?>","<?php echo __("Mon") ?>","<?php echo __("Tue") ?>","<?php echo __("Wed") ?>","<?php echo __("Thu") ?>","<?php echo __("Fri") ?>","<?php echo __("Sat") ?>");



                var __days = new Array();
                __days['Sunday'] = "<?php echo __("Sunday") ?>";
                __days['Monday'] = "<?php echo __("Monday") ?>";
                __days['Tuesday'] = "<?php echo __("Tuesday") ?>";
                __days['Wednesday'] = "<?php echo __("Wednesday") ?>";
                __days['Thursday'] = "<?php echo __("Thursday") ?>";
                __days['Friday'] = "<?php echo __("Friday") ?>";
                __days['Saturday'] = "<?php echo __("Saturday") ?>";

                var __calendarstrings = new Array();
                __calendarstrings['Starts'] = "<?php echo __("Starts") ?>";
                __calendarstrings['Ends'] = "<?php echo __("Ends") ?>";
                __calendarstrings['STATUS'] = "<?php echo __("STATUS") ?>";
                __calendarstrings['Unfinished'] = "<?php echo __("Unfinished") ?>";
                __calendarstrings['Done'] = "<?php echo __("Done") ?>";
                __calendarstrings['ESTIMATED_HOURS'] = "<?php echo __("ESTIMATED_HOURS") ?>";
                __calendarstrings['REPORTED_HOURS'] = "<?php echo __("REPORTED_HOURS") ?>";
                                
                //used by frontier calendar to show stat and end dates
                var __locale = "<?php echo Configure::read('Config.language') == "fi" ? "fi-FI" : "en-US"; ?>";
                var __localecode = "<?php echo Configure::read('Config.language'); ?>";
                var __dateformat_options= {
                    weekday: "long", 
                    year: "numeric", 
                    month: "long", 
                    day: "numeric",
                    hour: "numeric",
                    minute: "numeric"
                };

            </script>

            <!-- Include CSS for JQuery Frontier Calendar plugin (Required for calendar plugin) -->
            <link rel="stylesheet" type="text/css" href="css/frontierCalendar/<?php echo $apptheme ?>/jquery-frontier-cal.css" />
            <!-- Include CSS for color picker plugin (Not required for calendar plugin. Used for example.) -->
            <link rel="stylesheet" type="text/css" href="css/colorpicker/colorpicker.css" />
            <!-- Include CSS for JQuery UI (Required for calendar plugin.) -->
            <link rel="stylesheet" type="text/css" href="css/jquery-ui/<?php echo $apptheme ?>/jquery-ui.css" />

            <!--
            Include JQuery Core (Required for calendar plugin)
            ** This is our IE fix version which enables drag-and-drop to work correctly in IE. See README file in js/jquery-core folder. **
            -->
            <script type="text/javascript" src="js/jquery-core/jquery-1.9.1.js"></script>
            <script type="text/javascript" src="js/jquery-ui/<?php echo $apptheme ?>/jquery-ui.min.js"></script>

            <!-- Include JQuery UI (Required for calendar plugin.) -->
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
            <script type="text/javascript" src="js/frontierCalendar/jquery-frontier-cal-1.3.2.js"></script>
            <!-- tooltip and drag - only when calendar is active-->
            <script type="text/javascript" src="js/frontierCalendar/tooltip.drag.js"></script>
            <script type="text/javascript" src="js/calendar.custom.js"></script>
            <script type="text/javascript" src="js/tasklist.js"></script>
            <script type="text/javascript" src="js/timepicker_addon.js"></script>
            <script type="text/javascript" src="js/energybar.js"></script>

    <?php
    //custom css at the end
    echo $this->Html->css('app_theme/' . $apptheme . '/tasklists');
    echo $this->Html->css('app_theme/' . $apptheme . '/calendar');
}
?>
    </head>
    <body class="apptheme_<?php echo $apptheme ?>">
        <div id="container">
            <div id="header">

<?php
//calling on the login bar element /view/elements/login_bar
echo $this->element('login_bar', array("user" => $user));
?>
            </div>
            <div id="content">
<?php echo $this->Session->flash(); ?>
                <?php
//if the user is logged in - show his calendar-
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
