<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Citas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                @if($citas->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No tienes citas programadas.</p>
                @else
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Paciente</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Fecha y Hora</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Estado</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($citas as $cita)
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $cita->user->name }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $cita->appointment_date }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">
                                    {{ $cita->status == 'finalizado' ? 'Finalizado' : 'Pendiente' }}
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="confirmConsultar('{{ $cita->id }}')">Consultar</button>

                                        @if($cita->status == 'finalizado')
                                            <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="verDetalles('{{ $cita->id }}')">Detalles</button>
                                            <button type="button" class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" onclick="confirmDelete('{{ $cita->id }}')">Eliminar</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Incluir Alertify.js -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script>
    function confirmConsultar(id) {
        alertify.confirm("¿Confirmar consulta?", function(){
            window.location.href = '/consulta/' + id;
        }, function(){
            alertify.error('Cancelado');
        });
    }

    function verDetalles(id) {
        alertify.alert("Detalles de la consulta", "Aquí puedes mostrar los detalles de la consulta.").set('onok', function(){
            window.location.href = '/consulta/' + id; // Esto redirige a la vista de consulta donde se pueden ver los detalles
        });
    }

    function confirmDelete(id) {
        alertify.confirm("¿Confirmar eliminación de la consulta?", function(){
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/citas/' + id;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
            alertify.success('Consulta eliminada');
        }, function(){
            alertify.error('Cancelado');
        });
    }
</script>
