<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('vendedores.index') }}">Vendedores</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Editar Vendedor</h1>
        <form action="{{ route('vendedores.update', $vendedor) }}" method="POST" class="submit-form">
            @csrf
            @method('PUT')
            <flux:input name="name" label="Nombre" value="{{ $vendedor->name }}" placeholder="Nombre" required class="border rounded p-2 mb-2 w-full" />
            <flux:input name="email" label="Email" value="{{ $vendedor->email }}" placeholder="Email" required class="border rounded p-2 mb-2 w-full" />
            <flux:input name="password" type="password" label="Password" placeholder="Password" class="border rounded p-2 mb-2 w-full" />
            <flux:input name="password_confirmation" type="password" label="Confirmar" placeholder="Confirmar" class="border rounded p-2 mb-2 w-full" />
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
        </form>
    </div>
</x-app-layout>
