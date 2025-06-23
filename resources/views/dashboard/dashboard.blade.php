@php
    use App\Models\Tiket;
    use App\Models\Merch;
    use App\Models\Nis;

    $totalTiket = Tiket::where('order_id', '!=', 'MN-E26KYO')->sum('jumlah_tiket');
    $totalPendapatan = Tiket::whereIn('status', ['completed', 'half'])->sum('harga');
    $terverifikasi = Tiket::whereIn('status', ['completed', 'half'])
        ->where('order_id', '!=', 'MN-E26KYO')
        ->count();
    $sudahCheckIn = Tiket::where('entry', '1')->where('order_id', '!=', 'MN-E26KYO')->count();
    $belumCheckIn = Tiket::where('entry', '0')->where('order_id', '!=', 'MN-E26KYO')->count();
    $pendapatanMerch = Merch::where('status_bayar', 'success')->sum(\DB::raw('grand_total'));
    $belumPickup = Merch::where('status_bayar', 'success')->where('status_pickup', 'not_picked')->count();
    $totalbuyerMerch = Merch::count();
    $merchverified = Merch::where('status_bayar', 'success')->count();

    // Chart data per kelas
    $kelasList = ['XII - 1','XII - 2','XII - 3','XII - 4','XII - 5','XII - 6','XII - 7','XII - 8','XII - 9'];
    $dataKelas = [];
    foreach ($kelasList as $kelas) {
        $totalSiswa = Nis::where('kelas', $kelas)->count();
        $ikut = Tiket::where('kelas', $kelas)->distinct('nis')->count('nis');
        $tidakIkut = $totalSiswa - $ikut;
        $persenIkut = $totalSiswa > 0 ? round(($ikut / $totalSiswa) * 100, 1) : 0;
        $dataKelas[] = [
            'kelas' => $kelas,
            'ikut' => $ikut,
            'tidak_ikut' => $tidakIkut,
            'persen' => $persenIkut
        ];
    }
    $labelKelas = collect($dataKelas)->pluck('kelas')->toArray();
    $ikutKelas = collect($dataKelas)->pluck('ikut')->toArray();
    $tidakIkutKelas = collect($dataKelas)->pluck('tidak_ikut')->toArray();
    $persenKelas = collect($dataKelas)->pluck('persen')->toArray();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-foreground flex items-center gap-2">
            <i class="fa fa-home"></i>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-foreground">
                {{ __('Selamat Datang, ') . Auth::user()->name . '!' }}
            </h1>
            <p class="mt-3 text-lg text-muted" id="dailyQuote">
                {{ __('Memuat Quotes...') }}
            </p>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-foreground">
                    {{ __('Ticket Sales') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-stat-card title="Tiket Terjual" value="{{ $totalTiket }}" />
                <x-stat-card title="Total Pendapatan" value="Rp {{ number_format($totalPendapatan, 0, ',', '.') }}" />
                <x-stat-card title="Terverifikasi" value="{{ $terverifikasi }}" />
                <x-stat-card title="Sudah Check In" value="{{ $sudahCheckIn }}" />
            </div>

            <div class="text-center pt-6">
                <h2 class="text-2xl font-semibold text-foreground">
                    {{ __('Merch Sales') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-stat-card title="Total Pembeli" value="{{ $totalbuyerMerch }}" />
                <x-stat-card title="Terverifikasi" value="{{ $merchverified }}" />
                <x-stat-card title="Total Pendapatan" value="Rp {{ number_format($pendapatanMerch, 0, ',', '.') }}" />
                <x-stat-card title="Menunggu Pickup" value="{{ $belumPickup }}" />
            </div>

            

            <!-- Tabel Persentase -->
            <div class="rounded-2xl bg-background p-4 shadow-sm mt-6">
                <h3 class="text-lg font-semibold text-foreground mb-4">Tabel Persentase:</h3>
                <table class="w-full text-sm text-left text-muted border border-muted rounded-xl overflow-hidden">
                    <thead class="text-xs uppercase bg-muted text-muted-foreground">
                        <tr>
                            <th class="px-4 py-2">Kelas</th>
                            <th class="px-4 py-2">Total Siswa</th>
                            <th class="px-4 py-2">Ikut</th>
                            <th class="px-4 py-2">Tidak Ikut</th>
                            <th class="px-4 py-2">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataKelas as $row)
                            <tr class="border-t border-muted">
                                <td class="px-4 py-2 font-medium">{{ $row['kelas'] }}</td>
                                <td class="px-4 py-2">{{ $row['ikut'] + $row['tidak_ikut'] }}</td>
                                <td class="px-4 py-2 text-green-600">{{ $row['ikut'] }}</td>
                                <td class="px-4 py-2 text-red-600">{{ $row['tidak_ikut'] }}</td>
                                <td class="px-4 py-2 font-semibold">{{ $row['persen'] }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <x-footer />
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('/api/get-quote')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('dailyQuote').textContent = data?.quote ?? 'Quotes tidak tersedia.';
                })
                .catch(() => {
                    document.getElementById('dailyQuote').textContent = 'Gagal memuat Quotes.';
                });

            
        });
    </script>
    @endpush
</x-app-layout>
