<?php

namespace App\Http\Controllers;

use App\Models\Winner;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WinnerController extends Controller
{
    public function index(): View
    {
        return view('winners', [
            'winners' => Winner::with('participant')->latest('drawn_at')->paginate(10),
        ]);
    }

    public function destroy(Winner $winner): RedirectResponse
    {
        // Restore prize quota when a winner is deleted
        if ($winner->prize) {
            $winner->prize->increment('remaining');
        }

        $winner->delete();

        return redirect()->route('winners')->with('success', 'Pemenang berhasil dihapus.');
    }
}
