<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPIN JMK</title>
    <script data-cfasync="false" src="{{ asset('tailwind-play-cdn.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { fontFamily: { sora: ['Sora'], jakarta: ['Plus Jakarta Sans'], mono: ['JetBrains Mono'] } } }
        }
    </script>
    <style>
        body { background: #0A0A0F radial-gradient(circle at 15% 50%, rgba(207, 92, 255, .12), transparent 28%); color: #dce4e5; }
        .glass-card { background: rgba(0, 219, 233, .05); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,.1); }
        .glass-input { background: rgba(8, 15, 16, .7); border: 0; border-bottom: 2px solid rgba(0, 240, 255, .3); color: #ffffff; caret-color: #00f0ff; }
        .glass-input:focus { border-bottom-color: #00f0ff; box-shadow: 0 10px 25px -15px rgba(0,240,255,.7); }
        .glass-button { background: linear-gradient(135deg, rgba(236,178,255,.9), rgba(219,252,255,.9)); border: 2px solid #00f0ff; box-shadow: 0 0 18px rgba(0,240,255,.35); }
    </style>
</head>
<body class="min-h-screen font-jakarta antialiased flex items-center justify-center p-5">
    <main class="w-full max-w-md glass-card rounded-2xl p-8 relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-cyan-400/20 blur-3xl"></div>
        <div class="relative">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-gradient-to-br from-cyan-300 to-fuchsia-400 p-1">
                    <div class="w-full h-full rounded-full bg-[#080f10] flex items-center justify-center font-sora font-black text-cyan-200">SJ</div>
                </div>
                <h1 class="font-sora text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-100 to-fuchsia-300">Masuk SPIN JMK</h1>
                <p class="mt-2 text-sm text-slate-400">Kelola peserta giveaway dari dashboard.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-300/30 bg-red-500/10 p-3 text-sm text-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block font-mono text-xs tracking-widest text-slate-400 mb-2">EMAIL</label>
                    <input class="glass-input w-full rounded-t-md px-4 py-3" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div>
                    <label class="block font-mono text-xs tracking-widest text-slate-400 mb-2">PASSWORD</label>
                    <input class="glass-input w-full rounded-t-md px-4 py-3" type="password" name="password" required>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-300">
                    <input type="checkbox" name="remember" class="rounded bg-slate-950 border-cyan-300/30 text-cyan-300 focus:ring-cyan-300">
                    Ingat saya
                </label>
                <button class="glass-button w-full rounded-lg py-3 font-sora font-bold uppercase text-[#320047]" type="submit">Login</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-400">Belum punya akun? <a class="text-cyan-200 hover:text-fuchsia-300" href="{{ route('register') }}">Daftar</a></p>
        </div>
    </main>
</body>
</html>
