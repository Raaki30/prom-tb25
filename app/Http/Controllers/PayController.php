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
use App\Models\WaitingRoom;

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
    $session_id = Session::getId();
    $waitingRoom = WaitingRoom::where('session_id', $session_id)->first();
        if ($waitingRoom) {
            $waitingRoom->status = 'completed';
            $waitingRoom->save();
        }

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

    public function showGroupForm()
    {
        return view('payment.group');
    }

    public function initGroupPayment(Request $request)
    {
        // Determine the number of tickets from the request
        $ticketCount = $request->input('ticket_count', 2);
        
        // Validate based on ticket count
        $validationRules = [
            'nis1' => 'required|string',
            'nama_siswa1' => 'required|string',
            'kelas1' => 'required|string',
            'nis2' => 'required|string',
            'nama_siswa2' => 'required|string',
            'kelas2' => 'required|string',
        ];
        
        // Add validation rules for additional tickets if more than 2
        for ($i = 3; $i <= $ticketCount; $i++) {
            $validationRules["nis$i"] = 'required|string';
            $validationRules["nama_siswa$i"] = 'required|string';
            $validationRules["kelas$i"] = 'required|string';
        }
        
        $request->validate($validationRules);
        
        // Set pricing based on group size
        $price_per_ticket = $ticketCount > 2 ? 390000 : 415000;
        $biaya_lain = 0;
        $total_per_tiket = $price_per_ticket;
        $total_discount = 0;
        $grand_total = $price_per_ticket * $ticketCount;
        
        // Build participants data for the view
        $participants = [];
        for ($i = 1; $i <= $ticketCount; $i++) {
            $participants[] = [
                'nis' => $request->{"nis$i"},
                'nama_siswa' => $request->{"nama_siswa$i"},
                'kelas' => $request->{"kelas$i"},
            ];
        }
        
        // return view
        return view('payment.group-payment', [
            'participants' => $participants,
            'ticketCount' => $ticketCount,
            'harga' => $price_per_ticket,
            'biaya_lain' => $biaya_lain,
            'total_per_tiket' => $total_per_tiket,
            'total_discount' => $total_discount,
            'grand_total' => $grand_total,
        ]);
    }

    public function processGroupPayment(Request $request)
    {
        // Basic validation
        $request->validate([
            'order_id' => 'required|string',
            'harga' => 'required|numeric',
            'grandtotal' => 'required|numeric',
            'metodebayar' => 'required|string|in:bca,mandiri',
            'ticketCount' => 'required|integer|min:2'
        ]);
        
        // Generate base order ID with GP- prefix (Group Purchase)
        $baseOrderId = $request->order_id;
        $ticketCount = $request->ticketCount;
        $tickets = [];
        
        // Create tickets for all participants
        for ($i = 1; $i <= $ticketCount; $i++) {
            // Validate individual participant data
            $request->validate([
                "nis$i" => 'required|string',
                "nama_siswa$i" => 'required|string',
                "kelas$i" => 'required|string',
                "email$i" => 'required|email',
                "phone$i" => 'required|string',
            ]);
            
            // Create ticket with -N suffix
            $ticket = Tiket::create([
                'order_id' => $baseOrderId . '-' . $i,
                'nis' => $request->{"nis$i"},
                'nama' => $request->{"nama_siswa$i"},
                'kelas' => $request->{"kelas$i"},
                'jumlah_tiket' => 1,
                'harga' => $request->grandtotal / $ticketCount, // Split the price equally
                'email' => $request->{"email$i"}, // Use person's email
                'phone' => $request->{"phone$i"}, // Use person's phone
                'metodebayar' => $request->metodebayar,
                'status' => 'pending',
            ]);
            
            $tickets[] = $ticket;
        }

        return view('payment.group-instruction', [
            'tickets' => $tickets, 
            'baseOrderId' => $baseOrderId,
            'ticketCount' => $ticketCount
        ]);
    }

    public function uploadGroupProof(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'base_order_id' => 'required|string'
        ]);

        $baseOrderId = $request->base_order_id;
        
        // Find all tickets with this base order ID
        $tickets = Tiket::where('order_id', 'like', $baseOrderId . '-%')->get();
        
        if ($tickets->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tickets not found'
            ], 404);
        }
        
        $file = $request->file('bukti');

        try {
            $fileName = 'bukti/group-' . Str::slug($tickets->first()->nama) . '-' . time() . '.' . $file->extension();
            
            Storage::disk('spaces')->put(
                $fileName, 
                file_get_contents($file),
                'public'
            );
            
            $url = env('DO_SPACES_CDN_URL') . '/' . $fileName;
            
            // Update all tickets with the same proof
            foreach ($tickets as $ticket) {
                $ticket->update(['bukti' => $url]);
            }

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
