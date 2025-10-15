<ul class="space-y-2">
    @foreach ($menuItems as $item)
        <li>
            <a href="#"
               wire:click.prevent="contentSelected('{{ $item['id'] }}', '{{ $item['label'] }}')"
               class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 group">
                <x-dynamic-component :component="$item['icon']" class="w-5 h-5 text-gray-500 group-hover:text-gray-700" />
                <span class="font-medium">{{ $item['label'] }}</span>
            </a>
            @if(isset($item['subItems']) && is_array($item['subItems']) && count($item['subItems']) > 0)
                <ul class="mt-2 ml-6 space-y-1">
                    @foreach ($item['subItems'] as $subItem)
                        <li>
                            <a href="#"
                               wire:click.prevent="contentSelected('{{ $subItem['id'] }}', '{{ $subItem['label'] }}')"
                               class="flex items-center gap-3 px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors duration-200 group">
                                <x-dynamic-component :component="$subItem['icon']" class="w-4 h-4 text-gray-400 group-hover:text-gray-600" />
                                <span class="font-medium text-sm">{{ $subItem['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
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
