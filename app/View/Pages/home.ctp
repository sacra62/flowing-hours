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
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
//init calendar
//echo $this->Html->script('calendar.custom');
?>
<div class="flowinghours">

    <div id="tabs">
        <ul>
            <li><a href="#calendar">Calendar</a></li>
            <li><a href="#tasklist">Task List</a></li>
        </ul>
        <div id="calendar">
            <div id="example" style="margin: auto; width:80%;">

                <br>


                <div id="toolbar" class="ui-widget-header ui-corner-all" style="padding:3px; vertical-align: middle; white-space:nowrap; overflow: hidden;">
                    <button id="BtnPreviousMonth">Previous Month</button>
                    <button id="BtnNextMonth">Next Month</button>
                    &nbsp;&nbsp;&nbsp;
                    Date: <input type="text" id="dateSelect" size="20"/>
                    &nbsp;&nbsp;&nbsp;
                    <button id="BtnDeleteAll">Delete All</button>
                    <!--            <button id="BtnICalTest">iCal Test</button>
                                <input type="text" id="iCalSource" size="30" value="extra/fifa-world-cup-2010.ics"/>-->
                </div>

                <br>

                <!--
                You can use pixel widths or percentages. Calendar will auto resize all sub elements.
                Height will be calculated by aspect ratio. Basically all day cells will be as tall
                as they are wide.
                -->
                <div id="mycal"></div>

            </div>

            <!-- debugging-->
            <div id="calDebug"></div>

            <!-- Add event modal form -->
            <style type="text/css">
                /*label, input.text, select { display:block; }*/
                fieldset { padding:0; border:0; margin-top:25px; }
                .ui-dialog .ui-state-error { padding: .3em; }
                .validateTips { border: 1px solid transparent; padding: 0.3em; }
            </style>

            <?php echo $this->element('add_event_form'); ?>
            <div id="display-event-form" title="View Agenda Item">

            </div>		

            <p>&nbsp;</p>
        </div><!-- end tab 1 -->
        <div id="tasklist">
        <script type="text/javascript" src="js/tasklist.js"></script>
        <script type="text/javascript" src="js/timepicker_addon.js"></script>
<!--  <p><a class="jQbutton newtaskButton" href="javascript:void(0)">Add a task</a></p>-->
            <div id="tasklistcontainer">
                <div id="accordion" style="width: 500px;">
                    <?php if(count($this->data)): foreach ($this->data as $task): 
                        echo $this->element('prepare_new_task', array("task" => $task['Tasks'],"edit"=>true));
                    endforeach; 
                   endif;
                        ?>
                </div>
                <p><br/><a class="jQbutton" id="newtaskButton" href="javascript:void(0)">Add a task</a></p>

            </div>
        </div>
                <?php echo $this->element('new_task_form'); ?>
    </div>

