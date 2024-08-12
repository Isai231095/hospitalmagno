import './bootstrap';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import esLocale from '@fullcalendar/core/locales/es';  // Importa el idioma español


document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        locale: esLocale,  // Configura el idioma a español
        events: '/api/citas',
        selectable: true,
        editable: true,
        timeFormat: 'h:mm a',  // Configura el formato de hora a 12 horas con AM/PM
        eventTimeFormat: { // similar to timeFormat, but for event labels
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        },
        eventClick: function(info) {
            alert('Cita de: ' + info.event.extendedProps.user +
                  '\nDoctor: ' + info.event.extendedProps.doctor +
                  '\nFecha: ' + info.event.start.toLocaleString('es-ES', {
                      hour: 'numeric',
                      minute: '2-digit',
                      hour12: true
                  }));
        }
    });

    calendar.render();  // Renderiza el calendario
});





