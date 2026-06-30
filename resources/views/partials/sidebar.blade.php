@php
    $items = [
        ['route' => 'dashboard', 'match' => 'dashboard', 'icon' => 'database', 'label' => 'DATA_PELANGGAN'],
        ['route' => 'prizes.index', 'match' => 'prizes.*', 'icon' => 'card_giftcard', 'label' => 'UNDIAN'],
        ['route' => 'winners', 'match' => 'winners', 'icon' => 'history_edu', 'label' => 'PEMENANG'],
    ];
@endphp

<nav class="fixed left-0 top-0 h-full hidden lg:flex flex-col z-50 w-72 bg-surface-container-lowest border-r border-white/5" style="font-family: 'JetBrains Mono', monospace;">
    <div class="p-8 mb-4">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 tech-border bg-primary-container/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary-container text-2xl">grid_view</span>
            </div>
            <div>
                <h1 class="text-xl text-primary tracking-tight leading-none font-extrabold" style="font-family: 'Sora', sans-serif;">NEON<span class="text-secondary">CORE</span></h1>
                <span class="text-[10px] text-on-surface-variant">{{ auth()->user()->name }}</span>
            </div>
        </div>

        <p class="text-[11px] text-on-surface-variant mb-4 opacity-50 tracking-wider">TERMINAL_NAVIGATION</p>

        <div class="space-y-1">
            @foreach ($items as $item)
                @php($active = request()->routeIs($item['match']))
                <a class="flex items-center gap-4 px-4 py-3 text-[11px] tracking-wider transition-all group {{ $active ? 'bg-primary-container/5 text-primary border-l-2 border-primary shadow-[inset_4px_0_12px_rgba(0,240,255,0.05)]' : 'text-on-surface-variant hover:text-primary hover:bg-white/5' }}" href="{{ route($item['route']) }}">
                    <span class="material-symbols-outlined text-xl {{ $active ? '' : 'group-hover:scale-110 transition-transform' }}">{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="mt-auto p-8 space-y-4">
        <div class="p-4 bg-surface-container/50 tech-border rounded">
            <div class="flex justify-between items-center mb-2">
                <span class="text-[10px] text-on-surface-variant">UPTIME</span>
                <span class="text-[10px] text-primary">99.9%</span>
            </div>
            <div class="h-1 bg-surface-container-low w-full">
                <div class="h-full bg-primary-container w-[99%] shadow-[0_0_8px_rgba(0,240,255,0.5)]"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="flex items-center gap-3 px-2 py-2 text-error/70 hover:text-error text-sm transition-colors" type="submit">
                <span class="material-symbols-outlined text-lg">power_settings_new</span>
                <span>TERMINATE</span>
            </button>
        </form>
    </div>
</nav>
