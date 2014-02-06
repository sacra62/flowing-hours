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
//@abrar - settings come from the PagesController set in the loadTasks function

$wallpaper = isset($settings->calendar_wallpaper) ? $settings->calendar_wallpaper." "."wallpaper" : ""; 
?>
<div class="flowinghours">

    <?php echo $this->element('energybar'); ?>


    <div id="tabs">
        <ul>
            <li><a href="#tasklist">Task List</a></li>
            <li><a href="#calendar">Calendar</a></li>
        </ul>
        <div id="calendar">
            <div id="calendar_container" style="margin: auto; width: 100%;">
                <br>
                <div id="toolbar" class="ui-widget-header ui-corner-all" >
                    <button id="BtnPreviousMonth">Previous Month</button>
                    <button id="BtnNextMonth">Next Month</button>
                    &nbsp;&nbsp;&nbsp;
                    Date: <input type="text" id="dateSelect" size="20"/>
                    &nbsp;&nbsp;&nbsp;
<!--                    <button id="BtnDeleteAll">Delete All</button>-->
                    <!--            <button id="BtnICalTest">iCal Test</button>
                                <input type="text" id="iCalSource" size="30" value="extra/fifa-world-cup-2010.ics"/>-->
                </div>
                <br>
                <!--
                You can use pixel widths or percentages. Calendar will auto resize all sub elements.
                Height will be calculated by aspect ratio. Basically all day cells will be as tall
                as they are wide.
                -->
                <div id="mycal" class="<?php echo $wallpaper ?>"></div>
            </div>
            <div id="calDebug"></div>
            <?php echo $this->element('add_event_form'); ?>
            <div id="display-event-form" title="View Agenda Item">
            </div>		
            <p>&nbsp;</p>
        </div><!-- end tab 1 -->
        <div id="tasklist">
            <?php
            $totalwidth = "";
            $accordionwidth = 330 + (7 * 2); //width+margins*total lists
            if ($listcount > 0) {
                $listcount = $listcount+1; //newlist form takes space
                $allaccordionwidth = $accordionwidth * $listcount;
                $totalwidth = $allaccordionwidth + 40; //extra padding
                $totalwidth = 'style="width:' . $totalwidth . 'px"';
            }
            ?>
            <div id="tasklistcontainer" <?php echo $totalwidth ?>>
                <?php
                //echo "<pre>";
                //print_r($data);exit;
                $output = "";
                if (count($data)):
                    $tasklistid = $newtaskid = -1;
                    $tasklisttitle = '';
                    $realcount = count($data);
                    $end = $realcount - 1;
                    $endtasklisthtml = '<p><br/><a class="jQbutton newtaskButton" href="javascript:void(0)">Add a task</a></p>';

                    foreach ($data as $key => $task):
                        $tmptasklistid = $task['tasklist']['id'];
                        $addending = false;
                        if ($tmptasklistid != $tasklistid) {
                            $tasklistid = $tmptasklistid;
                            $output.='<div id="accordion-' . $tasklistid . '" class="accordion">';
                            $tasklisttitle = '<div class="tasklisttitle_container"><h2 id="tasklist_title-' . $tasklistid . '" class="tasklist_title">' . $task['tasklist']['title'] . '</h2><span class="edit_title invisible">Edit</span></div>';
                        }
                        else
                            $tasklisttitle = "";

                        $tasklistid = $task['tasklist']['id'];
                        $output.= $this->element('prepare_new_task', array("tasklisttitle" => $tasklisttitle, "task" => $task['task'], "edit" => true));

                        //for every ending tasklist container
                        if ($realcount > 0 && $key > 0 && $key != $end)
                            $addending = $data[$key + 1]['tasklist']['id'] != $tmptasklistid ? true : false;
                        //for the ending tasklist container
                        if ($key == $end)
                            $addending = true;

                        $output.= $addending ? $endtasklisthtml . "</div>" : "";


                    endforeach;
                endif;

                echo $output;
                echo $this->element('new_tasklist');
                ?>

            </div>
            <span style="display:none;" rel="<?php echo $this->Session->read('Tasks.editTaskId') ? $this->Session->read('Tasks.editTaskId') : ""; ?>" id="editaskid"></span>
            <span style="display:none" rel="<?php echo $accordionwidth ?>" id="accordionwidth"></span>

        </div>
    </div>
    <?php echo $this->element('new_task_form'); ?>
</div>
