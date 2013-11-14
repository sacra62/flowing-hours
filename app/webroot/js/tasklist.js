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
    $( "#accordion") .accordion({
        collapsible: true, 
        header: 'h3',       
        active: true, 
        height: 'fill'
    }).sortable({
        }); 
 
    $('#accordion').on('accordionactivate', function (event, ui) {

        if (ui.newPanel.length) {
            $('#accordion').sortable('disable');
        } else {
            $('#accordion').sortable('enable');
        }
    });
                    
    //Text to span and span to text script 
    $.fn.spantoinput = function(id) {
        
        var $thisid = $(this).attr("rel");
        var $thisval = $(this).html();
        if($thisid=="desc") {
            var input = $('<textarea />', {
                'name': $thisid, 
                'value': $thisval,
                'id': "newtask_"+$thisid+"_"+id
            }); 
            input.val($thisval);
        }else if($thisid=="status"){
            var checked_done = 'checked="checked"';
            var checked_notdone= 'checked="checked"';
            if($thisval=="Unfinished") checked_done = ""; else checked_notdone = "";
            var input = '<input type="radio" value="0" '+checked_notdone+' name="'+$thisid+'">Unfinished'+'<input type="radio" value="1" '+checked_done+'  name="'+$thisid+'">Done';
        }
        else{
            var input = $('<input />', {
                'type': 'text', 
                'name': $thisid, 
                'value': $thisval,
                'id': "newtask_"+$thisid+"_"+id
            });
        }
        
        $(this).parent().append(input);
        $(this).remove();
        if($thisid=="estimated_hours" || $thisid=="reported_hours") input.attr("size","2");
        if($thisid=="start_date" || $thisid=="end_date") {
            input.datetimepicker({
                dateFormat: "d MM, yy",
                timeFormat: "HH:mm"
            });
            input.datetimepicker('setDate', $thisval);
        }
        if($thisid=="desc")input.focus();
    };

    $.fn.inputospan= function() {
        $(this).parent().append($('<span />').html($(this).val()));
        $(this).remove();
    };
    //edit task function 
                    
    $(".task_edit").on('click',function(){
        $(this).toggle();
        var id = $(this).attr("id");
        var task = "#task_"+id.replace("task_edit_", "");
        $(task).find(".edittask_controls").toggle();

        $(task).find(".text_edit").each(function(){
            
            $(this).spantoinput(id);

        });
    });
    
    $(".task .edittask_controls .edittask_save").on('click',function(e){
        e.preventDefault();
        var allGood = true;
        var $task = $(this).parents().find("div.task").attr("id");
        
        $("#"+$task+" textarea, #"+$task+" input[type='text']:not([name='reported_hours'])").each(function() {
            var val = $(this).val();
            $(this).css({
                backgroundColor:'transparent'
            });//reset every time
            if(val == "" || val == 0) {
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
    $( "#newtaskButton" ).click(function(){
        $("#newtask").insertAfter($(this)).show("slow");
        $("#newtask").find(".date").datetimepicker({
            dateFormat: "d MM, yy",
            timeFormat: "HH:mm"
        });
        $(this).toggle();
    });
   
    $("#newtask_save").click(function(){
        var allGood = true;
        $("#newtask textarea, #newtask input.text_edit").each(function() {
            var val = $(this).val();
            $(this).css({
                backgroundColor:'transparent'
            });//reset every time
            if(val == "" || val == 0 ||  val==$(this).attr("title")) {
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
                resetNewTaskDialog();
                $("#accordion").append(result);
                $("#accordion").accordion( "refresh" );
                _init();
            }
                        
        });
    // no issues go ahead and save.
    });
                    
    function resetNewTaskDialog(){
        $("#newtask").hide("slow");
        $("#newtaskButton").toggle();
        $("#newtask textarea, #newtask input.text_edit").each(function() {
            $(this).val("");  
        });
    //$("#newtask .defaultText").blur(); 
    }
                    
                    
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
  
});
});