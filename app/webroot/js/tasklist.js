$(function() {
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
    ///default text behavior
    
    $(".jQbutton").button();
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
    $.fn.spantoinput = function() {
        
        var $thisid = $(this).attr("id");
        if($thisid=="desc") {
            var input = $('<textarea />', {
                'name': $thisid, 
                'value': $(this).html(),
                'id': "newtask_"+$thisid
            }); 
            input.val($(this).html());
        }else if($thisid=="status"){
            var checked_done = 'checked="checked"';
            var checked_notdone= 'checked="checked"';
            if($(this).html()=="Unfinished") checked_done = ""; else checked_notdone = "";
            var input = '<input type="radio" value="0" '+checked_notdone+' name="'+$thisid+'">Unfinished'+'<input type="radio" value="1" '+checked_done+'  name="'+$thisid+'">Done';
        }
        else{
            var input = $('<input />', {
                'type': 'text', 
                'name': $thisid, 
                'value': $(this).html(),
                'id': "newtask_"+$thisid
            });
        }
        
        $(this).parent().append(input);
        $(this).remove();
        if($thisid=="estimated_hours" || $thisid=="reported_hours") input.attr("size","2");
        if($thisid=="start_date" || $thisid=="end_date") input.datepicker({ dateFormat: "d MM, yy" } );
        if($thisid=="desc")input.focus();
    };

    $.fn.inputospan= function() {
        $(this).parent().append($('<span />').html($(this).val()));
        $(this).remove();
    };
    //edit task function 
                    
    $(".task_edit").click(function(){
        //clone the task_ and put cancel and save buttons - upon cancel put back the clone on save, save chanegs. discard the clone
        var id = "#task_"+$(this).attr("id").replace("task_edit_", "");
        $(id).find(".text_edit").each(function(){
            
            $(this).spantoinput();

        });
    //$(id).find(".date").datepicker();
                                                    

    });
    
    
    $( "#newtaskButton" ).click(function(){
        $("#newtask").insertAfter($(this)).show("slow");
        $("#newtask").find(".date").datepicker({dateFormat: "d MM, yy"});
        $(this).toggle();
    });
    //seee if something has been changed in the dialog box 
    //                    $("#newtask").find("texarea, input.text_edit").on('input', function() {
    //                        console.log("something changed.");
    //                    });

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
        $("#newtask .defaultText").blur(); 
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