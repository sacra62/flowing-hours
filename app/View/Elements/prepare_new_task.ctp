<!-- @abrar - Template TASK - used as a template for the task list and to inject after saving a new form -->

<div class="task" id="task_<?php echo $task['id']; ?>">

    <h3 ><?php echo $task['title']; ?></h3>
    <div>
        <?php
        if (isset($edit)) {
            echo '<p><a class="task_edit" id="task_edit_' . $task['id'] . '">Edit</a></p>';
        }
        ?>
        <p>
            <span id="desc" class="text_edit"><?php echo $task['desc']; ?></span>
        </p>
        <hr/>
        <p><label>Status:</label> <span class="text_edit" id="status"><?php echo empty($task['status']) ? "Unfinished" : "Done"; ?></span></p>
        <p><label>Estimated Hours:</label> <span class="text_edit" id="estimated_hours"><?php echo $task['estimated_hours']; ?></span></p>
        <p><label>Reported Hours:</label> <span class="text_edit" id="reported_hours"><?php echo empty($task['reported_hours']) ? "0" : $task['reported_hours']; ?></span></p>
        <hr/>
        <p><label>Start Date:</label> <span class="text_edit" id="start_date" class="date"><?php echo $this->Time->format('F j, Y, G:i', $task['start_date']); ?></span></p>
        <p><label>End Date:</label> <span class="text_edit" id="end_date" class="date"><?php echo $this->Time->format('F j, Y, G:i', $task['end_date']); ?></span></p>
    </div>
</div>