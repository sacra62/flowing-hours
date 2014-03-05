$(function() {

    $("#save_energy").on('click', function() {
        var $this = $(this);
        var hours = $("#energybar_hours").html();
        $.ajax({
            type: "POST",
            url: "tasks/updateEnergy",
            dataType: "HTML",
            data: {
                "energy_hours": hours
            },
            success: function(result) {
                if (result == "0") {
                    _showGenericErrorDialogBox();
                }
                else {
                    var oldcolor = $this.find("span").css("color");
                    $this.find("span").animate({
                        backgroundColor: "#008000",
                        color: "#fff"
                    }, 1000, "swing", function() {
                        $this.find("span").animate({
                            backgroundColor: "transparent",
                            color: oldcolor
                        }, 1, "swing", function() {
                            $this.hide("slow")
                        });
                    });
                    
                    
                    //call feedback system
                    updateFeedback("saveenergy");
                }
            }
        });
        
        return true;
    });


//    
//    var flowingfeedback = new FlowingFeedback({
//        g_punctual:0
//    });
//    flowingfeedback.showStartupMessage();


});


function energy_slider_change(event, ui) {
    if (event.type != "slidechange")
        return;
    //if value has changed and is not equal to the old value, show the save button
    var energybar_hours = $("#energybar_hours").attr("rel"); //previous hours
    if (energybar_hours != ui.value)
        $("#save_energy").show();
    else
        $("#save_energy").hide();
}

;