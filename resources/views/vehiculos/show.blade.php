<x-layouts.app>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('vehiculos.index') }}">Vehículos</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $vehiculo->nombre }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container mx-auto">
        <h1 class="text-2xl font-bold">{{ $vehiculo->nombre }}</h1>
        <p>Referencia: {{ $vehiculo->referencia }}</p>
        <p>Stock: {{ $vehiculo->stock }}</p>
    </div>
</x-layouts.app>
