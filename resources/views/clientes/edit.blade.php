<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('clientes.index') }}">Clientes</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="mt-4 bg-white p-4 rounded-md shadow container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Editar Cliente</h1>

        <form action="{{ route('clientes.update', $cliente) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <flux:input name="nombre" label="Nombre*" value="{{ old('nombre', $cliente->nombre) }}" class="input" required />
                @error('nombre') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <flux:input name="email" type="email" label="Email*" value="{{ old('email', $cliente->email) }}" class="input" required />
                @error('email') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <flux:input name="telefono" label="Teléfono*" value="{{ old('telefono', $cliente->telefono) }}" class="input" required />
                @error('telefono') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <flux:input name="codigo_postal" label="Código postal*" value="{{ old('codigo_postal', $cliente->codigo_postal) }}" class="input" required />
                @error('codigo_postal') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <flux:select name="provincia_id" label="Provincia*" required class="buscar input">
                    <option value="">Seleccionar</option>
                    @foreach($provincias as $prov)
                        <option value="{{ $prov->id }}" @selected(old('provincia_id', $cliente->provincia_id) == $prov->id)>{{ $prov->nombre }}</option>
                    @endforeach
                </flux:select>
                @error('provincia_id') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <flux:select name="tipo" label="Tipo*" required class="buscar input">
                    <option value="">Seleccionar</option>
                    @foreach($tipos as $t)
                        <option value="{{ $t }}" @selected(old('tipo', $cliente->tipo->value) == $t)>{{ ucfirst($t) }}</option>
                    @endforeach
                </flux:select>
                @error('tipo') <p class="text-red-600">{{ $message }}</p> @enderror
            </div>

            @if(isset($vendedores) && $vendedores->count() > 1)
                <div>
                    <flux:select name="vendedor_id" label="Vendedor*" class="buscar input">
                        <option value="">Seleccionar</option>
                        @foreach($vendedores as $v)
                            <option value="{{ $v->id }}" @selected(old('vendedor_id', $cliente->vendedor_id) == $v->id)>{{ $v->name }}</option>
                        @endforeach
                    </flux:select>
                    @error('vendedor_id') <p class="text-red-600">{{ $message }}</p> @enderror
                </div>
            @elseif(isset($vendedores) && $vendedores->count() === 1)
                <flux:input type="hidden" name="vendedor_id" value="{{ $vendedores->first()->id }}" />
            @endif

            <div class="flex items-center justify-end space-x-2">
                <flux:button size="sm" variant="danger" class="ml-2" href="{{ route('clientes.index') }}">Cancelar</flux:button>
                <flux:button size="sm" variant="outline" class="ml-2" type="submit">Actualizar</flux:button>
            </div>
        </form>
    </div>
        <script>
            $('.buscar').select2({
            theme: 'tailwindcss-3',
            placeholder: 'Seleccionar',
            allowClear: true,
            width: '100%'
            });
        </script>
</x-app-layout>
