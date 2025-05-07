@php
    use App\Models\Tiket;

    $totalTiket = Tiket::sum('jumlah_tiket');
    $totalPendapatan = Tiket::where('status', 'completed')->sum(\DB::raw('jumlah_tiket * harga'));
    $terverifikasi = Tiket::where('status', 'completed')->count();
    $sudahCheckIn = Tiket::where('entry', '1')->count();
    $belumCheckIn = Tiket::where('entry', '0')->count();
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
            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    fetch('/api/get-quote')
                        .then(response => response.json())
                        .then(data => {
                            const dailyQuoteElement = document.getElementById('dailyQuote');
                            if (data && data.quote) {
                                dailyQuoteElement.textContent = data.quote;
                            } else {
                                dailyQuoteElement.textContent = 'Quotes tidak tersedia.';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching quote:', error);
                            document.getElementById('dailyQuote').textContent = 'Gagal memuat Quotes.';
                        });
                });
            </script>
            @endpush
        </div>
        
        
            
        </div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-2xl bg-background p-6 shadow-sm">
                    <h3 class="text-sm font-medium text-muted">Tiket Terjual</h3>
                    <p class="mt-2 text-3xl font-bold text-foreground">{{ $totalTiket }}</p>
                </div>

                <div class="rounded-2xl bg-background p-6 shadow-sm">
                    <h3 class="text-sm font-medium text-muted">Total Pendapatan</h3>
                    <p class="mt-2 text-3xl font-bold text-foreground">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>

                <div class="rounded-2xl bg-background p-6 shadow-sm">
                    <h3 class="text-sm font-medium text-muted">Terverifikasi</h3>
                    <p class="mt-2 text-3xl font-bold text-foreground">{{ $terverifikasi }}</p>
                </div>

                <div class="rounded-2xl bg-background p-6 shadow-sm">
                    <h3 class="text-sm font-medium text-muted">Sudah Check In</h3>
                    <p class="mt-2 text-3xl font-bold text-foreground">{{ $sudahCheckIn }}</p>
                </div>
            </div>

            

            
            <x-footer></x-footer>
        </div>
        
    </div>
    
    
</x-app-layout>
