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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach ($votes as $index => $category)
    <div class="bg-background rounded-2xl p-6 shadow-sm flex flex-col">
        <h3 class="text-lg font-semibold text-foreground mb-4">{{ $category['name'] }}</h3>
        <canvas id="chart-{{ $index }}" height="120"></canvas>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full text-sm text-left border">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">#</th>
                        <th class="px-4 py-2 border-b">Nama Kandidat</th>
                        <th class="px-4 py-2 border-b">Jumlah Vote</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category['candidates'] as $i => $candidate)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $i + 1 }}</td>
                        <td class="px-4 py-2 border-b">{{ $candidate['name'] }}</td>
                        <td class="px-4 py-2 border-b">{{ $candidate['votes'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
