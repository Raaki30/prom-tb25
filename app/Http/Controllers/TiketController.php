<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nis;
use App\Models\Tiket;
use App\Mail\TiketMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class TiketController extends Controller
{
    public function validasiNIS($id)
    {
        $siswa = Nis::where('nis', $id)->first();
        $sudah_beli = $siswa->sudah_beli;

        if ($sudah_beli == true) {
            return response()->json([
                'status' => 'error',
                'valid'=> false,
                'message' => 'NIS sudah melakukan pembelian tiket'
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'valid'=> true,
                'siswa' => $siswa,
                'message' => 'NIS valid'
            ]);
        }
    }
    

    public function verifikasi($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->status = 'completed';
        $tiket->save();
        if ($tiket->nis != 0) {
            $nis = Nis::where('nis', $tiket->nis)->first();
            if ($nis) {
            $nis->sudah_beli = true;
            $nis->save();
            }
        }

        $data = [
            'nis' => $tiket->nis,
            'nama' => $tiket->nama,
            'kelas' => $tiket->kelas,
            'status' => $tiket->status,
            'order_id' => $tiket->order_id,
            'email' => $tiket->email,
            'no_hp' => $tiket->phone,
            'metodebayar' => $tiket->metodebayar,
            'url' => url('/eticket/' . $tiket->order_id . '?nis=' . $tiket->nis),
        ];

        Mail::to($tiket->email)->send(new TiketMail($data));

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function create()
    {
        return view('dashboard.tiket-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'kelas' => 'required',
            'nis' => 'required',
        ]);
        $harga = 00000;

        $tiket = new Tiket();
        $tiket->order_id = 'MN-' . strtoupper(Str::random(6));
        $tiket->nama = $request->nama;
        $tiket->email = $request->email;
        $tiket->phone = $request->phone;
        $tiket->kelas = $request->kelas;
        $tiket->nis = $request->nis;
        $tiket->metodebayar = 'Manual';
        $tiket->status = 'completed';
        $tiket->jumlah_tiket = 1;
        $tiket->harga = $harga;
        $tiket->save();

        return redirect()->route('dashboard.tiket')->with('success', 'Order manual berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tiket = Tiket::findOrFail($id);
        return view('dashboard.tiket-edit', compact('tiket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'kelas' => 'required',
            'nis' => 'required',
        ]);

        $tiket = Tiket::findOrFail($id);
        $tiket->nama = $request->nama;
        $tiket->email = $request->email;
        $tiket->phone = $request->phone;
        $tiket->kelas = $request->kelas;
        $tiket->nis = $request->nis;
        $tiket->save();

        return redirect()->route('dashboard.tiket')->with('success', 'Order berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->delete();

        return redirect()->route('dashboard.tiket')->with('success', 'Order berhasil dihapus.');
    }

    public function validateScan(Request $request)
    {
        try {
            $request->validate([
                'qr' => 'required|string|max:255'
            ]);

            $tiket = Tiket::where('order_id', $request->qr)->first();

            if (!$tiket) {
                return response()->json([
                    'valid' => false,
                    'message' => 'ticket_not_found'
                ]);
            }

            if ($tiket->status == 'completed' && $tiket->entry == 0) {
                
                $tiket->entry = 1;
                $tiket->checkin_time = now();
                $tiket->save();

                return response()->json([
                    'valid' => true,
                    'message' => 'Check-In Berhasil',
                    'ticket' => [
                        'nis' => $tiket->nis,
                        'nama_siswa' => $tiket->nama,
                        'kelas' => $tiket->kelas,
                        'status' => $tiket->status,
                        'order_id' => $tiket->order_id,
                        'email' => $tiket->email,
                        'no_hp' => $tiket->phone
                    ]
                ]);
            } else if ($tiket->status == 'pending') {
                return response()->json([
                    'valid' => false,
                    'message' => 'ticket_pending'
                ]);
            } else if ($tiket->status == 'completed' && $tiket->entry == 1) {
                return response()->json([
                    'valid' => false,
                    'message' => 'ticket_already_used'
                ]);
            } else {
                return response()->json([
                    'valid' => false,
                    'message' => 'ticket_invalid'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Terjadi kesalahan saat memvalidasi tiket'
            ], 500);
        }
    }

    public function show($id, Request $request)
{
    $nis = $request->query('nis');

    $tiket = Tiket::where('order_id', $id)->where('nis', $nis)->first();

    if (!$tiket) {
        return abort(404, 'Tiket tidak ditemukan.');
    }

    if ($tiket->status === 'pending') {
        return abort(404, 'Tiket belum dibayar.');
    }

    // Generate QR code as base64
    $qrCode = QrCode::format('svg')->size(150)->generate($tiket->order_id);
    $qrCodeImage = 'data:image/png;base64,' . base64_encode($qrCode);

    return view('eticket.show', compact('tiket', 'qrCode'));
}


    public function manualCheckin(Request $request)
    {
        Log::info('Manual checkin request', $request->all());

        $request->validate([
            'order_id' => 'required|string'
        ]);

        if ($request->order_id == '0') {
            return response()->json(['valid' => false, 'message' => 'ticket_not_found']);
        }

        $ticket = Tiket::where('order_id', $request->order_id)
            ->orWhere('nis', $request->order_id)
            ->first();

        if (!$ticket) {
            return response()->json(['valid' => false, 'message' => 'ticket_not_found']);
        }

        if ($ticket->status === 'pending') {
            return response()->json(['valid' => false, 'message' => 'ticket_pending']);
        }

        if ($ticket->entry === 1) {
            return response()->json(['valid' => false, 'message' => 'ticket_already_used']);
        }

        $ticket->entry = 1;
        $ticket->checkin_time = now();
        $ticket->save();

        return response()->json([
            'valid' => true,
            'message' => 'Tiket berhasil digunakan',
            'ticket' => [
                'nis' => $ticket->nis,
                'nama_siswa' => $ticket->nama,
                'kelas' => $ticket->kelas,
                'status' => $ticket->status,
                'order_id' => $ticket->order_id,
                'email' => $ticket->email,
                'no_hp' => $ticket->phone
            ]
        ]);
    }

    public function caribuyer(Request $request)
    {
        $query = $request->input('query');
        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $search = Tiket::where('nis', 'LIKE', "%{$query}%")
            ->orWhere('nama', 'LIKE', "%{$query}%")
            ->select('nis', 'nama', 'kelas', 'order_id', 'status')
            ->get();
        
        return response()->json($search);
    }

    

    
}
