$(function() {
    //sends a call to the server,gets the user pref and updates
    __feedback = false;

});
    
///
    
/* feedback algorithm */
//function FlowingFeedback(options) {
//    
//    options = $.extend(defaults, options);
//
//    //if logged on monday and on the tasklist screen
//    // then show a message based on the previous week's stats else the current week'
//
//    var showSaveAfterFeedback = function() {
//        _showGenericErrorDialogBox();
//
//    }
//    this.showStartupMessage = function() {
//
//        var msg = this.decideFeedback();
//        _showGenericErrorDialogBox(msg);
//
//    }
//
//    this.decideFeedback = function() {
//
//        //check the performance
//        //
//        //decide a feedback
//        //
//        //show it
//        return msg = 'You are so cute';
//    }
//}


//you may actually change the value of "event" to the id of the button which contains the id of the task or tells if it is save energy button
// or just sent the task id if it is a task. and also send it the task was created or edited.
// knowing all these values changes how often and when to show the feedback

// just change this function's call in 3 different places to send more information : in the tasklists.js - when a task is updated and created
// and in th energy.js when energy bar save button is pressed.
function updateFeedback(event){
    $.ajax({
        type: "POST",
        url: "tasks/getUserPref",
        dataType: "json",
        success: function(result) {
            if (result == "0") {
                _showGenericErrorDialogBox();
            }
            __feedback = result;
            
            
            if(__feedback){
                console.log("energy ready");
                var diff = 0;
                //feedback loaded
                //TODO - DOnt use the if condition below every time, better just use the showRandomMessage(); function and make it more intelligent
                //
                //if more hours saved than global, inform the user
                if(event=="saveenergy"){
                    diff = __feedback.settings.cw_energy_hours - __feedback.settings.g_energy_hours;
                    if(diff>5){
                        _showFeedbackDialogBox("You are trying to work more than you can chew. You defined more working hours for this week than your average work power. Check the settings.");
                    }
                    if(diff<-5){
                        _showFeedbackDialogBox("You are trying to work less than you can. You defined more working hours for this as your average work power in the settings.");
                    }
                }
                else{
                    //came from edit or update task
                    
                    showRandomMessage();
                }
            }
            
        //showStartUpMessage();
        }
    });
}

