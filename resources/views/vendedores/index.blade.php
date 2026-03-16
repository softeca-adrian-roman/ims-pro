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
                        <a href="{{ route('vendedores.edit', $v) }}">Editar</a>
                        <form action="{{ route('vendedores.destroy', $v) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Borrar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $vendedores->links() }}</div>
    </div>
</x-app-layout>
