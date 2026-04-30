@extends('layouts.dashboard')

@section('page-title', $workout->title)
@section('page-subtitle', 'Workout Plan Details')

@section('content')
<div class="space-y-6 fade-up">
    <!-- Back -->
    <a href="{{ route('workouts.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Workouts
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6 hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full {{ $workout->level === 'beginner' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : ($workout->level === 'intermediate' ? 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20') }} uppercase mb-3 inline-block">{{ $workout->level }}</span>
                        <h1 class="text-3xl font-extrabold text-white">{{ $workout->title }}</h1>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-2xl font-extrabold text-brand">{{ $workout->duration_weeks }}</p>
                        <p class="text-xs text-gray-500">Weeks</p>
                    </div>
                </div>

                <p class="text-gray-400 leading-relaxed mb-8">{{ $workout->description }}</p>

                @auth
                    <form action="{{ route('workout-logs.store') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="workout_plan_id" value="{{ $workout->id }}">
                        <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600 hover:scale-105 shadow-lg transition-all duration-300 text-sm font-bold flex items-center">
                            <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Mark as Completed
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-green-500 text-white px-5 py-2 rounded-lg hover:bg-green-600 hover:scale-105 shadow-lg transition-all duration-300 text-sm inline-block font-bold">Login to Start</a>
                @endauth
            </div>

            <!-- Exercise List -->
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6 hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
                <h3 class="font-bold text-white text-base mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Exercise List ({{ $workout->exercises->count() }} exercises)
                </h3>
                @if($workout->exercises->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($workout->exercises as $i => $exercise)
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-surface hover:bg-surface-3 transition-all duration-200 group">
                            <div class="w-9 h-9 rounded-xl bg-brand/10 flex items-center justify-center text-brand font-bold text-sm shrink-0 group-hover:bg-brand/20 transition">{{ $i + 1 }}</div>
                            <div class="flex-1">
                                <p class="font-semibold text-white text-sm">{{ $exercise->name }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $exercise->body_part }}</p>
                            </div>
                            @if($exercise->sets && $exercise->reps)
                            <span class="text-xs text-gray-400 bg-surface-2 px-3 py-1.5 rounded-lg border border-border-col">{{ $exercise->sets }}x{{ $exercise->reps }}</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-600 text-sm italic">Exercise details will be added soon.</div>
                @endif
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-5">
            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6 hover:scale-105 hover:shadow-green-500/10 transition-all duration-300">
                <h3 class="font-bold text-white text-sm mb-4">Plan Overview</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-border-col/50">
                        <span class="text-xs text-gray-500">Duration</span>
                        <span class="text-sm font-semibold text-white">{{ $workout->duration_weeks }} Weeks</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-border-col/50">
                        <span class="text-xs text-gray-500">Difficulty</span>
                        <span class="text-sm font-semibold text-white capitalize">{{ $workout->level }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-xs text-gray-500">Exercises</span>
                        <span class="text-sm font-semibold text-white">{{ $workout->exercises->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-xl shadow-lg p-6 hover:scale-105 hover:shadow-green-500/10 transition-all duration-300 border-l-4 border-l-brand-orange">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h4 class="text-sm font-bold text-white">Tips</h4>
                </div>
                <p class="text-xs text-gray-400 leading-relaxed">Warm up for 5-10 minutes before starting. Stay hydrated throughout your session and rest 60-90 seconds between sets.</p>
            </div>
        </div>
    </div>
</div>
@endsection
