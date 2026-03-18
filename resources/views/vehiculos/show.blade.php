<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('vehiculos.index') }}">Vehículos</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $vehiculo->nombre }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">{{ $vehiculo->nombre }}</h1>
                    <hr>
                    <p class="mt-4">Referencia: {{ $vehiculo->referencia }}</p>
                    <p class="mt-4">Stock: {{ $vehiculo->stock }}</p>
                    <p class="mt-4">Precio base: {{ number_format($vehiculo->precio_base, 2, ',', '.') }}€</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
