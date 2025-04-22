<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function getQuote()
    {
        $quotes = [
            "Cinta pertama tak selalu abadi, tapi kenangan bersamamu di sekolah akan terus hidup. – Ayu Prameswari",
            "Persahabatan sejati tidak diukur dari seberapa lama kita bersama, tapi dari seberapa dalam kita saling memahami. – Fajar Nugroho",
            "Perpisahan hanyalah jarak, bukan penghalang untuk terus meraih mimpi. – Reza Mahendra",
            "Kita datang sebagai siswa, pulang sebagai keluarga yang penuh kenangan. – Lestari Wulandari",
            "Mungkin kita tak lagi duduk di kelas yang sama, tapi hati kita akan selalu terhubung. – Dian Ayuningtyas",
            "Perjalanan ini telah mengajarkan arti cinta yang sederhana: perhatian di antara bangku sekolah. – Andi Saputra",
            "Berpisah dengan teman sekelas lebih menyakitkan daripada gagal ujian. – Intan Maulani",
            "Sekolah telah selesai, tapi mimpi-mimpi kita baru saja dimulai. – Rangga Permadi",
            "Tak mudah melupakan tawa di bangku belakang dan tatapan diam di perpustakaan. – Nabila Fauziah",
            "Dalam ruang kelas yang sempit, kita menemukan dunia yang luas bernama persahabatan. – Dito Santosa",
            "Aku jatuh cinta padamu di antara jadwal pelajaran dan tugas harian. – Sari Lestari",
            "Satu demi satu kita akan pergi, tapi janji untuk saling mendukung tak akan mati. – Yoga Prabowo",
            "Tak ada yang lebih menyentuh hati selain perpisahan dengan mereka yang setiap hari menemani. – Winda Oktaviani",
            "Perpisahan ini bukanlah akhir, tapi titik awal menuju masa depan yang telah kita impikan. – Hendra Wijaya",
            "Semua yang pernah kita jalani akan menjadi bab indah dalam buku kehidupan kita. – Tika Rahmawati",
            "Di antara deretan meja dan papan tulis, kita menulis kisah yang tak akan terhapus. – Rino Kurniawan",
            "Cinta masa sekolah mungkin singkat, tapi bekasnya bisa abadi. – Karina Putri",
            "Kita bukan sekadar teman sebangku, kita adalah saksi tumbuhnya mimpi satu sama lain. – Farhan Nugraha",
            "Waktu akan memisahkan kita, tapi kenangan akan terus menyatukan. – Salsabila Azmi",
            "Langit sekolah ini pernah jadi tempat kita bermimpi dan jatuh cinta dalam diam. – Bima Ramadhan",
            "Kita tertawa, menangis, bahkan jatuh cinta di tempat yang sama. – Fitri Azzahra",
            "Sekolah adalah panggung pertama, masa depan adalah pentas sesungguhnya. – Rangga Dwi Putra",
            "Persahabatan kita lahir dari tugas kelompok, ujian, dan tawa tanpa alasan. – Luki Andriansyah",
            "Saat kita berpisah, bukan hanya orang yang kita tinggalkan, tapi juga sebagian dari hati kita. – Mentari Ayu",
            "Aku mengenal arti cinta bukan dari drama, tapi dari caramu menatapku saat ulangan. – Aditya Saputro",
            "Mimpi besar dimulai dari ruang kelas kecil dan semangat yang tak pernah padam. – Febrian Hartanto",
            "Tak ada yang benar-benar berakhir jika kenangan masih hidup di hati. – Aulia Khairunnisa",
            "Perpisahan adalah saat kita mengemas kenangan, bukan menghapusnya. – Rizky Maulana",
            "Kita pernah jadi kisah dalam buku pelajaran, kini kita jadi kisah dalam hidup satu sama lain. – Vina Lestari",
            "Waktu boleh berlalu, tapi cinta dan persahabatan yang tumbuh di sekolah tak akan pudar. – Arif Nugroho",
            "Perjalanan kita belum selesai, hanya berganti arah. – Meisya Fadilah",
            "Kita tak bisa kembali ke masa lalu, tapi kita bisa membawa semangatnya ke masa depan. – Daffa Hidayat",
            "Terkadang, orang yang paling kita rindukan adalah mereka yang setiap hari kita temui di sekolah. – Sheila Ramadhani",
            "Bersama kalian, aku belajar bukan hanya pelajaran, tapi juga arti kehidupan. – Fikri Adnan",
            "Hari terakhir sekolah adalah hari pertama kita sebagai pemilik masa depan. – Nadia Zahra"
        ];
        

        $randomQuote = $quotes[array_rand($quotes)];

        return response()->json([
            'quote' => $randomQuote
        ]);
    }
}
