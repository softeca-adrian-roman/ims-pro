<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('clientes.index') }}">Clientes</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $cliente->nombre }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
        <div class="container mx-auto">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold">{{ $cliente->nombre }}</h1>
                <p class="text-gray-600">{{ $cliente->email }} | {{ $cliente->telefono }}</p>
            </div>

            <h2 class="mt-4 text-xl font-semibold">Vehículos asignados</h2>
            <div class="overflow-hidden mt-2">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehículo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($vehiculosAsignados as $v)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $v->nombre }} ({{ $v->referencia }})</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($v->pivot->precio, 2, ',', '.') }} €</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <form method="POST" class="delete-form inline" action="{{ route('clientes.vehiculos.destroy', [$cliente, $v]) }}">
                                        @csrf @method('DELETE')
                                        <flux:button  variant="danger" type="submit" icon="trash" title="Eliminar vehículo"></flux:button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">No hay vehículos asignados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <hr class="border-gray-300 mt-2">
            <h3 class="mt-4 text-lg font-semibold">Asignar nuevo vehículo</h3>
            <form method="POST" action="{{ route('clientes.vehiculos.store', $cliente) }}" class="mt-2">
                @csrf
                <div class="flex items-end space-x-4">
                    <div class="flex-1">
                        <flux:select name="vehiculo_id" label="Vehículo" class="buscar w-full">
                            @foreach($vehiculosDisponibles as $veh)
                                <option value="{{ $veh->id }}">
                                    {{ $veh->nombre }} ({{ $veh->referencia }}) - Precio sugerido: {{ number_format($veh->precioPara($cliente), 2, ',', '.') }} €
                                </option>
                            @endforeach
                        </flux:select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <flux:button size="sm" variant="danger" href="{{ route('clientes.index') }}">Cancelar</flux:button>
                        <flux:button size="sm" variant="outline" type="submit">Asignar</flux:button>
                    </div>
                </div>
            </form>
        </div>

        @push('js')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let forms = document.querySelectorAll('.delete-form');

                    forms.forEach(form => {
                        form.addEventListener('submit', (e) => {
                            e.preventDefault();

                            Swal.fire({
                                title: "¿Quieres eliminar este vehículo?",
                                text: "Estás seguro de este cambio?",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Sí, eliminar",
                                cancelButtonText: "Cancelar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        });
                    });
                });
            </script>
        @endpush
                </div>
            </div>
        </div>
        <script>
            $('.buscar').select2({
            theme: 'tailwindcss-3',
            placeholder: 'Seleccionar',
            allowClear: true,
            width: '100%'
            });
        </script>

</x-app-layout>
