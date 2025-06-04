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

    public function showCoupleForm()
    {
        return view('payment.couple');
    }

    public function initCouplePayment(Request $request)
    {
        //validasi request
        $request->validate([
            'nis1' => 'required|string',
            'nama_siswa1' => 'required|string',
            'kelas1' => 'required|string',
            'nis2' => 'required|string',
            'nama_siswa2' => 'required|string',
            'kelas2' => 'required|string',
        ]);

        // Harga tetap untuk couple: 840000 untuk berdua
        $harga = 420000; // per orang
        $biaya_lain = 0;
        $total_per_tiket = $harga;
        $total_discount = 0;
        $grand_total = 840000;
        
        // return view
        return view('payment.couple-payment', [
            'nis1' => $request->nis1,
            'nama_siswa1' => $request->nama_siswa1,
            'kelas1' => $request->kelas1,
            'nis2' => $request->nis2,
            'nama_siswa2' => $request->nama_siswa2,
            'kelas2' => $request->kelas2,
            'harga' => $harga,
            'biaya_lain' => $biaya_lain,
            'total_per_tiket' => $total_per_tiket,
            'total_discount' => $total_discount,
            'grand_total' => $grand_total,
        ]);
    }

    public function processCouplePayment(Request $request)
    {
        // Validate request
        $request->validate([
            'order_id' => 'required|string',
            'nis1' => 'required|string',
            'nama_siswa1' => 'required|string',
            'kelas1' => 'required|string',
            'nis2' => 'required|string',
            'nama_siswa2' => 'required|string',
            'kelas2' => 'required|string',
            'harga' => 'required|numeric',
            'grandtotal' => 'required|numeric',
            'email1' => 'required|email',
            'phone1' => 'required|string',
            'email2' => 'required|email', 
            'phone2' => 'required|string',
            'metodebayar' => 'required|string|in:bca,mandiri',
        ]);

        // Generate base order ID with CP- prefix
        $baseOrderId = $request->order_id;
        
        // Create first ticket with -1 suffix
        $tiket1 = Tiket::create([
            'order_id' => $baseOrderId . '-1',
            'nis' => $request->nis1,
            'nama' => $request->nama_siswa1,
            'kelas' => $request->kelas1,
            'jumlah_tiket' => 1,
            'harga' => $request->grandtotal / 2, // Split the price between two tickets
            'email' => $request->email1, // Use person 1's email
            'phone' => $request->phone1, // Use person 1's phone
            'metodebayar' => $request->metodebayar,
            'status' => 'pending',
        ]);
        
        // Create second ticket with -2 suffix
        $tiket2 = Tiket::create([
            'order_id' => $baseOrderId . '-2',
            'nis' => $request->nis2,
            'nama' => $request->nama_siswa2,
            'kelas' => $request->kelas2,
            'jumlah_tiket' => 1,
            'harga' => $request->grandtotal / 2, // Split the price between two tickets
            'email' => $request->email2, // Use person 2's email
            'phone' => $request->phone2, // Use person 2's phone
            'metodebayar' => $request->metodebayar,
            'status' => 'pending',
        ]);

        return view('payment.couple-instruction', [
            'tiket1' => $tiket1, 
            'tiket2' => $tiket2, 
            'baseOrderId' => $baseOrderId
        ]);
    }

    public function uploadCoupleProof(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'base_order_id' => 'required|string'
        ]);

        $baseOrderId = $request->base_order_id;
        $tiket1 = Tiket::where('order_id', $baseOrderId . '-1')->firstOrFail();
        $tiket2 = Tiket::where('order_id', $baseOrderId . '-2')->firstOrFail();
        
        $file = $request->file('bukti');

        try {
            $fileName = 'bukti/couple-' . Str::slug($tiket1->nama) . '-' . time() . '.' . $file->extension();
            
            Storage::disk('spaces')->put(
                $fileName, 
                file_get_contents($file),
                'public'
            );
            
            $url = env('DO_SPACES_CDN_URL') . '/' . $fileName;
            
            // Update both tickets with the same proof
            $tiket1->update(['bukti' => $url]);
            $tiket2->update(['bukti' => $url]);

            return response()->json([
                'success' => true,
                'image_url' => $url,
                'base_order_id' => $baseOrderId,
            ]);
        } catch (\Exception $e) {
            Log::error('Upload Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Upload failed. Please try again.'
            ], 500);
        }
    }


}
