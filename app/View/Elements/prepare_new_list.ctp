<?php if (isset($tasklisttitle)) echo $tasklisttitle; ?>
<div id="accordion-<?php echo $tasklist['id']; ?>" class="accordion">
    <h2 id="tasklist_title-<?php echo $tasklist['id']; ?>" class="tasklist_title"><?php echo $tasklist['title']; ?></h2>
    <div>
        <p><br/><a class="jQbutton newtaskButton" href="javascript:void(0)">Add a task</a></p>

    </div>
</div>