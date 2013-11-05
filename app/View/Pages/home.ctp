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
echo $this->Html->script('calendar.custom');
?>
<div class="flowinghours">
    
<div id="tabs">
    <ul>
		<li><a href="#tabs-1">Calendar</a></li>
		<li><a href="#tabs-2">Task List</a></li>
	</ul>
<div id="tabs-1">
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
    <div id="add-event-form" title="Add New Event">
        <p class="validateTips">All form fields are required.</p>
        <form>
            <fieldset>
                <label for="name">What?</label>
                <input type="text" name="what" id="what" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>
                <table style="width:100%; padding:5px;">
                    <tr>
                        <td>
                            <label>Start Date</label>
                            <input type="text" name="startDate" id="startDate" value="" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>				
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <label>Start Hour</label>
                            <select id="startHour" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
                                <option value="12" SELECTED>12</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                            </select>				
                        <td>
                        <td>
                            <label>Start Minute</label>
                            <select id="startMin" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
                                <option value="00" SELECTED>00</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                            </select>				
                        <td>
                        <td>
                            <label>Start AM/PM</label>
                            <select id="startMeridiem" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
                                <option value="AM" SELECTED>AM</option>
                                <option value="PM">PM</option>
                            </select>				
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>End Date</label>
                            <input type="text" name="endDate" id="endDate" value="" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;"/>				
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <label>End Hour</label>
                            <select id="endHour" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
                                <option value="12" SELECTED>12</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                            </select>				
                        <td>
                        <td>
                            <label>End Minute</label>
                            <select id="endMin" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
                                <option value="00" SELECTED>00</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                            </select>				
                        <td>
                        <td>
                            <label>End AM/PM</label>
                            <select id="endMeridiem" class="text ui-widget-content ui-corner-all" style="margin-bottom:12px; width:95%; padding: .4em;">
                                <option value="AM" SELECTED>AM</option>
                                <option value="PM">PM</option>
                            </select>				
                        </td>				
                    </tr>			
                </table>
                <table>
                    <tr>
                        <td>
                            <label>Background Color</label>
                        </td>
                        <td>
                            <div id="colorSelectorBackground"><div style="background-color: #333333; width:30px; height:30px; border: 2px solid #000000;"></div></div>
                            <input type="hidden" id="colorBackground" value="#333333">
                        </td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td>
                            <label>Text Color</label>
                        </td>
                        <td>
                            <div id="colorSelectorForeground"><div style="background-color: #ffffff; width:30px; height:30px; border: 2px solid #000000;"></div></div>
                            <input type="hidden" id="colorForeground" value="#ffffff">
                        </td>						
                    </tr>				
                </table>
            </fieldset>
        </form>
    </div>

    <div id="display-event-form" title="View Agenda Item">

    </div>		

    <p>&nbsp;</p>
</div><!-- end tab 1 -->
<div id="tabs-2">Coming soon</div>
</div>
</div>
