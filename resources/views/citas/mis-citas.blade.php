<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Mis Citas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 lg:p-8">
                @if($citas->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400 text-center">No tienes citas programadas.</p>
                @else
                    <table class="min-w-full bg-white dark:bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                        <thead class="bg-gray-200 dark:bg-gray-700">
                            <tr>
                                <th class="py-3 px-6 text-xs font-bold uppercase text-gray-700 dark:text-gray-300">Paciente</th>
                                <th class="py-3 px-6 text-xs font-bold uppercase text-gray-700 dark:text-gray-300">Fecha y Hora</th>
                                <th class="py-3 px-6 text-xs font-bold uppercase text-gray-700 dark:text-gray-300">Estado</th>
                                <th class="py-3 px-6 text-xs font-bold uppercase text-gray-700 dark:text-gray-300">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($citas as $cita)
                            <tr>
                                <td class="py-4 px-6 text-center text-gray-800 dark:text-gray-200">{{ $cita->user->name }}</td>
                                <td class="py-4 px-6 text-center text-gray-800 dark:text-gray-200">{{ $cita->appointment_date }}</td>
                                <td class="py-4 px-6 text-center text-gray-800 dark:text-gray-200">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $cita->status == 'finalizado' ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-200 dark:text-yellow-900' }}">
                                        {{ $cita->status == 'finalizado' ? 'Finalizado' : 'Pendiente' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300" onclick="confirmConsultar('{{ $cita->id }}')">Consultar</button>

                                        @if($cita->status == 'finalizado')
                                            <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300" onclick="verDetalles('{{ $cita->id }}')">Detalles</button>
                                            <button type="button" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300" onclick="confirmDelete('{{ $cita->id }}')">Eliminar</button>
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
            window.location.href = '/consulta/realizar/' + id;
        }, function(){
            alertify.error('Cancelado');
        });
    }

    function verDetalles(id) {
        alertify.alert("Detalles de la consulta", function(){
            window.location.href = '/consulta/' + id + '/ticket';
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
