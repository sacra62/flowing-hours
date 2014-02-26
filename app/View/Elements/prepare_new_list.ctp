<?php if (isset($tasklisttitle)) echo $tasklisttitle; ?>
<div class="accordion_container" id="accordion_container-<?php echo $tasklist['id']; ?>">
    <div class="tasklisttitle_container">
        <h2 id="tasklist_title-<?php echo $tasklist['id']; ?>" class="tasklist_title"><?php echo $tasklist['title']; ?></h2>
        <div class="list_controls invisible">
            <span class="edit_title"><?php echo __("EDIT") ?></span><span class="remove_list"><?php echo __("DELETE_LIST") ?></span> 
        </div>
    </div>
    <div id="accordion-<?php echo $tasklist['id']; ?>" class="accordion">

        <div>

        </div>
    </div>
    <p><br/><a class="jQbutton newtaskButton" href="javascript:void(0)"><?php echo __("ADD_TASK") ?></a></p>

</div>
