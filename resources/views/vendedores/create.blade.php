<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('vendedores.index') }}">Vendedores</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Crear Vendedor</h1>
        <form action="{{ route('vendedores.store') }}" method="POST" class="space-y-4">
            @csrf
            <flux:input name="name" label="Nombre" placeholder="Nombre" required class="input" />
            <flux:input name="email" label="Email" placeholder="Email" required class="input" />
            <flux:input name="password" type="password" label="Password" placeholder="Password" required class="input" />
            <flux:input name="password_confirmation" type="password" label="Confirmar" placeholder="Confirmar" required class="input" />
            <flux:button size="sm" variant="outline" class="ml-2" type="submit">Crear</flux:button>
            <flux:button size="sm" variant="danger" class="ml-2" href="{{ route('vendedores.index') }}">Cancelar</flux:button>
        </form>
    </div>
</x-app-layout>
