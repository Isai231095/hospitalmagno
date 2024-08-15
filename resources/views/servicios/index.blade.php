<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Servicios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('servicios.create') }}" class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Agregar</a>
                </div>

                <table class="min-w-full bg-white dark:bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th class="py-3 px-6 text-xs font-bold uppercase text-gray-700 dark:text-gray-300">ID</th>
                            <th class="py-3 px-6 text-xs font-bold uppercase text-gray-700 dark:text-gray-300">Nombre</th>
                            <th class="py-3 px-6 text-xs font-bold uppercase text-gray-700 dark:text-gray-300">Precio</th>
                            <th class="py-3 px-6 text-xs font-bold uppercase text-gray-700 dark:text-gray-300">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($servicio as $servicio)
                        <tr>
                            <td class="py-4 px-6 text-center text-gray-800 dark:text-gray-200">{{ $servicio->id }}</td>
                            <td class="py-4 px-6 text-center text-gray-800 dark:text-gray-200">{{ $servicio->name }}</td>
                            <td class="py-4 px-6 text-center text-gray-800 dark:text-gray-200">${{ number_format($servicio->price, 2) }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('servicios.edit', $servicio->id) }}" class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-2 px-4 rounded-lg transition duration-300">Editar</a>
                                    <button type="button" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300" onclick="confirmDelete('{{ $servicio->id }}')">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Incluir Alertify.js -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script>
    function confirmDelete(id) {
        alertify.confirm("¿Confirmar eliminación del servicio?", function(){
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/servicios/' + id;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
            alertify.success('Servicio eliminado');
        }, function(){
            alertify.error('Cancelado');
        });
    }
</script>
