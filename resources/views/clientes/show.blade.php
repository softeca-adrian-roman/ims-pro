<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('clientes.index') }}">Clientes</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $cliente->nombre }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container mx-auto">
        <h1 class="text-2xl font-bold">{{ $cliente->nombre }}</h1>
        <p>{{ $cliente->email }}</p>
        <p>{{ $cliente->telefono }}</p>
        <h2 class="mt-4">Vehículos asignados</h2>
        <ul class="space-y-4">
            @foreach($vehiculosAsignados as $v)
                <li>
                    <div class="mt-4 mb-2">
                    {{ $v->nombre }} - {{ $v->pivot->precio }}
                    </div>
                <form method="POST" class="space-y-4" action="{{ route('clientes.vehiculos.destroy', [$cliente, $v]) }}">@csrf @method('DELETE')
                <flux:button size="sm" variant="danger" class="space-y-4 ml-2" type="submit">Designar</flux:button>
                </form></li>
            @endforeach
        </ul>

        <h3 class="mt-4">Asignar vehículo</h3>
        <form method="POST" class="space-y-4" action="{{ route('clientes.vehiculos.store', $cliente) }}">
            @csrf
            <flux:select name="vehiculo_id">
                @foreach($vehiculosDisponibles as $veh)
                    <option value="{{ $veh->id }}">{{ $veh->nombre }} ({{ $veh->referencia }}) - Precio sugerido: {{ number_format($veh->precioPara($cliente), 2) }}</option>
                @endforeach
            </flux:select>
            <flux:button size="sm" variant="outline" class="ml-2" type="submit">Asignar</flux:button>
            <flux:button size="sm" variant="danger" class="ml-2" href="{{ route('clientes.index') }}" >Cancelar</flux:button>
        </form>
    </div>
</x-app-layout>
