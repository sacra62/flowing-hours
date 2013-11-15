

function resetNewTaskDialog(){
    $("#newtask").hide("slow");
    $("#newtaskButton").toggle();
    $("#newtask textarea, #newtask input.text_edit").each(function() {
        $(this).val("");  
    });
    _init();
}
function _init(){
    //for default text
    $(".defaultText").focus(function(srcc)
    {
        if ($(this).val() == $(this)[0].title)
        {
            $(this).removeClass("defaultTextActive");
            $(this).val("");
        }
    });
    
    $(".defaultText").blur(function()
    {
        if ($(this).val() == "")
        {
            $(this).addClass("defaultTextActive");
            $(this).val($(this)[0].title);
        }
    });
    $(".defaultText").blur(); //activate the function  
    $(".jQbutton").button();  
}

$(function() {
    
    _init();
    $( "#newtaskButton" ).on('click',function(){
        $("#newtask").insertAfter($(this)).show("slow");
        $("#newtask").find(".date").datetimepicker({
            dateFormat: "d MM, yy",
            timeFormat: "HH:mm",
            minDate: 0,
            onSelect:
            function (dateText, inst) {
                var thisdate = $(this);
                if(thisdate.attr("name")=="start_date")
                    $('#newtask_end_date').datepicker("option", 'minDate', new Date(dateText));
            }
        });
        $(this).toggle();
    });
    
    $("#newtask_save").on('click',function(){
        var allGood = true;
        $("#newtask textarea, #newtask input.text_edit").each(function() {
            var val = $(this).val();
            $(this).css({
                backgroundColor:'transparent'
            });//reset every time
            //check for date fields
            //            if($(this).attr("name")=="end_date"){
            //                var startdate = $("#newtask_start_date").datepicker( "getDate" );
            //                var enddate = $(this).datepicker( "getDate" );
            //                var begD = $.datepicker.parseDate('d MM, yy HH:mm', startdate);
            //                var endD = $.datepicker.parseDate('d MM, yy HH:mm',enddate);
            //                if (begD > endD) {
            //                    alert('Begin date must be before End date');
            //                    $(this).focus();
            //                    return false;
            //                }
            //            }
            
            if(val == "" || val <=0 ||  val==$(this).attr("title")) {
               
                $(this).css({
                    backgroundColor:'orange'
                });
                allGood = false;
                
            }
        });
        if(!allGood){
            $( "#incompleteform" ).dialog({
                modal: true, 
                zIndex: 10000, 
                autoOpen: true,
                width: 'auto', 
                resizable: false,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                },
                close: function (event, ui) {
                    $(this).dialog("close");
                }
            });
            return false;
        }
        $.post( "tasks/saveTask",$( "#newtaskForm" ).serialize(), function( result ) {
            if(result=="0"){
                //remove data and cancel
                $( "#failuredialog" ).dialog({
                    modal: true, 
                    zIndex: 10000, 
                    autoOpen: true,
                    width: 'auto', 
                    resizable: false,
                    buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                        }
                    },
                    close: function (event, ui) {
                        $(this).dialog("close");
                    }
                });
            }
            else {
                //success - add the task to the list
                $("#accordion").append(result);
                $("#accordion").accordion( "refresh" );
                resetNewTaskDialog();
            
            }
        
        });
    // no issues go ahead and save.
    });
    
    
    $("#newtask_cancel").click(function(){
        var cancel = true;
        $("#newtask textarea, #newtask input.text_edit").each(function() {
            var val = $(this).val();
            if(val != "" && val != "0" &&  val!=$(this).attr("title")) {
                cancel = false;
            }
        });
        if(!cancel){
            
            //remove data and cancel
            $( "#confirmdialog" ).dialog({
                modal: true, 
                zIndex: 10000, 
                autoOpen: true,
                width: 'auto', 
                resizable: false,
                buttons: {
                    Yes: function () {
                        $(this).dialog("close");
                        resetNewTaskDialog();
                    },
                    No: function () {
                        $(this).dialog("close");
                    }
                },
                close: function (event, ui) {
                    $(this).dialog("close");
                }
            });
            return true;
        }
        else {
            resetNewTaskDialog();
        
        }
    
    });
    
    
    
    
    var $accordion = $( "#accordion") .accordion({
        collapsible: false, 
        header: 'h3',       
        active: true, 
        heightStyle: 'content'
    }).sortable(); 
    
    //disable sorting when an accordion is active - why? - just for now dont know
    $('#accordion').on('accordionactivate', function (event, ui) {
        if (ui.newPanel.length) {
            $('#accordion').sortable('disable');
        } else {
            $('#accordion').sortable('enable');
        }
    });
    //if tab is #tasklist then check if an editask is set, if yes, then set its id
    if(location.hash=="#tasklist"){ 
        var editid = $("#editaskid").attr("rel");
        if(editid) {
            //find the accordion for this id
            var panelitem = $("div#task_"+editid);
            var panelindex = $( "div.task" ).index( panelitem );
            $accordion.accordion("option","active",panelindex);
            //open for editing
            $("#task_edit_"+editid)[0].click();
            //not working, but thats fine :(
            //found so destory it now
            $.ajax({
                url: 'tasks/destoryEditTaskIdInSession',
                success:function(data){
                }
            });
        }
    }
    //Text to span and span to text script 
    $.fn.spantoinput = function(id) {
        
        var $thisid = $(this).attr("rel");
        var $thisval = $(this).html();
        if($thisid=="desc") {
            var input = $('<textarea />', {
                'name': $thisid, 
                'value': $thisval
                ,
                'class':'text_edit'
            }); 
            input.val($thisval);
        }else if($thisid=="status"){
            var checked_done = 'checked="checked"';
            var checked_notdone= 'checked="checked"';
            if($thisval=="Unfinished") checked_done = ""; else checked_notdone = "";
            var input = '<input class="text_edit" type="radio" value="0" '+checked_notdone+' name="'+$thisid+'">Unfinished'+'<input class="text_edit" type="radio" value="1" '+checked_done+'  name="'+$thisid+'">Done';
        }
        else{
            var input = $('<input />', {
                'type': 'text', 
                'name': $thisid, 
                'value': $thisval
                ,
                'class':'text_edit'
            });
        }
        
        $(this).parent().append(input);
        $(this).remove();
        if($thisid=="estimated_hours" || $thisid=="reported_hours") input.attr("size","2");
        if($thisid=="start_date" || $thisid=="end_date") {
            input.datetimepicker({
                dateFormat: "d MM, yy",
                timeFormat: "HH:mm",
                minDate: 0
            });
            input.datetimepicker('setDate', $thisval);
        }
        if($thisid=="desc")input.focus();
    };
    
    //edit task function - for ajax html to work we need to define a top level scope like the container element
    //or the click wont register
    $("#tasklistcontainer").on("click", ".task_edit",function(){
        $(this).toggle();
        var id = $(this).attr("id");
        var task = "#task_"+id.replace("task_edit_", "");
        $(task).find(".edittask_controls").toggle();
        
        $(task).find(".text_edit").each(function(){
            
            $(this).spantoinput(id);
        
        });
    });
    
    //cancel task
    
    $("#tasklistcontainer").on("click", ".edittask_cancel",function(){
        var $task = $(this).closest("div.task").attr("id");
        $("#"+$task).find(".edittask_controls").toggle();
        $("#"+$task+" .text_edit").each(function() {
            //exception for the staus radio buttons - we will make it a simple trigger later
            if($(this).attr("type")=="radio"){
                if($(this).is(":checked")){
                    $(this).parent().html("").html('<label>Status:</label><span class="text_edit" rel="status"> '+($(this).val()=="0" ? "Unfinished" : "Done")+'</span>');
                }
                else return;
            }
            $(this).parent().append($('<span />',{
                'class': 'text_edit', 
                'rel': $(this).attr("name")
            }).html($(this).val()));
            $(this).remove();
        });
        $("#"+$task).find(".task_edit").toggle();
    //$($task).find(".edittask_controls").toggle();
    });
    $("#tasklistcontainer").on("click", ".task_delete",function(){
        var $this = $(this);
        //remove data and cancel
        $( "#deletedialog" ).dialog({
            modal: true, 
            zIndex: 10000, 
            autoOpen: true,
            width: 'auto', 
            resizable: false,
            buttons: {
                Yes: function () {
                    $(this).dialog("close");
                    $.ajax({
                        type: "POST",
                        url: "tasks/deleteTask",
                        dataType: "HTML",
                        data: {
                            "id":$this.closest("div.task").attr("id").replace("task_","")
                        },
                        success:function( result ) {
                            if(result=="0"){
                                $( "#failuredialog" ).dialog({
                                    modal: true, 
                                    zIndex: 10000, 
                                    autoOpen: true,
                                    width: 'auto', 
                                    resizable: false,
                                    buttons: {
                                        Ok: function () {
                                            $(this).dialog("close");
                                        }
                                    },
                                    close: function (event, ui) {
                                        $(this).dialog("close");
                                    }
                                });
                            }
                            else{
                                $this.closest("div.task").hide('slow');
                            //maybe we can use the undo feature this way :) - we will just show the task again
                            //$("#accordion").accordion( "refresh" );
                            }
                        
                        }
                    });
                },
                No: function () {
                    $(this).dialog("close");
                }
            },
            close: function (event, ui) {
                $(this).dialog("close");
            }
        });
        return true;
    });
    
    $("#tasklistcontainer").on("click", ".edittask_save",function(){
        var allGood = true;
        var $task = $(this).closest("div.task").attr("id");
        //input[type='text']:not([name='reported_hours'])
        $("#"+$task+" textarea, #"+$task+" input[type='text']").each(function() {
            var val = $(this).val();
            $(this).css({
                backgroundColor:'transparent'
            });//reset every time
            if(val == "" || val <= 0) {
                if($(this).attr("name")=="reported_hours" && val==0){
                //never mind
                }
                else{
                    $(this).css({
                        backgroundColor:'orange'
                    });
                    allGood = false;
                }
            }
        });
        if(!allGood){
            $( "#incompleteform" ).dialog({
                modal: true, 
                zIndex: 10000, 
                autoOpen: true,
                width: 'auto', 
                resizable: false,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                },
                close: function (event, ui) {
                    $(this).dialog("close");
                }
            });
            return false;
        }
        
        //all good so save it
        $.ajax({
            type: "POST",
            url: "tasks/updateTask",
            dataType: "HTML",
            data: $("#"+$task).find( ".edittaskForm" ).serialize(),
            success:function( result ) {
                if(result=="0"){
                    //remove data and cancel
                    $( "#failuredialog" ).dialog({
                        modal: true, 
                        zIndex: 10000, 
                        autoOpen: true,
                        width: 'auto', 
                        resizable: false,
                        buttons: {
                            Ok: function () {
                                $(this).dialog("close");
                            }
                        },
                        close: function (event, ui) {
                            $(this).dialog("close");
                        }
                    });
                }
                else {
                    //success - add the task to the list
                    $("#"+$task).find(".task_inner").html($('.task_inner', result).html());
                    $("#accordion").accordion( "refresh" );
                    _init();//so that the default text works,
                
                }
            }
        });
    
    
    
    
    });
});