<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Control;

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

    public function uploadbukti(Request $request){
        $request->validate([
            'bukti' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'order_id' => 'required|exists:tikets,order_id'
        ]);

        $file = $request->file('bukti');
        $tiket = Tiket::where('order_id', $request->order_id)->first();

        try {
            $newFileName = 'bukti_' . Str::slug($tiket->nama, '_') . '.' . $file->getClientOriginalExtension();
            $response = Http::asMultipart()
                ->attach(
                    'image',
                    fopen($file->getRealPath(), 'r'),
                    $newFileName
                )
                ->post('https://api.imgbb.com/1/upload?key=' . env('IMGBB_API_KEY'));

            $result = $response->json();

            if (!$response->successful() || !isset($result['data']['url'])) {
                Log::error('Gagal upload gambar ke imgbb.', [
                    'response_status' => $response->status(),
                    'response_body' => $response->body(),
                    'file_name' => $file->getClientOriginalName(),
                    'order_id' => $request->order_id,
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal upload gambar ke imgbb.'
                ]);
            }

            $imageUrl = $result['data']['url'];
            $tiket->bukti = $imageUrl;
            $tiket->save();

            return response()->json([
                'success' => true,
                'image_url' => $imageUrl,
                'order_id' => $tiket->order_id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