function showRandomMessage(){
    
    //@Henry - create your own stats here, dont trust this feedback logic !! - to know how each setting is calculated see app/controllers/TasksController getUserPref
    //1. maybe use javascript session or cookie to store when we showed user a feedback, if he is too quick and saving the same task over and over again, it may not make sense to show a feedback every time
    // all the required stats are available, 
    //2, in the updateFeedback function, dont stress the server side, better decide when to call server and when not.
    var avg_energy_per_day = Math.ceil(__feedback.settings.cw_energy_hours/7);
    var avg_work_per_day = Math.ceil(__feedback.settings.cw_total_hours/7);
    //var avg_hours = Math.ceil(__feedback.settings.cw_energy_hours/7);
    var d = new Date();
    var currentday = d.getDay();
    var shouldbe_totalscheduled = avg_energy_per_day*currentday;
    var shouldbe_totalworked = avg_work_per_day*currentday; 
    
    var diffscheduleHours = shouldbe_totalscheduled - __feedback.settings.cw_total_hours;
    var diffworkingHours = shouldbe_totalworked - __feedback.settings.cw_finished_hours;
    
    
    
    var diffscheduleHoursPercent = (shouldbe_totalscheduled*100)/__feedback.settings.cw_total_hours;
    var diffworkingHoursPercent = (shouldbe_totalworked*100)/__feedback.settings.cw_finished_hours;
    
    //decide level
    var msgtype = 0;
    var msglevel = 0;
    
    console.log(diffscheduleHoursPercent);
    /// positive feedaback
    //@Henry this approach of categorizing encouraging","positive as positive may not be correct
    // use entirely your own approach. better use logic to determine the feedback "type" and dont use categories
    
    //    var positivefeedback = Array("encouraging","positive");
    //    var negativefeedback = Array("persuasive","caring");
    //    //we have 2 positive methods
    //    var positiverandom = Math.floor(Math.random() * positivefeedback.length);
    //    var negativerandom = Math.floor(Math.random() * negativefeedback.length);
    //    var levelrandom = Math.floor(Math.random() * 2); //2 is the numbers of levels we have 0,1 (all messags must have same number of levels or when a level is suggested by the same which is not present then do level=level-1 until you find a message for that level
    
    //    if(diffscheduleHoursPercent>-15 && diffscheduleHoursPercent<=15){
    //        msglevel = 0;
    //        msgtype = positivefeedback[positiverandom];
    //    }
    //    if(diffscheduleHoursPercent>15 && diffscheduleHoursPercent<=50){
    //        msglevel = 1;
    //       msgtype = positivefeedback[positiverandom];
    //    }
    //    if(diffscheduleHoursPercent<-50){
    //        msglevel = 1;
    //        msgtype = "persuasive";
    //    }
    //    /// negative feedaback
    //    if(diffscheduleHoursPercent>=-50 && diffscheduleHoursPercent<-15){
    //        msglevel = 0;
    //        msgtype = negativefeedback[negativerandom];
    //    }
    //    if(diffscheduleHoursPercent<-50){
    //        msglevel = 1;
    //        msgtype = negativefeedback[negativerandom];
    //    }
    //    if(diffscheduleHoursPercent>50){
    //        msglevel = 1;
    //        msgtype = "caring";
    //    }


//this is just for the random - do some logic by uncommenting the above lines or write completely new
    var positivefeedback = Array("encouraging","positive","persuasive","caring");
    //we have 2 positive methods
    var positiverandom = Math.floor(Math.random() * positivefeedback.length);
    var levelrandom = Math.floor(Math.random() * 2);
    msglevel = levelrandom;
    msgtype = positivefeedback[positiverandom];
    /// end of random logic
    
    
    
    var msg = __feedback.feedback[msgtype][msglevel]['message'];
    _showFeedbackDialogBox(msg);
//    if(diffscheduleHours>5){
//        _showFeedbackDialogBox("According to your weekly energy level you are <strong>falling behind</strong>. By today you should have shceduled <strong>"+shouldbe_totalscheduled+"</strong> working hours but you only did <strong>"+__feedback.settings.cw_total_hours+"</strong>");
//    }
//    if(diffscheduleHours<-5){
//        _showFeedbackDialogBox("According to your weekly energy level you must <strong>slow down</strong>. By now you should have shceduled <strong>"+shouldbe_totalscheduled+"</strong> working hours you already did <strong>"+__feedback.settings.cw_total_hours+"</strong> hours");
//    }
//    if(diffscheduleHours<3 && diffscheduleHours>=-3){
//      _showFeedbackDialogBox("According to your weekly energy level you must <strong>slow down</strong>. By now you should have shceduled <strong>"+shouldbe_totalscheduled+"</strong> working hours you already did <strong>"+__feedback.settings.cw_total_hours+"</strong> hours");
//
//    }
    
}
function _showFeedbackDialogBox(msg){
    //remove data and cancel
    var $dialog = $( "#feedbackdlg" ).clone(true).removeAttr("id").addClass("feedbackdlg");
    $dialog.html(msg);
    $dialog.dialog({
        modal: true, 
        zIndex: 10000, 
        autoOpen: true,
        width: '300px', 
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
function showStartUpMessage() {
    var diff = __feedback.settings.cw_energy_hours - __feedback.settings.g_energy_hours;
    if(diff>5){
    //_showFeedbackDialogBox("You are trying to work more than you can chew. You defined more working hours for this week than your average work power. Check the settings.");
    }
    
}
function showFeedbackAfterInterval() {
    console.log("interval");
}

function showFeedbackOnEnergyLevelSettings() {
    console.log("energy setttings");
}

function checkHours(estimatedHours) {
    var energybar_hours = $("#energybar_hours").val();
    console.log(estimatedHours);
    var energylevel_bar = 1
    if (energybar_hours > 25 && energybar_hours <= 37.5)
        energylevel_bar = 2
    else if (energybar_hours > 37.5)
        energylevel_bar = 3

    var data = {
        g_energy_hours: 27,
        g_punctual: 1,
        cw_energy_hours: 25,
        cw_unfinished_hours: estimatedHours,
        cw_finished_hours: 10,
        lfw_unfinished_hours: 15,
        lfw_finished_hours: 12,
        energyLevel_Bar: energylevel_bar,
        feedbackmessages: {
            "0": {
                type: "caring", 
                level: "0", 
                message: "It seems you have lots of work and no breaks. How about a break now?"
            },
            "1": {
                type: "caring", 
                level: "0", 
                message: "You already have many unifinshed tasks. Do you really want to add this task? Are you sure?"
            },
            "2": {
                type: "encouraging", 
                level: "0", 
                message: "Hey, you are doing really great!"
            },
            "3": {
                type: "persuasive", 
                level: "0", 
                message: "You still need plenty of work to do"
            }
        }
    };
    return checkHoursReturn(data);
}

function checkHoursReturn(data) {

    var energyLevel = {
        Low: 1,
        Medium: 2,
        High: 3
    };

    if (data.energyLevel_Bar == energyLevel.High) {
        if (data.cw_unfinished_hours > 37.5) {
            return data;
        }
    }
    else if (data.energyLevel_Bar == energyLevel.Medium) {
        if (data.cw_unfinished_hours + data.thisTaskHours > 37.5) {
            return data.messages[1];
        }
    }
    else if (data.energyLevel_Bar == energyLevel.Low) {
        if (data.cw_unfinished_hours + data.thisTaskHours > 25) {
            return data.messages[2];
        }
    }

    return true;
}
    


var myRevealingModule = function() {

    var initial = function() {

        $("#dialog").dialog({
            autoOpen: false,
            show: {
                effect: "clip",
                duration: 500
            },
            hide: {
                effect: "fade",
                duration: 300
            },
            buttons: {
                OK: function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#dialog").dialog("option", "closeOnEscape", true);
    };
    return {
        init: initial
    };
}();

var msgBox = function(data) {
   
    var energyLevel = {
        Low: 1,
        Medium: 2,
        High: 3
    };

    if (data.energyLevel == energyLevel.High) {
        if (data.unfinishedTaskHours + data.thisTaskHours > 40) {
            $("#dialog").dialog("open");
            document.getElementById('btnExp1Para').innerHTML = data.messages;
        }
    }
    else if (data.energyLevel == energyLevel.Medium) {
        if (data.unfinishedTaskHours + data.thisTaskHours > 30) {
            $("#dialog").dialog("open");
            document.getElementById('btnExp1Para').innerHTML = data.messages;
        }
    }
    else if (data.energyLevel == energyLevel.Low) {
        if (data.unfinishedTaskHours + data.thisTaskHours > 20) {
            console.log(data);
            $("#dialog").dialog("open");
            document.getElementById('btnExp1Para').innerHTML = data.messages[0];  
        }
    }
};

$(function() {
    //        $(document).on(data.eventType, data.jQueryPath, function(data){....}
    myRevealingModule.init();

    $("#newtask_save").on('click', function() {
        var estimatedHours = document.getElementById("newtask_estimated_hours").value;
        var energy = 1;//document.getElementById("txtEnergyLevel").value;
                    
        var data = {
            energyLevel: energy, 
            unfinishedTaskHours: 20, 
            thisTaskHours: estimatedHours, 
            messages: ['You already have 20 unfinished tasks hours. Do you want to consider resecheduling some tasks?', 'Great Job. Well done!', 'Hey, remember to check on your tasks!', 'It seems you have lots of work and no breaks. How about a break now?']
        };
        msgBox(data);
    });
});
