<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard - NeonDraw | Kelola Peserta</title>
    <script src="{{ asset('tailwind-play-cdn.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'secondary-container': '#cf5cff', tertiary: '#faf3ff', 'tertiary-fixed-dim': '#d1bcff', 'outline-variant': '#3b494b', 'primary-container': '#00f0ff', 'on-primary-container': '#006970', background: '#080b0c', 'on-secondary': '#520071', 'error-container': '#93000a', surface: '#0d1515', 'on-background': '#dce4e5', 'primary-fixed': '#7df4ff', 'surface-container-highest': '#1c2425', 'surface-container-low': '#111819', 'surface-container-high': '#192122', primary: '#dbfcff', 'on-surface': '#dce4e5', 'surface-container': '#151d1e', 'surface-bright': '#232b2c', 'surface-variant': '#2e3637', 'primary-fixed-dim': '#00dbe9', 'surface-container-lowest': '#06090a', secondary: '#ecb2ff', outline: '#4b5c5d', error: '#ffb4ab', 'on-surface-variant': '#849495'
                    },
                    borderRadius: { DEFAULT: '0.125rem', lg: '0.25rem', xl: '0.5rem', full: '9999px' },
                    spacing: { 'grid-gap': '20px', 'container-padding-desktop': '48px', 'container-padding-mobile': '20px' },
                    fontFamily: { 'headline-lg': ['Sora'], 'headline-lg-mobile': ['Sora'], 'body-md': ['Plus Jakarta Sans'], 'label-sm': ['JetBrains Mono'] },
                    fontSize: { 'body-md': ['15px', { lineHeight: '1.6', fontWeight: '400' }], 'label-sm': ['11px', { lineHeight: '1.0', letterSpacing: '0.08em', fontWeight: '600' }] }
                }
            }
        }
    </script>
    <style>
        body { background-color: #06090a; background-image: linear-gradient(rgba(255,255,255,.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.02) 1px, transparent 1px); background-size: 40px 40px; color: #dce4e5; }
        .tech-border { border: 1px solid rgba(75,92,93,.4); position: relative; }
        .tech-border::before, .tech-border::after { content: ''; position: absolute; width: 8px; height: 8px; border-color: #00f0ff; opacity: .6; }
        .tech-corner-tl::before { top: -1px; left: -1px; border-top: 2px solid; border-left: 2px solid; }
        .tech-corner-br::after { bottom: -1px; right: -1px; border-bottom: 2px solid; border-right: 2px solid; }
        .glass-card { background: rgba(21,29,30,.7); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,.08); }
        .glass-input { background: rgba(6,9,10,.4); border: 1px solid rgba(132,148,149,.2); color: #dce4e5; transition: all .2s ease; }
        .glass-input::placeholder { color: #849495; opacity: 1; }
        .glass-input:focus { outline: none; border-color: #00f0ff; box-shadow: 0 0 0 1px rgba(0,240,255,.2); background: rgba(6,9,10,.6); color: #dce4e5; }
        .glass-input:-webkit-autofill { -webkit-text-fill-color: #dce4e5; box-shadow: 0 0 0 1000px #06090a inset; }
        .tech-button { background: #00f0ff; color: #002022; font-family: 'JetBrains Mono', monospace; text-transform: uppercase; letter-spacing: .1em; font-weight: 700; clip-path: polygon(0 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%); transition: all .2s ease; }
        .tech-button:hover { background: #7df4ff; transform: translateY(-1px); box-shadow: 0 4px 15px rgba(0,240,255,.4); }
        .data-row { transition: all .2s ease; border-bottom: 1px solid rgba(255,255,255,.03); }
        .data-row:hover { background: rgba(0,240,255,.03); }
        .status-badge { font-family: 'JetBrains Mono', monospace; font-size: 10px; padding: 2px 8px; border-radius: 2px; border: 1px solid currentColor; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,240,255,.2); border-radius: 2px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0,240,255,.4); }
    </style>
</head>
<body class="font-body-md text-body-md min-h-screen flex antialiased selection:bg-primary-container selection:text-on-primary-container">
    @include('partials.sidebar')

    <main class="flex-1 lg:ml-72 min-h-screen flex flex-col relative pb-20 lg:pb-0">
        <header class="min-h-20 border-b border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-4 px-container-padding-mobile lg:px-container-padding-desktop py-5 bg-surface-container-lowest/50 backdrop-blur-md sticky top-0 z-40">
            <div class="flex items-center gap-4"><div class="h-8 w-[2px] bg-primary/20"></div><div><h2 class="font-label-sm text-lg text-primary uppercase tracking-widest">Participant_Management</h2><p class="text-[10px] font-label-sm text-on-surface-variant/60 uppercase">Directory: Root/System/Giveaway/Entries</p></div></div>
            <div class="flex items-center gap-4"><div class="flex items-center gap-2 px-4 py-1.5 bg-surface-container tech-border rounded"><span class="w-2 h-2 rounded-full bg-secondary shadow-[0_0_8px_#cf5cff]"></span><span class="font-label-sm text-on-surface-variant">TOTAL_ENTRIES:</span><span class="font-label-sm text-on-surface font-bold">{{ number_format($totalParticipants) }}</span></div></div>
        </header>

        <div class="px-container-padding-mobile lg:px-container-padding-desktop pt-5">
            @if (session('status'))
                <div class="mb-5 rounded tech-border bg-primary-container/10 px-4 py-3 text-primary font-label-sm text-xs">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-5 rounded tech-border bg-error-container/20 px-4 py-3 text-error font-label-sm text-xs">{{ $errors->first() }}</div>
            @endif
        </div>

        <div class="p-container-padding-mobile lg:p-container-padding-desktop pt-0 grid grid-cols-12 gap-grid-gap flex-1">
            <div class="col-span-12 xl:col-span-4 space-y-grid-gap">
                <section class="glass-card tech-border tech-corner-tl p-6" id="quick-add">
                    <div class="flex items-center justify-between mb-8"><h3 class="font-label-sm text-primary flex items-center gap-2"><span class="material-symbols-outlined text-lg">add_box</span>MANUAL_ENTRY_NODE</h3><span class="text-[9px] font-label-sm text-on-surface-variant bg-white/5 px-2 py-0.5">READY</span></div>
                    <form class="space-y-6" method="POST" action="{{ route('participants.store') }}">
                        @csrf
                        <div class="space-y-2"><label class="font-label-sm text-[10px] text-on-surface-variant flex justify-between"><span>IDENTIFIER_NAME</span><span class="text-primary/40">[STR]</span></label><input class="glass-input w-full px-4 py-3 text-sm focus:ring-0" name="name" placeholder="MASUKKAN_NAMA..." required type="text" value="{{ old('name') }}"></div>
                        <div class="space-y-2"><label class="font-label-sm text-[10px] text-on-surface-variant flex justify-between"><span>ADDRESS_NODE</span><span class="text-primary/40">[TXT]</span></label><textarea class="glass-input w-full px-4 py-3 text-sm focus:ring-0 min-h-24" name="address" placeholder="MASUKKAN_ALAMAT..." required>{{ old('address') }}</textarea></div>
                        <div class="space-y-2"><label class="font-label-sm text-[10px] text-on-surface-variant flex justify-between"><span>SERIAL_ID_OR_CONTACT</span><span class="text-primary/40">[PHONE]</span></label><input class="glass-input w-full px-4 py-3 text-sm focus:ring-0" name="phone_number" placeholder="CONTOH: 081234567890" required type="text" value="{{ old('phone_number') }}"></div>
                        <button class="w-full tech-button py-4 mt-2 flex items-center justify-center gap-3" type="submit"><span class="material-symbols-outlined text-xl">sync_alt</span>EXECUTE_ADD</button>
                    </form>
                </section>

                <section class="glass-card tech-border p-6 flex-1">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2"><span class="material-symbols-outlined text-secondary">database_upload</span><h3 class="font-label-sm text-on-surface">IMPORT_CSV</h3></div>
                        <a class="font-label-sm text-[10px] text-primary/60 hover:text-primary flex items-center gap-1 transition-colors" href="{{ asset('templates/participants-template.csv') }}" download><span class="material-symbols-outlined text-sm">download</span>Template</a>
                    </div>

                    {{-- Drop / click zone --}}
                    <input accept=".csv,text/csv" class="hidden" id="fileInput" type="file">
                    <div id="dropZone" class="border-2 border-dashed border-white/10 bg-black/20 rounded p-8 flex flex-col items-center justify-center text-center cursor-pointer hover:border-secondary/50 hover:bg-secondary/5 transition-all">
                        <span class="material-symbols-outlined text-4xl text-secondary/50 mb-3">upload_file</span>
                        <p class="font-label-sm text-[11px] text-on-surface-variant mb-1">Klik atau seret file CSV ke sini</p>
                        <p class="text-[10px] text-on-surface-variant/40 font-label-sm">Format: nama, alamat, no. telepon</p>
                    </div>

                    {{-- Selected file + import button --}}
                    <div class="mt-4 hidden" id="fileSelected">
                        <div class="flex items-center gap-3 px-4 py-3 bg-secondary/5 border border-secondary/20 rounded mb-4">
                            <span class="material-symbols-outlined text-secondary text-lg">description</span>
                            <span class="font-label-sm text-[11px] text-on-surface truncate flex-1" id="fileNameLabel"></span>
                            <button type="button" onclick="clearFile()" class="text-on-surface-variant hover:text-error transition-colors"><span class="material-symbols-outlined text-base">close</span></button>
                        </div>
                        <button class="w-full tech-button py-3 flex items-center justify-center gap-2" id="importBtn" type="button">
                            <span class="material-symbols-outlined text-lg">upload</span>
                            <span>Upload &amp; Import</span>
                        </button>
                    </div>

                    {{-- Progress --}}
                    <div class="mt-4 hidden" id="importProgress">
                        <div class="flex justify-between font-label-sm text-[10px] text-on-surface-variant mb-2">
                            <span id="progressLabel">Memproses...</span>
                            <span id="progressPct">0%</span>
                        </div>
                        <div class="h-2 bg-white/5 w-full rounded-full overflow-hidden">
                            <div class="h-full bg-primary transition-all duration-200 shadow-[0_0_8px_rgba(0,240,255,0.5)]" id="progressBar" style="width:0%"></div>
                        </div>
                        <p class="font-label-sm text-[10px] text-on-surface-variant/50 mt-1.5" id="progressCount"></p>
                    </div>
                </section>
            </div>

            <div class="col-span-12 xl:col-span-8 flex flex-col glass-card tech-border tech-corner-br overflow-hidden min-h-[620px]">
                <div class="px-6 py-4 bg-surface-container-highest/30 border-b border-white/5 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-6"><div class="flex items-center gap-2"><span class="material-symbols-outlined text-primary text-xl">table_rows</span><h3 class="font-label-sm text-on-surface">DATA_BUFFER</h3></div><div class="h-4 w-[1px] bg-white/10 hidden sm:block"></div><div class="hidden sm:flex gap-4"><span class="font-label-sm text-[10px] text-on-surface-variant">ALL_NODES</span><span class="font-label-sm text-[10px] text-primary">VALIDATED</span></div></div>
                    <div class="flex items-center gap-3 w-full md:w-auto flex-wrap">
                        <form class="relative w-full md:w-72" method="GET" action="{{ route('dashboard') }}"><span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-primary/40 text-lg">search</span><input class="glass-input w-full pl-10 pr-4 py-2 text-[11px] font-label-sm focus:border-primary-container" name="search" placeholder="FILTER_RECORDS..." type="text" value="{{ $search }}"></form>
                        @if ($totalParticipants > 0)
                            <button type="button" onclick="openDeleteAllModal()" class="flex items-center gap-1.5 px-4 py-2 border border-error/40 text-error font-label-sm text-[10px] hover:bg-error/10 transition-colors whitespace-nowrap">
                                <span class="material-symbols-outlined text-base">delete_forever</span>DELETE_ALL
                            </button>
                        @endif
                    </div>
                </div>

                <div class="hidden md:grid grid-cols-12 gap-4 px-8 py-3 bg-black/40 border-b border-white/5 font-label-sm text-[10px] text-on-surface-variant uppercase tracking-widest"><div class="col-span-1">UID</div><div class="col-span-4">SUBJECT_NAME</div><div class="col-span-3">ADDRESS</div><div class="col-span-2">NETWORK_ID</div><div class="col-span-1">STATUS</div><div class="col-span-1 text-right">OPS</div></div>

                <div class="flex-1 overflow-y-auto custom-scrollbar bg-black/20">
                    @forelse ($participants as $participant)
                        <div class="data-row grid grid-cols-1 md:grid-cols-12 gap-3 md:gap-4 px-6 md:px-8 py-4 items-center">
                            <div class="md:col-span-1 font-label-sm text-primary/60">#{{ str_pad((string) ($participants->firstItem() + $loop->index), 3, '0', STR_PAD_LEFT) }}</div>
                            <div class="md:col-span-4 flex items-center gap-3 min-w-0"><div class="w-7 h-7 tech-border flex items-center justify-center text-[10px] font-bold text-primary bg-primary/5 shrink-0">{{ strtoupper(substr($participant->name, 0, 1)) }}</div><span class="font-semibold text-on-surface text-sm truncate">{{ $participant->name }}</span></div>
                            <div class="md:col-span-3 font-label-sm text-xs text-on-surface-variant truncate">{{ $participant->address }}</div>
                            <div class="md:col-span-2 font-label-sm text-on-surface-variant text-xs">{{ $participant->phone_number }}</div>
                            <div class="md:col-span-1"><span class="status-badge text-primary-container">VERIFIED</span></div>
                            <div class="md:col-span-1 md:text-right"><button class="text-on-surface-variant hover:text-error transition-colors" type="button" onclick="openDeleteModal('{{ route('participants.destroy', $participant) }}', '{{ addslashes($participant->name) }}')"><span class="material-symbols-outlined text-lg">delete_sweep</span></button></div>
                        </div>
                    @empty
                        <div class="px-8 py-16 text-center text-on-surface-variant font-label-sm">NO_RECORDS_FOUND. Tambahkan peserta manual atau import CSV.</div>
                    @endforelse
                </div>

                <div class="px-8 py-4 bg-surface-container-highest/20 border-t border-white/5 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="font-label-sm text-[10px] text-on-surface-variant/60 flex items-center gap-2"><span class="material-symbols-outlined text-sm">info</span>DISPLAYING_NODES_{{ str_pad((string) ($participants->firstItem() ?? 0), 3, '0', STR_PAD_LEFT) }}_TO_{{ str_pad((string) ($participants->lastItem() ?? 0), 3, '0', STR_PAD_LEFT) }}_OF_{{ number_format($participants->total()) }}</div>
                    <div class="text-sm [&_nav]:flex [&_nav]:justify-end [&_span]:bg-surface [&_a]:bg-surface [&_a]:text-on-surface-variant [&_span]:text-on-surface-variant [&_a]:border-white/10 [&_span]:border-white/10">{{ $participants->links() }}</div>
                </div>
            </div>
        </div>
    </main>

    <nav class="lg:hidden fixed bottom-0 w-full bg-surface-container-lowest/90 backdrop-blur-xl border-t border-white/10 z-50 px-4 py-2 flex justify-around">
        <a class="flex flex-col items-center p-2 text-primary" href="{{ route('dashboard') }}"><span class="material-symbols-outlined mb-1">database</span><span class="font-label-sm text-[10px] font-bold">Data</span></a>
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('prizes.index') }}"><span class="material-symbols-outlined mb-1">card_giftcard</span><span class="font-label-sm text-[10px]">Hadiah</span></a>
        <a class="flex flex-col items-center p-2 text-on-surface-variant" href="{{ route('winners') }}"><span class="material-symbols-outlined mb-1">history_edu</span><span class="font-label-sm text-[10px]">Winners</span></a>
    </nav>

    <!-- Delete Single Modal -->
    <div class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/70 backdrop-blur-sm" id="deleteModal">
        <div class="glass-card tech-border p-8 max-w-sm w-full mx-4 space-y-6">
            <div class="flex items-center gap-3"><span class="material-symbols-outlined text-error text-2xl">warning</span><h3 class="font-label-sm text-error text-sm">CONFIRM_DELETE</h3></div>
            <p class="font-label-sm text-[11px] text-on-surface-variant">Hapus peserta <span class="text-on-surface font-bold" id="deleteModalName"></span>?</p>
            <div class="flex gap-3 justify-end">
                <button onclick="closeDeleteModal()" class="px-5 py-2 font-label-sm text-[10px] border border-white/10 text-on-surface-variant hover:bg-white/5 transition-colors">CANCEL</button>
                <form id="deleteModalForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-5 py-2 font-label-sm text-[10px] bg-error/20 border border-error/50 text-error hover:bg-error/30 transition-colors">DELETE</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete All Modal -->
    <div class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/70 backdrop-blur-sm" id="deleteAllModal">
        <div class="glass-card tech-border p-8 max-w-sm w-full mx-4 space-y-6">
            <div class="flex items-center gap-3"><span class="material-symbols-outlined text-error text-2xl">delete_forever</span><h3 class="font-label-sm text-error text-sm">PURGE_ALL_RECORDS</h3></div>
            <p class="font-label-sm text-[11px] text-on-surface-variant">Hapus <span class="text-error font-bold">SEMUA {{ number_format($totalParticipants) }} peserta</span>? Tindakan ini tidak bisa dibatalkan.</p>
            <div class="flex gap-3 justify-end">
                <button onclick="closeDeleteAllModal()" class="px-5 py-2 font-label-sm text-[10px] border border-white/10 text-on-surface-variant hover:bg-white/5 transition-colors">CANCEL</button>
                <form method="POST" action="{{ route('participants.destroy-all') }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-5 py-2 font-label-sm text-[10px] bg-error/20 border border-error/50 text-error hover:bg-error/30 transition-colors">PURGE_ALL</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ── Drop Zone ──
        const dropZone  = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileLabel = document.getElementById('fileNameLabel');
        const importBtn = document.getElementById('importBtn');
        const fileSelected = document.getElementById('fileSelected');

        function setFile(file) {
            if (!file) return;
            fileInput._selectedFile = file;
            fileLabel.textContent = file.name;
            fileSelected.classList.remove('hidden');
        }
        function clearFile() {
            fileInput.value = '';
            fileInput._selectedFile = null;
            fileSelected.classList.add('hidden');
        }

        dropZone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => setFile(fileInput.files[0]));

        ['dragenter','dragover','dragleave','drop'].forEach(ev => dropZone.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); }));
        ['dragenter','dragover'].forEach(ev => dropZone.addEventListener(ev, () => dropZone.classList.add('border-secondary/50')));
        ['dragleave','drop'].forEach(ev => dropZone.addEventListener(ev, () => dropZone.classList.remove('border-secondary/50')));
        dropZone.addEventListener('drop', e => { if (e.dataTransfer.files[0]) setFile(e.dataTransfer.files[0]); });

        // ── AJAX Import with SSE progress ──
        importBtn.addEventListener('click', () => {
            const file = fileInput._selectedFile || fileInput.files[0];
            if (!file) return;

            const progressWrap  = document.getElementById('importProgress');
            const progressBar   = document.getElementById('progressBar');
            const progressPct   = document.getElementById('progressPct');
            const progressLabel = document.getElementById('progressLabel');
            const progressCount = document.getElementById('progressCount');

            fileSelected.classList.add('hidden');
            progressWrap.classList.remove('hidden');
            progressBar.style.width = '0%';
            progressPct.textContent = '0%';
            progressLabel.textContent = 'Mengupload...';
            progressCount.textContent = '';

            const formData = new FormData();
            formData.append('csv_file', file);
            formData.append('_token', '{{ csrf_token() }}');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('participants.import-stream') }}');
            xhr.setRequestHeader('Accept', 'text/event-stream');

            let buf = '';
            xhr.onprogress = () => {
                const newChunk = xhr.responseText.slice(buf.length);
                buf = xhr.responseText;
                newChunk.split('\n').forEach(line => {
                    if (!line.startsWith('data: ')) return;
                    try {
                        const d = JSON.parse(line.slice(6));
                        if (d.done) {
                            progressBar.style.width = '100%';
                            progressPct.textContent = '100%';
                            progressLabel.textContent = 'Selesai ✓';
                            progressCount.textContent = d.inserted + ' peserta berhasil diimport';
                            setTimeout(() => location.reload(), 1200);
                        } else if (d.progress !== undefined) {
                            progressLabel.textContent = 'Memproses...';
                            progressBar.style.width = d.progress + '%';
                            progressPct.textContent = d.progress + '%';
                            progressCount.textContent = d.inserted + ' / ' + d.total + ' baris';
                        }
                    } catch {}
                });
            };

            xhr.onerror = () => {
                progressLabel.textContent = 'Gagal — coba lagi';
                fileSelected.classList.remove('hidden');
            };

            xhr.send(formData);
        });

        // ── Delete Modals ──
        function openDeleteModal(action, name) {
            document.getElementById('deleteModalName').textContent = name;
            document.getElementById('deleteModalForm').action = action;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }
        function openDeleteAllModal() {
            document.getElementById('deleteAllModal').classList.remove('hidden');
            document.getElementById('deleteAllModal').classList.add('flex');
        }
        function closeDeleteAllModal() {
            document.getElementById('deleteAllModal').classList.add('hidden');
            document.getElementById('deleteAllModal').classList.remove('flex');
        }
        // Close on backdrop click
        ['deleteModal','deleteAllModal'].forEach(id => {
            document.getElementById(id).addEventListener('click', function(e) {
                if (e.target === this) { this.classList.add('hidden'); this.classList.remove('flex'); }
            });
        });
    </script>
</body>
</html>
