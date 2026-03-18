<x-app-layout>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('vendedores.index') }}">Vendedores</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="mt-4 bg-white p-4 rounded-md shadow container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Crear Vendedor</h1>

        {{-- Mostrar errores generales si los hay --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendedores.store') }}" method="POST" class="space-y-4">
            @csrf

            <flux:input
                name="name"
                label="Nombre*"
                placeholder="Nombre"
                value="{{ old('name') }}"
                required
                class="input"
            />

            <flux:input
                name="email"
                label="Email*"
                placeholder="Email"
                value="{{ old('email') }}"
                required
                class="input"
            />

            <flux:input
                name="password"
                type="password"
                label="Contraseña*"
                placeholder="Contraseña"
                value="{{ old('password') }}"
                required
                class="input"
            />

            <flux:input
                name="password_confirmation"
                type="password"
                label="Confirmar contraseña*"
                placeholder="Confirmar"
                value="{{ old('password_confirmation') }}"
                required
                class="input"
            />

            <div class="flex items-center space-x-2">
                <flux:button size="sm" variant="danger" href="{{ route('vendedores.index') }}">
                    Cancelar
                </flux:button>
                <flux:button size="sm" variant="outline" type="submit">
                    Crear
                </flux:button>
            </div>
        </form>
    </div>
</x-app-layout>
