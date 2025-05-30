<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-foreground flex items-center gap-2">
            <i class="fa fa-bar-chart"></i>
            {{ __('Hasil Voting') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-foreground">
                    {{ __('Hasil Voting Prom Awards') }}
                </h1>
            </div>
            <div class="flex items-center justify-center mb-8">
                <div class="flex items-center gap-4 bg-muted px-8 py-5 rounded-2xl shadow">
                    <div class="flex items-center justify-center w-14 h-14 rounded-full bg-white shadow-inner">
                        <i class="fa fa-users text-3xl text-blue-600"></i>
                    </div>
                    <div class="text-left">
                        <div class="text-3xl font-bold text-foreground leading-tight">
                            {{ number_format($totalVoters) }}
                        </div>
                        <div class="text-muted-foreground text-base font-medium">
                            orang sudah melakukan voting
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mb-6">
                <div class="text-sm text-muted-foreground">
                    Terakhir diperbaharui: {{ now()->format('d M Y H:i') }}
                </div>
                <form method="GET" action="{{ url()->current() }}">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition border border-blue-600 shadow">
                        <i class="fa fa-refresh mr-2"></i> Refresh
                    </button>
                </form>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($votes as $index => $category)
                    @php
                        $topVotes = collect($category['candidates'])->max('votes');
                    @endphp
                    <div class="bg-background rounded-2xl p-6 shadow-sm flex flex-col">
                        <h3 class="text-lg font-semibold text-foreground mb-4">{{ $category['name'] }}</h3>
                        <canvas id="chart-{{ $index }}" height="120"></canvas>

                        <div class="mt-4 space-y-3">
                            @foreach ($category['candidates'] as $i => $candidate)
                                <div class="flex items-center gap-4 bg-muted/50 p-3 rounded-xl shadow-sm">
                                    <div class="relative w-14 h-14 shrink-0 rounded-full overflow-hidden border border-muted">
                                        <img src="{{ $candidate['photo_url'] }}" alt="{{ $candidate['name'] }}" class="w-full h-full object-cover">
                                        @if ($candidate['votes'] == $topVotes)
                                            <div class="absolute -top-3 -right-3 text-xl">👑</div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium text-foreground">
                                            {{ $candidate['name'] }}
                                        </div>
                                        <div class="text-sm text-muted-foreground">
                                            {{ $candidate['votes'] }} suara
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <x-footer></x-footer>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const votes = @json($votes);
            const pieColors = [
                '#3B82F6', '#F59E42', '#10B981', '#EF4444', '#A78BFA', '#F472B6', '#FCD34D', '#60A5FA'
            ];

            votes.forEach((category, index) => {
                const ctx = document.getElementById('chart-' + index).getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: category.candidates.map(c => c.name),
                        datasets: [{
                            data: category.candidates.map(c => c.votes),
                            backgroundColor: pieColors,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: true, position: 'bottom' }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
