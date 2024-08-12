<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Citas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">

                <div class="mb-4 flex justify-end">
                    <a href="{{ route('citas.create') }}" class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Agregar Cita
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($citas as $cita)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md p-5 hover:shadow-lg transition-shadow duration-300">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Paciente: {{ $cita->user->name }}</h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Doctor:</strong> {{ $cita->doctor->name }}</p>
                        <p class="text-gray-700 dark:text-gray-300 mb-2"><strong>Fecha y Hora:</strong> {{ $cita->appointment_date }}</p>
                        <div class="mt-4 flex justify-between">
                            <a href="{{ route('citas.edit', $cita->id) }}" class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-2 px-4 rounded flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h.01M9 12h.01M4 12h.01M12 4v1m4.24 2.76a5 5 0 10-7.07 7.07m7.07-7.07L17 7l-2.5 4-2.5-4m-2 4l-2.5-4L7 7m-2.5 4l4 2.5 4-2.5m0 0L17 17m-4 0l-2.5-4-2.5 4M17 17l2.5-4L17 7m0 0a5 5 0 00-7.07 7.07"></path></svg>
                                Editar
                            </a>
                            <form action="{{ route('citas.destroy', $cita->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta cita?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
