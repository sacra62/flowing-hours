

function resetNewTaskDialog(tasklists_id){
    $("#accordion-"+tasklists_id).find(".newtask").remove();
    $("#accordion-"+tasklists_id).find(".newtaskButton").toggle();
    //    $("#newtask textarea, #newtask input.text_edit").each(function() {
    //        $(this).val("");
    //        $(this).css({
    //                backgroundColor:'transparent'
    //            });
    //    });
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
function showErrorDialogBox(){
    //remove data and cancel
    $( "#failuredialog" ).clone(true).removeAttr("id").addClass("failuredialog").dialog({
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
function _showErrorMsgDialogBox(msg){
    //remove data and cancel
    var $dialog = $( "#failuremsgdialog" ).clone(true).removeAttr("id").addClass("failuremsgdialog");
    $dialog.html(msg);
    $dialog.dialog({
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
function _showGenericErrorDialogBox(){
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
//gets the hours for the week in which the recently added task belongs to
/*
 *recentlyadded task
 **/
function _getEstimatedHoursForAWeek(form){
    $.post( "tasks/calculateWeeklyHours",form.serialize(), function( hours ) {
        //checkhours is the feedback messaging system
        //flowingfeedback.showSaveAfterFeedback();
        var msg = checkHours(hours);
        var dlg = $( "#feedbackdialog" ).clone(true).html(msg);
        dlg.removeAttr("id").addClass("feedbackdialog").dialog({
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
    });
    
}
function _startAccordion(){
     
    $( ".accordion") .accordion({
        collapsible: true, 
        header: 'h3',       
        active: false, 
        heightStyle: 'content'
    }).sortable(function(e, ui){
        console.log(e);
    }); 
    
    //disable sorting when an accordion is active - why? - just for now dont know
    $('.accordion').on('accordionactivate', function (e, ui) {
        if (ui.newPanel.length) {
            $(this).sortable('disable');
        } else {
            $(this).sortable('enable');
        }
    });
}

$(function() {
    /////////// accordion
     
   
    
    _startAccordion();
    _init();
    
    ////list functions
    
    //edit title functions 
    
    $( ".tasklisttitle_container" ).on("click", ".newlistcancel",function(){
        var parent = $(this).parents(".tasklisttitle_container");
        parent.removeClass("active").find(".tasklist_title").show("slow");
        parent.find(".edittitlecontainer").hide("slow");
        
    //        if($(this).hasClass("newlistcancel")){
    //            $(".newlistname").val("");
    //        }
    });
    $(".accordion").on('mouseenter  mouseleave'," .tasklisttitle_container",function(){
        var $this = $(this);
        $this.find(".list_controls").toggleClass("invisible");
    });
    //this syntax of ON on("click", ".edit_title",function() seems to work with newly added,cloned elements
    $(".accordion .tasklisttitle_container").on("click", ".edit_title",function(){
        //clone add list form
        //if already has a form open, return
        var $this = $(this);
        
        var $container = $this.parents(".tasklisttitle_container");
        var $listcontrols = $container.find(".list_controls");
        if($container.hasClass(".active")) return;
        $container.addClass("active")
        var $titleh2 = $container.find("h2");
        $titleh2.hide();
        if($container.find(".edittitlecontainer").length){
            $container.find(".edittitlecontainer").show();   
        }
        else{
            var clone = $("#newtasklistcontainer .add-list:last-child").clone().show().attr("class","edittitlecontainer");
            clone.find(".newlistname").attr("placeholder",$titleh2.html());
            $listcontrols.after(clone);
        }
        
    });
    
    $(".accordion .tasklisttitle_container").on("click", ".remove_list",function(){
        //clone add list form
        //if already has a form open, return
        var $this = $(this);
        var $listid = $this.parents(".accordion").attr("id").replace("accordion-","");
        var $container = $this.parents(".tasklisttitle_container");
        if($container.hasClass(".active")) return;
        $container.addClass("active")
        $( "#deletelist" ).dialog({
            modal: true, 
            zIndex: 10000, 
            autoOpen: true,
            width: '400px', 
            resizable: false,
            buttons: {
                Yes: function () {
                    $(this).dialog("close");
                    $.ajax({
                        type: "POST",
                        url: "tasklists/deleteList",
                        dataType: "HTML",
                        data: {
                            "id":$listid
                        },
                        success:function( result ) {
                            if(result!="1"){
                                _showErrorMsgDialogBox(result);
                            }
                            else{
                                $this.parents(".accordion").hide('slow');
                                //decrease width
                                var width = parseInt($("#tasklistcontainer").css("width").replace("px",""));
                                var totalwidth = width-parseInt($("#accordionwidth").attr("rel"));//can be just picked up dynamically
                                $("#tasklistcontainer").css("width",totalwidth+"px");
        
                            //maybe we can use the undo feature this way :) - we will just show the list again
                            //$("#accordion").accordion( "refresh" );
                            }
                        
                        }
                    });
                },
                No: function () {
                    $(this).dialog("close");
                    $container.removeClass("active");
                }
            },
            close: function (event, ui) {
                $(this).dialog("close");
            }
        });
        
    });
    
    $(".accordion .tasklisttitle_container").on("click", ".newlistsave",function(){
        var parent = $(this).parents(".tasklisttitle_container");
        var listname = parent.find(".newlistname");
        if(listname.val()=="") return false;
        
        //send tasklist id for updation
        var id = parent.find(".tasklist_title").attr("id");
        var tasklist_id = id.replace("tasklist_title-", "");
        
        var form = parent.find( "form" );
        
        var data = form.serializeArray();
        data.push({
            name: 'tasklist_id', 
            value: tasklist_id
        });
        $.post( "tasklists/saveListTitle",data, function( result ) {
            if(result!="1"){
                showErrorDialogBox();
            }
            else {
                parent.find("h2").html(listname.val());
                parent.removeClass("active");
                parent.find(".tasklist_title").show("slow");
                parent.find(".edittitlecontainer").hide("slow");
            
            }
        });
    });
    
    ///edit title functions end ///////////
    
    $( "#newtasklistcontainer .js-open-add-list,#newtasklistcontainer .newlistcancel" ).on('click',function(){
        $( "#newtasklistcontainer .add-list,#newtasklistcontainer .js-open-add-list" ).toggle();
        $( "#newtasklistcontainer" ).toggleClass("idle");
        if($(this).hasClass("newlistcancel")){
            $("#newtasklistcontainer .newlistname").val("");
        }
    });
    $( "#newtasklistcontainer  .newlistsave " ).on('click',function(){
        var listname = $("#newtasklistcontainer .newlistname");
        if(listname.val()=="") return false;
        
        var form = $("#newtasklistcontainer").find( "form" );
        $.post( "tasklists/saveList",form.serialize(), function( result ) {
            if(result=="0"){
                showErrorDialogBox();
            }
            else {
                //success - add the list to the container
                $("#newtasklistcontainer").before(result);
                _startAccordion();
                $(".accordion").accordion( "refresh" );
                $(".jQbutton").button();
            
            }
        });
        
        //increase width
        var width = parseInt($("#tasklistcontainer").css("width").replace("px",""));
        var totalwidth = parseInt($("#accordionwidth").attr("rel"))+width;//can be just picked up dynamically
        $("#tasklistcontainer").css("width",totalwidth+"px");
        
        ////
        
        $( "#newtasklistcontainer .add-list,.js-open-add-list" ).toggle();
        $( "#newtasklistcontainer" ).toggleClass("idle");
        if($(this).hasClass("newlistcancel")){
            $("#newtasklistcontainer .newlistname").val("");
        }
        
        
    });
    
    /////////////////// list functions end ////////////
    
    ///task functions///////
    
    $("#tasklistcontainer").on("click", ".newtaskButton",function(){
        //check how many exist already
        var newtaskbox = $("#newtask").clone(true).removeAttr("id").addClass("newtask").insertAfter($(this).parents("p")).show("slow");
        _init();
        newtaskbox.find(".date").datetimepicker({
            dateFormat: "d MM, yy",
            timeFormat: "HH:mm",
            minDate: 0,
            onSelect:
            function (dateText, inst) {
                var thisdate = $(this);
                if(thisdate.attr("name")=="start_date")
                    thisdate.datepicker("option", 'minDate', new Date(dateText));
            }
        });
        $(this).toggle();
    });
    
    $("#tasklistcontainer").on("click", ".newtask_save",function(){
        var allGood = true;
        var thistaskbox = $(this).parents(".newtask");
        var tasklists_id = $(this).parents(".accordion").attr("id").replace("accordion-", "");
        thistaskbox.find("textarea, input.text_edit").each(function() {
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
            $( "#incompleteform" ).clone(true).removeAttr("id").addClass("incompleteform").dialog({
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
        //all is good. we need to set tasklist id 
        var form = thistaskbox.find( ".newtaskForm" );
        form.find(".tasklists_id").val(tasklists_id);
        $.post( "tasks/saveTask",form.serialize(), function( result ) {
            if(result=="0"){
                //remove data and cancel
                $( "#failuredialog" ).clone(true).removeAttr("id").addClass("failuredialog").dialog({
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
                $("#accordion-"+tasklists_id).find(".newtaskButton").parent().before(result);
                $("#accordion-"+tasklists_id).accordion( "refresh" );
                resetNewTaskDialog(tasklists_id);
                _getEstimatedHoursForAWeek(form);
            }
        
        
        // no issues go ahead and save.
        });
    });
    $("#tasklistcontainer").on("click", ".newtask_cancel",function(){

        var cancel = true;
        var thistaskbox = $(this).parents(".newtask");
        var tasklists_id = $(this).parents(".accordion").attr("id").replace("accordion-", "");
        thistaskbox.find("textarea, input.text_edit").each(function() {
            var val = $(this).val();
            if(val != "" && val != "0" &&  val!=$(this).attr("title")) {
                cancel = false;
            }
        });
        if(!cancel){
            
            //remove data and cancel
            $( "#confirmdialog" ).clone(true).removeAttr("id").addClass("confirmdialog").dialog({
                modal: true, 
                zIndex: 10000, 
                autoOpen: true,
                width: 'auto', 
                resizable: false,
                buttons: {
                    Yes: function () {
                        $(this).dialog("close");
                        resetNewTaskDialog(tasklists_id);
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
            resetNewTaskDialog(tasklists_id);
        
        }
    
    });
    
    //if tab is #tasklist then check if an editask is set, if yes, then set its id
    if(location.hash=="#tasklist"){ 
        var editid = $("#editaskid").attr("rel");
        if(editid) {
            //find the accordion for this id
            var panelitem = $("div#task_"+editid);
            var panelindex = $( "div.task" ).index( panelitem );
            $('.accordion').accordion("option","active",panelindex);
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
                                _showGenericErrorDialogBox();
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
        var form = $("#"+$task).find( ".edittaskForm" );
        $.ajax({
            type: "POST",
            url: "tasks/updateTask",
            dataType: "HTML",
            data: form.serialize(),
            success:function( result ) {
                if(result=="0") _showGenericErrorDialogBox();
                else {
                    //success - add the task to the list
                    $("#"+$task).find(".task_inner").html($('.task_inner', result).html());
                    $("#accordion").accordion( "refresh" );
                    _init();//so that the default text works,
                    _getEstimatedHoursForAWeek(form);
                
                }
            }
        });
    
    
    
    
    });
    
    
    
    
});