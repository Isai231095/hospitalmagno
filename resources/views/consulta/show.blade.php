<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Consulta para ') . $cita->user->name }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center items-center">
        <div class="w-full max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <form method="POST" action="{{ route('consulta.store', $cita->id) }}">
                    @csrf

                    <!-- Campos del formulario de consulta -->
                    <div class="mb-5">
                        <label for="diagnosis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnóstico</label>
                        <textarea name="diagnosis" id="diagnosis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>
                    </div>

                    <div class="mb-5">
                        <label for="treatment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tratamiento</label>
                        <textarea name="treatment" id="treatment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>
                    </div>

                    <div class="mb-5">
                        <label for="height" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Altura (m)</label>
                        <input type="number" step="0.01" name="height" id="height" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>

                    <div class="mb-5">
                        <label for="weight" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peso (kg)</label>
                        <input type="number" step="0.1" name="weight" id="weight" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>

                    <div class="mb-5">
                        <label for="blood_pressure" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Presión Arterial (mm Hg)</label>
                        <input type="text" name="blood_pressure" id="blood_pressure" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="120/80" required>
                    </div>

                    <!-- Selección de Servicios -->
                    <div id="servicios-container">
                        <div class="mb-5">
                            <label for="servicio_0" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Servicios:</label>
                            <select name="servicios[]" id="servicio_0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Seleccionar Servicio</option>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}" data-price="{{ $servicio->price }}">{{ $servicio->name }}</option>
                                @endforeach
                            </select>

                            <p id="servicio_price_0" class="text-sm text-gray-500 dark:text-gray-400 mt-1"></p>
                        </div>
                    </div>

                    <!-- Botón para añadir otro servicio -->
                    <div class="mb-5 flex justify-center">
                        <button type="button" id="add-servicio" class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Añadir</button>
                    </div>

                    <!-- Selección de Medicamentos -->
                    <div id="medicamentos-container">
                        <div class="mb-5">
                            <label for="medicamento_0" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Medicamentos:</label>
                            <select name="medicamentos[]" id="medicamento_0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="updateMedicamentoPrice(this, 0)">
                                <option value="">Seleccionar</option>
                                @foreach($medicamentos as $medicamento)
                                    <option value="{{ $medicamento->id }}" data-price="{{ $medicamento->precio }}">{{ $medicamento->nombre }}</option>
                                @endforeach
                            </select>
                            <p id="medicamento_price_0" class="text-sm text-gray-500 dark:text-gray-400 mt-1"></p>
                        </div>
                    </div>

                    <!-- Botón para añadir otro medicamento -->
                    <div class="mb-5 flex justify-center">
                        <button type="button" id="add-medicamento" class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Añadir</button>
                    </div>



                    <div class="flex justify-center">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Finalizar Consulta</button>
                    </div>

                    <!-- Campos de Altura, Peso, Presión Arterial -->

                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-medicamento').addEventListener('click', function() {
            const container = document.getElementById('medicamentos-container');
            const index = container.children.length;
            const newMedicamento = `
                <div class="mb-5">
                    <label for="medicamento_${index}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Medicamento</label>
                    <select name="medicamentos[]" id="medicamento_${index}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="updateMedicamentoPrice(this, ${index})">
                        <option value="">Seleccionar Medicamento</option>
                        @foreach($medicamentos as $medicamento)
                            <option value="{{ $medicamento->id }}" data-price="{{ $medicamento->precio }}">{{ $medicamento->nombre }}</option>
                        @endforeach
                    </select>
                    <p id="medicamento_price_${index}" class="text-sm text-gray-500 dark:text-gray-400 mt-1"></p>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newMedicamento);
        });

        document.getElementById('add-servicio').addEventListener('click', function() {
            const container = document.getElementById('servicios-container');
            const index = container.children.length;
            const newServicio = `
                <div class="mb-5">
                    <label for="servicio_${index}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Servicio:</label>
                    <select name="servicios[]" id="servicio_${index}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="updateServicePrice(this, ${index})">
                        <option value="">Seleccionar Servicio</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}" data-price="{{ $servicio->price }}">{{ $servicio->name }}</option>
                        @endforeach
                    </select>
                    <p id="servicio_price_${index}" class="text-sm text-gray-500 dark:text-gray-400 mt-1"></p>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newServicio);
        });

        function updateMedicamentoPrice(select, index) {
            const price = select.options[select.selectedIndex].getAttribute('data-price');
            document.getElementById(`medicamento_price_${index}`).textContent = price ? `Precio: $${price}` : '';
        }

        function updateServicePrice(select, index) {
            const price = select.options[select.selectedIndex].getAttribute('data-price');
            document.getElementById(`servicio_price_${index}`).textContent = price ? `Precio: $${price}` : '';
        }
    </script>
</x-app-layout>
