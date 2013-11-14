<div id="newtask" style="display:none;" class="ui-corner-all ui-widget-content">
            <form id="newtaskForm" action="">
                <div>
                    <p>  <textarea name="title" id="newtask_title" class="defaultText" type="text" title="Name your task..."></textarea>
                    </p>
                    <p>
                        <textarea  name="desc"  type="text"  id="newtask_desc" class="text_edit defaultText" title="Describe it..."></textarea>
                    </p>
                    <p><label>Estimated Hours:</label> <input name="estimated_hours"  type="text" class="text_edit" id="newtask_estimated_hours" size="2" value="0"/></p>
                    <p><label>Start Date:</label> <input name="start_date"  size="30"  type="text" class="text_edit date" id="newtask_start_date" /></p>
                    <p><label>End Date:</label> <input name="end_date"  size="30"  type="text" class="text_edit date" id="newtask_end_date" /></p>
                </div>
                <div class="newtask_controls"><a class="jQbutton" id="newtask_save" href="javascript:void(0)">Save</a><a class="jQbutton" id="newtask_cancel" href="javascript:void(0)">Cancel</a></div>
                <div class="clear"></div>
            </form>
        </div>



<!-- messages -->


    <div style="display:none;" id="confirmdialog" title="Confirmation">You were in the middle of it, are you sure you want to cancel?</div>
        <div style="display:none;" id="failuredialog" title="Oops">Something went wrong, try again.</div>
        <div style="display:none;" id="incompleteform" title="Not too fast">Some fields have invalid/missing values.</div>
        <div style="display:none;" id="deletedialog" title="Are you sure?">Are you sure you want to delete this task?</div>
