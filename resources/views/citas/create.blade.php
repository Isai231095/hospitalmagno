<x-app-layout>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Cita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <form method="POST" action="{{ route('citas.store') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="doctor_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botón para desplegar el calendario, centrado -->
                    <div class="mb-5 flex justify-center">
                        <button type="button" id="schedule_button" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">Agendar</button>
                    </div>

                    <!-- Campo de fecha y hora que inicialmente está oculto -->
                    <div class="mb-5" id="date_time_field" style="display:none;">
                        <label for="appointment_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha y Hora</label>
                        <input type="text" name="appointment_date" id="appointment_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>

                    <div class="mb-5">
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas</label>
                        <textarea name="notes" id="notes" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    </div>

                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
                    <a href="{{ route('citas.index') }}" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-800">Cancelar</a>
                </form>

            </div>
        </div>
    </div>

    <!-- Iniciar Flatpickr -->
    <script>
        document.getElementById('schedule_button').addEventListener('click', function() {
            // Mostrar el campo de fecha y hora
            document.getElementById('date_time_field').style.display = 'block';

            // Iniciar Flatpickr
            flatpickr("#appointment_date", {
                enableTime: true, // Habilita la selección de la hora además de la fecha
                dateFormat: "Y-m-d H:i", // Formato de la fecha y hora
                time_24hr: true, // Formato de 24 horas para la hora
                onClose: function(selectedDates, dateStr, instance) {
                    // Mostrar el valor seleccionado en el campo
                    document.getElementById('appointment_date').value = dateStr;
                }
            });

            // Abrir automáticamente el calendario después de mostrar el campo
            document.getElementById('appointment_date').flatpickr.open();
        });
    </script>
</x-app-layout>
