<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Winners History - NEON DRAW</title>
    <script src="{{ asset('tailwind-play-cdn.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { 'secondary-container': '#cf5cff', 'primary-container': '#00f0ff', background: '#0d1515', surface: '#0d1515', primary: '#dbfcff', secondary: '#ecb2ff', 'surface-container-lowest': '#080f10', 'surface-container': '#192122', 'on-surface': '#dce4e5', 'on-surface-variant': '#b9cacb' }, spacing: { 'grid-gap': '16px', 'container-padding-desktop': '40px', 'container-padding-mobile': '20px' }, fontFamily: { headline: ['Sora'], body: ['Plus Jakarta Sans'], label: ['JetBrains Mono'] } } } }
    </script>
    <style>
        body { background-color: #0A0A0F; background-image: radial-gradient(circle at 15% 50%, rgba(207,92,255,.15), transparent 25%), radial-gradient(circle at 85% 30%, rgba(0,240,255,.1), transparent 25%); background-attachment: fixed; margin: 0; min-height: 100vh; }
        .glass-panel { background: rgba(13,21,21,.4); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,.1); }
        .tech-border { border: 1px solid rgba(75,92,93,.4); position: relative; }
        .tech-border::before, .tech-border::after { content: ''; position: absolute; width: 8px; height: 8px; border-color: #00f0ff; opacity: .6; }
        .neon-border-recent { box-shadow: 0 0 15px rgba(0,240,255,.3), inset 0 0 10px rgba(0,240,255,.1); border: 1px solid rgba(0,240,255,.4); }
        .table-row-hover:hover { background: rgba(255,255,255,.05); transform: scale(1.01); transition: all .3s cubic-bezier(.25,.8,.25,1); }
    </style>
</head>
<body class="text-on-surface antialiased overflow-x-hidden font-body">
    <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-grid-gap h-16 bg-surface/40 backdrop-blur-xl lg:hidden shadow-[0_0_20px_rgba(0,240,255,0.1)] border-b border-white/10">
        <div class="font-headline text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary-container">NEON DRAW</div>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-on-surface-variant hover:text-primary p-2"><span class="material-symbols-outlined">logout</span></button></form>
    </header>

    @include('partials.sidebar')

    <main class="pt-24 pb-24 lg:pt-20 lg:ml-72 min-h-screen flex flex-col px-container-padding-mobile lg:px-container-padding-desktop">
        <div class="max-w-6xl w-full mx-auto">
            <header class="mb-10">
                <h1 class="font-headline text-5xl lg:text-6xl text-primary font-extrabold mb-4 drop-shadow-[0_0_10px_rgba(0,240,255,0.3)]">Winners History</h1>
                <p class="text-on-surface-variant max-w-2xl">Record hasil live draw. Pemenang yang terpilih otomatis masuk ke halaman ini.</p>
            </header>

            <div class="glass-panel rounded-xl overflow-hidden shadow-2xl flex flex-col relative z-10">
                <div class="hidden md:grid grid-cols-5 gap-4 px-6 py-4 border-b border-white/10 bg-white/5 font-label text-xs text-primary uppercase tracking-widest sticky top-0 z-20">
                    <div>Date</div><div>Giveaway Name</div><div>Winner</div><div>Nomer Telfon</div><div>Prize</div>
                </div>
                <div class="flex flex-col w-full">
                    @forelse ($winners as $winner)
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3 md:gap-4 px-6 py-5 border-b border-white/5 items-center table-row-hover m-2 rounded-lg {{ $loop->first ? 'bg-primary-container/10 neon-border-recent relative' : ($loop->even ? 'bg-white/[0.02]' : '') }}">
                            @if ($loop->first)
                                <div class="hidden md:block absolute -left-1 top-1/2 -translate-y-1/2 w-1 h-8 bg-primary rounded-r-full shadow-[0_0_10px_#00f0ff]"></div>
                            @endif
                            <div class="font-label text-xs text-on-surface-variant">{{ $winner->drawn_at->format('d M Y H:i') }}</div>
                            <div class="font-semibold {{ $loop->first ? 'text-primary drop-shadow-[0_0_5px_rgba(0,240,255,0.5)]' : 'text-on-surface' }}">{{ $winner->giveaway_name }}</div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $loop->first ? 'bg-secondary-container/30 border-secondary-container text-secondary' : 'bg-white/10 border-white/20 text-on-surface' }} border flex items-center justify-center text-xs font-bold">{{ strtoupper(substr($winner->participant->name, 0, 1)) }}</div>
                                <div><span class="text-on-surface">{{ $winner->participant->name }}</span><p class="md:hidden text-xs text-on-surface-variant">{{ $winner->participant->address }}</p></div>
                            </div>
                            <div class="font-label text-xs text-on-surface-variant">{{ $winner->participant->phone_number }}</div>
                            <div class="font-label text-xs {{ $loop->first ? 'text-secondary font-bold' : 'text-on-surface-variant' }}">{{ $winner->prize_name }}</div>
                        </div>
                    @empty
                        <div class="px-6 py-16 text-center text-on-surface-variant">Belum ada winner. Jalankan Live Draw terlebih dahulu.</div>
                    @endforelse
                </div>
                <div class="px-6 py-4 flex flex-col sm:flex-row justify-between gap-4 sm:items-center bg-white/5 border-t border-white/10">
                    <span class="font-label text-xs text-on-surface-variant opacity-60">Showing {{ $winners->firstItem() ?? 0 }}-{{ $winners->lastItem() ?? 0 }} of {{ $winners->total() }}</span>
                    <div class="text-sm [&_nav]:flex [&_nav]:justify-end [&_span]:bg-surface [&_a]:bg-surface [&_a]:text-on-surface-variant [&_span]:text-on-surface-variant [&_a]:border-white/10 [&_span]:border-white/10">{{ $winners->links() }}</div>
                </div>
            </div>
        </div>
    </main>

    <nav class="lg:hidden fixed bottom-0 w-full bg-surface-container-lowest/80 backdrop-blur-xl border-t border-white/10 z-50 px-4 py-2 flex justify-around">
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('live-draw') }}"><span class="material-symbols-outlined mb-1">bolt</span><span class="font-label text-[10px]">Live Draw</span></a>
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('dashboard') }}"><span class="material-symbols-outlined mb-1">dashboard</span><span class="font-label text-[10px]">Dashboard</span></a>
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('prizes.index') }}"><span class="material-symbols-outlined mb-1">card_giftcard</span><span class="font-label text-[10px]">Hadiah</span></a>
        <a class="flex flex-col items-center p-2 text-secondary" href="{{ route('winners') }}"><span class="material-symbols-outlined mb-1" style="font-variation-settings: 'FILL' 1;">history</span><span class="font-label text-[10px] font-bold">Winners</span></a>
    </nav>
</body>
</html>
