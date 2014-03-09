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


//you may actually change the value of "event" to the id of the button
// which contains the id of the task or tells if it is save energy button
// or just sent the task id if it is a task. and also send it the task was created or edited.
// knowing all these values changes how often and when to show the feedback

// just change this function's call in 3 different places to send more information : in the tasklists.js - when a task is updated and created
// and in th energy.js when energy bar save button is pressed.
function updateFeedback(event) {
    $.ajax({
        type: "POST",
        url: "tasks/getUserPref",
        dataType: "json",
        success: function(result) {
            if (result == "0") {
                _showGenericErrorDialogBox();
            }
            __feedback = result;

            if (__feedback) {
                console.log("energy ready");
                var diff = 0;
                //feedback loaded
                //TODO - DOnt use the if condition below every time,
                // better just use the showRandomMessage(); function and make it more intelligent
                //
                //if more hours saved than global, inform the user
                if (event == "saveenergy") {
                    diff = __feedback.settings.cw_energy_hours - __feedback.settings.g_energy_hours;
                    if (diff > 5) {
                        _showFeedbackDialogBox("You are trying to work more than you can chew. You defined more working hours for this week than your average work energy. Check the settings.");
                    }
                    if (diff < -5) {
                        _showFeedbackDialogBox("You are trying to work less than you can. You defined more working hours for this as your average work energy in the settings.");
                    }
                }
                else {
                    //came from edit or update task

                    //showRandomMessage();

                    var msg = decideFeedback();
                    _showFeedbackDialogBox(msg);

                }
            }
        }
    });
}

