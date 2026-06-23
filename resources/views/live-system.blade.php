<!DOCTYPE html>
<html class="dark" lang="id">
<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>NeonDraw - Live Draw Professional</title>
<script src="{{ asset('tailwind-play-cdn.js') }}"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@400;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "secondary-container": "#cf5cff", "tertiary": "#faf3ff", "tertiary-fixed-dim": "#d1bcff",
                    "outline-variant": "#3b494b", "primary-container": "#00f0ff", "on-primary-container": "#006970",
                    "background": "#080b0c", "on-secondary": "#520071", "inverse-primary": "#006970",
                    "on-secondary-container": "#480063", "error-container": "#93000a", "surface": "#0d1515",
                    "surface-dim": "#0d1515", "on-background": "#dce4e5", "primary-fixed": "#7df4ff",
                    "surface-container-highest": "#2e3637", "surface-container-low": "#151d1e",
                    "surface-container-high": "#232b2c", "primary": "#dbfcff", "tertiary-container": "#e1d2ff",
                    "on-surface": "#dce4e5", "on-error": "#690005", "surface-container": "#192122",
                    "on-primary-fixed-variant": "#004f54", "on-tertiary-fixed": "#23005b",
                    "secondary-fixed-dim": "#ecb2ff", "tertiary-fixed": "#e9ddff", "surface-bright": "#333b3b",
                    "on-tertiary-container": "#7213ff", "surface-variant": "#2e3637", "inverse-surface": "#dce4e5",
                    "primary-fixed-dim": "#00dbe9", "surface-container-lowest": "#080f10", "secondary": "#ecb2ff",
                    "outline": "#849495", "on-tertiary": "#3c0090", "on-primary": "#00363a",
                    "inverse-on-surface": "#2a3233", "on-tertiary-fixed-variant": "#5700c9",
                    "secondary-fixed": "#f8d8ff", "on-error-container": "#ffdad6",
                    "on-secondary-fixed-variant": "#74009f", "on-primary-fixed": "#002022",
                    "surface-tint": "#00dbe9", "error": "#ffb4ab", "on-secondary-fixed": "#320047",
                    "on-surface-variant": "#b9cacb"
                },
                borderRadius: { DEFAULT: "0.125rem", lg: "0.375rem", xl: "0.5rem", full: "9999px" },
                spacing: { "grid-gap": "16px", "base-unit": "8px", "container-padding-desktop": "40px", "entry-card-width": "120px", "container-padding-mobile": "20px" },
                fontFamily: { "headline-lg": ["Sora"], "display-xl": ["Sora"], "display-xl-mobile": ["Sora"], "body-md": ["Plus Jakarta Sans"], "label-sm": ["JetBrains Mono"] },
                fontSize: {
                    "headline-lg": ["32px", { lineHeight: "1.2", fontWeight: "700" }],
                    "display-xl-mobile": ["40px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "800" }],
                    "display-xl": ["64px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "800" }],
                    "body-md": ["16px", { lineHeight: "1.6", fontWeight: "400" }],
                    "label-sm": ["11px", { lineHeight: "1.0", letterSpacing: "0.1em", fontWeight: "500" }]
                }
            }
        }
    }
