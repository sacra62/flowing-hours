$(function() {
    
    //set defaults for the user pref
    
    defaults = {
        g_energy_hours: 27,
        g_punctual: 1,
        cw_energy_hours: 25,
        cw_unfinished_hours: 18,
        cw_finished_hours: 12,
        lfw_unfinished_hours: 15,
        lfw_finished_hours: 12,
        energyLevel: {
        Low: 1,
        Medium: 2,
        High: 3
        },
        feedbackmessages: {
            "0":{type:"caring",level:"0",message:"It seems you have lots of work and no breaks. How about a break now?"},
            "1":{type:"encouraging",level:"0",message:"Hey, you are doing really great!"},
            "2":{type:"persuasive",level:"0",message:"You still need plenty of work to do"}
        }
    };

    //sends a call to the server,gets the user pref and updates
   
    $.ajax({
        type: "POST",
        url: "tasks/getUserPref",
        dataType: "json",
        success:function( result ) {
            if(result=="0"){
                _showGenericErrorDialogBox();
            }
            //merge deffaults with userpref
            //defaults = ///
            //defaults = result;
            showStartUpMessage();
        }
    });
    ///
    
    
    $("#save_energy").on('click',function(){
        var $this = $(this);
        var hours = $("#energybar_hours").html();
        $.ajax({
            type: "POST",
            url: "tasks/updateEnergy",
            dataType: "HTML",
            data: {
                "energy_hours":hours
            },
            success:function( result ) {
                if(result=="0"){
                    _showGenericErrorDialogBox();
                }
                else {
                    var oldcolor = $this.find("span").css("color");
                    $this.find("span").animate({
                        backgroundColor: "#008000",
                        color: "#fff"
                    }, 1000,"swing",function(){
                        $this.find("span").animate({
                            backgroundColor: "transparent",
                            color: oldcolor
                        }, 1, "swing",function(){
                            $this.hide("slow")
                        });
                    } );
                    
                    
                }
            }
        });
    });
    
    
//    
//    var flowingfeedback = new FlowingFeedback({
//        g_punctual:0
//    });
//    flowingfeedback.showStartupMessage();


});


function energy_slider_change(event, ui){
    if(event.type!="slidechange") return;
    //if value has changed and is not equal to the old value, show the save button
    var energybar_hours = $("#energybar_hours").attr("rel"); //previous hours
    if(energybar_hours!=ui.value) $("#save_energy").show();
    else $("#save_energy").hide();
}



/* feedback algorithm */
function FlowingFeedback(options) {
    var defaults = {
        g_energy_hours: 27,
        g_punctual: 1,
        cw_energy_hours: 25,
        cw_unfinished_hours: 18,
        cw_finished_hours: 12,
        lfw_unfinished_hours: 15,
        lfw_finished_hours: 12
    };

    options = $.extend(defaults, options);

    //if logged on monday and on the tasklist screen then show a message based on the previous week's stats else the current week'
    var showSaveAfterFeedback= function () {
        _showGenericErrorDialogBox();
        
    }
    this.showStartupMessage = function () {
        
        var msg = this.decideFeedback();
        _showGenericErrorDialogBox(msg);
        
    }
    
    this.decideFeedback = function(){
        
        //check the performance
        //
        //decide a feedback
        //
        //show it
        return msg = 'You are so cute';
    }
}

function showStartUpMessage(){
    console.log("start up");
}
function showFeedbackAfterInterval(){
    console.log("interval");
}

function showFeedbackOnEnergyLevelSettings(){
    console.log("energy setttings");
}

function checkHours(estimatedHours){
    var energybar_hours = $("#energybar_hours").val();
                    
    var energy = 1
    if (energybar_hours>25 && energybar_hours <=37.5)
        energy = 2
    else if (energybar_hours>37.5)
        energy = 3

    var data = {
        energyLevel: energy, 
        unfinishedTaskHours: 20, 
        thisTaskHours: estimatedHours, 
        messages: ['You already have 20 unfinished tasks hours. Do you want to consider resecheduling some tasks?', 'Great Job. Well done!', 'Hey, remember to check on your tasks!', 'It seems you have lots of work and no breaks. How about a break now?']
    };
        
    return checkHoursReturn(data);
}

function checkHoursReturn(data) {

    var energyLevel = {
        Low: 1,
        Medium: 2,
        High: 3
    };

    if (data.energyLevel == energyLevel.High) {
        if (data.unfinishedTaskHours + data.thisTaskHours > 37.5) {
            return data.messages[0];
        }
    }
    else if (data.energyLevel == energyLevel.Medium) {
        if (data.unfinishedTaskHours + data.thisTaskHours > 37.5) {
            return data.messages[1];
        }
    }
    else if (data.energyLevel == energyLevel.Low) {
        if (data.unfinishedTaskHours + data.thisTaskHours > 25) {
            return data.messages[2];
        }
    }
    
    return true;
};
