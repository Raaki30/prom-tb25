<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nis;

class SiswaController extends Controller
{
    public function search(Request $request)
    {
        
        $query = $request->input('query');
        if (strlen($query)<3) {
            return response()->json([]);
        }

        $search = Nis::where('nis', 'LIKE', "%{$query}%")
            ->orWhere('nama_siswa', 'LIKE', "%{$query}%")
            ->select('nis', 'nama_siswa', 'kelas')
            ->get();
        return response()->json($search);

        
    }
}
