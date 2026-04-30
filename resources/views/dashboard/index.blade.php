@extends('layouts.dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Here\'s your fitness summary for today')

@section('content')
<div class="space-y-6 fade-up">
    <!-- Welcome Banner -->
    <div class="relative bg-gradient-to-r from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6 overflow-hidden shadow-lg">
        <div class="absolute right-0 top-0 w-64 h-full opacity-10">
            <svg viewBox="0 0 200 200" class="w-full h-full"><circle cx="150" cy="50" r="100" fill="#22c55e"/></svg>
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-2xl">👋</span>
                    <span class="text-gray-400 text-sm">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}!</span>
                </div>
                <h2 class="text-3xl font-extrabold text-white mb-1">{{ $user->name }}</h2>
                @if($profile?->goal)
                    <div class="badge-green mt-2">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Goal: {{ ucfirst(str_replace('_', ' ', $profile->goal)) }}
                    </div>
                @endif
            </div>
            <div class="flex gap-3 shrink-0">
                <a href="{{ route('workouts.index') }}" class="bg-green-500 text-white font-bold px-6 py-3 rounded-xl hover:bg-green-600 hover:scale-105 shadow-lg shadow-green-500/30 transition-all duration-300 text-base flex items-center justify-center">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Start Workout
                </a>
            </div>
        </div>
    </div>

    <!-- Today's Action -->
    <h3 class="font-bold text-white text-lg mt-8 mb-4">Today's Action</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-gray-800 p-5 rounded-xl border border-gray-700 shadow-lg hover:scale-105 transition-all duration-300">
            <h4 class="text-gray-400 text-sm font-medium uppercase tracking-wider mb-2 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center mr-1">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                Next Workout
            </h4>
            <div class="flex items-center justify-between">
                <p class="text-xl font-bold text-white">{{ $recommendations['workout_plan']->title ?? 'Rest Day' }}</p>
                <a href="{{ route('workouts.index') }}" class="text-green-400 hover:text-green-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        <div class="bg-gray-800 p-5 rounded-xl border border-gray-700 shadow-lg hover:scale-105 transition-all duration-300">
            <h4 class="text-gray-400 text-sm font-medium uppercase tracking-wider mb-2 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-orange-500/10 flex items-center justify-center mr-1">
                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                Calories Target
            </h4>
            <p class="text-xl font-bold text-orange-400">2,400 kcal</p>
        </div>
        <div class="bg-gray-800 p-5 rounded-xl border border-gray-700 shadow-lg hover:scale-105 transition-all duration-300">
            <h4 class="text-gray-400 text-sm font-medium uppercase tracking-wider mb-2 flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center mr-1">
                    <span class="text-red-400 text-sm">🔥</span>
                </div>
                Daily Streak
            </h4>
            <p class="text-xl font-bold text-green-400">{{ $recentWorkoutLogs->count() > 0 ? '3 Days' : '0 Days' }}</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <h3 class="font-bold text-white text-lg mb-4">Overview</h3>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Weight Card -->
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white mb-1">{{ $profile?->weight ?? '--' }} <span class="text-sm text-gray-500 font-normal">kg</span></p>
            <p class="text-gray-400 text-sm uppercase tracking-wider font-semibold">Current Weight</p>
        </div>

        <!-- BMI Card -->
        @php $bmi = $profile?->bmi; $bmiCategory = 'N/A'; $bmiColor = 'text-gray-400'; if($bmi) { if($bmi < 18.5) { $bmiCategory = 'Underweight'; $bmiColor='text-blue-400'; } elseif($bmi < 25) { $bmiCategory = 'Normal'; $bmiColor='text-green-400'; } elseif($bmi < 30) { $bmiCategory = 'Overweight'; $bmiColor='text-yellow-400'; } else { $bmiCategory = 'Obese'; $bmiColor='text-red-400'; } } @endphp
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <span class="text-xs px-2 py-1 rounded border border-gray-700 bg-gray-900 {{ $bmiColor }} font-medium">{{ $bmiCategory }}</span>
            </div>
            <p class="text-3xl font-extrabold text-white mb-1">{{ $profile?->bmi ? number_format($profile->bmi, 1) : '--' }}</p>
            <p class="text-gray-400 text-sm uppercase tracking-wider font-semibold">BMI Score</p>
        </div>

        <!-- Workouts Card -->
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white mb-1">{{ $workoutLogsThisMonth }}</p>
            <p class="text-gray-400 text-sm uppercase tracking-wider font-semibold">Workouts (This Month)</p>
        </div>

        <!-- Progress Card -->
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold text-white mb-1">{{ $progressLogs->count() }}</p>
            <p class="text-gray-400 text-sm uppercase tracking-wider font-semibold">Progress Entries</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Weight Chart -->
        <div class="lg:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-white text-base">Weight Progress</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Your journey over time</p>
                </div>
                <span class="badge-green text-xs">Live Data</span>
            </div>
            <div class="h-60">
                <canvas id="weightChart"></canvas>
            </div>
        </div>

        <!-- Quick Actions + Recommendation -->
        <div class="space-y-4">
            <!-- Today's Tip -->
            <div class="bg-gray-800 p-6 rounded-xl border border-green-500/20 shadow-lg hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Today's Tip</h3>
                </div>
                @if(!empty($recommendations['tips'][0]))
                    <p class="text-green-400 italic text-sm leading-relaxed border-l-2 border-green-500 pl-3">"{{ $recommendations['tips'][0] }}"</p>
                @else
                    <p class="text-gray-400 text-sm italic">Complete your profile to get personalized tips.</p>
                @endif
            </div>

            <!-- AI Recommendation: Workout -->
            <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">Workout Plan</h3>
                </div>
                @if(isset($recommendations['workout_plan']) && $recommendations['workout_plan'])
                    <div class="bg-gray-900/50 p-4 rounded-xl mb-4 border border-gray-700/50">
                        <p class="text-sm font-bold text-white mb-1">{{ $recommendations['workout_plan']->title }}</p>
                        <p class="text-xs text-gray-400 leading-relaxed">{{ Str::limit($recommendations['workout_plan']->description, 80) }}</p>
                    </div>
                    <a href="{{ route('workouts.show', $recommendations['workout_plan']) }}" class="text-xs font-bold text-brand hover:underline uppercase tracking-widest flex items-center gap-1">
                        View Plan <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>

            <!-- AI Recommendation: Diet -->
            <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-orange-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white">Nutritional Plan</h3>
                </div>
                @if(isset($recommendations['diet_plan']) && $recommendations['diet_plan'])
                    @php
                        $meals = is_string($recommendations['diet_plan']->meals_json) 
                                 ? json_decode($recommendations['diet_plan']->meals_json, true) 
                                 : (array)$recommendations['diet_plan']->meals_json;
                        $preview = array_slice($meals ?: [], 0, 3);
                    @endphp
                    <div class="space-y-3 mb-4">
                        @foreach($preview as $type => $food)
                            <div>
                                <p class="text-[10px] font-bold text-orange-400 uppercase tracking-widest">{{ $type }}</p>
                                <p class="text-xs text-gray-300 line-clamp-1">{{ is_string($food) ? str_replace('&', ',', $food) : '—' }}</p>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('diets.show', $recommendations['diet_plan']) }}" class="text-xs font-bold text-brand hover:underline uppercase tracking-widest flex items-center gap-1">
                        View Full Diet <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>

            <!-- Log Progress -->
            <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
                <h3 class="text-xl font-bold text-white mb-4">Log Today's Weight</h3>
                <form action="{{ route('progress.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="number" step="0.1" name="weight" placeholder="Enter weight (kg)" required class="w-full bg-gray-800 border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
                    <input type="date" name="log_date" value="{{ date('Y-m-d') }}" required class="w-full bg-gray-800 border border-gray-600 text-white px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
                    <button type="submit" class="bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600 hover:scale-105 shadow-lg transition-all duration-300 w-full text-sm font-bold flex items-center justify-center">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Save Progress
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    @if($recentWorkoutLogs->isNotEmpty() || $progressLogs->isNotEmpty())
    <div class="card p-6">
        <h3 class="font-bold text-white text-base mb-5">Recent Activity</h3>
        <div class="space-y-3">
            @foreach($recentWorkoutLogs->take(3) as $log)
            <div class="flex items-center gap-4 p-3 rounded-xl bg-surface hover:bg-surface-3 transition-all duration-200">
                <div class="w-9 h-9 rounded-xl bg-orange-500/10 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white">{{ $log->workoutPlan?->title ?? 'Workout Logged' }}</p>
                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->date)->diffForHumans() }}</p>
                </div>
                <span class="badge-green text-xs">{{ ucfirst($log->status) }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('weightChart').getContext('2d');
const grad = ctx.createLinearGradient(0, 0, 0, 240);
grad.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
grad.addColorStop(1, 'rgba(34, 197, 94, 0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($progressLogs->pluck('log_date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))->toArray()) !!},
        datasets: [{
            label: 'Weight (kg)',
            data: {!! json_encode($progressLogs->pluck('weight')->toArray()) !!},
            borderColor: '#22c55e',
            borderWidth: 2.5,
            pointBackgroundColor: '#22c55e',
            pointBorderColor: '#0a0f1a',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
            fill: true,
            backgroundColor: grad,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: false,
                grid: { color: 'rgba(255,255,255,0.03)', drawBorder: false },
                ticks: { color: '#6b7280', font: { family: 'Inter', size: 11 } }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#6b7280', font: { family: 'Inter', size: 11 } }
            }
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1f2937',
                titleFont: { family: 'Inter', size: 12 },
                bodyFont: { family: 'Inter', size: 12 },
                padding: 12,
                cornerRadius: 10,
                displayColors: false,
                borderColor: 'rgba(34, 197, 94, 0.2)',
                borderWidth: 1,
                callbacks: { label: ctx => `${ctx.parsed.y} kg` }
            }
        }
    }
});
</script>
@endsection
