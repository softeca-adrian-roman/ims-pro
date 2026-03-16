<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Vendedores</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Vendedores</h1>
            @can('crear vendedores')
                <a href="{{ route('vendedores.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md">Crear Vendedor</a>
            @endcan
        </div>
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded">{{ session('success') }}</div>
        @endif
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendedores as $v)
                <tr>
                    <td>{{ $v->name }}</td>
                    <td>{{ $v->email }}</td>
                    <td>
                        <a href="{{ route('vendedores.edit', $v) }}" class="ml-2 text-indigo-600">Editar</a>
                        <form action="{{ route('vendedores.destroy', $v) }}" method="POST" style="display:inline-block" class="delete-form ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Borrar</button>
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
    </div>
</x-app-layout>
