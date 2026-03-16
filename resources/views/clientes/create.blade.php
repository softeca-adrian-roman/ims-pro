<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('clientes.index') }}">Clientes</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Crear Cliente</h1>

        <form action="{{ route('clientes.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block">Nombre</label>
                <input name="nombre" value="{{ old('nombre') }}" class="input" required />
                @error('nombre') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block">Email</label>
                <input name="email" type="email" value="{{ old('email') }}" class="input" required />
                @error('email') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block">Teléfono</label>
                <input name="telefono" value="{{ old('telefono') }}" class="input" />
                @error('telefono') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block">Código postal</label>
                <input name="codigo_postal" value="{{ old('codigo_postal') }}" class="input" />
                @error('codigo_postal') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block">Provincia</label>
                <select name="provincia_id" required class="input">
                    <option value="">Seleccionar</option>
                    @foreach($provincias as $prov)
                        <option value="{{ $prov->id }}" @selected(old('provincia_id') == $prov->id)>{{ $prov->nombre }}</option>
                    @endforeach
                </select>
                @error('provincia_id') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block">Tipo</label>
                <select name="tipo" required class="input">
                    <option value="">Seleccionar</option>
                    @foreach($tipos as $t)
                        <option value="{{ $t }}" @selected(old('tipo') == $t)>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
                @error('tipo') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            @if(isset($vendedores) && $vendedores->count() > 1)
                <div>
                    <label class="block">Vendedor</label>
                    <select name="vendedor_id" class="input">
                        <option value="">Seleccionar</option>
                        @foreach($vendedores as $v)
                            <option value="{{ $v->id }}" @selected(old('vendedor_id') == $v->id)>{{ $v->name }}</option>
                        @endforeach
                    </select>
                    @error('vendedor_id') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>
            @elseif(isset($vendedores) && $vendedores->count() === 1)
                <input type="hidden" name="vendedor_id" value="{{ $vendedores->first()->id }}" />
            @endif

            <div>
                <button class="btn btn-primary" type="submit">Crear</button>
                <a href="{{ route('clientes.index') }}" class="btn">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
