<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Vehículos</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Vehículos</h1>
        @can('crear vehiculos')
            <a href="{{ route('vehiculos.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md">Crear Vehículo</a>
        @endcan
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referencia</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($vehiculos as $vehiculo)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehiculo->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehiculo->referencia }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $vehiculo->stock }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <a href="{{ route('vehiculos.show', $vehiculo) }}" class="text-blue-600">Ver</a>
                        @can('editar vehiculos') <a href="{{ route('vehiculos.edit', $vehiculo) }}" class="ml-2 text-indigo-600">Editar</a> @endcan
                        @can('eliminar vehiculos')
                            <form action="{{ route('vehiculos.destroy', $vehiculo) }}" method="POST" style="display:inline-block" class="delete-form ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Borrar</button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
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
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $vehiculos->links() }}</div>
</x-app-layout>
