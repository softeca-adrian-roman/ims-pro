@php
$user = auth()->user();
$groups = [
    'Platform' => [
        [
            'name'  => 'Dashboard',
            'icon'  => 'home',
            'url'   => route('dashboard'),
            'active'=> request()->routeIs('dashboard'),
        ],
        [
            'name'  => 'Clientes',
            'icon'  => 'users',
            'url'   => route('clientes.index'),
            'active'=> request()->routeIs('clientes.*'),
        ],
        [
            'name'  => 'Vehículos',
            'icon'  => 'truck',
            'url'   => route('vehiculos.index'),
            'active'=> request()->routeIs('vehiculos.*'),
        ],
    ],
];

// Solo si el usuario es administrador, añadimos "Vendedores"
if ($user && $user->hasRole('admin')) {
    $groups['Platform'][] = [
        'name'  => 'Vendedores',
        'icon'  => 'user-group',
        'url'   => route('vendedores.index'),
        'active'=> request()->routeIs('vendedores.*'),
    ];
}
@endphp

<flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.header>
        <flux:button href="{{ route('dashboard') }}" class="flex items-center gap-2 px-2 text-lg font-semibold">
            {{ "Invicta Management System" }}
        </flux:button>
        <flux:sidebar.collapse class="lg:hidden" />
    </flux:sidebar.header>

    <flux:sidebar.nav>
        @foreach ($groups as $group => $links)
            <flux:sidebar.group :heading="__($group)" class="grid">
                @foreach ($links as $link)
                    <flux:sidebar.item icon="{{ $link['icon'] }}" :href="$link['url']" :current="$link['active']" wire:navigate>
                        {{ __($link['name']) }}
                    </flux:sidebar.item>
                @endforeach
            </flux:sidebar.group>
        @endforeach
    </flux:sidebar.nav>

    <flux:sidebar.spacer />

    <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
</flux:sidebar>

<!-- Mobile User Menu -->
<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left"/>

    <flux:spacer />

    <flux:dropdown position="top" align="end">
        <flux:profile
            :initials="auth()->user()->initials()"
            icon-trailing="chevron-down"
        />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <flux:avatar
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                        />

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                            <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                    {{ __('Settings') }}
                </flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>
