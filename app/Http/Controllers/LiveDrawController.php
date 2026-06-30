<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Prize;
use App\Models\Winner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LiveDrawController extends Controller
{
    public function index(): View
    {
        $participants = Participant::query()
            ->oldest()
            ->get(['id', 'name', 'address', 'phone_number']);

        return view('live-draw', [
            'participants' => $participants,
            'totalParticipants' => $participants->count(),
            'currentPrize' => Prize::available()->orderBy('priority')->oldest()->first(),
            'latestWinner' => Winner::with('participant')->latest('drawn_at')->first(),
        ]);
    }

    public function liveSystem(): View
    {
        $participants = Participant::query()
            ->oldest()
            ->get(['id', 'name', 'address', 'phone_number']);

        return view('live-system', [
            'participants' => $participants,
            'totalParticipants' => $participants->count(),
            'currentPrize' => Prize::available()->orderBy('priority')->oldest()->first(),
        ]);
    }

    public function storeWinner(Request $request): JsonResponse
    {
        $data = $request->validate([
            'participant_id' => ['required', 'exists:participants,id'],
        ]);

        try {
            $winner = DB::transaction(function () use ($data): Winner {
                $prize = Prize::available()->orderBy('priority')->oldest()->lockForUpdate()->firstOrFail();

                $winner = Winner::create([
                    'participant_id' => $data['participant_id'],
                    'prize_id' => $prize->id,
                    'giveaway_name' => 'Undian Hadiah',
                    'prize_name' => $prize->name,
                    'drawn_at' => now(),
                ]);

                $prize->decrement('remaining');

                return $winner;
            })->load('participant');
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Tidak ada hadiah yang tersedia.'], 422);
        }

        return response()->json([
            'winner' => [
                'id' => $winner->id,
                'name' => $winner->participant->name,
                'address' => $winner->participant->address,
                'phone_number' => $winner->participant->phone_number,
                'giveaway_name' => $winner->giveaway_name,
                'prize_name' => $winner->prize_name,
                'drawn_at' => $winner->drawn_at->format('d M Y H:i'),
            ],
        ]);
    }
}
