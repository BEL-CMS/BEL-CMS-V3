(function ($) {
    'use strict';
	var quick_events = [];
	var today = new Date();
	var today_date_g 	= today.getDate();
	var today_month_g 	= today.getMonth() + 1;
	var today_year_g 	= today.getFullYear();
	var date_start;
	var order_num = 0;
	var word_day;
	var word_month;
	
	function shortTitle(text, num) {
		if(text) {
			var text_array = text.split(' ');
			if (text_array.length > num) {
				return text_array.slice(0, num).join(' ') + ' ...';
			}
			return text;
		}
		return '';
	}

	function sortEventsByDate(a,b) {
		if (a.date < b.date) {
			return -1;
		} else if (a.date > b.date) {
			return 1;
		} else {
			return 0;
		}
	}

	function sortEventsByUpcoming(a,b) {
		var today_date = new Date(today_year_g, today_month_g - 1, today_date_g);
		if (Math.abs(a.date - today_date.getTime()) < Math.abs(b.date - today_date.getTime())) {
			return -1;
		} else if (Math.abs(a.date - today_date.getTime()) > Math.abs(b.date - today_date.getTime())) {
			return 1;
		} else {
			return 0;
		}
	}

	function getDayEventsByTime(type) {
		var events = [];
		var today_date = new Date(today_year_g, today_month_g - 1, today_date_g);
		for (var i = 0; i < quick_events.length; i++) {
			if (type == 'upcoming') {
				if (quick_events[i].date >= today_date.getTime()) {
					events.push(quick_events[i]);
				}
			} else {
				if (quick_events[i].date < today_date.getTime()) {
					events.push(quick_events[i]);
				}
			}
		}
		return events;
	}

	function dayHasEvent(day, month, year) {
		var num_events = 0;
		var date_check = new Date(year, Number(month) - 1, day);
		for (var i = 0; i < quick_events.length; i++) { 
			var start_date = new Date(quick_events[i].year, Number(quick_events[i].month) - 1, quick_events[i].day); 
			var end_date = new Date(quick_events[i].year, Number(quick_events[i].month) - 1, Number(quick_events[i].day) + Number(quick_events[i].duration) - 1);
			if ((start_date.getTime() <= date_check.getTime()) && (date_check.getTime() <= end_date.getTime())) {
				num_events++;
			}
		}
		
		if (num_events == 0) {
			return false;
		} else {
			return true;
		}
	}

	function getEventOrderNumber(id, day, month, year) {
		var date_check = new Date(year, Number(month) - 1, day);
		var events = [];
		for (var i = 0; i < quick_events.length; i++) {
			var start_date = new Date(quick_events[i].year, Number(quick_events[i].month) - 1, quick_events[i].day);
			var end_date = new Date(quick_events[i].year, Number(quick_events[i].month) - 1, Number(quick_events[i].day) + Number(quick_events[i].duration) - 1);
			if ((start_date.getTime() <= date_check.getTime()) && (date_check.getTime() <= end_date.getTime())) {
				var first_day = (start_date.getTime() == date_check.getTime()) ? true : false;
				var event = {id:quick_events[i].id, title:quick_events[i].title, day:quick_events[i].day, month:quick_events[i].month, year:quick_events[i].year, first_day:first_day};
				events.push(event);
			}
		}
		
		if (events.length) {
			if (events[0].id == id) {
				var num = order_num;
				order_num = 0;
				return num;	
			} else { 
				order_num++;
				for (var j = 0; j < events.length; j++) {
					if (events[j].id == id) {
						return getEventOrderNumber(events[j-1].id, events[j-1].day, events[j-1].month, events[j-1].year);
					}
				}
				
			}
		}
		
		return 0;
	}

	function getDayEvents(day, month, year) {
		var n = 0;
		var date_check = new Date(year, Number(month) - 1, day);
		var events = [];
		for (var i = 0; i < quick_events.length; i++) {
			var start_date = new Date(quick_events[i].year, Number(quick_events[i].month) - 1, quick_events[i].day);
			var end_date = new Date(quick_events[i].year, Number(quick_events[i].month) - 1, Number(quick_events[i].day) + Number(quick_events[i].duration) - 1);
			if ((start_date.getTime() <= date_check.getTime()) && (date_check.getTime() <= end_date.getTime())) {
				var first_day = (start_date.getTime() == date_check.getTime()) ? true : false;
				var last_day = (end_date.getTime() == date_check.getTime()) ? true : false;
				var event = {id:quick_events[i].id, title:quick_events[i].title, image:quick_events[i].image, day:quick_events[i].day, month:quick_events[i].month, year:quick_events[i].year, time:quick_events[i].time, duration:quick_events[i].duration, color:quick_events[i].color, location:quick_events[i].location, description:quick_events[i].description, first_day:first_day, last_day:last_day};
				
				if (!first_day) {
					n = getEventOrderNumber(quick_events[i].id, quick_events[i].day, quick_events[i].month, quick_events[i].year);
				}
				
				events[n] = event;
				n++;
			}
		}
		
		return events;
	}

	function showEventsCalendar(el, month_num, year_num, nav_time) {
		var layout = (typeof el.attr('data-layout') != 'undefined') ? el.attr('data-layout') : 'full';

		layout = (screen.width < 768) ? 'compact' : layout;

		if (nav_time == 'prev-year') {
			year_num--;
		} else if (nav_time == 'next-year') {
			year_num++;
		} else if (nav_time == 'prev-month') {
			month_num--;
		} else if (nav_time == 'next-month') {
			month_num++;
		} else if (nav_time == 'current') {
			month_num = today_month_g;
			year_num = today_year_g;
		}

		if (month_num == 0) {
			month_num = 12;
			year_num--;
		} else if (month_num == 13) {
			month_num = 1;
			year_num++;
		}
		
		var first_date_g = new Date(year_num, month_num - 1, 1);
		if (date_start == 'sunday') {
			var first_day_g = first_date_g.getDay() + 1;
		} else {
			var first_day_g = (first_date_g.getDay() == 0) ? 7 : first_date_g.getDay();
		}
		
		var last_date_g = new Date(year_num, month_num, 0);
		var num_days = last_date_g.getDate();
		
		var calendar_string = '';
		var day_counter = 0;
		
		calendar_string += 	'<div class="events-calendar ' + layout + '">';
		calendar_string += 		'<div class="calendar-header">';
		
		if (layout == 'full') {
			calendar_string += 		'<h4 class="current-date">' + word_month[month_num - 1] + ' <span>' + year_num + '</span></h4>';
			calendar_string +=		'<div class="nav-time">';
			calendar_string += 			'<span id="prev-year" class="btn-change-date">«</span>';
			calendar_string += 			'<span id="prev-month" class="btn-change-date">‹</span>';
			calendar_string += 			'<span id="current" class="btn-change-date">aujourd\'hui</span>';
			calendar_string += 			'<span id="next-month" class="btn-change-date">›</span>';
			calendar_string += 			'<span id="next-year" class="btn-change-date">»</span>';
			calendar_string +=		'</div>';
		} else {
			calendar_string +=		'<div class="nav-time left">';
			calendar_string += 			'<span id="prev-year" class="btn-change-date">«</span>';
			calendar_string += 			'<span id="prev-month" class="btn-change-date">‹</span>';
			calendar_string +=		'</div>';
			calendar_string += 		'<h4 class="current-date">' + word_month[month_num - 1] + ' <span>' + year_num + '</span></h4>';
			calendar_string +=		'<div class="nav-time right">';
			calendar_string += 			'<span id="next-month" class="btn-change-date">›</span>';
			calendar_string += 			'<span id="next-year" class="btn-change-date">»</span>';
			calendar_string +=		'</div>';
		}
		
		calendar_string += 		'</div>';

		calendar_string += 		'<table class="calendar-table">';
		calendar_string += 			'<tbody>';
				
		calendar_string += 				'<tr>';
		for (var m = 0; m < word_day.length; m++) {
			calendar_string += 				'<th>' + word_day[m].substring(0, 3) + '</th>';
		}
		calendar_string += 				'</tr>';

		var this_date = 1;
		
		for (var i = 1; i <= 6; i++) {
			var k = (i - 1) * 7 + 1;
			if (k < (first_day_g + num_days)) {
				calendar_string += 		'<tr>';
				for (var x = 1; x <= 7; x++) {
					day_counter = (this_date - first_day_g) + 1;
					this_date++;
					if ((day_counter > num_days) || (day_counter < 1)) {
						calendar_string += 	'<td class="calendar-day blank"></td>';
					} else {			
						// Weekend
						var weekend_class = '';
						if (date_start == 'sunday') {
							if ((x == 1) || (x == 7)) {
								weekend_class = ' weekend';
							}
						} else {
							if ((x == 6) || (x == 7)) {
								weekend_class = ' weekend';
							}
						}

						var today_class = '';
						if ((today_date_g == day_counter) && (today_month_g == month_num) && (today_year_g == year_num)) {
							today_class = ' today';
						}

						var has_events_class = '';
						if (dayHasEvent(day_counter, month_num, year_num)) { 
							has_events_class = ' has-events';
						}

						calendar_string += 	'<td class="calendar-day' + weekend_class + today_class + has_events_class + '">';
						calendar_string += 		'<span class="day-num">' + day_counter + '</span>';
						
						if (dayHasEvent(day_counter, month_num, year_num)) { 
							// Get events of day
							if (layout == 'full') { // Full layout
								var events = getDayEvents(day_counter, month_num, year_num); 
								for (var t = 0; t < events.length; t++) {
									if (typeof events[t] != "undefined") {
										var color = events[t].color ? events[t].color : 1;
										var event_class = '';
										if (events[t].first_day && !events[t].last_day) {
											event_class = 'first-day';
										} else if (events[t].last_day && !events[t].first_day) {
											event_class = 'last-day';
										} else if (!events[t].first_day && !events[t].last_day) {
											event_class = 'middle-day';
										}
																				
										calendar_string += '<div class="event-title ' + event_class + ' color-' + color + '" href="#' + el.attr('id') + '-popup-' + events[t].id + '"><span>' + shortTitle(events[t].title, 2) + '</span></div>';
										
										// ==== Event detail popup ====
										calendar_string += 	'<div id="' + el.attr('id') + '-popup-' + events[t].id + '" class="event-popup zoom-anim-dialog mfp-hide">'
																+ '<div class="popup-body">'
										 							+ showEventDetail(events[t])
										 						+ '</div>'
										 					+ '</div>';
									} else {
										var event_deputize;
										if (typeof events[t+1] != "undefined") {
											if (typeof quick_events[events[t+1].id - 1] != "undefined") { 
												event_deputize = shortTitle(quick_events[events[t+1].id - 1].title, 2);
											} else {
												event_deputize = 'hidden';
											}
										} else {
											event_deputize = 'hidden';
										}
										calendar_string += '<div class="event-title hidden-title">' + event_deputize + '</div>';
									}
								}
							} else {
								var events = getDayEvents(day_counter, month_num, year_num); 
								for (var t = 0; t < events.length; t++) {
									if (typeof events[t] != "undefined") {
										var color = events[t].color ? events[t].color : 1;
										
										calendar_string += '<div class="event-mark color-' + color + '" href="#' + el.attr('id') + '-popup-' + events[t].id + '"></div>';					
										
										// ==== Event detail popup ====
										calendar_string += 	'<div id="' + el.attr('id') + '-popup-' + events[t].id + '" class="event-popup zoom-anim-dialog mfp-hide">'
																+ '<div class="popup-body">'
										 							+ showEventDetail(events[t])
										 						+ '</div>'
										 					+ '</div>';
									}
								}
							}
						}
						
						calendar_string += 	'</td>';
					}
				}
				calendar_string += 		'</tr>';
			}
		}
		calendar_string += 			'</tbody>';
		calendar_string += 		'</table>';
		calendar_string += 		'<div id="month-num" style="display:none">' + month_num + '</div>';
		calendar_string += 		'<div id="year-num" style="display:none">' + year_num + '</div>';
		calendar_string += 	'</div>';
		
		// Create calendar
		el.html(calendar_string);

		// Popup
		el.find('.event-title').magnificPopup({
			type: 'inline',
			removalDelay: 800,
			mainClass: 'my-mfp-zoom-in'
		});
		el.find('.event-mark').magnificPopup({
			type: 'inline',
			removalDelay: 800,
			mainClass: 'my-mfp-zoom-in'
		});
	}

	// Show events list
	function showEventsList(el, view, layout, max_events) {
		// Sort event via upcoming
		var upcoming_events = getDayEventsByTime('upcoming');
		upcoming_events.sort(sortEventsByUpcoming);
		var past_events = getDayEventsByTime('past');
		past_events.sort(sortEventsByUpcoming);
		var quick_list_events = upcoming_events.concat(past_events);
		quick_list_events = quick_list_events.slice(0, max_events);
		
		// Create events list
		var events_list = '';

		events_list += 	'<div class="events-list ' + layout + ' ' + view + '">';
		
		for (var i = 0; i < quick_list_events.length; i++) {
			// Start date
			var day = new Date(quick_list_events[i].year, Number(quick_list_events[i].month) - 1, quick_list_events[i].day);
			if (date_start == 'monday') {
				var event_day = word_day[day.getDay()];
			} else {
				if (day.getDay() > 0) {
					var event_day = word_day[day.getDay() - 1];
				} else {
					var event_day = word_day[6];
				}
			}
			var event_date = quick_list_events[i].day + ' ' + word_month[Number(quick_list_events[i].month) - 1] + ', ' + quick_list_events[i].year;
			
			// End date
			var event_end_time = '';
			if (quick_list_events[i].duration > 1) {
				var end_date = new Date(quick_list_events[i].year, Number(quick_list_events[i].month) - 1, Number(quick_list_events[i].day) + Number(quick_list_events[i].duration) - 1);
				
				if (date_start == 'monday') {
					var event_end_day = word_day[end_date.getDay()];
				} else {
					if (end_date.getDay() > 0) {
						var event_end_day = word_day[end_date.getDay() - 1];
					} else {
						var event_end_day = word_day[6];
					}
				}
				var event_end_date = ('0' + end_date.getDate()).slice(-2) + ' ' + word_month[Number(end_date.getMonth())] + ', ' + end_date.getFullYear();
				event_end_time = ' - ' + event_end_day + ', ' + event_end_date;
			}

			var event_image 		= (quick_list_events[i].image) ? '<img src="admin/event/images/' + quick_list_events[i].image + '" alt="' + quick_list_events[i].title + '" />' : '';
			var event_time 			= (quick_list_events[i].time) ? '<i class="icon-clock"></i>' + quick_list_events[i].time : '';
			var event_location 		= (quick_list_events[i].location) ? '<i class="icon-location-pin"></i>' + quick_list_events[i].location : '';
			var event_description 	= ((layout == 'compact') || (view == 'grid')) ? shortTitle(quick_list_events[i].description, 10) : shortTitle(quick_list_events[i].description, 25);
			
			events_list +=	'<div class="event-item-wrap">'	
								+ '<div class="event-item">'
									+ '<div class="event-image" href="#' + el.attr('id') + '-popup-' + quick_list_events[i].id + '">' + event_image + '</div>'
									+ '<div class="event-info">'
										+ '<div class="event-title" href="#' + el.attr('id') + '-popup-' + quick_list_events[i].id + '">' + quick_list_events[i].title + '</div>'
										+ '<div class="event-meta">'
											+ '<div class="event-date"><i class="icon-calendar"></i>' + event_day + ', ' + event_date + '</div>'
											+ '<div class="event-time">' + event_time + '</div>'
											+ '<div class="event-location">' + event_location + '</div>'
										+ '</div>'
										+ '<div class="event-intro">' + event_description + '</div>'
									+ '</div>'
								+ '</div>'
							+ '</div>';

			events_list += 	'<div id="' + el.attr('id') + '-popup-' + quick_list_events[i].id + '" class="event-popup zoom-anim-dialog mfp-hide">'
								+ '<div class="popup-body">'
		 							+ showEventDetail(quick_list_events[i])
		 						+ '</div>'
		 					+ '</div>';
		}

		events_list += '</div>';

		// Create list
		el.html(events_list);

		// Popup
		el.find('.event-image').magnificPopup({
			type: 'inline',
			removalDelay: 800,
			mainClass: 'my-mfp-zoom-in'
		});
		el.find('.event-title').magnificPopup({
			type: 'inline',
			removalDelay: 800,
			mainClass: 'my-mfp-zoom-in'
		});
	}

	// Show event detail
	function showEventDetail(event) {
		var event_string = '';

		// Start date
		var day = new Date(event.year, Number(event.month) - 1, event.day);
		if (date_start == 'monday') {
			var event_day = word_day[day.getDay()];
		} else {
			if (day.getDay() > 0) {
				var event_day = word_day[day.getDay() - 1];
			} else {
				var event_day = word_day[6];
			}
		}
		var event_date = event.day + ' ' + word_month[Number(event.month) - 1] + ', ' + event.year;
		
		// End date
		var event_end_time = '';
		if (event.duration > 1) {
			var end_date = new Date(event.year, Number(event.month) - 1, Number(event.day) + Number(event.duration) - 1);
			
			if (date_start == 'monday') {
				var event_end_day = word_day[end_date.getDay()];
			} else {
				if (end_date.getDay() > 0) {
					var event_end_day = word_day[end_date.getDay() - 1];
				} else {
					var event_end_day = word_day[6];
				}
			}
			var event_end_date = ('0' + end_date.getDate()).slice(-2) + ' ' + word_month[Number(end_date.getMonth())] + ', ' + end_date.getFullYear();
			event_end_time = ' - ' + event_end_day + ', ' + event_end_date;
		}
		var event_image 		= (event.image) ? '<img src="admin/event/images/' + event.image + '" alt="' + event.title + '" />' : '';
		var event_time 			= (event.time) ? '<i class="icon-clock"></i>' + event.time : '';
		var event_location 		= (event.location) ? '<i class="icon-location-pin"></i>' + event.location : '';

		event_string += '<div class="event-item">'
							+ '<div class="event-image">' + event_image + '</div>'
							+ '<div class="event-info">'
								+ '<div class="event-title">' + event.title + '</div>'
								+ '<div class="event-meta">'
									+ '<div class="event-date"><i class="icon-calendar"></i>' + event_day + ', ' + event_date + event_end_time + '</div>'
									+ '<div class="event-time">' + event_time + '</div>'
									+ '<div class="event-location">' + event_location + '</div>'
								+ '</div>'
								+ '<div class="event-intro">' + event.description + '</div>'
							+ '</div>'
						+ '</div>';
		return event_string;
	}

	$(document).ready(function(){
		$('.quick-events').each(function(index) {
			// Set id for timetable
			$(this).attr('id', 'quick-events-' + (index + 1));

			var events_calendar_contain = $(this);

			// Get variables
			var source 	= (typeof $(this).attr('data-source') != 'undefined') ? $(this).attr('data-source') : 'json';
			var view 	= (typeof $(this).attr('data-view') != 'undefined') ? $(this).attr('data-view') : 'calendar';
			var layout 	= (typeof $(this).attr('data-layout') != 'undefined') ? $(this).attr('data-layout') : 'full';
			var items 	= (typeof $(this).attr('data-items') != 'undefined') ? $(this).attr('data-items') : '1000';
			
			date_start 	= (typeof $(this).attr('data-start') != 'undefined') ? $(this).attr('data-start') : 'monday';
			if (date_start == 'monday') { // Start with sunday
				word_day = new Array(word_day_sun, word_day_mon, word_day_tue, word_day_wed, word_day_thu, word_day_fri, word_day_sat);
			} else { // Start with monday
				word_day = new Array(word_day_mon, word_day_tue, word_day_wed, word_day_thu, word_day_fri, word_day_sat, word_day_sun);
			}
			word_month = new Array(word_month_1, word_month_2, word_month_3, word_month_4, word_month_5, word_month_6, word_month_7, word_month_8, word_month_9, word_month_10, word_month_11, word_month_12);

			$.ajax({
				url: '/calendar/get?ajax',
				dataType: 'json',
				data: '',
				success: function(data) {
					quick_events = [];
					for (var i = 0; i < data.length; i++) {
						var event_date = new Date(data[i].year, Number(data[i].month) - 1, data[i].day);
						data[i].date = event_date.getTime();
						quick_events.push(data[i]);
					}

					// Sort events by date
					quick_events.sort(sortEventsByDate);
					
					for (var j = 0; j < quick_events.length; j++) {
						quick_events[j].id = j;
						if (!quick_events[j].duration) {
							quick_events[j].duration = 1;
						}
					}
					
					if ((view == 'list') || (view == 'grid')) {
						showEventsList(events_calendar_contain, view, layout, items);
					} else {
						showEventsCalendar(events_calendar_contain, today_month_g, today_year_g, 'current');
					}
				}
			});
		});

		$('.quick-events').on('click', '.btn-change-date', function() {
			var events_calendar_contain = $(this).closest('.quick-events');
			var month_num = events_calendar_contain.find('#month-num').text();
			var year_num = events_calendar_contain.find('#year-num').text();
			var nav_time = $(this).attr('id');
            showEventsCalendar(events_calendar_contain, month_num, year_num, nav_time);
        });
	});
})(jQuery);