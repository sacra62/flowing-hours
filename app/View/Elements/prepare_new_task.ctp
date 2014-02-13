<?php if (isset($tasklisttitle)) echo $tasklisttitle; ?>

<div class="task_container">
    <?php if (!empty($task['id'])): ?>
        <div class="task" id="task_<?php echo $task['id']; ?>" >

            <h3><?php echo $task['title']; ?></h3>
            <div>
                <div class="task_inner">
                    <form class="edittaskForm" action="">
                        <input type="hidden" value="<?php echo $task['id']; ?>" name="id">
                        <?php
                        if (isset($edit)) {
                            echo '<p><a class="jQbutton  task_edit" id="task_edit_' . $task['id'] . '">Edit</a> <a class="jQbutton  task_delete" id="task_delete_' . $task['id'] . '">Delete</a></p>';
                        }
                        ?>
                        <p>
                            <span rel="desc" class="text_edit"><?php echo $task['desc']; ?></span>
                        </p>
                        <hr/>
                        <p><label>Status:</label> <span class="text_edit" rel="status"><?php echo empty($task['status']) ? "Unfinished" : "Done"; ?></span></p>
                        <p><label>Estimated Hours:</label> <span class="text_edit" rel="estimated_hours"><?php echo $task['estimated_hours']; ?></span></p>
                        <p><label>Reported Hours:</label> <span class="text_edit" rel="reported_hours"><?php echo empty($task['reported_hours']) ? "0" : $task['reported_hours']; ?></span></p>
                        <hr/>
                        <p><label>Start Date:</label> <span class="text_edit" rel="start_date" class="date"><?php echo $this->Time->format('j F, Y G:i', $task['start_date']); ?></span></p>
                        <p><label>End Date:</label> <span class="text_edit" rel="end_date" class="date"><?php echo $this->Time->format('j F, Y G:i', $task['end_date']); ?></span></p>
                        <div style="display:none;" class="edittask_controls"><a class="jQbutton edittask_save" href="javascript:void(0)">Save</a><a class="jQbutton edittask_cancel" href="javascript:void(0)">Cancel</a></div>
                        <div class="clear"></div>
                        <input type="hidden" value="<?php echo $task['tasklists_id']; ?>" name="tasklists_id" class="tasklists_id"/>
                    </form>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>