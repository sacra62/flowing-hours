$(function() {
    $("#save_energy").on('click',function(){
        var $this = $(this);
        var hours = $("#energybar_hours").html();
        $.ajax({
            type: "POST",
            url: "tasks/updateEnergy",
            dataType: "HTML",
            data: {"energyhours":hours},
            success:function( result ) {
                if(result=="0"){
                    _showGenericErrorDialogBox();
                }
                else {
                    $this.animate({
                        backgroundColor: "#008000",
                        color: "#fff"
                    }, 1000 );
      
                }
            }
        });
    });

});


function energy_slider_change(event, ui){
    if(event.type!="slidechange") return;
    //if value has changed and is not equal to the old value, show the save button
    var energybar_hours = $("#energybar_hours").attr("rel"); //previous hours
    if(energybar_hours!=ui.value) $("#save_energy").show();
    else $("#save_energy").hide();
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
