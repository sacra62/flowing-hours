<div id="newtask" style="display:none;" class="ui-corner-all ui-widget-content">
            <form class="newtaskForm" action="">
                <div>
                    <p>  <textarea name="title" class="defaultText newtask_title" type="text" title="<?php echo __("NAME_TASK")?>"></textarea>
                    </p>
                    <p>
                        <textarea  name="desc"  type="text"  class="newtask_desc text_edit defaultText" title="<?php echo __("DESCRIBE_TASK")?>"></textarea>
                    </p>
                    <p><label><?php echo __("ESTIMATED_HOURS")?></label> <input name="estimated_hours"  type="text" class="text_edit newtask_estimated_hours" size="2" value="0"/></p>
                    <p><label><?php echo __("START_DATE")?></label> <input name="start_date"  size="30"  type="text" class="text_edit date newtask_start_date"  /></p>
                    <p><label><?php echo __("END_DATE")?></label> <input name="end_date"  size="30"  type="text" class="text_edit date newtask_end_date"  /></p>
                </div>
                <div class="newtask_controls"><a class="jQbutton newtask_save" href="javascript:void(0)"><?php echo __("SAVE")?></a><a class="jQbutton newtask_cancel" href="javascript:void(0)"><?php echo __("CANCEL")?></a></div>
                <div class="clear"></div>
                <input type="hidden" value="" name="tasklists_id" class="tasklists_id"/>
            </form>
        </div>



<!-- messages -->


    <div style="display:none;" id="confirmdialog" title="<?php echo __("CONFIRMATION")?>"><?php echo __("CANCEL_MESSAGE_MIDDLEOFSOMETHING")?></div>
        <div style="display:none;" id="failuredialog" title="<?php echo __("OOPS")?>"><?php echo __("MSG_SOMETHINGWENTWRONG")?></div>
        <div style="display:none;" id="incompleteform" title="<?php echo __("MSG_NOT_TOO_FAST")?>"><?php echo __("MSG_MISSINGVALUES")?></div>
        <div style="display:none;" id="deletedialog" title="<?php echo __("MSG_AREYOUSURE")?>"><?php echo __("MSG_AREYOUSURE_DELETETASK")?></div>
        <div style="display:none;" id="feedbackdialog" title="<?php echo __("MSG_HEYYOU")?>"><?php echo __("ALERT")?></div>
        <div style="display:none;" id="deletelist" title="<?php echo __("MSG_AREYOUSURE")?>"><?php echo __("MSG_AREYOURSURE_DELETELIST")?></div>
                <div style="display:none;" id="failuremsgdialog" title=<?php echo __("MSG_SOMETHING_WENTWRONG")?></div>

