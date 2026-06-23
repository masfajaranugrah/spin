<!DOCTYPE html>
<html class="dark" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - NeonDraw</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sora: ['Sora'], jakarta: ['Plus Jakarta Sans'], mono: ['JetBrains Mono'] } } } }
    </script>
    <style>
        body { background: #0A0A0F radial-gradient(circle at 85% 30%, rgba(0, 240, 255, .12), transparent 28%); color: #dce4e5; }
        .glass-card { background: rgba(0, 219, 233, .05); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,.1); }
        .glass-input { background: rgba(8, 15, 16, .7); border: 0; border-bottom: 2px solid rgba(0, 240, 255, .3); color: #dce4e5; }
        .glass-input:focus { border-bottom-color: #00f0ff; box-shadow: 0 10px 25px -15px rgba(0,240,255,.7); }
        .glass-button { background: linear-gradient(135deg, rgba(236,178,255,.9), rgba(219,252,255,.9)); border: 2px solid #00f0ff; box-shadow: 0 0 18px rgba(0,240,255,.35); }
    </style>
</head>
<body class="min-h-screen font-jakarta antialiased flex items-center justify-center p-5">
    <main class="w-full max-w-md glass-card rounded-2xl p-8 relative overflow-hidden">
        <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-fuchsia-400/20 blur-3xl"></div>
        <div class="relative">
            <div class="mb-8 text-center">
                <h1 class="font-sora text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-100 to-fuchsia-300">Buat Akun</h1>
                <p class="mt-2 text-sm text-slate-400">Registrasi admin untuk mengakses dashboard NeonDraw.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-300/30 bg-red-500/10 p-3 text-sm text-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block font-mono text-xs tracking-widest text-slate-400 mb-2">NAMA</label>
                    <input class="glass-input w-full rounded-t-md px-4 py-3" type="text" name="name" value="{{ old('name') }}" required autofocus>
                </div>
                <div>
                    <label class="block font-mono text-xs tracking-widest text-slate-400 mb-2">EMAIL</label>
                    <input class="glass-input w-full rounded-t-md px-4 py-3" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label class="block font-mono text-xs tracking-widest text-slate-400 mb-2">PASSWORD</label>
                    <input class="glass-input w-full rounded-t-md px-4 py-3" type="password" name="password" required>
                </div>
                <div>
                    <label class="block font-mono text-xs tracking-widest text-slate-400 mb-2">KONFIRMASI PASSWORD</label>
                    <input class="glass-input w-full rounded-t-md px-4 py-3" type="password" name="password_confirmation" required>
                </div>
                <button class="glass-button w-full rounded-lg py-3 font-sora font-bold uppercase text-[#320047]" type="submit">Register</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-400">Sudah punya akun? <a class="text-cyan-200 hover:text-fuchsia-300" href="{{ route('login') }}">Login</a></p>
        </div>
    </main>
</body>
</html>
