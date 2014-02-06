
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
                    
                    var data = {energyLevel: energy, unfinishedTaskHours: 20, thisTaskHours: estimatedHours, messages: ['You already have 20 unfinished tasks hours. Do you want to consider resecheduling some tasks?', 'Great Job. Well done!', 'Hey, remember to check on your tasks!', 'It seems you have lots of work and no breaks. How about a break now?']};
                    msgBox(data);
                });
            });
