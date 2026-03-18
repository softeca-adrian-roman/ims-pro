<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Bienvenido al Dashboard</h1>
                    <p class="mt-4">{{ __("Estás logueado correctamente con la cuenta :email", ['email' => auth()->user()->email]) }}</p>
                    <br />
                    <hr>
                    <br />
                    <p>Desde aquí puedes gestionar:</p>
                    <ul class="list-disc pl-5">
                        <li><flux:link href="{{ route('clientes.index') }}">Clientes</flux:link></li>
                        @can('ver vehiculos')
                            <li><flux:link href="{{ route('vehiculos.index') }}">Vehículos</flux:link></li>
                        @endcan
                        @can('ver vendedores')
                            <li><flux:link href="{{ route('vendedores.index') }}">Vendedores</flux:link></li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
