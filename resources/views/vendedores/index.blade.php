<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Vendedores</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Vendedores</h1>
        @can('crear vendedores')
            <a href="{{ route('vendedores.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md">Crear Vendedor</a>
        @endcan
    </div>
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded">{{ session('success') }}</div>
    @endif
    <table class="min-w-full divide-y divide-gray-200 w-full table-auto">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($vendedores as $v)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $v->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $v->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <flux:button size="sm" variant="outline" href="{{ route('vendedores.edit', $v) }}" class="ml-2">Editar</flux:button>
                    <form action="{{ route('vendedores.destroy', $v) }}" method="POST" style="display:inline-block" class="delete-form ml-2">
                        @csrf
                        @method('DELETE')
                        <flux:button size="sm" variant="danger" type="submit">Borrar</flux:button>
                    </form>
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
    <div class="mt-4">{{ $vendedores->links() }}</div>
</x-app-layout>
