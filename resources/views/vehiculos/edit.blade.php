<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('vehiculos.index') }}">Vehículos</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Editar Vehículo</h1>

        <form action="{{ route('vehiculos.update', $vehiculo) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <flux:input name="nombre" label="Nombre" value="{{ old('nombre', $vehiculo->nombre) }}" class="input" required />
                @error('nombre') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:input name="referencia" label="Referencia" value="{{ old('referencia', $vehiculo->referencia) }}" class="input" required />
                @error('referencia') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:input name="stock" type="number" label="Stock" value="{{ old('stock', $vehiculo->stock) }}" class="input" min="0" />
                @error('stock') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:input name="precio_base" type="number" label="Precio base" value="{{ old('precio', 0) }}" class="input" min="0" required />
                @error('precio') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:button size="sm" variant="outline" class="ml-2" type="submit">Actualizar</flux:button>
                <flux:button size="sm" variant="danger" class="ml-2" href="{{ route('vehiculos.index') }}" >Cancelar</flux:button>
            </div>
        </form>
    </div>
</x-app-layout>
