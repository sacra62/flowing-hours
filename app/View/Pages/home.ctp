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

$wallpaper = isset($user_settings['calendar_wallpaper']) ? $user_settings['calendar_wallpaper'] . " " . "wallpaper" : "";
?>
<div class="flowinghours">

    <?php echo $this->element('energybar'); ?>


    <div id="tabs">
        <ul>
            <li><a href="#tasklist"><?php echo __("TASKLIST") ?></a></li>
            <li><a href="#calendar"><?php echo __("CALENDAR") ?></a></li>
        </ul>
        <div id="calendar">
            <div id="calendar_container" style="margin: auto; width: 100%;">
                <br>
                <div id="toolbar" class="ui-widget-header ui-corner-all" >
                    <button id="BtnPreviousMonth"><?php echo __("PREV_MONTH") ?></button>
                    <button id="BtnNextMonth"><?php echo __("NEXT_MONTH") ?></button>
                    &nbsp;&nbsp;&nbsp;
                    <?php echo __("DATE") ?>: <input type="text" id="dateSelect" size="20"/>
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
            <div id="display-event-form" title="<?php echo __("VIEW_AGENDA") ?>">
            </div>		
            <p>&nbsp;</p>
        </div><!-- end tab 1 -->
        <div id="tasklist">
            <?php 
            //set filtered data
            
            foreach($filtereddata as $filtertitle=>$filter){
                echo $this->element('prepare_new_filtered_list',array("filtertitle"=>$filtertitle,"filter"=>$filter));
            }
            
            ?>
            
            <?php
            $totalwidth = "";
            $accordionwidth = 330 + (7 * 2); //width+margins*total lists
            if ($listcount > 0) {
                $listcount = $listcount + 1; //newlist form takes space
                $allaccordionwidth = $accordionwidth * $listcount;
                $totalwidth = $allaccordionwidth + 40; //extra padding
                $totalwidth = 'style="width:' . $totalwidth . 'px"';
            }
            ?>
            <div id="tasklistcontainer" <?php echo $totalwidth ?>>
                <?php
//                echo "<pre>";
//                print_r($data);
//                exit;
                $output = "";
                if (count($data)):

                    foreach ($data as $key => $tasks):
                        $tasklistid = $tasks['tasklist']['id'];

                        $tasklisttitle = '<div class="tasklisttitle_container"><h2 id="tasklist_title-' . $tasklistid . '" class="tasklist_title">' . $tasks['tasklist']['title'] . '</h2><div class="list_controls invisible"><span class="edit_title">' . __("EDIT") . '</span><span class="remove_list">' . __("DELETE_LIST") . '</span></div></div>';

                        $output.='<div class="accordion_container" id="accordion_container-' . $tasklistid . '">' . $tasklisttitle . '<div id="accordion-' . $tasklistid . '" class="accordion">';



                        foreach ($tasks['tasks'] as $task) {
                            $output.= $this->element('prepare_new_task', array("task" => $task['task'], "edit" => true));
                        }

                        $endtasklisthtml = '<p><br/><a class="jQbutton newtaskButton" href="javascript:void(0)">' . __("ADD_TASK") . '</a></p>';

                        $output.= "</div>$endtasklisthtml</div>";


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