</script>
<style>
    body {
        background-color: #080b0c;
        background-image: linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);
        background-size: 40px 40px;
        background-attachment: fixed;
        color: #dce4e5;
    }
    .noise-bg {
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        opacity: .03;
    }
    .glass-card-refined {
        background: rgba(13,21,21,.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: .5px solid rgba(255,255,255,.08);
        box-shadow: 0 4px 24px -1px rgba(0,0,0,.6);
    }
    .tech-btn {
        position: relative;
        clip-path: polygon(8px 0%,100% 0%,100% calc(100% - 8px),calc(100% - 8px) 100%,0% 100%,0% 8px);
        background: linear-gradient(90deg,#00dbe9 0%,#00f0ff 100%);
        transition: all .2s cubic-bezier(.4,0,.2,1);
    }
    .tech-btn:hover { filter: brightness(1.2); letter-spacing: .05em; }
    .entry-chip {
        position: absolute;
        transition: all .25s ease-out;
        opacity: .2;
        filter: blur(.5px);
        font-family: 'JetBrains Mono', monospace;
        font-size: 10px;
        letter-spacing: .05em;
    }
    .entry-chip.drawing {
        opacity: 1;
        filter: blur(0);
        color: #00f0ff;
        text-shadow: 0 0 5px rgba(0,240,255,.5);
        transform: scale(1.2) translateX(4px);
        z-index: 50;
    }
    .grid-mask {
        mask-image: radial-gradient(circle at 50% 50%,black 20%,transparent 85%);
        -webkit-mask-image: radial-gradient(circle at 50% 50%,black 20%,transparent 85%);
    }
    .scanning-line {
        position: absolute;
        width: 100%;
        height: 1px;
        background: linear-gradient(90deg,transparent,#00f0ff,transparent);
        top: 0;
        left: 0;
        animation: scan 4s linear infinite;
        opacity: .3;
    }
    @keyframes scan { 0% { top: 0% } 100% { top: 100% } }
    .tech-border { border: 1px solid rgba(0,240,255,.15); position: relative; }
    .tech-border::before {
        content: '';
        position: absolute;
        top: -1px; left: -1px;
        width: 4px; height: 4px;
        border-top: 1px solid #00f0ff;
        border-left: 1px solid #00f0ff;
    }
    .tech-border::after {
        content: '';
        position: absolute;
        bottom: -1px; right: -1px;
        width: 4px; height: 4px;
        border-bottom: 1px solid #00f0ff;
        border-right: 1px solid #00f0ff;
    }

    /* Rain Draw Overlay */
    #drawOverlay {
        display: none;
        position: fixed;
        inset: 0;
        background: #000;
        z-index: 200;
        overflow: hidden;
    }
    #drawOverlay.active { display: block; }
    .rain-name {
        position: absolute;
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        color: #00f0ff;
        text-shadow: 0 0 12px rgba(0,240,255,.8), 0 0 30px rgba(0,240,255,.4);
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        animation: rainDrop var(--dur,.8s) ease-in forwards;
        top: var(--sy, -5%);
        left: var(--x, 50%);
        font-size: var(--fs, 2rem);
        transform: translateX(-50%);
    }
    @keyframes rainDrop {
        0%   { opacity: 0; transform: translateX(-50%) translateY(-20px); filter: blur(4px); }
        15%  { opacity: 1; transform: translateX(-50%) translateY(0);     filter: blur(0); }
        80%  { opacity: .85; }
        100% { opacity: 0; transform: translateX(-50%) translateY(160px); filter: blur(8px); }
    }
    #finalName {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 1rem;
        opacity: 0;
        transition: opacity .8s ease;
    }
    #finalName.visible { opacity: 1; }
</style>
</head>
<body class="font-body-md text-body-md min-h-screen flex overflow-x-hidden">
<div class="fixed inset-0 noise-bg pointer-events-none z-0"></div>

<!-- Top Branding Strip -->
<div class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-10 py-6 pointer-events-none">
    <div class="flex items-center gap-3 pointer-events-auto">
        <div class="w-10 h-10 rounded-lg bg-surface-variant p-0.5 border border-primary/20 overflow-hidden flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-xl">casino</span>
        </div>
        <div>
            <h1 class="font-label-sm text-sm text-primary font-bold tracking-tighter">NEONDRAW</h1>
            <span class="text-[9px] text-on-surface-variant/60 font-label-sm block -mt-1">SYSTEM_ACTIVE</span>
        </div>
        <div class="ml-4 pl-4 border-l border-white/10 hidden md:block">
            <span class="font-mono text-[9px] text-on-surface-variant/50 uppercase tracking-widest">by jernih multi komunikasi</span>
        </div>
    </div>
    <div class="font-label-sm text-[10px] text-primary/40 uppercase tracking-widest pointer-events-auto">
        Nexus // Unit 04
    </div>
</div>

<!-- Main Content -->
<main class="flex-1 w-full pt-20 lg:pt-24 px-container-padding-mobile lg:px-20 pb-12 relative flex flex-col h-screen overflow-hidden z-10">

    <!-- Centered Header -->
    <div class="flex flex-col items-center text-center mb-16 z-20">
        <div class="flex items-center gap-3 mb-3">
            <span class="w-1.5 h-1.5 bg-primary rounded-full animate-pulse"></span>
            <h2 class="font-label-sm text-primary tracking-[0.3em] font-bold uppercase text-xs">Active Giveaway Protocol</h2>
        </div>
        @if($currentPrize)
            <h1 class="font-display-xl-mobile md:text-6xl text-white font-extrabold tracking-tight uppercase mb-4">{{ $currentPrize->name }}</h1>
        @else
            <h1 class="font-display-xl-mobile md:text-6xl text-white font-extrabold tracking-tight uppercase mb-4">No Prize Available</h1>
        @endif
        <div class="flex gap-6 font-label-sm text-[11px] text-on-surface-variant uppercase tracking-[0.2em]">
            <span>ID: DRAW_{{ str_pad($currentPrize?->id ?? 0, 4, '0', STR_PAD_LEFT) }}-X</span>
            <span class="opacity-30">/</span>
            <span>Registry: {{ $totalParticipants }} Entities</span>
        </div>
    </div>

    <!-- The Interface Stage -->
    <div class="flex-1 relative w-full flex flex-col lg:flex-row items-center justify-between gap-12 max-w-7xl mx-auto w-full">

        <!-- Left Data Panels -->
        <div class="hidden lg:flex flex-col gap-6 w-56 z-20 order-2 lg:order-1">
            <div class="glass-card-refined p-4 border-l-2 border-primary">
                <div class="font-label-sm text-[10px] text-on-surface-variant uppercase mb-3">Buffer Stream</div>
                <div class="space-y-1.5 opacity-60">
                    <div class="h-1 bg-white/5 w-full"></div>
                    <div class="h-1 bg-white/5 w-3/4"></div>
                    <div class="h-1 bg-white/5 w-5/6"></div>
                    <div class="h-1 bg-white/5 w-1/2"></div>
                    <div class="h-1 bg-white/5 w-2/3"></div>
                </div>
            </div>
            <div class="glass-card-refined p-4">
                <div class="font-label-sm text-[10px] text-on-surface-variant uppercase mb-2">Entropy Load</div>
                <div class="text-2xl font-bold text-primary font-label-sm" id="entropyVal">84.2%</div>
                <div class="w-full bg-white/5 h-1 mt-3">
                    <div class="bg-primary h-full" id="entropyBar" style="width:84.2%"></div>
                </div>
            </div>
        </div>

        <!-- Central Draw Module -->
        <div class="relative z-30 flex flex-col items-center justify-center flex-1 order-1 lg:order-2" id="prizeDisplay">
            <div class="tech-border glass-card-refined p-0.5 w-full max-w-lg shadow-[0_0_80px_-20px_rgba(0,240,255,0.2)]">
                <div class="bg-surface-container-lowest/40 p-12 text-center relative overflow-hidden">
                    <div class="scanning-line"></div>
                    <!-- Prize Icon -->
                    <div class="relative w-32 h-32 mx-auto mb-8">
                        <div class="absolute inset-0 border border-primary/20 rotate-45 scale-110"></div>
                        <div class="absolute inset-0 border border-secondary/20 -rotate-12"></div>
                        <div class="w-full h-full bg-surface-variant/30 flex items-center justify-center border-0.5 border-primary/30 backdrop-blur-sm">
                            @if($currentPrize?->image_url)
                                <img src="{{ $currentPrize->image_url }}" alt="{{ $currentPrize->name }}" class="w-20 h-20 object-cover">
                            @else
                                <span class="material-symbols-outlined text-5xl text-primary drop-shadow-[0_0_15px_rgba(0,240,255,0.6)]">memory</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-8">
                        <h3 class="font-label-sm text-xs text-on-surface-variant uppercase tracking-[0.3em] mb-2">Current Objective</h3>
                        <h2 class="text-3xl md:text-4xl font-bold text-white tracking-tighter uppercase">
                            {{ $currentPrize?->name ?? 'No Prize Available' }}
                        </h2>
                        @if($currentPrize)
                        <p class="font-label-sm text-[10px] text-on-surface-variant/50 mt-2 uppercase tracking-widest">
                            Remaining: {{ $currentPrize->remaining }} / {{ $currentPrize->quota }}
                        </p>
                        @endif
                    </div>
                    <div class="flex flex-col gap-4 max-w-sm mx-auto">
                        @if($currentPrize)
                        <button class="tech-btn w-full py-5 text-background font-bold font-label-sm uppercase tracking-[0.2em] text-sm hover:scale-[1.02]" id="startDrawBtn">
                            <span id="drawBtnText">Mulai</span>
                        </button>
                        @else
                        <div class="w-full py-5 text-center font-label-sm text-on-surface-variant/50 uppercase tracking-[0.2em] text-xs border border-white/10">
                            No Prize Configured
                        </div>
                        @endif
                        <div class="flex justify-between font-label-sm text-[10px] text-on-surface-variant/40 px-2 uppercase">
                            <span>Sec_Verify: ON</span>
                            <span>Build_ID: {{ $currentPrize?->id ?? '—' }}.1</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Data Panels -->
        <div class="hidden lg:flex flex-col gap-6 w-56 z-20 items-end order-3">
            <div class="text-right">
                <div class="font-label-sm text-[11px] text-on-surface-variant uppercase tracking-widest mb-1">Local Network Time</div>
                <div class="font-label-sm text-2xl text-white font-bold" id="clock">--:--:--</div>
            </div>
            <div class="glass-card-refined p-5 w-full">
                <div class="font-label-sm text-[10px] text-on-surface-variant uppercase mb-4 text-right">System_Logs.txt</div>
                <div class="font-label-sm text-[10px] text-primary/60 text-right space-y-2 font-mono" id="sysLogs">
                    <p>&gt; Connection stable</p>
                    <p>&gt; Syncing registry</p>
                    <p>&gt; Protocol v4.2.0</p>
                    <p>&gt; Waiting for command</p>
                </div>
            </div>
            <div class="flex flex-col items-end">
                <span class="font-label-sm text-[10px] text-on-surface-variant uppercase mb-2 tracking-widest">Network Stability</span>
                <div class="flex gap-1">
                    <div class="w-1.5 h-4 bg-primary"></div>
                    <div class="w-1.5 h-4 bg-primary"></div>
                    <div class="w-1.5 h-4 bg-primary"></div>
                    <div class="w-1.5 h-4 bg-primary/20"></div>
                </div>
            </div>
        </div>

        <!-- Scattered Names Area -->
        <div class="absolute inset-0 grid-mask z-10 overflow-hidden pointer-events-none" id="scatterContainer"></div>
    </div>

    <!-- Bottom Status Bar -->
    <div class="mt-auto flex justify-between items-center py-6 border-t border-white/5 z-20 font-label-sm text-[10px] uppercase tracking-[0.2em] text-on-surface-variant/50">
        <div class="flex gap-8">
            <span>Kernel: Optimized</span>
            <span class="hidden md:inline">Secure Layer: 7</span>
        </div>
        <div class="flex gap-8">
            <span class="hidden md:inline">Latency: 24ms</span>
            <span>Uptime: 99.9%</span>
        </div>
    </div>

    <!-- Error Toast -->
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[200] hidden" id="errorToast">
        <div class="glass-card-refined px-6 py-3 border border-error/30 font-label-sm text-[11px] text-error uppercase tracking-widest"></div>
    </div>
</main>

<!-- Rain Draw Fullscreen Overlay -->
<div id="drawOverlay">
    <div id="rainField"></div>
    <div id="countdown" style="display:none;position:absolute;inset:0;align-items:center;justify-content:center;font-family:'JetBrains Mono',monospace;font-weight:900;color:#fff;text-shadow:0 0 60px rgba(0,240,255,.8);transition:opacity .3s ease;"></div>
    <div id="finalName">
        <span class="font-label-sm text-[11px] tracking-[0.4em] uppercase" style="color:rgba(0,240,255,.5)">Winner Identified</span>
        <div id="finalNameText" style="font-family:'JetBrains Mono',monospace;font-size:clamp(2rem,6vw,5rem);font-weight:900;color:#fff;letter-spacing:-.02em;text-shadow:0 0 40px rgba(0,240,255,.6),0 0 80px rgba(0,240,255,.3)"></div>
        <div id="finalPrizeText" style="font-family:'JetBrains Mono',monospace;font-size:.85rem;color:rgba(0,240,255,.7);letter-spacing:.15em;text-transform:uppercase;margin-top:.25rem"></div>
    </div>
</div>

<script>
    const participants = @json($participants);
    const storeWinnerUrl = '{{ route('live-draw.winners.store') }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Clock
    function updateClock() {
        const el = document.getElementById('clock');
        if (el) el.textContent = new Date().toTimeString().slice(0,8);
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Scatter chips (idle background)
    const scatterContainer = document.getElementById('scatterContainer');
    let chips = [];

    function initNames() {
        scatterContainer.innerHTML = '';
        chips = [];
        if (!participants.length) return;
        for (let i = 0; i < 120; i++) {
            const p = participants[Math.floor(Math.random() * participants.length)];
            const chip = document.createElement('div');
            chip.className = 'entry-chip';
            chip.textContent = p.name.toUpperCase().replace(/\s+/g,'_').substring(0,16);
            chip.dataset.id = p.id;
            chip.dataset.name = p.name;
            chip.dataset.address = p.address || '';
            chip.style.top  = (Math.random()*85+7.5)+'%';
            chip.style.left = (Math.random()*90+5)+'%';
            scatterContainer.appendChild(chip);
            chips.push(chip);
        }
    }
    initNames();

    // — Rain Draw Logic —
    const overlay   = document.getElementById('drawOverlay');
    const rainField = document.getElementById('rainField');
    const finalName = document.getElementById('finalName');
    const finalNameText  = document.getElementById('finalNameText');
    const finalPrizeText = document.getElementById('finalPrizeText');
    const startBtn  = document.getElementById('startDrawBtn');

    let isDrawing = false;
    let rainInterval = null;
    let drawStart = 0;

    const SIZES = ['0.75rem','0.9rem','1.1rem','1.3rem','1.5rem'];

    function spawnDrop() {
        if (!participants.length) return;
        const p = participants[Math.floor(Math.random() * participants.length)];
        const el = document.createElement('div');
        el.className = 'rain-name';
        const x   = (Math.random()*96+2).toFixed(1)+'%';
        const sy  = (Math.random()*100).toFixed(1)+'%';
        const dur = (Math.random()*1.2+1.0).toFixed(2)+'s';
        const fs  = SIZES[Math.floor(Math.random()*SIZES.length)];
        el.style.cssText = `--x:${x};--sy:${sy};--dur:${dur};--fs:${fs};top:${sy};left:${x};font-size:${fs};animation-duration:${dur};`;
        el.textContent = p.name.toUpperCase().replace(/\s+/g,' ').substring(0,20);
        rainField.appendChild(el);
        el.addEventListener('animationend', () => el.remove());
    }

    function startRain() {
        overlay.classList.add('active');
        finalName.classList.remove('visible');
        rainField.innerHTML = '';

        // spawn drops fast — burst then steady
        let count = 0;
        const burst = setInterval(() => {
            for (let i = 0; i < 8; i++) spawnDrop();
            count++;
            if (count > 20) {
                clearInterval(burst);
                rainInterval = setInterval(() => {
                    for (let i = 0; i < 4; i++) spawnDrop();
                }, 80);
            }
        }, 40);

        // If winner data already came back, show after short rain
        // Otherwise wait for server then show
    }

    function stopRainAndShow(winner) {
        clearInterval(rainInterval);
        rainInterval = null;
        rainField.innerHTML = '';

        // Countdown 3 → 2 → 1 → tampilkan pemenang
        const cdEl = document.getElementById('countdown');
        cdEl.style.display = 'flex';
        cdEl.style.opacity = '1';
        let n = 3;
        cdEl.style.fontSize = 'clamp(6rem,20vw,14rem)';
        cdEl.textContent = n;

        const tick = setInterval(() => {
            n--;
            if (n > 0) {
                cdEl.textContent = n;
                cdEl.style.opacity = '0';
                setTimeout(() => { cdEl.style.opacity = '1'; }, 150);
            } else {
                clearInterval(tick);
                cdEl.style.opacity = '0';
                setTimeout(() => {
                    cdEl.style.display = 'none';
                    finalNameText.textContent = winner.name;
                    finalPrizeText.textContent = winner.prize_name ? '🏆 ' + winner.prize_name : '';
                    finalName.classList.add('visible');
                }, 400);
            }
        }, 1800);
    }

    if (startBtn) {
        startBtn.addEventListener('click', () => {
            if (isDrawing || !participants.length) return;
            isDrawing = true;
            startBtn.disabled = true;
            drawStart = Date.now();

            startRain();

            // Pick random participant client-side immediately
            const picked = participants[Math.floor(Math.random() * participants.length)];

            // Call server
            fetch(storeWinnerUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ participant_id: picked.id }),
            })
            .then(r => r.json())
            .then(data => {
                if (data.winner) {
                    // Rain must run at least 8s before showing winner
                    const elapsed = Date.now() - drawStart;
                    const delay = Math.max(0, 8000 - elapsed);
                    setTimeout(() => stopRainAndShow(data.winner), delay);
                } else {
                    clearInterval(rainInterval);
                    overlay.classList.remove('active');
                    isDrawing = false;
                    startBtn.disabled = false;
                    showError(data.message || 'Terjadi kesalahan.');
                }
            })
            .catch(() => {
                clearInterval(rainInterval);
                overlay.classList.remove('active');
                isDrawing = false;
                startBtn.disabled = false;
                showError('Gagal menghubungi server.');
            });
        });
    }

    // Click overlay after winner shown → reset
    overlay.addEventListener('click', () => {
        if (!finalName.classList.contains('visible')) return;
        overlay.classList.remove('active');
        finalName.classList.remove('visible');
        document.getElementById('countdown').style.display = 'none';
        isDrawing = false;
        if (startBtn) startBtn.disabled = false;
        initNames();
    });

    function showError(msg) {
        const toast = document.getElementById('errorToast');
        toast.querySelector('div').textContent = msg;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 4000);
    }
</script>
</body>
</html>
