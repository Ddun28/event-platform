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
        
    </div>
</x-filament::widget>