<x-layouts.app>
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
        <ul>
            @foreach($vehiculosAsignados as $v)
                <li>{{ $v->nombre }} - {{ $v->pivot->precio }} <form method="POST" action="{{ route('clientes.vehiculos.destroy', [$cliente, $v]) }}">@csrf @method('DELETE')<button type="submit">Desasignar</button></form></li>
            @endforeach
        </ul>

        <h3 class="mt-4">Asignar vehículo</h3>
        <form method="POST" action="{{ route('clientes.vehiculos.store', $cliente) }}">
            @csrf
            <select name="vehiculo_id">
                @foreach($vehiculosDisponibles as $veh)
                    <option value="{{ $veh->id }}">{{ $veh->nombre }} ({{ $veh->referencia }})</option>
                @endforeach
            </select>
            <input type="number" name="precio" step="0.01" placeholder="Precio" required />
            <button type="submit">Asignar</button>
        </form>
    </div>
</x-layouts.app>
