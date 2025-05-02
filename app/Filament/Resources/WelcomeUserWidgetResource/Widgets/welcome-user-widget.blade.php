<x-filament::widget>
    <div class="flex items-center justify-between px-6 py-4  dark:bg-zinc-900 rounded-lg shadow-lg bg-[#18181B] dark:border-zinc-700">
        
        <div class="flex items-center space-x-4">
            
            <x-heroicon-o-user-circle class="w-9 h-9 text-primary-600 dark:text-primary-400" />
            
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    ¡Bienvenido, 
                    <span class="text-primary-600 dark:text-primary-400 font-bold">{{ $user->name }}</span>!
                </h2>
            </div>
        </div>
        
        <x-filament::dropdown placement="bottom-end">
            <x-slot name="trigger">
                <button class="p-2 -m-2 rounded-full hover:bg-gray-100 dark:hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <x-heroicon-o-ellipsis-vertical class="w-6 h-6 text-gray-500 dark:text-zinc-400" /> {{-- Ajustamos el color del icono --}}
                </button>
            </x-slot>
            <x-filament::dropdown.list>
                {{ $this->getActions()[0] }} 
            </x-filament::dropdown.list>
        </x-filament::dropdown>
        
    </div>
</x-filament::widget>