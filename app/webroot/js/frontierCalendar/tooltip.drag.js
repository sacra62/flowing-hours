
/**
 * Do something when dragging starts on agenda div
 */
function myAgendaDragStart(eventObj,divElm,agendaItem){
	// destroy our qtip tooltip
	if(divElm.data("qtip")){
		divElm.qtip("destroy");
	}	
};

/**
 * Do something when dragging stops on agenda div
 */
function myAgendaDragStop(eventObj,divElm,agendaItem){
	alert("drag stop");
};

/**
 * Custom tooltip - use any tooltip library you want to display the agenda data.
 *
 * For this example we use qTip - http://craigsworks.com/projects/qtip/
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
	
	var title = agendaItem.title;
	var startDate = agendaItem.startDate;
	var endDate = agendaItem.endDate;
	var allDay = agendaItem.allDay;
	var data = agendaItem.data;
	displayData += "<br><b>" + title+ "</b><br><br>";
	if(allDay){
		displayData += "(All day event)<br><br>";
	}else{
		displayData += "<b>Starts:</b> " + startDate + "<br>" + "<b>Ends:</b> " + endDate + "<br><br>";
	}
	for (var propertyName in data) {
		displayData += "<b>" + propertyName + ":</b> " + data[propertyName] + "<br>"
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
		style: {
			border: {
				width: 5,
				radius: 10
			},
			padding: 10, 
			textAlign: "left",
			tip: true,
			name: "dark"
		}
	});

};
