<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrizeController extends Controller
{
    public function index(): View
    {
        return view('prizes', [
            'prizes' => Prize::query()->orderBy('priority')->latest()->get(),
            'configuredPrizes' => Prize::count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1', 'max:100000'],
            'priority' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'image_url' => ['nullable', 'url', 'max:2048'],
        ]);

        Prize::create([
            'name' => $data['name'],
            'category' => $data['category'],
            'quota' => $data['quota'],
            'remaining' => $data['quota'],
            'priority' => $data['priority'] ?? (Prize::max('priority') + 1),
            'image_url' => $data['image_url'] ?? null,
            'is_active' => true,
        ]);

        return back()->with('status', 'Hadiah berhasil disimpan ke database.');
    }

    public function destroy(Prize $prize): RedirectResponse
    {
        $prize->delete();

        return back()->with('status', 'Hadiah berhasil dihapus.');
    }
}