function decideFeedback() {
    var energybar_hours = $("#energybar_hours").val();

    var energylevel_bar = 1;
    if (energybar_hours > 25 && energybar_hours <= 37.5)
        energylevel_bar = 2;
    else if (energybar_hours > 37.5)
        energylevel_bar = 3;

    var data = {
        g_energy_hours: __feedback.settings.g_energy_hours,
        cw_energy_hours: energybar_hours,
        cw_unfinished_hours: __feedback.settings.lfw_total_hours,
        cw_finished_hours: __feedback.settings.cw_finished_hours,
        energyLevel_Bar: energylevel_bar,
    };

    var energyLevel = {
        Low: 1,
        Medium: 2,
        High: 3
    };

    var avg_energy_per_day = Math.ceil(__feedback.settings.cw_energy_hours / 7);
    var d = new Date();
    var currentweekday = d.getDay();
    if (curentday == 0)
        currentweekday = 7; //Sunday
    var shouldbe_totalscheduled = avg_energy_per_day * currentweekday;

    if (data.energyLevel_Bar == energyLevel.High) {
        if (data.cw_unfinished_hours > 37.5)
            return __feedback.feedback["caring"][1]['message'];
        else if (currentweekday != 1)
        {
            if (_feedback.settings.cw_finished_hours < (shouldbe_totalscheduled - avg_energy_per_day))
                return "You must have completed at least " + avg_energy_per_day + " hours till now.";
            else if (_feedback.settings.cw_finished_hours >= (shouldbe_totalscheduled - avg_energy_per_day))
                return __feedback.feedback["positive"][1]['message'];
        }
    }
    else if (data.energyLevel_Bar == energyLevel.Medium)
    {
        if (data.cw_unfinished_hours > 37.5)
            return __feedback.feedback["caring"][1]['message'];
        else if (currentweekday != 1)
        {
            if (_feedback.settings.cw_finished_hours < (shouldbe_totalscheduled - avg_energy_per_day))
                return "You must have completed at least " + avg_energy_per_day + " hours till now.";
            else if (_feedback.settings.cw_finished_hours >= (shouldbe_totalscheduled - avg_energy_per_day))
                return __feedback.feedback["positive"][1]['message'];
        }
    }

    else if (data.energyLevel_Bar == energyLevel.Low)
    {
        if (data.cw_unfinished_hours > 25)
            return __feedback.feedback["caring"][1]['message'];
        else if (currentweekday != 1)
        {
            if (_feedback.settings.cw_finished_hours < (shouldbe_totalscheduled - avg_energy_per_day))
                return "You must have completed at least " + avg_energy_per_day + " hours till now.";
            else if (_feedback.settings.cw_finished_hours >= (shouldbe_totalscheduled - avg_energy_per_day))
                return __feedback.feedback["positive"][1]['message'];
        }
    }
}

        function showFeedbackStartUp() {

            var avg_energy_per_day = Math.ceil(__feedback.settings.cw_energy_hours / 7);
            var d = new Date();
            var currentweekday = d.getDay();
            if (curentday == 0)
                currentweekday = 7; //Sunday
            var shouldbe_totalscheduled = avg_energy_per_day * currentweekday;

            if (_feedback.settings.cw_finished_hours < shouldbe_totalscheduled) {
                _showFeedbackDialogBox("According to your weekly energy level you are <strong>falling behind</strong>. By today you should have shceduled <strong>" + shouldbe_totalscheduled + "</strong> working hours but you only did <strong>" + __feedback.settings.cw_total_hours + "</strong>");
            }
            else if (_feedback.settings.cw_finished_hours > shouldbe_totalscheduled) {
                _showFeedbackDialogBox("According to your weekly energy level you must <strong>slow down</strong>. By now you should have shceduled <strong>" + shouldbe_totalscheduled + "</strong> working hours you already did <strong>" + __feedback.settings.cw_total_hours + "</strong> hours");
            }
        }

        function setCookie(cname)
        {
            var d = new Date();
            cvalue = d.getMinutes();
            document.cookie = cname + "=" + cvalue;
        }

        function getCookie()
        {
            var x = document.cookie;
            return x;
        }

        function checkCookie()
        {
            var cookie = getCookie();
            if (cookie != "")
            {
                if (cookie > 15)
                    return 1;
                else
                    return 0;
            }
            else
            {
                setCookie("lastShownFeedback");
            }
        }

        function _showFeedbackDialogBox(msg) {
            //remove data and cancel
            var $dialog = $("#feedbackdlg").clone(true).removeAttr("id").addClass("feedbackdlg");
            $dialog.html(msg);
            $dialog.dialog({
                modal: true,
                zIndex: 10000,
                autoOpen: true,
                width: '300px',
                resizable: false,
                buttons: {
                    Ok: function() {
                        $(this).dialog("close");
                    }
                },
                close: function(event, ui) {
                    $(this).dialog("close");
                }
            });
        }

        function showRandomMessage() {

            //@Henry - create your own stats here, dont trust this feedback logic !!
            // - to know how each setting is calculated see app/controllers/TasksController getUserPref
            //1. maybe use javascript session or cookie to store when we showed user a feedback,
            // if he is too quick and saving the same task over and over again,
            // it may not make sense to show a feedback every time
            // all the required stats are available, 
            //2. in the updateFeedback function, dont stress the server side, better decide when to call server and when not.
//    
//    
//    var avg_energy_per_day = Math.ceil(__feedback.settings.cw_energy_hours / 7);
//    var avg_work_per_day = Math.ceil(__feedback.settings.cw_total_hours / 7);
//    //var avg_hours = Math.ceil(__feedback.settings.cw_energy_hours/7);
//    var d = new Date();
//    var currentday = d.getDay();
//    var shouldbe_totalscheduled = avg_energy_per_day * currentday;
//    var shouldbe_totalworked = avg_work_per_day * currentday;
//
//    var diffscheduleHours = shouldbe_totalscheduled - __feedback.settings.cw_total_hours;
//    var diffworkingHours = shouldbe_totalworked - __feedback.settings.cw_finished_hours;
//
//    var diffscheduleHoursPercent = (shouldbe_totalscheduled * 100) / __feedback.settings.cw_total_hours;
//    var diffworkingHoursPercent = (shouldbe_totalworked * 100) / __feedback.settings.cw_finished_hours;
//
//    //decide level
//    var msgtype = 0;
//    var msglevel = 0;
//
//    console.log(diffscheduleHoursPercent);
//    
//    
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
            var positivefeedback = Array("encouraging", "positive", "persuasive", "caring");
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
//        _showFeedbackDialogBox("According to your weekly energy level you must <strong>slow down</strong>. By now you should have shceduled <strong>"+shouldbe_totalscheduled+"</strong> working hours you already did <strong>"+__feedback.settings.cw_total_hours+"</strong> hours");
//
//    }
        }

        function showStartUpMessage() {
            var diff = __feedback.settings.cw_energy_hours - __feedback.settings.g_energy_hours;
            if (diff > 5) {
                //_showFeedbackDialogBox("You are trying to work more than you can chew. You defined more working hours for this week than your average work power. Check the settings.");
            }
}