$(document).ready(function(){	

    var clickDate = "";
    var clickAgendaItem = "";
	
    /**
	 * Initializes calendar with current year & month
	 * specifies the callbacks for day click & agenda item click events
	 * then returns instance of plugin object
	 */
    var jfcalplugin = $("#mycal").jFrontierCal({
        date: new Date(),
        dayClickCallback: myDayClickHandler,
        agendaClickCallback: myAgendaClickHandler,
        agendaDropCallback: myAgendaDropHandler,
        agendaMouseoverCallback: myAgendaMouseoverHandler
        ,
        applyAgendaTooltipCallback: myApplyTooltip
        ,
        agendaDragStartCallback : myAgendaDragStart,
        agendaDragStopCallback : myAgendaDragStop,
        dragAndDropEnabled: false
    }).data("plugin");
	    
    //@abrar - add events to the calendar
        
    $.ajax({
        contentType: "application/json; charset=utf-8",
        data: '{}',
        dataType: "json",
        type: "POST",
        url: "tasks/loadTasks",                                        //the code behind method
        success: function(data) {      
            //using the value returned by the code behind in a for loop to print all the existing events from the DB
            for (var i = 0; i < data.length; i++) {
                var stdate = new Date(data[i].Task.start_date.toString());   //Retrieving the startdate
                var endate = new Date(data[i].Task.end_date.toString());   //Retrieving the enddate
                var alldayValue = false;
                //                    var allDay = data[i].Task.allDay.toString();                      //Retrieving the allDay Value
                //                    if (allDay == "false")
                //                        alldayValue = false;
                //                    if (allDay == "true")
                //                        alldayValue = true;



                jfcalplugin.addAgendaItem(                  //This is the method that adds the event to the calander. Refer the documentation for more details of this method
                    "#mycal",                                      //The Div element for my calander
                    data[i].Task.title,
                    stdate,
                    endate,
                    alldayValue,
                    {
                        task: data[i].Task,
                        editTaskId:data[i].Task.id //to help us keep the id of the task in the task list
                    },
                    {
                        backgroundColor: $("#colorBackground").val(),
                        foregroundColor: $("#colorForeground").val()
                    }
                    );
            }
        },
        error: function(result) {
            //alert(result.responseText);
            console.log(result.responseText);
        }
    });
    /**
	 * Do something when dragging starts on agenda div
	 */
    //    function myAgendaDragStart(eventObj,divElm,agendaItem){
    //        // destroy our qtip tooltip
    //        if(divElm.data("qtip")){
    //            divElm.qtip("destroy");
    //        }	
    //    };
	
    /**
	 * Do something when dragging stops on agenda div
	 */
    //    function myAgendaDragStop(eventObj,divElm,agendaItem){
    //    //alert("drag stop");
    //    };
	
    /**
	 * Custom tooltip - use any tooltip library you want to display the agenda data.
	 * for this example we use qTip - http://craigsworks.com/projects/qtip/
	 *
	 * @param divElm - jquery object for agenda div element
	 * @param agendaItem - javascript object containing agenda data.
	 */
    function myApplyTooltip(divElm,agendaItem){

        // Destroy currrent tooltip if present
        if(divElm.data("qtip")){
            divElm.qtip("destroy");
        }
		
        var displayData = "";
        var data = agendaItem.data;

        var title = agendaItem.title;
        var startDate = data.task.start_date;
        var endDate = data.task.end_date;
        var allDay = agendaItem.allDay;
        displayData += "<br><b>" + title+ "</b><br><br>";
        displayData += data.task.desc+ "<br><br>";
        if(allDay){
            displayData += "(All day event)<br><br>";
        }else{
            displayData += "<b>Starts:</b> " + startDate + "<br><br>" + "<b>Ends:</b> " + endDate + "<br><br>";
            displayData += "<b>Status:</b> " + (data.task.status=="0" ? "Unfinished": "Done")+ "<br><br>";
            displayData += "<b>Estimated Hours:</b> " + data.task.estimated_hours+ "<br><br>";
            displayData += "<b>Reported Hours:</b> " + data.task.reported_hours+ "<br><br>";
        }
        //        for (var propertyName in data) {
        //            displayData += "<b>" + propertyName + ":</b> " + data[propertyName] + "<br>"
        //        }
        // use the user specified colors from the agenda item.
        var backgroundColor = agendaItem.displayProp.backgroundColor;
        var foregroundColor = agendaItem.displayProp.foregroundColor;
        var myStyle = {
            border: {
                width: 5,
                radius: 10
            },
            padding: 10, 
            textAlign: "left",
            tip: true,
            name: "dark" // other style properties are inherited from dark theme		
        };
        if(backgroundColor != null && backgroundColor != ""){
            myStyle["backgroundColor"] = backgroundColor;
        }
        if(foregroundColor != null && foregroundColor != ""){
            myStyle["color"] = foregroundColor;
        }
        // apply tooltip
        divElm.qtip({
            content: displayData,
            position: {
                corner: {
                    tooltip: "bottomMiddle",
                    target: "topMiddle"			
                },
                adjust: { 
                    mouse: true,
                    x: 0,
                    y: -15
                },
                target: "mouse"
            },
            show: { 
                when: { 
                    event: 'mouseover'
                }
            },
            style: myStyle
        });

    };

    /**
	 * Make the day cells roughly 3/4th as tall as they are wide. this makes our calendar wider than it is tall. 
	 */
    jfcalplugin.setAspectRatio("#mycal",0.75);

    /**
	 * Called when user clicks day cell
	 * use reference to plugin object to add agenda item
	 */
    function myDayClickHandler(eventObj){
    //@abrar - disabled for now
    //		// Get the Date of the day that was clicked from the event object
    //		var date = eventObj.data.calDayDate;
    //		// store date in our global js variable for access later
    //		clickDate = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
    //		// open our add event dialog
    //		$('#add-event-form').dialog('open');
    };
	
    /**
	 * Called when user clicks and agenda item
	 * use reference to plugin object to edit agenda item
	 */
    function myAgendaClickHandler(eventObj){
        // Get ID of the agenda item from the event object
        var agendaId = eventObj.data.agendaId;		
        // pull agenda item from calendar
        var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
        clickAgendaItem = agendaItem;
        $("#display-event-form").dialog('open');
    };
	
    /**
	 * Called when user drops an agenda item into a day cell.
	 */
    function myAgendaDropHandler(eventObj){
    //@abrar - disabled for now
    //		// Get ID of the agenda item from the event object
    //		var agendaId = eventObj.data.agendaId;
    //		// date agenda item was dropped onto
    //		var date = eventObj.data.calDayDate;
    //		// Pull agenda item from calendar
    //		var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);		
    //		alert("You dropped agenda item " + agendaItem.title + 
    //			" onto " + date.toString() + ". Here is where you can make an AJAX call to update your database.");
    };
	
    /**
	 * Called when a user mouses over an agenda item	
	 */
    function myAgendaMouseoverHandler(eventObj){
        var agendaId = eventObj.data.agendaId;
        var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
    //alert("You moused over agenda item " + agendaItem.title + " at location (X=" + eventObj.pageX + ", Y=" + eventObj.pageY + ")");
    };
    /**
	 * Initialize jquery ui datepicker. set date format to yyyy-mm-dd for easy parsing
	 */
    $("#dateSelect").datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd'
    });
	
    /**
	 * Set datepicker to current date
	 */
    $("#dateSelect").datepicker('setDate', new Date());
    /**
	 * Use reference to plugin object to a specific year/month
	 */
    $("#dateSelect").bind('change', function() {
        var selectedDate = $("#dateSelect").val();
        var dtArray = selectedDate.split("-");
        var year = dtArray[0];
        // jquery datepicker months start at 1 (1=January)		
        var month = dtArray[1];
        // strip any preceeding 0's		
        month = month.replace(/^[0]+/g,"")		
        var day = dtArray[2];
        // plugin uses 0-based months so we subtrac 1
        jfcalplugin.showMonth("#mycal",year,parseInt(month-1).toString());
    });	
    /**
	 * Initialize previous month button
	 */
    $("#BtnPreviousMonth").button();
    $("#BtnPreviousMonth").click(function() {
        jfcalplugin.showPreviousMonth("#mycal");
        // update the jqeury datepicker value
        var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
        var cyear = calDate.getFullYear();
        // Date month 0-based (0=January)
        var cmonth = calDate.getMonth();
        var cday = calDate.getDate();
        // jquery datepicker month starts at 1 (1=January) so we add 1
        $("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);
        return false;
    });
    /**
	 * Initialize next month button
	 */
    $("#BtnNextMonth").button();
    $("#BtnNextMonth").click(function() {
        jfcalplugin.showNextMonth("#mycal");
        // update the jqeury datepicker value
        var calDate = jfcalplugin.getCurrentDate("#mycal"); // returns Date object
        var cyear = calDate.getFullYear();
        // Date month 0-based (0=January)
        var cmonth = calDate.getMonth();
        var cday = calDate.getDate();
        // jquery datepicker month starts at 1 (1=January) so we add 1
        $("#dateSelect").datepicker("setDate",cyear+"-"+(cmonth+1)+"-"+cday);		
        return false;
    });
	
    /**
	 * Initialize delete all agenda items button
	 */
    $("#BtnDeleteAll").button();
    $("#BtnDeleteAll").click(function() {	
        jfcalplugin.deleteAllAgendaItems("#mycal");	
        return false;
    });		
	
    /**
	 * Initialize iCal test button
	 */
    $("#BtnICalTest").button();
    $("#BtnICalTest").click(function() {
        // Please note that in Google Chrome this will not work with a local file. Chrome prevents AJAX calls
        // from reading local files on disk.		
        jfcalplugin.loadICalSource("#mycal",$("#iCalSource").val(),"html");	
        return false;
    });	

    /**
	 * Initialize add event modal form
	 */
    $("#add-event-form").dialog({
        autoOpen: false,
        height: 400,
        width: 400,
        modal: true,
        buttons: {
            'Add Event': function() {

                var what = jQuery.trim($("#what").val());
			
                if(what == ""){
                    alert("Please enter a short event description into the \"what\" field.");
                }else{
				
                    var startDate = $("#startDate").val();
                    var startDtArray = startDate.split("-");
                    var startYear = startDtArray[0];
                    // jquery datepicker months start at 1 (1=January)		
                    var startMonth = startDtArray[1];		
                    var startDay = startDtArray[2];
                    // strip any preceeding 0's		
                    startMonth = startMonth.replace(/^[0]+/g,"");
                    startDay = startDay.replace(/^[0]+/g,"");
                    var startHour = jQuery.trim($("#startHour").val());
                    var startMin = jQuery.trim($("#startMin").val());
                    var startMeridiem = jQuery.trim($("#startMeridiem").val());
                    startHour = parseInt(startHour.replace(/^[0]+/g,""));
                    if(startMin == "0" || startMin == "00"){
                        startMin = 0;
                    }else{
                        startMin = parseInt(startMin.replace(/^[0]+/g,""));
                    }
                    if(startMeridiem == "AM" && startHour == 12){
                        startHour = 0;
                    }else if(startMeridiem == "PM" && startHour < 12){
                        startHour = parseInt(startHour) + 12;
                    }

                    var endDate = $("#endDate").val();
                    var endDtArray = endDate.split("-");
                    var endYear = endDtArray[0];
                    // jquery datepicker months start at 1 (1=January)		
                    var endMonth = endDtArray[1];		
                    var endDay = endDtArray[2];
                    // strip any preceeding 0's		
                    endMonth = endMonth.replace(/^[0]+/g,"");

                    endDay = endDay.replace(/^[0]+/g,"");
                    var endHour = jQuery.trim($("#endHour").val());
                    var endMin = jQuery.trim($("#endMin").val());
                    var endMeridiem = jQuery.trim($("#endMeridiem").val());
                    endHour = parseInt(endHour.replace(/^[0]+/g,""));
                    if(endMin == "0" || endMin == "00"){
                        endMin = 0;
                    }else{
                        endMin = parseInt(endMin.replace(/^[0]+/g,""));
                    }
                    if(endMeridiem == "AM" && endHour == 12){
                        endHour = 0;
                    }else if(endMeridiem == "PM" && endHour < 12){
                        endHour = parseInt(endHour) + 12;
                    }
					
                    //alert("Start time: " + startHour + ":" + startMin + " " + startMeridiem + ", End time: " + endHour + ":" + endMin + " " + endMeridiem);

                    // Dates use integers
                    var startDateObj = new Date(parseInt(startYear),parseInt(startMonth)-1,parseInt(startDay),startHour,startMin,0,0);
                    var endDateObj = new Date(parseInt(endYear),parseInt(endMonth)-1,parseInt(endDay),endHour,endMin,0,0);

                    // add new event to the calendar
                    jfcalplugin.addAgendaItem(
                        "#mycal",
                        what,
                        startDateObj,
                        endDateObj,
                        false,
                        {
                            fname: "Santa",
                            lname: "Claus",
                            leadReindeer: "Rudolph",
                            myDate: new Date(),
                            myNum: 42
                        },
                        {
                            backgroundColor: $("#colorBackground").val(),
                            foregroundColor: $("#colorForeground").val()
                        }
                        );

                    $(this).dialog('close');

                }
				
            },
            Cancel: function() {
                $(this).dialog('close');
            }
        },
        open: function(event, ui){
            // initialize start date picker
            $("#startDate").datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'yy-mm-dd'
            });
            // initialize end date picker
            $("#endDate").datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'yy-mm-dd'
            });
            // initialize with the date that was clicked
            $("#startDate").val(clickDate);
            $("#endDate").val(clickDate);
            // initialize color pickers
            $("#colorSelectorBackground").ColorPicker({
                color: "#333333",
                onShow: function (colpkr) {
                    $(colpkr).css("z-index","10000");
                    $(colpkr).fadeIn(500);
                    return false;
                },
                onHide: function (colpkr) {
                    $(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function (hsb, hex, rgb) {
                    $("#colorSelectorBackground div").css("backgroundColor", "#" + hex);
                    $("#colorBackground").val("#" + hex);
                }
            });
            //$("#colorBackground").val("#1040b0");		
            $("#colorSelectorForeground").ColorPicker({
                color: "#ffffff",
                onShow: function (colpkr) {
                    $(colpkr).css("z-index","10000");
                    $(colpkr).fadeIn(500);
                    return false;
                },
                onHide: function (colpkr) {
                    $(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function (hsb, hex, rgb) {
                    $("#colorSelectorForeground div").css("backgroundColor", "#" + hex);
                    $("#colorForeground").val("#" + hex);
                }
            });
            //$("#colorForeground").val("#ffffff");				
            // put focus on first form input element
            $("#what").focus();
        },
        close: function() {
            // reset form elements when we close so they are fresh when the dialog is opened again.
            $("#startDate").datepicker("destroy");
            $("#endDate").datepicker("destroy");
            $("#startDate").val("");
            $("#endDate").val("");
            $("#startHour option:eq(0)").attr("selected", "selected");
            $("#startMin option:eq(0)").attr("selected", "selected");
            $("#startMeridiem option:eq(0)").attr("selected", "selected");
            $("#endHour option:eq(0)").attr("selected", "selected");
            $("#endMin option:eq(0)").attr("selected", "selected");
            $("#endMeridiem option:eq(0)").attr("selected", "selected");			
            $("#what").val("");
        //$("#colorBackground").val("#1040b0");
        //$("#colorForeground").val("#ffffff");
        }
    });
	
    /**
	 * Initialize display event form.
	 */
    $("#display-event-form").dialog({
        autoOpen: false,
        height: 400,
        width: 400,
        modal: true,
        buttons: {		
            Cancel: function() {
                $(this).dialog('close');
            },
            'Edit': function() {
                //set the id in session and reload the page to taskslist
                $.ajax({
                    type: "POST",
                    url: 'tasks/setEditTaskIdInSession',
                    data:{
                        "editTaskId":$(this).find(".editaskid").attr("rel")
                        },
                    success:function(data){
                        window.location.href = "#tasklist";
                        location.reload();
                    }
                });
            }
        //            ,
        //            'Delete': function() {
        //                if(confirm("Are you sure you want to delete this agenda item?")){
        //                    if(clickAgendaItem != null){
        //                        jfcalplugin.deleteAgendaItemById("#mycal",clickAgendaItem.agendaId);
        //                    //jfcalplugin.deleteAgendaItemByDataAttr("#mycal","myNum",42);
        //                    }
        //                    $(this).dialog('close');
        //                }
        //            }			
        },
        open: function(event, ui){
            if(clickAgendaItem != null){
                var data = clickAgendaItem.data;

                var title = clickAgendaItem.title;
                var startDate = data.task.start_date;
                ;
                var endDate = data.task.start_date;
                ;
                var allDay = clickAgendaItem.allDay;
                // in our example add agenda modal form we put some fake data in the agenda data. we can retrieve it here.
                $("#display-event-form").append(
                    "<br><b>" + title+ "</b><br><br>"+data.task.desc+ "<br><br>"
                    +"<span class='editaskid' rel='"+data.editTaskId+"' style='hidden'></span>"//this id to help open the correct task for editing
                    );				
                if(allDay){
                    $("#display-event-form").append(
                        "(All day event)<br><br>"				
                        );				
                }else{
                    $("#display-event-form").append(
                        "<b>Starts:</b> " + startDate + "<br><br>" +
                        "<b>Ends:</b> " + endDate + "<br><br>"
                        + "<b>Status:</b> " + (data.task.status=="0" ? "Unfinished": "Done")+ "<br><br>"
                        + "<b>Estimated Hours:</b> " + data.task.estimated_hours+ "<br><br>"
                        +"<b>Reported Hours:</b> " + data.task.reported_hours+ "<br><br>"
                        );				
                }
            //                for (var propertyName in data) {
            //                    $("#display-event-form").append("<b>" + propertyName + ":</b> " + data[propertyName] + "<br>");
            //                }			
            }		
        },
        close: function() {
            // clear agenda data
            $("#display-event-form").html("");
        }
    });	 

    /**
	 * Initialize our tabs
	 */
    $("#tabs").tabs({
        
        /*
		 * Our calendar is initialized in a closed tab so we need to resize it when the example tab opens.
		 */
        //        		show: function(event, ui){
        //        			if(ui.index == 1){
        //        				jfcalplugin.doResize("#mycal");
        //        			}
        //        		}	
        });
    $( "#tabs" ).on( "tabsactivate", function( e,ui ) {
        
        //        if(ui.index == 1){
        //            jfcalplugin.doResize("#mycal");
        //        }
        location.hash = ui.newTab.find( "[href]" ).get( 0 ).hash;
        location.href = location.hash;
        //refresh the calendar forcefully
        if(location.hash=="#calendar"){
            window.scrollTo(0, 0);
            location.reload();
        }
        
        //dont show settings on any page but tasklist
        
        if(location.hash=="#tasklist"){ 
            $(".settings_top_container").removeClass("invisible");
        }
        else $(".settings_top_container").addClass("invisible");
    });
    
    //resizsing the calendar
    if(location.hash=="#calendar" ){ 
        jfcalplugin.doResize("#mycal");
    }

    //everytime a page is loaded - check for the settings container
    if(location.hash=="#tasklist" || location.hash==""){ 
        $(".settings_top_container").removeClass("invisible");
    }
    else $(".settings_top_container").addClass("invisible");
	
});


