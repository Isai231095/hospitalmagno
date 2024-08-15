<!-- resources/views/citas/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Detalles de la Cita') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center items-center">
        <div class="w-full max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-lg font-semibold text-white mb-5">Resumen de la Consulta</h3>

                <!-- Detalles del diagnóstico y tratamiento -->
                <ul class="mb-5 text-white">
                    <li><strong>Diagnóstico:</strong> {{ $ticketDetails['diagnosis'] }}</li>
                    <li><strong>Tratamiento:</strong> {{ $ticketDetails['treatment'] }}</li>
                    <li><strong>Altura:</strong> {{ $ticketDetails['height'] }} m</li>
                    <li><strong>Peso:</strong> {{ $ticketDetails['weight'] }} kg</li>
                    <li><strong>Presión Arterial:</strong> {{ $ticketDetails['blood_pressure'] }} mm Hg</li>
                </ul>

                <!-- Resumen de costos -->
                <ul class="mb-5 text-white">
                    <li><strong>Consulta:</strong> $600</li>

                    <li><strong>Servicios:</strong></li>
                    <ul>
                        @foreach($ticketDetails['servicios'] as $servicio)
                            <li>{{ $servicio['name'] }} - ${{ $servicio['price'] }}</li>
                        @endforeach
                    </ul>
                    <li><strong>Total Servicios:</strong> ${{ $ticketDetails['total_servicios'] }}</li>

                    <li><strong>Medicamentos:</strong></li>
                    <ul>
                        @foreach($ticketDetails['medicamentos'] as $medicamento)
                            <li>{{ $medicamento['name'] }} - ${{ $medicamento['price'] }}</li>
                        @endforeach
                    </ul>
                    <li><strong>Total Medicamentos:</strong> ${{ $ticketDetails['total_medicamentos'] }}</li>
                </ul>

                <hr class="mb-5">
                <h4 class="text-lg font-bold text-white mb-5">Total a Pagar: ${{ $ticketDetails['total_pagar'] }}</h4>

                <div class="flex justify-center">
                    <a href="{{ route('dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
