<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $participants = Participant::query()
            ->when($search, function ($query, string $search) {
                // Menambahkan id_number ke dalam filter pencarian
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('dashboard', [
            'participants' => $participants,
            'totalParticipants' => Participant::count(),
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Menambahkan validasi untuk id_number dan subscription_fee
        $data = $request->validate([
            'id_number' => ['required', 'string', 'max:255', 'unique:participants,id_number'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'phone_number' => ['required', 'string', 'max:50'],
            'subscription_fee' => ['required', 'numeric', 'min:0'],
        ]);

        Participant::create($data);

        return back()->with('status', 'Peserta berhasil ditambahkan.');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ]);

        $file = $request->file('csv_file')->openFile();
        $rows = [];

        while (! $file->eof()) {
            $row = $file->fgetcsv();

            // Ubah pengecekan menjadi minimal 5 kolom (sesuai template Excel/CSV baru)
            if (! is_array($row) || count($row) < 5) continue;

            $idNumber = trim((string) $row[0]);
            $name = trim((string) $row[1]);
            $address = trim((string) $row[2]);
            $phone = trim((string) $row[3]);
            $fee = (int) preg_replace('/[^0-9]/', '', trim((string) $row[4])); // Ambil angka saja untuk fee

            // Abaikan baris kosong atau baris header
            if ($idNumber === '' || $name === '' || strtolower($idNumber) === 'id_number') continue;

            $rows[] = [
                'id_number' => $idNumber,
                'name' => $name,
                'address' => $address,
                'phone_number' => $phone,
                'subscription_fee' => $fee,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        $inserted = 0;
        foreach (array_chunk($rows, 500) as $chunk) {
            // insertOrIgnore akan mengabaikan data duplikat jika id_number sudah ada di database
            \DB::table('participants')->insertOrIgnore($chunk);
            $inserted += count($chunk);
        }

        return back()->with('status', "Import selesai. {$inserted} peserta diproses.");
    }

    public function importStream(Request $request): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ]);

        $path = $request->file('csv_file')->store('imports', 'local');
        $fullPath = storage_path('app/private/' . $path);

        return response()->stream(function () use ($fullPath) {
            $file = new \SplFileObject($fullPath, 'r');
            $rows = [];

            while (! $file->eof()) {
                $row = $file->fgetcsv();

                // Ubah pengecekan menjadi minimal 5 kolom
                if (! is_array($row) || count($row) < 5) continue;

                $idNumber = trim((string) $row[0]);
                $name = trim((string) $row[1]);
                $address = trim((string) $row[2]);
                $phone = trim((string) $row[3]);
                $fee = (int) preg_replace('/[^0-9]/', '', trim((string) $row[4]));

                if ($idNumber === '' || $name === '' || strtolower($idNumber) === 'id_number') continue;

                $rows[] = [
                    'id_number' => $idNumber,
                    'name' => $name,
                    'address' => $address,
                    'phone_number' => $phone,
                    'subscription_fee' => $fee,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $total = count($rows);
            if ($total === 0) {
                echo "data: " . json_encode(['done' => true, 'inserted' => 0, 'total' => 0]) . "\n\n";
                ob_flush(); flush();
                @unlink($fullPath);
                return;
            }

            $inserted = 0;
            $chunks = array_chunk($rows, 500);

            foreach ($chunks as $chunk) {
                \DB::table('participants')->insertOrIgnore($chunk); // Abaikan duplikat id_number
                $inserted += count($chunk);
                $pct = (int) round($inserted / $total * 100);
                echo "data: " . json_encode(['progress' => $pct, 'inserted' => $inserted, 'total' => $total]) . "\n\n";
                ob_flush(); flush();
            }

            echo "data: " . json_encode(['done' => true, 'inserted' => $inserted, 'total' => $total]) . "\n\n";
            ob_flush(); flush();
            @unlink($fullPath);
        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    public function destroy(Participant $participant): RedirectResponse
    {
        $participant->delete();

        return back()->with('status', 'Peserta berhasil dihapus.');
    }

    public function destroyAll(): RedirectResponse
    {
        // Hapus pemenang dan data peserta
        \App\Models\Winner::query()->delete();
        Participant::query()->delete();

        return back()->with('status', 'Semua peserta berhasil dihapus.');
    }
}
