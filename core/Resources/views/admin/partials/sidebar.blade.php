<nav class="sidebar">
    <ul>
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

        {{-- Dynamické položky z modulů --}}
        @foreach(config('modules') as $module)
            @if(isset($module['admin_menu']))
                @foreach($module['admin_menu'] as $item)
                    <li><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
                @endforeach
            @endif
        @endforeach
    </ul>
</nav>
