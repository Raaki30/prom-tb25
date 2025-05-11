<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Control;
use Illuminate\Support\Facades\Storage;
use App\Models\Nis;

class PayController extends Controller
{
    public function initPayment(Request $request)
    {
        
        //validasi request
        $request->validate([
            'nis' => 'required|string',
            'nama_siswa' => 'required|string',
            'kelas' => 'required|string',
            
        ]);

        // ambil harga dari control
        $harga = Control::where('jenis_tiket', 'general')->value('harga');
        $biaya_lain = Control::where('jenis_tiket', 'general')->value('biaya_lain');
        // return view
        return view('payment.payment', [
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'harga' => $harga,
            'biaya_lain' => $biaya_lain,
            'grand_total' => $harga + $biaya_lain,
        ]);
    }

    public function processPayment(Request $request)
    {
        //validasi request
        $request->validate([
            'order_id' => 'required|string',
            'nis' => 'required|string',
            'nama_siswa' => 'required|string',
            'kelas' => 'required|string',
            'harga' => 'required|numeric',
            'grandtotal' => 'required|numeric',
            'email' => 'required|email',
            'phone' => 'required|string',
            'metodebayar' => 'required|string|in:bca,mandiri',
        ]);

        // simpan data ke database

        $tiket = Tiket::create([
            
            'order_id' => $request->order_id,
            'nis' => $request->nis,
            'nama' => $request->nama_siswa,
            'kelas' => $request->kelas,
            'jumlah_tiket' => 1,
            'harga' => $request->grandtotal,
            'email' => $request->email,
            'phone' => $request->phone,
            'metodebayar' => $request->metodebayar,
            'status' => 'pending',
        ]);
        

        return view('payment.instruction', compact('tiket'));
        
    }

    public function uploadbukti(Request $request)
{
    $request->validate([
        'bukti' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        'order_id' => 'required|exists:tikets,order_id'
    ]);

    $tiket = Tiket::where('order_id', $request->order_id)->firstOrFail();
    $file = $request->file('bukti');

    try {
        $fileName = 'bukti/' . Str::slug($tiket->nama) . '-' . time() . '.' . $file->extension();
        
        Storage::disk('spaces')->put(
            $fileName, 
            file_get_contents($file),
            'public'
        );
        
        $url = env('DO_SPACES_CDN_URL') . '/' . $fileName;
        $tiket->update(['bukti' => $url]);

        return response()->json([
            'success' => true,
            'image_url' => $url,
            'order_id' => $tiket->order_id,
        ]);
    } catch (\Exception $e) {
        Log::error('Upload Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Upload failed. Please try again.'
        ], 500);
    }
}

public function tamubeli(Request $request)
    {
        $request->validate([
            'partner' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'metodebayar' => 'required|string|max:255',
            'bukti' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'harga' => 'required|numeric',
        ]);

        $kelas = 'General';

        $order_id = 'LN-' . Str::upper(Str::random(4)) . mt_rand(10, 99);
        $file = $request->file('bukti');
        $nis = 0;

        try {
            $fileName = 'bukti/' . Str::slug($request->nama) . '-' . time() . '.' . $file->extension();
            Storage::disk('spaces')->put(
                $fileName, 
                file_get_contents($file),
                'public'
            );
            
            $url = env('DO_SPACES_CDN_URL') . '/' . $fileName;

            Tiket::create([
                'order_id' => $order_id,
                'nis' => $nis,
                'nama' => $request->nama,
                'kelas' => $kelas,
                'jumlah_tiket' => 1,
                'harga' => $request->harga,
                'email' => $request->email,
                'phone' => $request->phone,
                'metodebayar' => $request->metodebayar,
                'status' => 'pending',
                'bukti' => $url
            ]);
        } catch (\Exception $e) {
            Log::error('Upload Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Upload failed. Please try again.'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pemesanan berhasil masuk.',
            'order_id' => $order_id,
            
        ]);
    }


}
