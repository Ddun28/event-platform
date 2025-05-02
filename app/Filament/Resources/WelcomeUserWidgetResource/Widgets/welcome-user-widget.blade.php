<x-filament::widget>
    {{-- Contenedor principal: Usamos zinc-900 para el fondo oscuro --}}
    <div class="flex items-center justify-between px-6 py-4  dark:bg-zinc-900 rounded-lg shadow-lg bg-[#18181B] dark:border-zinc-700">
        
        {{-- Sección izquierda: Icono y texto --}}
        <div class="flex items-center space-x-4">
            
            {{-- Icono --}}
            <x-heroicon-o-user-circle class="w-9 h-9 text-primary-600 dark:text-primary-400" />
            
            {{-- Contenedor del texto --}}
            <div>
                {{-- Título de bienvenida --}}
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    ¡Bienvenido, 
                    {{-- Nombre del usuario --}}
                    <span class="text-primary-600 dark:text-primary-400 font-bold">{{ $user->name }}</span>!
                </h2>
            </div>
        </div>
        
        {{-- Sección derecha: Menú mínimo (Dropdown) --}}
        <x-filament::dropdown placement="bottom-end">
            {{-- Trigger --}}
            <x-slot name="trigger">
                {{-- Ajustamos el hover para el fondo oscuro con zinc --}}
                <button class="p-2 -m-2 rounded-full hover:bg-gray-100 dark:hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <x-heroicon-o-ellipsis-vertical class="w-6 h-6 text-gray-500 dark:text-zinc-400" /> {{-- Ajustamos el color del icono --}}
                </button>
            </x-slot>

            {{-- Lista del Dropdown --}}
            <x-filament::dropdown.list>
                {{ $this->getActions()[0] }} 
            </x-filament::dropdown.list>
        </x-filament::dropdown>
        
    </div>
</x-filament::widget>