<div class="flex flex-col h-screen">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark"/>

    <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
        <x-app-logo/>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Platform')" class="grid">
            <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                               wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
        </flux:navlist.group>
    </flux:navlist>
    @role('administrator')
        <flux:navlist.group heading="Configuración" expandable>

            <flux:navlist.item
                icon="cog-8-tooth"
                :href="route('admin.settings.modules')"
                :current="request()->routeIs('admin.settings.modules')"
                wire:navigate
            >
                Módulos
            </flux:navlist.item>
            <flux:navlist.item
                icon="adjustments-horizontal"
                :href="route('users.roles')"
                :current="request()->routeIs('users.roles')"
                wire:navigate
            >
                Roles
            </flux:navlist.item>

            <flux:navlist.item
                icon="user-plus"
                :href="route('users.permissions')"
                :current="request()->routeIs('users.permissions')"
                wire:navigate
            >
                Permisos
            </flux:navlist.item>

        </flux:navlist.group>
    @endrole
    @if($modules['modules.warehouse'])
        @canany(['menu warehouse manager','menu general administrator','menu warehouse'])
        <flux:navlist.group heading="Almacén" expandable>
            <flux:navlist.item
                icon="numbered-list"
                :href="route('warehouse.inventory')"
                :current="request()->routeIs('warehouse.inventory')"
                wire:navigate
            >
                inventario
            </flux:navlist.item>

            <flux:navlist.item
                icon="arrow-down-left"
                :href="route('warehouse.entries')"
                :current="request()->routeIs('warehouse.entries')"
                wire:navigate
            >
                Ingreso a almacén
            </flux:navlist.item>

            <flux:navlist.item
                icon="arrow-up-right"
                :href="route('warehouse.dispatches')"
                :current="request()->routeIs('warehouse.dispatches')"
                wire:navigate
            >
                Salida a almacén
            </flux:navlist.item>

            <flux:navlist.item
                icon="inbox-stack"
                :href="route('warehouse.products')"
                :current="request()->routeIs('warehouse.products')"
                wire:navigate
            >
                Productos
            </flux:navlist.item>

            <flux:navlist.item
                icon="user-group"
                :href="route('warehouse.suppliers')"
                :current="request()->routeIs('warehouse.suppliers')"
                wire:navigate
            >
                Proveedores
            </flux:navlist.item>

            <flux:navlist.item
                icon="bookmark"
                :href="route('warehouse.categories')"
                :current="request()->routeIs('warehouse.categories')"
                wire:navigate
            >
                Categorías
            </flux:navlist.item>

            <flux:navlist.item
                icon="archive-box"
                :href="route('warehouse.units')"
                :current="request()->routeIs('warehouse.units')"
                wire:navigate
            >
                Unidades
            </flux:navlist.item>
            <flux:navlist.item
                icon="arrow-path"
                :href="route('warehouse.movements-type')"
                :current="request()->routeIs('warehouse.movements-type')"
                wire:navigate
            >
                Tipos de movimiento
            </flux:navlist.item>
            <flux:navlist.item
                icon="building-office"
                :href="route('warehouse.index')"
                :current="request()->routeIs('warehouse.index')"
                wire:navigate
            >
                Almacenes
            </flux:navlist.item>
        </flux:navlist.group>
        @endcanany
    @endif
    @canany(['menu company','menu general administrator'])
        <flux:navlist.group heading="Empresa" expandable>
            <flux:navlist.item
                icon="home-modern"
                :href="route('company.index')"
                :current="request()->routeIs('company.index')"
                wire:navigate
            >
                Empresa
            </flux:navlist.item>
        </flux:navlist.group>
    @endcanany
    @if($modules['modules.sales'])
        @canany(['menu sales manager','menu general administrator','menu sales clerk'])
        <flux:navlist.group heading="Ventas" expandable>
            <flux:navlist.item
                icon="rectangle-stack"
                :href="route('dashboard')"
                :current="request()->routeIs('dashboard')"
                wire:navigate
            >
                Ingresos
            </flux:navlist.item>

            <flux:navlist.item
                icon="user-group"
                :href="route('warehouse.suppliers')"
                :current="request()->routeIs('warehouse.suppliers')"
                wire:navigate
            >
                Proveedores
            </flux:navlist.item>
        </flux:navlist.group>
        @endcanany
    @endif
    @if($modules['modules.purchases'])
        @canany(['menu purchasing manager','menu general administrator','menu purchasing clerk'])
        <flux:navlist.group heading="Compras" expandable>
            <flux:navlist.item
                icon="rectangle-stack"
                :href="route('dashboard')"
                :current="request()->routeIs('dashboard')"
                wire:navigate
            >
                Compras
            </flux:navlist.item>

            <flux:navlist.item
                icon="bookmark"
                :href="route('dashboard')"
                :current="request()->routeIs('dashboard')"
                wire:navigate
            >
                Clientes
            </flux:navlist.item>
            <flux:navlist.item
                icon="user-group"
                :href="route('warehouse.suppliers')"
                :current="request()->routeIs('warehouse.suppliers')"
                wire:navigate
            >
                Proveedores
            </flux:navlist.item>
        </flux:navlist.group>
        @endcanany
    @endif
    @if($modules['modules.access'])
        @canany(['menu access','menu general administrator'])
        <flux:navlist.group heading="Accesos" expandable>
            <flux:navlist.item
                icon="users"
                :href="route('users.users')"
                :current="request()->routeIs('users.users')"
                wire:navigate
            >
                Usuarios
            </flux:navlist.item>

        </flux:navlist.group>
        @endcanany
    @endif
    @if($modules['modules.reports'])
        @canany(['menu reports','menu general administrator'])
        <flux:navlist.group heading="Reportes" expandable>
            <flux:navlist.item
                icon="rectangle-stack"
                :href="route('dashboard')"
                :current="request()->routeIs('dashboard')"
                wire:navigate
            >
                Compras
            </flux:navlist.item>

            <flux:navlist.item
                icon="bookmark"
                :href="route('dashboard')"
                :current="request()->routeIs('dashboard')"
                wire:navigate
            >
                Ventas
            </flux:navlist.item>
            <flux:navlist.item
                icon="hand-raised"
                :href="route('users.audits')"
                :current="request()->routeIs('users.audits')"
                wire:navigate
            >
                Auditorias
            </flux:navlist.item>
        </flux:navlist.group>
        @endcanany
    @endif

    <flux:spacer/>

    <!-- Desktop User Menu -->
    <flux:dropdown position="bottom" align="start">
        <flux:profile
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
            icon-trailing="chevrons-up-down"
        />

        <flux:menu class="w-[220px]">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                        >
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ __(auth()->user()->getRoleNames()->first()) }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" icon="cog"
                                wire:navigate>{{ __('Settings') }}</flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator/>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</div>
