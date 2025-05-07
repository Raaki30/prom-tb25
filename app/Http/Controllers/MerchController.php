<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Merch;
use App\Models\MerchItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\MerchMail;
use Illuminate\Support\Facades\Mail;

class MerchController extends Controller
{
    // Fungsi untuk proses pembelian
    public function beli(Request $request)
    {
        // Validasi input data dari request
        $validated = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'grand_total' => 'required|integer',
            'metodebayar' => 'required|string',
            'bukti' => 'required|file|mimes:jpg,jpeg,png', // Validasi bukti harus berupa file gambar
            'items' => 'required|array', // Harus ada list item yang dibeli
            'items.*.product_id' => 'required|string',
            'items.*.variant_id' => 'required|string',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|integer',
        ]);

        // Mulai transaksi untuk memastikan data tersimpan dengan aman
        DB::beginTransaction();
        try {
            // Upload file bukti ke DigitalOcean Spaces
            $file = $request->file('bukti');
            $fileName = 'bukti/' . Str::slug($request->nama) . '-' . time() . '.' . $file->extension();
            Storage::disk('spaces')->put(
                $fileName,
                file_get_contents($file),
                'public'
            );

            // Membuat URL untuk file bukti yang diupload
            $url = env('DO_SPACES_CDN_URL') . '/' . $fileName;
            $order_id = 'MC-' . Str::upper(Str::random(6));

            // Simpan data merch ke tabel merches
            $merch = Merch::create([
                'order_id' => $order_id,
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'],
                'grand_total' => $validated['grand_total'],
                'metodebayar' => $validated['metodebayar'],
                'bukti' => $url, // Simpan URL bukti di database
                'status_bayar' => 'pending',
                'status_pickup' => 'not_picked',
            ]);

            // Simpan setiap item yang dibeli ke tabel merch_items
            foreach ($validated['items'] as $item) {
                MerchItem::create([
                    'merch_id' => $merch->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // Commit transaksi jika semuanya berhasil
            DB::commit();

            return response()->json([
                'message' => 'Pembelian berhasil!',
                'data' => $merch
            ], 201);
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollback();
            Log::error('Upload Error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
{
    $search = $request->input('search');
    $perPage = $request->input('perPage', 10);

    // Membuat query untuk Merch dengan pencarian
    $query = Merch::query();

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('order_id', 'like', '%' . $search . '%')
              ->orWhere('nama', 'like', '%' . $search . '%');
        });
    }

    // Ambil semua data Merch dengan pagination
    $merchs = $query->orderByDesc('created_at')->paginate($perPage)->withQueryString();

    // Menyiapkan data untuk MerchItem terkait, ambil berdasarkan merch_id
    $merchItems = MerchItem::whereIn('merch_id', $merchs->pluck('id'))->get()->groupBy('merch_id');

    return view('dashboard.merch', compact('merchs', 'merchItems'));
}


    public function edit($id)
    {
        $merch = Merch::with('items')->findOrFail($id);
        return view('dashboard.merch-edit', compact('merch'));
    }

    public function update(Request $request, $id)
    {
        $merch = Merch::findOrFail($id);
        $merch->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'grand_total' => $request->grand_total,
            'metodebayar' => $request->metodebayar,
            'status_bayar' => $request->status_bayar,
            'status_pickup' => $request->status_pickup,
        ]);

        return redirect()->route('dashboard.merch.index')->with('success', 'Data merch berhasil diperbarui');
    }

    public function destroy($id)
    {
        $merch = Merch::findOrFail($id);
        $merch->delete();

        return redirect()->route('dashboard.merch.index')->with('success', 'Data merch berhasil dihapus');
    }

    public function verifyPayment($id)
    {
        $merch = Merch::findOrFail($id);
        $merch->update(['status_bayar' => 'success']);
        $data = [
            'order_id' => $merch->order_id,
            'nama' => $merch->nama,
            'email' => $merch->email,
            'no_hp' => $merch->no_hp,
            'grand_total' => $merch->grand_total,
            'metodebayar' => $merch->metodebayar,
            'items' => $merch->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ];
            })->toArray(),
        ];
        Mail::to($merch->email)->send(new MerchMail($data));

        return redirect()->route('dashboard.merch.index')->with('success', 'Pembayaran berhasil diverifikasi');
    }

    public function pickup($id)
    {
        $merch = Merch::findOrFail($id);
        $merch->update(['status_pickup' => 'picked_up']);

        return redirect()->route('dashboard.merch.index')->with('success', 'Status pengambilan diperbarui');
    }
}
