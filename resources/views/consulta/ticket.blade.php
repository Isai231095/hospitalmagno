<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Ticket de Pago') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center items-center">
        <div class="w-full max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <h3 class="text-lg font-semibold text-white mb-5">Resumen de la Consulta</h3>

                <!-- Detalles del diagnóstico y tratamiento -->
                <ul class="mb-5 text-white">
                    <li><strong>Diagnóstico:</strong> {{ $cita->diagnosis }}</li>
                    <li><strong>Tratamiento:</strong> {{ $cita->treatment }}</li>
                    <li><strong>Altura:</strong> {{ $cita->height }} m</li>
                    <li><strong>Peso:</strong> {{ $cita->weight }} kg</li>
                    <li><strong>Presión Arterial:</strong> {{ $cita->blood_pressure }} mm Hg</li>
                </ul>

                <!-- Resumen de costos -->
                <ul class="mb-5 text-white">
                    <li><strong>Consulta:</strong> $600</li>

                    <li><strong>Servicios:</strong></li>
                    <ul>
                        @foreach($cita->servicios as $servicio)
                            <li>{{ $servicio->name }} - ${{ $servicio->price }}</li>
                        @endforeach
                    </ul>
                    <li><strong>Total Servicios:</strong> ${{ $totalServicios }}</li>

                    <li><strong>Medicamentos:</strong></li>
                    <ul>
                        @foreach($cita->medicamentos as $medicamento)
                            <li>{{ $medicamento->nombre }} - ${{ $medicamento->precio }}</li>
                        @endforeach
                    </ul>
                    <li><strong>Total Medicamentos:</strong> ${{ $totalMedicamentos }}</li>
                </ul>

                <hr class="mb-5">
                <h4 class="text-lg font-bold text-white mb-5">Total a Pagar: ${{ $totalPagar }}</h4>

                <div class="flex justify-center">
                    <a href="{{ route('dashboard') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Finalizar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
