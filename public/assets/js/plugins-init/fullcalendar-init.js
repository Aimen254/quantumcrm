"use strict";

function fullCalender() {
    // Initialize draggable events
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

    // Initialize calendar
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
        navLinks: true,
        initialView: 'dayGridMonth',
        timeZone: 'local',
        
        // Handle date selection
        select: function(info) {
            showEventModal({
                start: info.start,
                end: info.end,
                allDay: info.allDay
            });
        },
        
        // Handle event click
        eventClick: function(info) {
            window.selectedEvent = info.event;
            showEventModal({
                event: info.event
            });
        },
        
        // Handle drop from external events
        drop: function(info) {
            const className = info.draggedEl.getAttribute('data-class');
            const title = info.draggedEl.innerText.trim();
            
            showEventModal({
                title: title,
                start: info.date,
                className: className
            });
        },
        
        // Fetch events
        events: function(fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: '/events',
                type: 'GET',
                success: function(response) {
                    successCallback(response);
                },
                error: function() {
                    failureCallback();
                }
            });
        }
    });

    calendar.render();

    // Show event modal with data
    function showEventModal(data) {
        const modal = $('#event-modal');
        const form = modal.find('#event-form');
        
        // Reset form
        form[0].reset();
        modal.find('.delete-event').hide();
        
        // Set values based on data
        if (data.event) {
            // Editing existing event
            modal.find('.modal-title').text('Edit Event');
            modal.find('.delete-event').show();
            
            form.find('#event-title').val(data.event.title);
            form.find('#event-color').val(data.event.classNames[0] || 'bg-primary');
            
            // Convert dates to local datetime-local format
            const start = data.event.start ? new Date(data.event.start) : null;
            const end = data.event.end ? new Date(data.event.end) : null;
            
            form.find('#event-start').val(start ? start.toISOString().slice(0, 16) : '');
            form.find('#event-end').val(end ? end.toISOString().slice(0, 16) : '');
        } else {
            // Creating new event
            modal.find('.modal-title').text('Add New Event');
            
            if (data.title) form.find('#event-title').val(data.title);
            if (data.className) form.find('#event-color').val(data.className);
            
            // Set default dates
            const start = data.start ? new Date(data.start) : new Date();
            const end = data.end ? new Date(data.end) : null;
            
            form.find('#event-start').val(start.toISOString().slice(0, 16));
            if (end) form.find('#event-end').val(end.toISOString().slice(0, 16));
        }
        
        modal.modal('show');
    }

    // Handle create event button click
    $('#create-event-btn').on('click', function() {
        showEventModal({
            start: new Date(),
            end: null
        });
    });

    // Handle save event
    $('.save-event').on('click', function() {
        const form = $('#event-form');
        if (!form[0].checkValidity()) {
            form[0].reportValidity();
            return;
        }
        
        const formData = {
            title: $('#event-title').val(),
            start: $('#event-start').val(),
            end: $('#event-end').val() || null,
            class_name: $('#event-color').val()
        };
        
        if (window.selectedEvent) {
            // Update existing event
            $.ajax({
                url: `/events/${window.selectedEvent.id}`,
                type: 'PUT',
                data: {
                    ...formData,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    window.selectedEvent.setProp('title', formData.title);
                    window.selectedEvent.setDates(formData.start, formData.end);
                    window.selectedEvent.setProp('classNames', [formData.class_name]);
                    $('#event-modal').modal('hide');
                    calendar.refetchEvents();
                },
                error: function() {
                    alert('Failed to update event.');
                }
            });
        } else {
            // Create new event
            $.ajax({
                url: '/events',
                type: 'POST',
                data: {
                    ...formData,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    calendar.refetchEvents();
                    $('#event-modal').modal('hide');
                },
                error: function() {
                    alert('Failed to create event.');
                }
            });
        }
    });

    // Handle delete event
    $('.delete-event').on('click', function() {
        if (window.selectedEvent && confirm('Are you sure you want to delete this event?')) {
            $.ajax({
                url: `/events/${window.selectedEvent.id}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    window.selectedEvent.remove();
                    $('#event-modal').modal('hide');
                    calendar.refetchEvents();
                },
                error: function() {
                    alert('Failed to delete event.');
                }
            });
        }
    });

    // Load categories (keep your existing function)
    loadCategories();
}

// Load categories function (keep your existing one)
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

// Initialize on window load
jQuery(window).on('load', function() {
    setTimeout(function() {
        fullCalender();
        loadCategories();
    }, 1000);
});