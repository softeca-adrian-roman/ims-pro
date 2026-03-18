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
    <div class="mb-4 bg-white p-4 rounded-md shadow"><h1 class="text-lg font-bold">Filtros</h1>
        <hr class="border-gray-300 my-2">
        <form method="GET" action="{{ route('clientes.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-2 items-end">
            <div>
                <flux:input name="nombre" label="Nombre" value="{{ request('nombre') }}" class="input" />
            </div>
            <div>
                <flux:input name="email" label="Email" value="{{ request('email') }}" class="input" />
            </div>
            @can('ver vendedores')
            <div>
                <flux:select name="vendedor_id" label="Vendedor" class="buscar input">
                    <option value="">Todos</option>
                    @foreach($vendedores as $v)
                        <option value="{{ $v->id }}" @selected(request('vendedor_id') == $v->id)>{{ $v->name }}</option>
                    @endforeach
                </flux:select>
            </div>
            @endcan
            <div>
                <flux:select name="provincia_id" label="Provincia" class="buscar input">
                    <option value="">Todas</option>
                    @foreach($provincias as $prov)
                        <option value="{{ $prov->id }}" @selected(request('provincia_id') == $prov->id)>{{ $prov->nombre }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div>
                <flux:select name="tipo" label="Tipo" class="buscar input">
                    <option value="">Todos</option>
                    @foreach($tipos as $t)
                        <option value="{{ $t }}" @selected(request('tipo') == $t)>{{ ucfirst($t) }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div class="md:col-span-1 flex space-x-2">
                <flux:button variant="outline" type="submit" icon="magnifying-glass"></flux:button>
                <flux:button variant="outline" href="{{ route('clientes.index') }}" class="inline-flex items-center px-3 py-2 border rounded-md" icon="backspace"></flux:button>
            </div>
        </form>
    </div>
    @if(session('success'))
        <div data-flash-success="{{ session('success') }}" style="display:none"></div>
    @endif
    <div class="overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-200">
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
                <tr class="{{ $loop->odd ? 'bg-gray-50' : 'bg-gray-100' }}">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->email }}</td>
                    @can('ver vendedores')
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->vendedor->name ?? '' }}</td>
                    @endcan
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->provincia->nombre ?? '' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($cliente->tipo->value) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <flux:button size="sm" variant="outline" href="{{ route('clientes.show', $cliente) }}" class="ml-2" icon="eye" title="Ver cliente"></flux:button>
                        @can('eliminar clientes')
                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:inline-block" class="delete-form inline">
                                @csrf
                                @method('DELETE')
                                <flux:button size="sm" variant="danger" type="submit" class="ml-2" icon="trash" title="Eliminar cliente"></flux:button>
                            </form>
                        @endcan
                        @can('editar clientes') <flux:button size="sm" variant="filled" href="{{ route('clientes.edit', $cliente) }}" class="ml-2" icon="pencil" title="Editar cliente"></flux:button> @endcan
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
        <script>
            $('.buscar').select2({
            theme: 'tailwindcss-3',
            placeholder: 'Seleccionar',
            allowClear: true,
            width: '100%'
            });
        </script>
    @endpush
</x-app-layout>
