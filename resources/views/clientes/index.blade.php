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
                    @can('ver vendedores')
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                    @endcan
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
                    @can('ver vendedores')
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->vendedor->name ?? '' }}</td>
                    @endcan
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->provincia->nombre ?? '' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($cliente->tipo->value) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <flux:button size="sm" variant="outline" href="{{ route('clientes.show', $cliente) }}" class="ml-2">Ver</flux:button>
                        @can('eliminar clientes')
                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline-block" class="ml-2 delete-form inline">
                                @csrf
                                @method('DELETE')
                                <flux:button size="sm" variant="danger" type="submit">Borrar</flux:button>
                            </form>
                        @endcan
                        @can('editar clientes') <flux:button size="sm" variant="filled" href="{{ route('clientes.edit', $cliente) }}" class="ml-2">Editar</flux:button> @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $clientes->links() }}</div>

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
</x-app-layout>
