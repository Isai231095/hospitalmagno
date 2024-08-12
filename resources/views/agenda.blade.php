<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Agenda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div id="calendar"></div> <!-- Aquí se renderizará el calendario -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- El contenido del modal se llenará dinámicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir los scripts de FullCalendar y Bootstrap -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Incluye Bootstrap JS si no está ya incluido -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid', 'timeGrid', 'interaction'],
                initialView: 'dayGridMonth',
                events: '/api/citas',  // API que devuelve las citas en formato JSON
                selectable: true,
                editable: true,
                eventClick: function(info) {
                    // Configurar el título del modal con los detalles de la cita
                    document.getElementById('modalTitle').innerText = 'Cita de: ' + info.event.extendedProps.user;
                    document.getElementById('modalBody').innerHTML = `
                        <p><strong>Doctor:</strong> ${info.event.extendedProps.doctor}</p>
                        <p><strong>Fecha:</strong> ${info.event.start.toLocaleString()}</p>
                        <p><strong>Descripción:</strong> ${info.event.title}</p>
                    `;
                    $('#eventModal').modal('show');  // Mostrar el modal con Bootstrap
                }
            });

            calendar.render();  // Renderiza el calendario en la página
        });
    </script>
</x-app-layout>
