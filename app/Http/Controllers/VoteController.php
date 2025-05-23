<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Vote;
use App\Models\Nis;


class VoteController extends Controller
{
    public function candidates()
    {
        $categories = [
            [
            'id' => 'CAT1',
            'name' => 'KING 👑',
            'candidates' => [
                [ 'id' => 'A1', 'name' => 'Misyal', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Misyal.jpg' ],
                [ 'id' => 'A2', 'name' => 'Syabil', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Syabil.jpg' ],
                [ 'id' => 'A3', 'name' => 'Kenza', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kenza.jpg' ],
            ],
            ],
            [
            'id' => 'CAT2',
            'name' => 'QUEEN 👸',
            'candidates' => [
                [ 'id' => 'B1', 'name' => 'Sasa', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Sasa.jpg' ],
                [ 'id' => 'B2', 'name' => 'Sasha', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Sasha.jpg' ],
                [ 'id' => 'B3', 'name' => 'Selma', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Selma.jpeg' ],
            ],
            ],
            [
            'id' => 'CAT3',
            'name' => 'TER-COOL 😎',
            'candidates' => [
                [ 'id' => 'C1', 'name' => 'Rafsan', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rafsan.JPG' ],
                [ 'id' => 'C2', 'name' => 'Galung', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Galung.jpg' ],
                [ 'id' => 'C3', 'name' => 'Daris', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Daris.jpg' ],
            ],
            ],
            [
            'id' => 'CAT4',
            'name' => 'TER-TENGIL 😜',
            'candidates' => [
                [ 'id' => 'D1', 'name' => 'Yasser', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Yasser.jpg' ],
                [ 'id' => 'D2', 'name' => 'Reno', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Reno.JPG' ],
                [ 'id' => 'D3', 'name' => 'Pandya', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Pandya.jpg' ],
            ],
            ],
            [
            'id' => 'CAT5',
            'name' => 'TER-NGAKAK 😂',
            'candidates' => [
                [ 'id' => 'E1', 'name' => 'Regita', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Regita.jpg' ],
                [ 'id' => 'E2', 'name' => 'Pawas', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Pawas.jpg' ],
                [ 'id' => 'E3', 'name' => 'Dafi', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Dafi.jpg' ],
            ],
            ],
            [
            'id' => 'CAT6',
            'name' => 'TER-FAMOUS 🌟',
            'candidates' => [
                [ 'id' => 'F1', 'name' => 'Alya', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Alya.jpg' ],
                [ 'id' => 'F2', 'name' => 'Kika', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kika.jpg' ],
                [ 'id' => 'F3', 'name' => 'Ludwig', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Ludwig.jpg' ],
            ],
            ],
            [
            'id' => 'CAT7',
            'name' => 'TER-JULID 🗣️',
            'candidates' => [
                [ 'id' => 'G1', 'name' => 'Arzu', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Arzu.jpg' ],
                [ 'id' => 'G2', 'name' => 'Davina', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Davina.JPG' ],
                [ 'id' => 'G3', 'name' => 'Kekei', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kekei.jpg' ],
            ],
            ],
            [
            'id' => 'CAT8',
            'name' => 'TER-SKENA 🎤',
            'candidates' => [
                [ 'id' => 'H1', 'name' => 'Laka', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Laka.jpeg' ],
                [ 'id' => 'H2', 'name' => 'Arga', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Arga.jpeg' ],
                [ 'id' => 'H3', 'name' => 'Cess', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Cess.jpg' ],
            ],
            ],
            [
            'id' => 'CAT9',
            'name' => 'TER-FRIENDLY 🤝',
            'candidates' => [
                [ 'id' => 'I1', 'name' => 'Sarah', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Sarah.jpg' ],
                [ 'id' => 'I2', 'name' => 'Aweng', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Aweng.jpg' ],
                [ 'id' => 'I3', 'name' => 'Abiel', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Abiel.jpg' ],
            ],
            ],
            [
            'id' => 'CAT10',
            'name' => 'TER-CANTIK 💃',
            'candidates' => [
                [ 'id' => 'J1', 'name' => 'Raya', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Raya.jpg' ],
                [ 'id' => 'J2', 'name' => 'Cleo', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Cleo.jpg' ],
                [ 'id' => 'J3', 'name' => 'Chelsea', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Chelsea.jpg' ],
            ],
            ],
            [
            'id' => 'CAT11',
            'name' => 'TER-GANTENG 🤵',
            'candidates' => [
                [ 'id' => 'K1', 'name' => 'Rayyan', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rayyan.JPG' ],
                [ 'id' => 'K2', 'name' => 'Radya', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Radya.jpg' ],
                [ 'id' => 'K3', 'name' => 'Keanu', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Keanu.jpg' ],
            ],
            ],
            [
            'id' => 'CAT12',
            'name' => 'TER-LAMBE 👄',
            'candidates' => [
                [ 'id' => 'L1', 'name' => 'Ninis', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Ninis.jpg' ],
                [ 'id' => 'L2', 'name' => 'Kitaro', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kitaro.jpg' ],
                [ 'id' => 'L3', 'name' => 'Kilun', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kilun.jpg' ],
            ],
            ],
            [
            'id' => 'CAT13',
            'name' => 'TER-HEBOH 🤯',
            'candidates' => [
                [ 'id' => 'M1', 'name' => 'Rachael', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rachael.jpg' ],
                [ 'id' => 'M2', 'name' => 'Cakra', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Cakra.jpg' ],
                [ 'id' => 'M3', 'name' => 'Kyara', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kyara.jpg' ],
            ],
            ],
            [
            'id' => 'CAT14',
            'name' => 'TER-FOSIL 🦖',
            'candidates' => [
                [ 'id' => 'N1', 'name' => 'Kimi', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kimi.jpg' ],
            ],
            ],
            [
            'id' => 'CAT15',
            'name' => 'TER-BAWEL 🗯️',
            'candidates' => [
                [ 'id' => 'O1', 'name' => 'Shalimar', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Shalimar.jpg' ],
                [ 'id' => 'O2', 'name' => 'Aca', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Aca.jpg' ],
                [ 'id' => 'O3', 'name' => 'Rama', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rama.jpg' ],
            ],
            ],
            [
            'id' => 'CAT16',
            'name' => 'TER-BESTIE 👭',
            'candidates' => [
                [ 'id' => 'P1', 'name' => 'Rara & Vio', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rara&Vio.JPG' ],
                [ 'id' => 'P2', 'name' => 'Alika & Alina', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Alika&Alina.jpg' ],
                [ 'id' => 'P3', 'name' => 'Ara & Shasa', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Ara&Shasa.jpg' ],
            ],
            ],
            [
            'id' => 'CAT17',
            'name' => 'TER-COUPLE 💑',
            'candidates' => [
                [ 'id' => 'Q1', 'name' => 'Abiel & Alina', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Abiel&Alina.jpg' ],
                [ 'id' => 'Q2', 'name' => 'Radya & Cleo', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Radya&Cleo.jpg' ],
                [ 'id' => 'Q3', 'name' => 'Raoul & Teta', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Raoul&Teta.jpg' ],
            ],
            ],
            [
            'id' => 'CAT18',
            'name' => 'TER-CIRCLE 🔄',
            'candidates' => [
                [ 'id' => 'R1', 'name' => 'YTTA', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/YTTA.jpg' ],
                [ 'id' => 'R2', 'name' => 'RC', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/RC.JPG' ],
                [ 'id' => 'R3', 'name' => 'JUBER', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/JUBER.JPG' ],
            ],
            ],
        ];

        return response()->json($categories);

    }

    public function submitVote(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string',
            'vote' => 'required|array',
            'vote.*.category_id' => 'required|string',
            'vote.*.nominee_id' => 'required|string',
        ]);

        // Decrypt the NIS value
        $nis_decrypt = Crypt::decryptString($validated['nis']);

        // Mark the NIS as already voted
        Nis::where('nis', $nis_decrypt)->update(['sudah_polling' => true]);

        // Use the decrypted NIS for storing votes
        $votes = $validated['vote'];

        $createdVotes = [];
        foreach ($votes as $vote) {
            $createdVotes[] = Vote::create([
                'nis' => $validated['nis'],
                'category_id' => $vote['category_id'],
                'nominee_id' => $vote['nominee_id'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Vote submitted successfully.',
            'data' => $createdVotes
        ], 201);
    }

    public function dashboard()
    {
        // Get vote counts grouped by category_id and nominee_id
        $voteCounts = Vote::select('category_id', 'nominee_id')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('category_id', 'nominee_id')
            ->get()
            ->keyBy(function ($item) {
            return $item->category_id . '_' . $item->nominee_id;
            });

        // Categories array (copy from your candidates() method or move to a config file)
        $categories = [
            [
            'id' => 'CAT1',
            'name' => 'KING 👑',
            'candidates' => [
                [ 'id' => 'A1', 'name' => 'Misyal', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Misyal.jpg' ],
                [ 'id' => 'A2', 'name' => 'Syabil', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Syabil.jpg' ],
                [ 'id' => 'A3', 'name' => 'Kenza', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kenza.jpg' ],
            ],
            ],
            [
            'id' => 'CAT2',
            'name' => 'QUEEN 👸',
            'candidates' => [
                [ 'id' => 'B1', 'name' => 'Sasa', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Sasa.jpg' ],
                [ 'id' => 'B2', 'name' => 'Sasha', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Sasha.jpg' ],
                [ 'id' => 'B3', 'name' => 'Selma', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Selma.jpeg' ],
            ],
            ],
            [
            'id' => 'CAT3',
            'name' => 'TER-COOL 😎',
            'candidates' => [
                [ 'id' => 'C1', 'name' => 'Rafsan', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rafsan.JPG' ],
                [ 'id' => 'C2', 'name' => 'Galung', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Galung.jpg' ],
                [ 'id' => 'C3', 'name' => 'Daris', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Daris.jpg' ],
            ],
            ],
            [
            'id' => 'CAT4',
            'name' => 'TER-TENGIL 😜',
            'candidates' => [
                [ 'id' => 'D1', 'name' => 'Yasser', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Yasser.jpg' ],
                [ 'id' => 'D2', 'name' => 'Reno', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Reno.JPG' ],
                [ 'id' => 'D3', 'name' => 'Pandya', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Pandya.jpg' ],
            ],
            ],
            [
            'id' => 'CAT5',
            'name' => 'TER-NGAKAK 😂',
            'candidates' => [
                [ 'id' => 'E1', 'name' => 'Regita', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Regita.jpg' ],
                [ 'id' => 'E2', 'name' => 'Pawas', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Pawas.jpg' ],
                [ 'id' => 'E3', 'name' => 'Dafi', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Dafi.jpg' ],
            ],
            ],
            [
            'id' => 'CAT6',
            'name' => 'TER-FAMOUS 🌟',
            'candidates' => [
                [ 'id' => 'F1', 'name' => 'Alya', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Alya.jpg' ],
                [ 'id' => 'F2', 'name' => 'Kika', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kika.jpg' ],
                [ 'id' => 'F3', 'name' => 'Ludwig', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Ludwig.jpg' ],
            ],
            ],
            [
            'id' => 'CAT7',
            'name' => 'TER-JULID 🗣️',
            'candidates' => [
                [ 'id' => 'G1', 'name' => 'Arzu', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Arzu.jpg' ],
                [ 'id' => 'G2', 'name' => 'Davina', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Davina.JPG' ],
                [ 'id' => 'G3', 'name' => 'Kekei', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kekei.jpg' ],
            ],
            ],
            [
            'id' => 'CAT8',
            'name' => 'TER-SKENA 🎤',
            'candidates' => [
                [ 'id' => 'H1', 'name' => 'Laka', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Laka.jpeg' ],
                [ 'id' => 'H2', 'name' => 'Arga', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Arga.jpeg' ],
                [ 'id' => 'H3', 'name' => 'Cess', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Cess.jpg' ],
            ],
            ],
            [
            'id' => 'CAT9',
            'name' => 'TER-FRIENDLY 🤝',
            'candidates' => [
                [ 'id' => 'I1', 'name' => 'Sarah', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Sarah.jpg' ],
                [ 'id' => 'I2', 'name' => 'Aweng', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Aweng.jpg' ],
                [ 'id' => 'I3', 'name' => 'Abiel', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Abiel.jpg' ],
            ],
            ],
            [
            'id' => 'CAT10',
            'name' => 'TER-CANTIK 💃',
            'candidates' => [
                [ 'id' => 'J1', 'name' => 'Raya', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Raya.jpg' ],
                [ 'id' => 'J2', 'name' => 'Cleo', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Cleo.jpg' ],
                [ 'id' => 'J3', 'name' => 'Chelsea', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Chelsea.jpg' ],
            ],
            ],
            [
            'id' => 'CAT11',
            'name' => 'TER-GANTENG 🤵',
            'candidates' => [
                [ 'id' => 'K1', 'name' => 'Rayyan', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rayyan.JPG' ],
                [ 'id' => 'K2', 'name' => 'Radya', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Radya.jpg' ],
                [ 'id' => 'K3', 'name' => 'Keanu', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Keanu.jpg' ],
            ],
            ],
            [
            'id' => 'CAT12',
            'name' => 'TER-LAMBE 👄',
            'candidates' => [
                [ 'id' => 'L1', 'name' => 'Ninis', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Ninis.jpg' ],
                [ 'id' => 'L2', 'name' => 'Kitaro', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kitaro.jpg' ],
                [ 'id' => 'L3', 'name' => 'Kilun', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kilun.jpg' ],
            ],
            ],
            [
            'id' => 'CAT13',
            'name' => 'TER-HEBOH 🤯',
            'candidates' => [
                [ 'id' => 'M1', 'name' => 'Rachael', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rachael.jpg' ],
                [ 'id' => 'M2', 'name' => 'Cakra', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Cakra.jpg' ],
                [ 'id' => 'M3', 'name' => 'Kyara', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kyara.jpg' ],
            ],
            ],
            [
            'id' => 'CAT14',
            'name' => 'TER-FOSIL 🦖',
            'candidates' => [
                [ 'id' => 'N1', 'name' => 'Kimi', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Kimi.jpg' ],
            ],
            ],
            [
            'id' => 'CAT15',
            'name' => 'TER-BAWEL 🗯️',
            'candidates' => [
                [ 'id' => 'O1', 'name' => 'Shalimar', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Shalimar.jpg' ],
                [ 'id' => 'O2', 'name' => 'Aca', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Aca.jpg' ],
                [ 'id' => 'O3', 'name' => 'Rama', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rama.jpg' ],
            ],
            ],
            [
            'id' => 'CAT16',
            'name' => 'TER-BESTIE 👭',
            'candidates' => [
                [ 'id' => 'P1', 'name' => 'Rara & Vio', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Rara&Vio.JPG' ],
                [ 'id' => 'P2', 'name' => 'Alika & Alina', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Alika&Alina.jpg' ],
                [ 'id' => 'P3', 'name' => 'Ara & Shasa', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Ara&Shasa.jpg' ],
            ],
            ],
            [
            'id' => 'CAT17',
            'name' => 'TER-COUPLE 💑',
            'candidates' => [
                [ 'id' => 'Q1', 'name' => 'Abiel & Alina', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Abiel&Alina.jpg' ],
                [ 'id' => 'Q2', 'name' => 'Radya & Cleo', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Radya&Cleo.jpg' ],
                [ 'id' => 'Q3', 'name' => 'Raoul & Teta', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/Raoul&Teta.jpg' ],
            ],
            ],
            [
            'id' => 'CAT18',
            'name' => 'TER-CIRCLE 🔄',
            'candidates' => [
                [ 'id' => 'R1', 'name' => 'YTTA', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/YTTA.jpg' ],
                [ 'id' => 'R2', 'name' => 'RC', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/RC.JPG' ],
                [ 'id' => 'R3', 'name' => 'JUBER', 'photo_url' => 'https://imageprom.sgp1.cdn.digitaloceanspaces.com/nominee/JUBER.JPG' ],
            ],
            ],
        ];


        // Attach vote count to each nominee
        foreach ($categories as &$category) {
            foreach ($category['candidates'] as &$candidate) {
            $key = $category['id'] . '_' . $candidate['id'];
            $candidate['votes'] = isset($voteCounts[$key]) ? $voteCounts[$key]->total : 0;
            }
        }
        unset($category, $candidate);

        $votes = $categories;
        return view('dashboard.vote', compact('votes'));
    }
}
