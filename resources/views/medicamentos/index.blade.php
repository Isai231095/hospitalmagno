<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Medicamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="mb-4 text-right">
                    <a href="{{ route('medicamentos.create') }}" class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">Agregar Medicamento</a>
                </div>

                @if($medicamentos->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No hay medicamentos registrados.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($medicamentos as $medicamento)
                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $medicamento->nombre }}</h3>
                                <p class="text-gray-600 dark:text-gray-300"><strong>Precio:</strong> ${{ $medicamento->precio }}</p>
                                <p class="text-gray-600 dark:text-gray-300"><strong>Stock:</strong> {{ $medicamento->stock }}</p>

                                <div class="mt-4 flex justify-between">
                                    <a href="{{ route('medicamentos.edit', $medicamento->id) }}" class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-2 px-4 rounded">Editar</a>

                                    <button type="button" class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" onclick="confirmDelete('{{ $medicamento->id }}')">Eliminar</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Alertify Script -->
    <script>
        function confirmDelete(id) {
            alertify.confirm("¿Confirmar eliminación?",
            function(){
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/medicamentos/' + id;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
                alertify.success('Eliminado exitosamente');
            },
            function(){
                alertify.error('Cancelado');
            });
        }
    </script>
</x-app-layout>
