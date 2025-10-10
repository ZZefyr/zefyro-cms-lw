<div>
    <livewire:admin.grid.user-grid/>
    {{-- Modal - Alpine sleduje $wire.showCreateForm --}}
    <div x-data="{ open: @entangle('showCreateForm') }"
         x-show="open"
         x-cloak
         @keydown.escape.window="open = false"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">

        {{-- Backdrop --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50"
             @click="open = false">
        </div>

        {{-- Modal Content --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative z-50 w-full max-w-2xl mx-auto my-8 bg-white rounded-lg shadow-xl">

            {{-- Header --}}
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold">Přidat uživatele</h3>
                <button @click="open = false"
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6">
                {{-- Tvůj formulář --}}
                <form wire:submit="save">
                    {{-- Error banner --}}
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Při přihlášení došlo k chybám:
                                    </h3>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Jméno</label>
                            <input type="text" wire:model="name" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Email</label>
                            <input type="email" wire:model="email" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Heslo</label>
                            <input type="password" wire:model="password" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Heslo znovu</label>
                            <input type="password" wire:model="passwordAgain" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <select wire:model="selectedRole"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="" disabled>-- Vyberte roli --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Footer --}}
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button"
                                @click="open = false"
                                class="px-4 py-2 border rounded-lg hover:bg-gray-50">
                            Zrušit
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Uložit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
