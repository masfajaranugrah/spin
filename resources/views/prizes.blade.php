<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Kelola Hadiah - NeonDraw</title>
    <script src="{{ asset('tailwind-play-cdn.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { 'secondary-container': '#cf5cff', 'primary-container': '#00f0ff', background: '#0d1515', surface: '#0d1515', primary: '#dbfcff', secondary: '#ecb2ff', 'surface-container-lowest': '#080f10', 'surface-container-low': '#151d1e', 'surface-container': '#192122', 'surface-container-highest': '#2e3637', 'on-surface': '#dce4e5', 'on-surface-variant': '#b9cacb', error: '#ffb4ab', 'error-container': '#93000a' }, fontFamily: { headline: ['Sora'], body: ['Plus Jakarta Sans'], label: ['JetBrains Mono'] } } } }
    </script>
    <style>
        body { background-color: #0A0A0F; background-image: radial-gradient(circle at 20% 10%, rgba(0,240,255,.11), transparent 28%), radial-gradient(circle at 85% 45%, rgba(207,92,255,.11), transparent 30%); background-attachment: fixed; color: #dce4e5; }
        .glass-card { background: rgba(21,29,30,.58); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,.1); }
        .tech-border { border: 1px solid rgba(75,92,93,.4); position: relative; }
        .tech-border::before, .tech-border::after { content: ''; position: absolute; width: 8px; height: 8px; border-color: #00f0ff; opacity: .6; }
        .glass-input { background: #ffffff; border: none; border-bottom: 2px solid #3b82f6; color: #111827; }
        .glass-input::placeholder { color: #6b7280; opacity: 1; }
        .glass-input:focus { outline: none; border-bottom-color: #00f0ff; box-shadow: 0 8px 22px -10px rgba(0,240,255,.45); background: #ffffff; color: #111827; }
        .glass-input:-webkit-autofill { -webkit-text-fill-color: #111827; box-shadow: 0 0 0 1000px #ffffff inset; }
    </style>
</head>
<body class="font-body min-h-screen flex antialiased">
    <header class="lg:hidden fixed top-0 left-0 w-full z-50 flex justify-between items-center px-4 h-16 bg-surface/40 backdrop-blur-xl border-b border-white/10">
        <div class="font-headline text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary-container">NEON DRAW</div>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="text-on-surface-variant hover:text-error"><span class="material-symbols-outlined">logout</span></button></form>
    </header>

    @include('partials.sidebar')

    <main class="flex-1 lg:ml-72 pt-24 lg:pt-10 px-5 lg:px-10 pb-24 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 mb-10">
                <div>
                    <h1 class="font-headline text-4xl text-primary mb-2">Kelola Hadiah</h1>
                    <p class="text-on-surface-variant">Hadiah di halaman Live Draw akan otomatis diambil dari daftar ini.</p>
                </div>
                <a class="inline-flex items-center justify-center gap-3 px-7 py-4 bg-primary-container text-[#00363a] font-bold rounded-xl shadow-[0_0_28px_rgba(0,240,255,0.28)] hover:scale-105 transition-all" href="{{ route('live-draw') }}"><span class="material-symbols-outlined">play_arrow</span>BUKA LIVE DRAW</a>
            </div>

            @if (session('status'))
                <div class="mb-5 rounded-xl border border-primary-container/30 bg-primary-container/10 px-4 py-3 text-primary">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-error/30 bg-error-container/20 px-4 py-3 text-error">{{ $errors->first() }}</div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
                <section class="xl:col-span-4 space-y-8">
                    <div class="glass-card p-6 rounded-2xl relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-container to-secondary-container"></div>
                        <h2 class="font-headline text-xl text-on-surface mb-6 flex items-center gap-2"><span class="material-symbols-outlined text-primary-container">add_box</span>Tambah Hadiah Baru</h2>
                        <form class="space-y-5" method="POST" action="{{ route('prizes.store') }}">
                            @csrf
                            <div><label class="block text-xs font-label text-primary uppercase tracking-widest mb-2">Nama Hadiah</label><input class="glass-input w-full px-4 py-3 rounded-t-lg" name="name" placeholder="Contoh: Tiket ke Bromo" required type="text" value="{{ old('name') }}"></div>
                            <div><label class="block text-xs font-label text-primary uppercase tracking-widest mb-2">Kategori</label><input class="glass-input w-full px-4 py-3 rounded-t-lg" name="category" placeholder="Travel, Elektronik, Voucher" required type="text" value="{{ old('category') }}"></div>
                            <div><label class="block text-xs font-label text-primary uppercase tracking-widest mb-2">Kuota Pemenang</label><input class="glass-input w-full px-4 py-3 rounded-t-lg" min="1" name="quota" required type="number" value="{{ old('quota', 1) }}"></div>
                            <div><label class="block text-xs font-label text-primary uppercase tracking-widest mb-2">Prioritas Urutan</label><input class="glass-input w-full px-4 py-3 rounded-t-lg" min="0" name="priority" placeholder="Kosongkan untuk urutan terakhir" type="number" value="{{ old('priority') }}"></div>
                            <div><label class="block text-xs font-label text-primary uppercase tracking-widest mb-2">URL Gambar</label><input class="glass-input w-full px-4 py-3 rounded-t-lg" name="image_url" placeholder="Opsional" type="url" value="{{ old('image_url') }}"></div>
                            <button class="w-full py-4 bg-white/5 border border-white/10 rounded-xl font-bold text-on-surface hover:bg-white/10 hover:border-primary-container/50 transition-all active:scale-95" type="submit">SIMPAN HADIAH</button>
                        </form>
                    </div>

                    <div class="glass-card p-6 rounded-2xl border-secondary-container/20">
                        <h3 class="font-headline text-xl text-secondary mb-3">Rotasi Otomatis</h3>
                        <p class="text-sm text-on-surface-variant mb-4">Ketika stok hadiah habis, sistem otomatis memakai hadiah berikutnya berdasarkan prioritas urutan.</p>
                        <div class="flex items-center gap-3 p-3 bg-secondary-container/10 border border-secondary-container/20 rounded-lg"><span class="material-symbols-outlined text-secondary">info</span><span class="text-xs font-label text-secondary uppercase">Strategi aktif: habiskan berurutan</span></div>
                    </div>
                </section>

                <section class="xl:col-span-8 glass-card rounded-2xl overflow-hidden">
                    <div class="p-6 border-b border-white/10 flex items-center justify-between bg-white/5">
                        <h2 class="font-headline text-xl text-on-surface">Inventaris Hadiah</h2>
                        <div class="flex items-center gap-2 px-3 py-1 bg-surface-container-highest rounded-full"><div class="w-2 h-2 rounded-full bg-primary-container animate-pulse"></div><span class="text-[10px] font-label uppercase tracking-widest text-on-surface-variant">{{ $configuredPrizes }} Hadiah</span></div>
                    </div>
                    <div class="divide-y divide-white/5">
                        @forelse ($prizes as $prize)
                            <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-white/[0.03] transition-colors">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden glass-card p-1 {{ $prize->remaining === 0 ? 'opacity-60' : '' }}">
                                        @if ($prize->image_url)
                                            <img class="w-full h-full object-cover rounded-lg {{ $prize->remaining === 0 ? 'grayscale' : '' }}" src="{{ $prize->image_url }}" alt="{{ $prize->name }}">
                                        @else
                                            <div class="w-full h-full rounded-lg bg-gradient-to-br from-primary-container/20 to-secondary-container/25 flex items-center justify-center"><span class="material-symbols-outlined text-primary-container text-3xl">card_giftcard</span></div>
                                        @endif
                                    </div>
                                    <div class="{{ $prize->remaining === 0 ? 'opacity-60' : '' }}">
                                        <h3 class="font-headline text-on-surface">{{ $prize->name }}</h3>
                                        <p class="text-xs font-label text-primary uppercase tracking-widest mt-1">{{ $prize->category }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-wrap items-center gap-5">
                                    <div class="text-center px-4 {{ $prize->remaining === 0 ? 'opacity-60' : '' }}"><p class="text-[10px] font-label text-on-surface-variant uppercase tracking-widest mb-1">Sisa</p><p class="text-xl text-secondary font-bold">{{ $prize->remaining }} <span class="text-on-surface-variant text-sm font-normal">/ {{ $prize->quota }}</span></p></div>
                                    <div class="text-center px-4"><p class="text-[10px] font-label text-on-surface-variant uppercase tracking-widest mb-1">Prioritas</p><p class="text-sm text-on-surface font-label">{{ $prize->priority }}</p></div>
                                    <div class="px-4 py-2 rounded-lg {{ $prize->remaining > 0 ? 'bg-primary-container/10 border-primary-container/20' : 'bg-error-container/20 border-error-container/30' }} border"><span class="text-xs font-label uppercase font-bold {{ $prize->remaining > 0 ? 'text-primary' : 'text-error' }}">{{ $prize->remaining > 0 ? 'Tersedia' : 'Habis' }}</span></div>
                                    <form method="POST" action="{{ route('prizes.destroy', $prize) }}" onsubmit="return confirm('Hapus hadiah ini?')">@csrf @method('DELETE')<button class="p-2 rounded-lg bg-surface-container-highest hover:bg-white/10 transition-all text-on-surface-variant hover:text-error"><span class="material-symbols-outlined text-sm">delete</span></button></form>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-on-surface-variant">Belum ada hadiah. Tambahkan hadiah pertama agar Live Draw bisa dijalankan.</div>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </main>

    <nav class="lg:hidden fixed bottom-0 w-full bg-surface-container-lowest/80 backdrop-blur-xl border-t border-white/10 z-50 px-4 py-2 flex justify-around">
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('live-draw') }}"><span class="material-symbols-outlined mb-1">bolt</span><span class="font-label text-[10px]">Live Draw</span></a>
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('dashboard') }}"><span class="material-symbols-outlined mb-1">dashboard</span><span class="font-label text-[10px]">Dashboard</span></a>
        <a class="flex flex-col items-center p-2 text-secondary" href="{{ route('prizes.index') }}"><span class="material-symbols-outlined mb-1" style="font-variation-settings: 'FILL' 1;">card_giftcard</span><span class="font-label text-[10px] font-bold">Hadiah</span></a>
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('winners') }}"><span class="material-symbols-outlined mb-1">history</span><span class="font-label text-[10px]">Winners</span></a>
    </nav>
</body>
</html>
