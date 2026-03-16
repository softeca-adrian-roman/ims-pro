<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Crear Vehículo</h1>

        <form action="{{ route('vehiculos.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <flux:input name="nombre" label="Nombre" value="{{ old('nombre') }}" class="input" required />
                @error('nombre') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:input name="referencia" label="Referencia" value="{{ old('referencia') }}" class="input" required />
                @error('referencia') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <flux:input name="stock" type="number" label="Stock" value="{{ old('stock', 0) }}" class="input" min="0" />
                @error('stock') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Crear</button>
                <a href="{{ route('vehiculos.index') }}" class="btn">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
