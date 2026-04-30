@extends('layouts.dashboard')

@section('page-title', 'Progress Tracker')
@section('page-subtitle', 'Track your transformation journey')

@section('content')
<div class="space-y-6 fade-up">

    @php
        $sortedLogs = $progressLogs->sortBy('log_date');
        $hasEnoughData = $sortedLogs->count() >= 2;
        $firstWeight = $hasEnoughData ? $sortedLogs->first()->weight : null;
        $lastWeight  = $hasEnoughData ? $sortedLogs->last()->weight : null;
        $totalChange = $hasEnoughData ? round($lastWeight - $firstWeight, 1) : null;
        $streak      = $progressLogs->count(); // simplified streak = total logs
    @endphp

    <!-- Weight Change Summary Banner -->
    @if($hasEnoughData)
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 flex items-center gap-4 shadow-lg hover:scale-105 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl {{ $totalChange <= 0 ? 'bg-green-500/10' : 'bg-orange-500/10' }} flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 {{ $totalChange <= 0 ? 'text-green-400' : 'text-orange-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="{{ $totalChange <= 0 ? 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' : 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' }}"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Weight Change</p>
                <p class="text-2xl font-extrabold {{ $totalChange <= 0 ? 'text-green-400' : 'text-orange-400' }}">
                    {{ $totalChange > 0 ? '+' : '' }}{{ $totalChange }} kg
                </p>
                <p class="text-xs text-gray-500">since you started</p>
            </div>
        </div>
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 flex items-center gap-4 shadow-lg hover:scale-105 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center shrink-0">
                <span class="text-2xl">🔥</span>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Consistency Streak</p>
                <p class="text-2xl font-extrabold text-purple-400">{{ $streak }} <span class="text-sm font-normal text-gray-500">entries</span></p>
                <p class="text-xs text-gray-500">keep it going!</p>
            </div>
        </div>
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 flex items-center gap-4 shadow-lg hover:scale-105 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-0.5">Latest Weight</p>
                <p class="text-2xl font-extrabold text-white">{{ $lastWeight }} <span class="text-sm font-normal text-gray-500">kg</span></p>
                <p class="text-xs text-gray-500">BMI: {{ $profile?->bmi ? number_format($profile->bmi,1) : '--' }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Forms -->
        <div class="space-y-5">

            <!-- Log Weight Form -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-white mb-5 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    Log Today's Weight
                </h3>
                <form action="{{ route('progress.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" placeholder="e.g. 75.5" required
                               class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/50 transition-all duration-300 placeholder-gray-600 text-lg font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Date</label>
                        <input type="date" name="log_date" value="{{ date('Y-m-d') }}" required
                               class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/50 transition-all duration-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                            Progress Photo <span class="text-gray-600 normal-case font-normal">(optional)</span>
                        </label>
                        <div class="relative group/upload">
                            <input type="file" name="image" accept="image/*"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="border-2 border-dashed border-gray-600 rounded-xl p-6 text-center hover:border-green-500 hover:bg-gray-700/50 transition-all duration-300">
                                <svg class="w-8 h-8 text-gray-500 mx-auto mb-2 group-hover/upload:text-green-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs text-gray-500">Click to upload photo</p>
                                <p class="text-xs text-gray-600 mt-0.5">PNG, JPG up to 5MB</p>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                            class="bg-green-500 text-white px-5 py-3 rounded-lg hover:bg-green-600 hover:scale-105 shadow-lg shadow-green-500/20 transition-all duration-300 w-full text-sm font-bold flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Save Progress Entry
                    </button>
                </form>
            </div>

            <!-- Current Stats -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6 hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
                <h3 class="text-xl font-bold text-white mb-4">Current Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                        <span class="text-sm text-gray-400">Weight</span>
                        <span class="text-sm font-bold text-white">{{ $profile?->weight ?? '--' }} kg</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                        <span class="text-sm text-gray-400">Height</span>
                        <span class="text-sm font-bold text-white">{{ $profile?->height ?? '--' }} cm</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-700">
                        <span class="text-sm text-gray-400">BMI</span>
                        <span class="text-sm font-bold text-green-400">{{ $profile?->bmi ? number_format($profile->bmi, 1) : '--' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-400">Goal</span>
                        <span class="text-sm font-bold text-white capitalize">{{ str_replace('_', ' ', $profile?->goal ?? '--') }}</span>
                    </div>
                </div>
            </div>

            <!-- Update Profile -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-white mb-4">Update Profile</h3>
                <form action="{{ route('dashboard.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Height (cm)</label>
                        <input type="number" step="0.1" name="height" value="{{ $profile?->height }}" placeholder="170"
                               class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/50 transition-all duration-300 placeholder-gray-600 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" value="{{ $profile?->weight }}" placeholder="70"
                               class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/50 transition-all duration-300 placeholder-gray-600 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Fitness Goal</label>
                        <select name="goal"
                                class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/50 transition-all duration-300 text-sm">
                            <option value="">Select goal</option>
                            <option value="weight_loss"  {{ $profile?->goal === 'weight_loss'  ? 'selected' : '' }}>Weight Loss</option>
                            <option value="muscle_gain"  {{ $profile?->goal === 'muscle_gain'  ? 'selected' : '' }}>Muscle Gain</option>
                            <option value="maintenance"  {{ $profile?->goal === 'maintenance'  ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="border border-gray-600 text-gray-300 hover:text-white px-5 py-2.5 rounded-lg hover:bg-gray-700 transition-all duration-300 w-full text-sm font-bold">
                        Update Stats
                    </button>
                </form>
            </div>
        </div>

        <!-- Right: Chart + History -->
        <div class="lg:col-span-2 space-y-5">

            <!-- Chart -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-white">Weight Over Time</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $sortedLogs->count() }} data points recorded</p>
                    </div>
                    @if($hasEnoughData)
                    <span class="text-xs px-3 py-1.5 rounded-full font-bold border
                        {{ $totalChange <= 0
                            ? 'bg-green-500/10 text-green-400 border-green-500/30'
                            : 'bg-orange-500/10 text-orange-400 border-orange-500/30' }}">
                        {{ $totalChange > 0 ? '▲ +' : '▼ ' }}{{ $totalChange }} kg total
                    </span>
                    @endif
                </div>
                <div class="h-72">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>

            <!-- History Table -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-white mb-5">Progress History</h3>
                @if($progressLogs->isNotEmpty())
                <div class="space-y-2">
                    @foreach($progressLogs->sortByDesc('log_date')->take(10) as $log)
                    <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-900 hover:bg-gray-700 transition-all duration-200 border border-gray-700 hover:border-green-500/30">
                        <div class="w-9 h-9 rounded-xl bg-green-500/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-white">{{ $log->weight }} kg</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->log_date)->format('M d, Y') }}</p>
                        </div>
                        @if($log->transformation_image)
                        <img src="{{ asset('storage/' . $log->transformation_image) }}"
                             class="w-10 h-10 rounded-lg object-cover border border-gray-700">
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                    <p class="text-gray-500 font-semibold">No progress logged yet.</p>
                    <p class="text-gray-600 text-sm mt-1">Use the form on the left to start tracking!</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('progressChart').getContext('2d');
const grad = ctx.createLinearGradient(0, 0, 0, 288);
grad.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
grad.addColorStop(0.6, 'rgba(34, 197, 94, 0.08)');
grad.addColorStop(1, 'rgba(34, 197, 94, 0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($sortedLogs->pluck('log_date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))->toArray()) !!},
        datasets: [{
            label: 'Weight (kg)',
            data: {!! json_encode($sortedLogs->pluck('weight')->toArray()) !!},
            borderColor: '#22c55e',
            borderWidth: 2.5,
            pointBackgroundColor: '#22c55e',
            pointBorderColor: '#1f2937',
            pointBorderWidth: 2.5,
            pointRadius: 6,
            pointHoverRadius: 9,
            pointHoverBackgroundColor: '#22c55e',
            pointHoverBorderColor: '#fff',
            pointHoverBorderWidth: 2,
            fill: true,
            backgroundColor: grad,
            tension: 0.45,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: false,
                grid: { color: 'rgba(255,255,255,0.04)', drawBorder: false },
                ticks: { color: '#6b7280', font: { family: 'Inter', size: 11 }, padding: 8 }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#6b7280', font: { family: 'Inter', size: 11 }, padding: 6 }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#111827',
                titleColor: '#f9fafb',
                bodyColor: '#9ca3af',
                borderColor: 'rgba(34, 197, 94, 0.4)',
                borderWidth: 1,
                titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                bodyFont: { family: 'Inter', size: 12 },
                padding: 12,
                cornerRadius: 10,
                displayColors: false,
                callbacks: { label: ctx => `${ctx.parsed.y} kg` }
            }
        }
    }
});
</script>
@endsection
