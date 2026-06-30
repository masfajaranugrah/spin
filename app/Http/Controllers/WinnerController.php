<?php

namespace App\Http\Controllers;

use App\Models\Winner;
use Illuminate\View\View;

class WinnerController extends Controller
{
    public function index(): View
    {
        return view('winners', [
            'winners' => Winner::with('participant')->latest('drawn_at')->paginate(10),
        ]);
    }
}
