let date = new Date, nextDay = new Date((new Date).getTime() + 864e5);
let nextMonth = 11 === date.getMonth() ? new Date(date.getFullYear() + 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() + 1, 1);
let prevMonth = 11 === date.getMonth() ? new Date(date.getFullYear() - 1, 0, 1) : new Date(date.getFullYear(), date.getMonth() - 1, 1);


window.events = [];
document.addEventListener("DOMContentLoaded", function (event) {
    fetch('fetch_events.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            window.events = data;
            window.D.removeAllEvents();
            window.D.addEventSource(window.events);
        })
        .catch(error => {
            alert('Error fetching events: ' + error.message);
        });
})

function addEvent(event) {
    const payload = extractPayload(event)
    fetch("add_event.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(payload),
    }).then(function (response) {
        return response.json();
    }).catch(error => {
        alert("Error adding event: " + error);
    })
}

function updateEvent(event) {
    const id = event.id
    const payload = extractPayload(event)
    fetch(`update_event.php?id=${id}`, {
        method: "PUT",
        query: "id=" + id,
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(payload),
    }).then(function (response) {
        let index = window.events.findIndex(ev => ev.id === id);
        window.events[index] = event;
        window.D.removeAllEvents();
        window.D.addEventSource(window.events);
        return response.json();
    }).catch(error => {
        alert("Error updating event: " + error);
    })
}

function deleteEvent(id) {
    fetch(`delete_event.php?id=${id}`, {
        method: "DELETE",
    }).then(response => {
        window.events = window.events.filter(event => event.id !== id);
        window.D.removeAllEvents();
        window.D.addEventSource(window.events);
        return response.json();
    })
        .catch(error => {
        alert("Error deleting event: " + error);
    })
}

function extractPayload(event){
    return {
        title: event.title,
        start: event.start,
        end: event.end,
        guests: event.extendedProps.guests,
        description: event.extendedProps.description,
        location: event.extendedProps.location,
        allDay: event.allDay,
        url: event.url,
        calendar: event.extendedProps.calendar
    }
}
