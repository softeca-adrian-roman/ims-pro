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
                    <hr class="border-gray-300 my-2">
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
                    <img class="mt-2 border-6 border-gray-100 " src="https://fotografias-2.larazon.es/clipping/cmsimages02/2023/12/26/4585ADC8-B35D-4912-B224-9D4952E763F0/invicta-gama-completa-movilidad-electrica-que-llega-china_98.jpg?crop=5386,3030,x0,y284&width=1900&height=1069&optimize=low&format=webply" alt="Dashboard Imagen Invicta" class="mt-6 rounded-md shadow-md">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
