"use strict"
function fullCalender() {
    var containerEl = document.getElementById('external-events');
    if ($('#external-events').length > 0) {
        new FullCalendar.Draggable(containerEl, {
            itemSelector: '.external-event',
            eventData: function(eventEl) {
                return {
                    title: eventEl.innerText.trim(),
                    className: $(eventEl).attr('data-class')
                }
            }
        });
    }

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        editable: true,
        droppable: true,
        nowIndicator: true,
        weekNumbers: true,
        navLinks: true,
        selectMirror: true,
        initialDate: '2025-03-28',

		drop: function(info) {
            // Get data-class from dragged element
            const className = info.draggedEl.getAttribute('data-class');
            const title = info.draggedEl.innerText.trim();

            // Store className temporarily on DOM modal
            $('#event-modal').data('title', title);
            $('#event-modal').data('start', info.date);
            $('#event-modal').data('end', null);
            $('#event-modal').data('allDay', info.allDay);
            $('#event-modal').data('className', className);

            $('#event-modal').modal('show');

            // Optional: remove if checkbox is checked
            if ($('#drop-remove').is(':checked')) {
                info.draggedEl.parentNode.removeChild(info.draggedEl);
            }
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: '/events',
                type: 'GET',
                success: function(response) {
                    console.log('Events fetched:', response);
                    successCallback(response);
                },
                error: function() {
                    failureCallback();
                }
            });
        },

        select: function(arg) {
            $('#event-modal').modal('show');
            $('#event-modal').data('start', arg.start);
            $('#event-modal').data('end', arg.end);
            $('#event-modal').data('allDay', arg.allDay);
        },

        eventClick: function(info) {
            window.selectedEvent = info.event;
			$('#event-modal').data('start', info.event.start);
            $('#event-modal').data('end', info.event.end);
            $('#event-modal').data('allDay', info.event.allDay);
            $('#event-modal').data('className', info.event.classNames[0] ?? null);
            $('#event-modal').modal('show');
        }
    });

    calendar.render();

    // Save event from modal
	$('.save-event').on('click', function () {
        let title = $('#event-modal').data('title');
		if (!title) return;

        let start = $('#event-modal').data('start');
        let end = $('#event-modal').data('end');
        let allDay = $('#event-modal').data('allDay');
        let className = $('#event-modal').data('className');

        let formattedStart = start.toISOString().slice(0, 19).replace('T', ' ');
        let formattedEnd = end ? end.toISOString().slice(0, 19).replace('T', ' ') : null;

        let newEvent = calendar.addEvent({
            title: title,
            start: formattedStart,
            end: formattedEnd,
            allDay: allDay,
            className: className
        });

        saveEvent(newEvent);
        $('#event-modal').modal('hide');
    });

    // Delete event from modal
  // Delete event from modal
$('.delete-event').on('click', function () {
    if (window.selectedEvent) {
        $.ajax({
            url: `/events/${window.selectedEvent.id}`,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                window.selectedEvent.remove();
                $('#event-modal').modal('hide');
                calendar.refetchEvents();  // Refresh events after deletion
            },
            error: function () {
                alert('Failed to delete the event.');
            }
        });
    }
});


    // Save event to backend
    function saveEvent(event) {
        $.ajax({
            url: '/events',
            type: 'POST',
            data: {
                title: event.title,
                start: event.start.toISOString(),
                end: event.end ? event.end.toISOString() : null,
                class_name: event.classNames[0] ?? null,
                type: 'call', // tag as call if needed
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Event saved:', response);
                calendar.refetchEvents();  // Fetch updated events after saving
            }
        });
    }

    // Handle Save Category Button Click
    $('.save-category').on('click', function () {
        var categoryName = $('input[name="category-name"]').val().trim();
        var categoryColor = $('select[name="category-color"]').val();

        if (categoryName !== "" && categoryColor !== "") {
            var newEvent = $('<div class="external-event btn-' + categoryColor + ' light" data-class="bg-' + categoryColor + '"><i class="fa fa-move"></i> ' + categoryName + '</div>');

            $('#external-events').append(newEvent);

            // Re-initialize draggable for new category
            new FullCalendar.Draggable(document.getElementById('external-events'), {
                itemSelector: '.external-event',
                eventData: function (eventEl) {
                    return {
                        title: eventEl.innerText.trim(),
                        className: $(eventEl).attr('data-class')
                    }
                }
            });

            // Close modal and clear form
            $('#add-category').modal('hide');
            $('input[name="category-name"]').val('');
            $('select[name="category-color"]').val('');
        }
    });
}

function loadCategories() {
    $.ajax({
        url: '/categories',
        type: 'GET',
        success: function (categories) {
            $('#external-events').empty().append('<p>Drag and drop your event or click in the calendar</p>');

            categories.forEach(cat => {
                let category = $(`<div class="external-event btn-${cat.color} light" data-class="bg-${cat.color}"><i class="fa fa-move"></i> ${cat.name}</div>`);

                $('#external-events').append(category);
            });

            // Re-initialize Draggable
            new FullCalendar.Draggable(document.getElementById('external-events'), {
                itemSelector: '.external-event',
                eventData: function (eventEl) {
                    return {
                        title: eventEl.innerText.trim(),
                        className: $(eventEl).attr('data-class')
                    };
                }
            });
        }
    });
}

// Initialize calendar on window load
jQuery(window).on('load', function () {
    setTimeout(function () {
        fullCalender();
        loadCategories();
    }, 1000);
});