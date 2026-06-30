<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NeonDraw - Live Draw</title>
    <script data-cfasync="false" src="{{ asset('tailwind-play-cdn.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@400;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'secondary-container': '#cf5cff',
                        'primary-container': '#00f0ff',
                        background: '#080b0c',
                        surface: '#0d1515',
                        'surface-container-lowest': '#080f10',
                        'surface-container-low': '#151d1e',
                        'surface-container': '#192122',
                        'surface-container-highest': '#2e3637',
                        'surface-variant': '#2e3637',
                        primary: '#dbfcff',
                        secondary: '#ecb2ff',
                        error: '#ffb4ab',
                        'on-surface': '#dce4e5',
                        'on-surface-variant': '#b9cacb',
                    },
                    borderRadius: { DEFAULT: '0.125rem', lg: '0.375rem', xl: '0.5rem', full: '9999px' },
                    spacing: { 'grid-gap': '16px', 'container-padding-desktop': '40px', 'container-padding-mobile': '20px' },
                    fontFamily: {
                        'headline-lg': ['Sora'],
                        'headline-lg-mobile': ['Sora'],
                        'body-md': ['Plus Jakarta Sans'],
                        'label-sm': ['JetBrains Mono'],
                    },
                },
            },
        }
    </script>
    <style>
        body {
            background-color: #080b0c;
            background-image: linear-gradient(rgba(255,255,255,.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.02) 1px, transparent 1px);
            background-size: 40px 40px;
            background-attachment: fixed;
            color: #dce4e5;
        }
        .noise-bg { background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E"); opacity: .03; }
        .glass-card-refined { background: rgba(13,21,21,.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: .5px solid rgba(255,255,255,.08); box-shadow: 0 4px 24px -1px rgba(0,0,0,.6); }
        .tech-btn { position: relative; clip-path: polygon(8px 0%, 100% 0%, 100% calc(100% - 8px), calc(100% - 8px) 100%, 0% 100%, 0% 8px); background: linear-gradient(90deg, #00dbe9 0%, #00f0ff 100%); transition: all .2s cubic-bezier(.4,0,.2,1); }
        .tech-btn:hover:not(:disabled) { filter: brightness(1.2); letter-spacing: .05em; }
        .tech-btn:disabled { opacity: .45; cursor: not-allowed; }
        .entry-chip { position: absolute; transition: all .25s ease-out; opacity: .22; filter: blur(.5px); font-family: 'JetBrains Mono', monospace; font-size: 10px; letter-spacing: .05em; color: #b9cacb; }
        .entry-chip.drawing { opacity: 1; filter: blur(0); color: #00f0ff; text-shadow: 0 0 5px rgba(0,240,255,.5); transform: scale(1.2) translateX(4px); z-index: 50; }
        .draw-focus .entry-chip { opacity: .42; filter: blur(0); font-size: 13px; }
        .draw-focus .entry-chip.drawing { opacity: 1; font-size: 22px; text-shadow: 0 0 10px rgba(0,240,255,.8), 0 0 28px rgba(207,92,255,.65); transform: scale(1.35); }
        .fade-out-focus { opacity: 0 !important; transform: scale(.96) !important; pointer-events: none !important; }
        .grid-mask { mask-image: none; -webkit-mask-image: none; }
        .scanning-line { position: absolute; width: 100%; height: 1px; background: linear-gradient(90deg, transparent, #00f0ff, transparent); top: 0; left: 0; animation: scan 4s linear infinite; opacity: .3; }
        @keyframes scan { 0% { top: 0%; } 100% { top: 100%; } }
        .tech-border { border: 1px solid rgba(0,240,255,.15); position: relative; }
        .tech-border::before { content: ''; position: absolute; top: -1px; left: -1px; width: 4px; height: 4px; border-top: 1px solid #00f0ff; border-left: 1px solid #00f0ff; }
        .tech-border::after { content: ''; position: absolute; bottom: -1px; right: -1px; width: 4px; height: 4px; border-bottom: 1px solid #00f0ff; border-right: 1px solid #00f0ff; }
        .winner-card { animation: cardPop .45s cubic-bezier(.34,1.56,.64,1) forwards; }
        @keyframes cardPop { from { transform: scale(.9) translateY(18px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }
    </style>
</head>
<body class="font-body-md min-h-screen flex overflow-x-hidden">
    <div class="fixed inset-0 noise-bg pointer-events-none z-0"></div>

    @include('partials.sidebar')

    <main class="flex-1 w-full lg:ml-72 pt-8 lg:pt-10 px-container-padding-mobile lg:px-12 pb-24 lg:pb-8 relative flex flex-col h-screen overflow-hidden z-10">
        <div class="flex justify-between items-start mb-12 z-20 transition-all duration-500" id="topStatusPanel">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
                    <h2 class="font-label-sm text-primary tracking-[0.2em] font-bold uppercase">Protokol Undian Aktif</h2>
                </div>
                <h1 class="font-headline-lg-mobile md:text-4xl text-white font-extrabold tracking-tight uppercase">{{ $currentPrize?->name ?? 'Belum Ada Hadiah' }}</h1>
                <div class="flex flex-wrap gap-4 mt-2 font-label-sm text-[10px] text-on-surface-variant uppercase tracking-widest">
                    <span>ID: DRAW_{{ now()->format('His') }}</span>
                    <span class="opacity-30">/</span>
                    <span>Registry: {{ number_format($totalParticipants) }} Peserta</span>
                    <span class="opacity-30">/</span>
                    <span>Stok: {{ $currentPrize ? $currentPrize->remaining.' / '.$currentPrize->quota : '0 / 0' }}</span>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-6">
                <div class="flex flex-col items-end">
                    <span class="font-label-sm text-[10px] text-on-surface-variant uppercase mb-1">Stabilitas Sistem</span>
                    <div class="flex gap-0.5"><div class="w-1 h-3 bg-primary"></div><div class="w-1 h-3 bg-primary"></div><div class="w-1 h-3 bg-primary"></div><div class="w-1 h-3 bg-primary/30"></div></div>
                </div>
                <div class="tech-border glass-card-refined px-4 py-2 flex flex-col">
                    <span class="font-label-sm text-[10px] text-primary/60 uppercase">Status</span>
                    <span class="font-label-sm text-primary font-bold">{{ $totalParticipants > 0 && $currentPrize ? 'SIAP' : 'BELUM SIAP' }}</span>
                </div>
            </div>
        </div>

        <div class="flex-1 relative w-full h-full flex flex-col lg:flex-row items-center justify-between min-h-[450px]">
            <div class="hidden lg:flex flex-col gap-4 w-48 z-20 transition-all duration-500" id="leftDataPanel">
                <div class="glass-card-refined p-3 border-l-2 border-primary">
                    <div class="font-label-sm text-[9px] text-on-surface-variant uppercase mb-2">Buffer Peserta</div>
                    <div class="space-y-1 opacity-60"><div class="h-1 bg-white/5 w-full"></div><div class="h-1 bg-white/5 w-3/4"></div><div class="h-1 bg-white/5 w-5/6"></div><div class="h-1 bg-white/5 w-1/2"></div></div>
                </div>
                <div class="glass-card-refined p-3">
                    <div class="font-label-sm text-[9px] text-on-surface-variant uppercase mb-2">Kesiapan</div>
                    <div class="text-lg font-bold text-primary font-label-sm">{{ $totalParticipants > 0 && $currentPrize ? '100%' : '0%' }}</div>
                </div>
            </div>

            <div class="relative z-30 flex flex-col items-center justify-center w-full max-w-xl mx-auto" id="prizeDisplay">
                <div class="tech-border glass-card-refined p-0.5 w-full shadow-[0_0_60px_-15px_rgba(0,240,255,0.15)]">
                    <div class="bg-surface-container-lowest/40 p-8 md:p-12 text-center relative overflow-hidden">
                        <div class="scanning-line"></div>
                        <div class="relative w-28 h-28 md:w-32 md:h-32 mx-auto mb-8">
                            <div class="absolute inset-0 border border-primary/20 rotate-45 scale-110"></div>
                            <div class="absolute inset-0 border border-secondary/20 -rotate-12"></div>
                            <div class="w-full h-full bg-surface-variant/30 flex items-center justify-center border border-primary/30 backdrop-blur-sm">
                                <span class="material-symbols-outlined text-5xl text-primary drop-shadow-[0_0_15px_rgba(0,240,255,0.6)]">card_giftcard</span>
                            </div>
                        </div>
                        <div class="mb-8">
                            <h3 class="font-label-sm text-xs text-on-surface-variant uppercase tracking-[0.3em] mb-2">Hadiah Saat Ini</h3>
                            <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tighter uppercase">{{ $currentPrize?->name ?? 'Tambahkan Hadiah Dulu' }}</h2>
                            <p class="mt-3 text-sm text-on-surface-variant">{{ $currentPrize ? $currentPrize->category : 'Buka menu Hadiah untuk mengatur stok.' }}</p>
                        </div>
                        <div class="flex flex-col gap-3 max-w-xs mx-auto">
                            <button class="tech-btn w-full py-4 text-background font-bold font-label-sm uppercase tracking-widest text-sm hover:scale-[1.02]" id="startDrawBtn" @disabled($totalParticipants === 0 || ! $currentPrize)>
                                <span id="drawBtnText">Mulai Undian</span>
                            </button>
                            <div class="flex justify-between font-label-sm text-[9px] text-on-surface-variant/50 px-2 uppercase">
                                <span>Validasi: ON</span>
                                <span>Prize_DB: {{ $currentPrize ? 'READY' : 'EMPTY' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden lg:flex flex-col gap-4 w-48 z-20 items-end transition-all duration-500" id="rightDataPanel">
                <div class="text-right"><div class="font-label-sm text-[10px] text-on-surface-variant uppercase">Waktu Lokal</div><div class="font-label-sm text-lg text-white" id="clock">00:00:00</div></div>
                <div class="glass-card-refined p-4 w-full">
                    <div class="font-label-sm text-[9px] text-on-surface-variant uppercase mb-3 text-right">Log Sistem</div>
                    <div class="font-label-sm text-[9px] text-primary/50 text-right space-y-1"><p>&gt; peserta_loaded</p><p>&gt; hadiah_loaded</p><p>&gt; siap_diundi</p></div>
                </div>
            </div>

            <div class="absolute inset-0 grid-mask z-10 overflow-hidden pointer-events-none" id="scatterContainer"></div>
        </div>
    </main>

    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-background/90 backdrop-blur-xl hidden" id="winnerOverlay">
        <div class="winner-card relative glass-card-refined p-0.5 w-full max-w-lg mx-4 tech-border">
            <div class="bg-surface-container-lowest p-8 md:p-12 text-center relative overflow-hidden">
                <div class="absolute top-4 left-4 font-label-sm text-[9px] text-primary/40">WINNER_VALIDATED</div>
                <div class="absolute top-4 right-4 font-label-sm text-[9px] text-primary/40">GEN_PROTO_X</div>
                <div class="mb-8">
                    <span class="material-symbols-outlined text-6xl text-primary mb-4">verified</span>
                    <h2 class="font-label-sm text-xs text-primary tracking-[0.4em] uppercase mb-1">Pemenang Ditemukan</h2>
                    <div class="w-24 h-0.5 bg-primary/30 mx-auto mb-6"></div>
                    <h1 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase mb-4" id="winnerNameDisplay">-</h1>
                    <p class="font-label-sm text-xs text-on-surface-variant uppercase tracking-widest" id="winnerPhoneDisplay"></p>
                    <p class="mt-2 text-xs text-on-surface-variant" id="winnerAddressDisplay"></p>
                    <div class="mt-6 p-4 border border-primary/15 bg-primary/5">
                        <p class="text-xs text-on-surface-variant mb-1">Mendapatkan hadiah</p>
                        <p class="font-bold text-primary" id="winnerPrizeDisplay">{{ $currentPrize?->name ?? '-' }}</p>
                    </div>
                </div>
                <button class="tech-btn w-full py-5 text-background font-black font-label-sm uppercase tracking-[0.2em]" onclick="resetDraw()">Tutup & Simpan Hasil</button>
            </div>
        </div>
    </div>

    <nav class="lg:hidden fixed bottom-0 w-full bg-surface-container-lowest/90 backdrop-blur-xl border-t border-white/10 z-50 px-4 py-2 flex justify-around">
        <a class="flex flex-col items-center p-2 text-primary" href="{{ route('live-draw') }}"><span class="material-symbols-outlined mb-1">terminal</span><span class="font-label-sm text-[10px] font-bold">Live</span></a>
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('dashboard') }}"><span class="material-symbols-outlined mb-1">grid_view</span><span class="font-label-sm text-[10px]">Dashboard</span></a>
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('prizes.index') }}"><span class="material-symbols-outlined mb-1">database</span><span class="font-label-sm text-[10px]">Hadiah</span></a>
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('winners') }}"><span class="material-symbols-outlined mb-1">history</span><span class="font-label-sm text-[10px]">Winners</span></a>
    </nav>

    <script>
        const participants = @json($participants);
        const scatterContainer = document.getElementById('scatterContainer');
        const startBtn = document.getElementById('startDrawBtn');
        const winnerOverlay = document.getElementById('winnerOverlay');
        const winnerNameDisplay = document.getElementById('winnerNameDisplay');
        const winnerPhoneDisplay = document.getElementById('winnerPhoneDisplay');
        const winnerAddressDisplay = document.getElementById('winnerAddressDisplay');
        const winnerPrizeDisplay = document.getElementById('winnerPrizeDisplay');
        const drawBtnText = document.getElementById('drawBtnText');
        const prizeDisplay = document.getElementById('prizeDisplay');
        const topStatusPanel = document.getElementById('topStatusPanel');
        const leftDataPanel = document.getElementById('leftDataPanel');
        const rightDataPanel = document.getElementById('rightDataPanel');
        let isDrawing = false;
        let chips = [];

        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            const clock = document.getElementById('clock');
            if (clock) clock.textContent = `${h}:${m}:${s}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        function randomParticipant() {
            return participants[Math.floor(Math.random() * participants.length)];
        }

        function initNames() {
            scatterContainer.innerHTML = '';
            chips = [];
            const count = Math.min(Math.max(participants.length * 5, 140), 260);
            for (let i = 0; i < count; i++) {
                if (!participants.length) break;
                const p = randomParticipant();
                const chip = document.createElement('div');
                chip.className = 'entry-chip';
                chip.textContent = p.name;
                chip.dataset.participant = JSON.stringify(p);
                chip.style.top = `${Math.random() * 96 + 2}%`;
                chip.style.left = `${Math.random() * 96 + 2}%`;
                scatterContainer.appendChild(chip);
                chips.push(chip);
            }
        }

        // Setiap interval, acak ulang nama di semua chip agar semua peserta punya giliran tampil
        let shuffleInterval = null;
        function startChipShuffle() {
            shuffleInterval = setInterval(() => {
                if (isDrawing) return;
                chips.forEach(chip => {
                    const p = randomParticipant();
                    chip.textContent = p.name;
                    chip.dataset.participant = JSON.stringify(p);
                });
            }, 1200);
        }

        startBtn.addEventListener('click', () => {
            if (isDrawing || !participants.length) return;
            isDrawing = true;
            if (shuffleInterval) { clearInterval(shuffleInterval); shuffleInterval = null; }
            drawBtnText.textContent = 'Memindai...';
            startBtn.classList.add('opacity-50');
            scatterContainer.classList.add('draw-focus');
            scatterContainer.classList.add('!fixed', '!inset-0', '!z-50', '!overflow-hidden');
            topStatusPanel.classList.add('fade-out-focus');
            leftDataPanel.classList.add('fade-out-focus');
            rightDataPanel.classList.add('fade-out-focus');
            prizeDisplay.style.transition = 'all .6s cubic-bezier(.4,0,.2,1)';
            prizeDisplay.style.opacity = '0';
            prizeDisplay.style.transform = 'scale(.9)';
            prizeDisplay.style.pointerEvents = 'none';

            // Pilih pemenang nyata dari SEMUA peserta
            const actualWinner = participants[Math.floor(Math.random() * participants.length)];

            // Buat urutan: semua peserta diacak, lalu ditambah flash tambahan di akhir
            const shuffled = [...participants].sort(() => Math.random() - 0.5);
            const extraFlashes = 30;
            const totalFlashes = shuffled.length + extraFlashes;
            let speed = 30;
            let flashes = 0;
            let selectedChip = chips[0];

            function runFlash() {
                if (!chips.length) { saveWinner(actualWinner); return; }
                chips.forEach((chip) => chip.classList.remove('drawing'));
                selectedChip = chips[Math.floor(Math.random() * chips.length)];

                // Fase 1: cycling semua peserta satu per satu
                // Fase 2: flash acak melambat menuju pemenang
                if (flashes < shuffled.length) {
                    const p = shuffled[flashes];
                    selectedChip.textContent = p.name;
                    selectedChip.dataset.participant = JSON.stringify(p);
                } else if (flashes === totalFlashes - 1) {
                    selectedChip.textContent = actualWinner.name;
                    selectedChip.dataset.participant = JSON.stringify(actualWinner);
                    selectedChip.style.top = '50%';
                    selectedChip.style.left = '50%';
                    selectedChip.style.transform = 'translate(-50%, -50%)';
                } else {
                    const p = randomParticipant();
                    selectedChip.textContent = p.name;
                    selectedChip.dataset.participant = JSON.stringify(p);
                }

                selectedChip.classList.add('drawing');
                flashes++;

                if (flashes < totalFlashes) {
                    // Fase 1 cepat (cycling semua peserta), fase 2 melambat
                    if (flashes < shuffled.length) {
                        speed = participants.length > 200 ? 8 : participants.length > 50 ? 20 : 60;
                    } else {
                        speed += 12;
                    }
                    setTimeout(runFlash, speed);
                } else {
                    saveWinner(actualWinner);
                }
            }
            runFlash();
        });

        async function saveWinner(participant) {
            const response = await fetch('{{ route('live-draw.winners.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ participant_id: participant.id }),
            });
            const data = await response.json();
            if (!response.ok) {
                alert(data.message || 'Gagal menyimpan pemenang.');
                resetDraw(false);
                return;
            }
            showWinner(data.winner);
        }

        function showWinner(winner) {
            winnerNameDisplay.textContent = winner.name;
            winnerPhoneDisplay.textContent = winner.phone_number;
            winnerAddressDisplay.textContent = winner.address;
            winnerPrizeDisplay.textContent = winner.prize_name;
            setTimeout(() => winnerOverlay.classList.remove('hidden'), 800);
        }

        function resetDraw(reload = true) {
            winnerOverlay.classList.add('hidden');
            isDrawing = false;
            drawBtnText.textContent = 'Mulai Undian';
            startBtn.classList.remove('opacity-50');
            scatterContainer.classList.remove('draw-focus');
            topStatusPanel.classList.remove('fade-out-focus');
            leftDataPanel.classList.remove('fade-out-focus');
            rightDataPanel.classList.remove('fade-out-focus');
            prizeDisplay.style.opacity = '1';
            prizeDisplay.style.transform = 'scale(1) translateX(0)';
            prizeDisplay.style.pointerEvents = '';
            chips.forEach((chip) => chip.classList.remove('drawing'));
            initNames();
            if (!reload) startChipShuffle();
            if (reload) window.location.reload();
        }

        initNames();
        startChipShuffle();
    </script>
</body>
</html>
