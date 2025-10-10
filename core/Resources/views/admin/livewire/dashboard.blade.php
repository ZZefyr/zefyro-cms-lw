<div>
    <!-- Header -->
<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0">
    <div class="flex items-center space-x-4">
        <h2 class="text-lg font-semibold text-gray-800">{{ $this->pageTitle ?? 'Dashboard' }}</h2>
    </div>

    <div class="flex items-center space-x-4">
        <!-- User Info -->
        <div class="flex items-center space-x-3">
            <div class="text-right">
                <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                Odhlásit se
            </button>
        </form>
    </div>
</header>

<!-- Main Content -->
<main class="flex-1 overflow-y-auto p-6">
    <div class="mx-auto">
        <div class="content-area bg-white p-6 rounded shadow">
            @if($this->getComponentName())
                <div wire:key="content-{{ $selectedContent }}">
                    @livewire($this->getComponentName(), key($selectedContent))
                </div>
            @else
                <p>Vyberte položku z menu.</p>
            @endif
        </div>
    </div>
</main>
</div>
