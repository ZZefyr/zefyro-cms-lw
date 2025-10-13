<ul class="space-y-2">
    @foreach ($menuItems as $item)
        <li>
            <a href="#"
               wire:click.prevent="contentSelected('{{ $item['id'] }}', '{{ $item['label'] }}')"
               class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 group">
                <x-dynamic-component :component="$item['icon']" class="w-5 h-5 text-gray-500 group-hover:text-gray-700" />
                <span class="font-medium">{{ $item['label'] }}</span>
            </a>
        </li>
    @endforeach


{{--    --}}{{-- Produkty --}}
{{--    <li>--}}
{{--        <a href="#"--}}
{{--           wire:click.prevent="contentSelected('products', 'Produkty')"--}}
{{--           class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 group">--}}
{{--            <x-heroicon-o-shopping-bag class="w-5 h-5 text-gray-500 group-hover:text-gray-700" />--}}
{{--            <span class="font-medium">Produkty</span>--}}
{{--        </a>--}}
{{--    </li>--}}

{{--    --}}{{-- Nastavení --}}
{{--    <li>--}}
{{--        <a href="#"--}}
{{--           wire:click.prevent="contentSelected('settings', 'Nastavení')"--}}
{{--           class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 group">--}}
{{--            <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-gray-500 group-hover:text-gray-700" />--}}
{{--            <span class="font-medium">Nastavení</span>--}}
{{--        </a>--}}
{{--    </li>--}}
</ul>
