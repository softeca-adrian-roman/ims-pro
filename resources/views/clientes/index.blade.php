<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Clientes</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Clientes</h1>
        @can('crear clientes')
            <a href="{{ route('clientes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md">Crear Cliente</a>
        @endcan
    </div>

    @if(session('success'))
        <div data-flash-success="{{ session('success') }}" style="display:none"></div>
    @endif

    <div class="overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provincia</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($clientes as $cliente)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->vendedor->name ?? '' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->provincia->nombre ?? '' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($cliente->tipo->value) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <a href="{{ route('clientes.show', $cliente) }}" class="text-blue-600">Ver</a>
                        @can('editar clientes') <a href="{{ route('clientes.edit', $cliente) }}" class="ml-2 text-indigo-600">Editar</a> @endcan
                        @can('eliminar clientes')
                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline-block" class="delete-form inline">
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
                                        title: "¿Quieres eliminar este cliente?",
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
    <div class="mt-4">{{ $clientes->links() }}</div>
</x-app-layout>
