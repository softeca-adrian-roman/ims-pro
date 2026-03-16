<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Crear Vehículo</h1>

        <form action="{{ route('vehiculos.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">Nombre</label>
                <input name="nombre" value="{{ old('nombre') }}" class="input" required />
                @error('nombre') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block">Referencia</label>
                <input name="referencia" value="{{ old('referencia') }}" class="input" required />
                @error('referencia') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block">Stock</label>
                <input name="stock" type="number" value="{{ old('stock', 0) }}" class="input" min="0" />
                @error('stock') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Crear</button>
                <a href="{{ route('vehiculos.index') }}" class="btn">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
