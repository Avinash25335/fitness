@extends('layouts.dashboard')

@section('page-title', 'Workout Plans')
@section('page-subtitle', 'Choose and track your training program')

@section('content')
<div class="space-y-10 fade-up" x-data="{ filter: 'all' }">

    <!-- Header + Premium Pill Filters with Icons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight">Training Programs</h2>
            <p class="text-sm text-gray-400 mt-1">Science-backed plans designed for your success</p>
        </div>
        
        <div class="flex p-1.5 bg-surface-2 rounded-2xl border border-border-col">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-brand text-white shadow-lg scale-105' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                All
            </button>
            <button @click="filter = 'beginner'" :class="filter === 'beginner' ? 'bg-green-500 text-white shadow-lg scale-105' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                🟢 Beginner
            </button>
            <button @click="filter = 'intermediate'" :class="filter === 'intermediate' ? 'bg-yellow-500 text-white shadow-lg scale-105' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                💪 Pro
            </button>
            <button @click="filter = 'advanced'" :class="filter === 'advanced' ? 'bg-red-500 text-white shadow-lg scale-105' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                🔥 Elite
            </button>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse($workouts as $index => $workout)
        @php
            $level = $workout->level ?? 'beginner';
            $isActive = isset($activePlanId) && $activePlanId == $workout->id;
            $isLogged = isset($loggedPlanIds) && $loggedPlanIds->contains($workout->id);
            $progressCount = $planProgress[$workout->id] ?? 0;
            $totalExpected = 12; // Mock total sessions per plan
            $percent = min(100, round(($progressCount / $totalExpected) * 100));
            $isCompleted = $percent >= 100;

            $isRecommended = $index === 0 && !$isActive;
            
            $bannerClass = match($level) {
                'beginner'     => 'from-green-500 to-emerald-400',
                'intermediate' => 'from-yellow-500 to-orange-500',
                'advanced'     => 'from-red-500 to-rose-500',
                default        => 'from-brand to-brand-dark',
            };

            $btnText = $isCompleted ? 'Completed ✅' : ($isActive ? 'Continue Program →' : ($isLogged ? 'Restart Program' : 'Start Program →'));
        @endphp
        
        <div class="flex flex-col h-full bg-gray-800 border transition-all duration-500 rounded-[2rem] overflow-hidden group relative"
             x-show="filter === 'all' || filter === '{{ $level }}'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             :class="{
                'border-brand shadow-[0_0_40px_rgba(34,197,94,0.15)] scale-[1.01] z-10': {{ $isActive ? 'true' : 'false' }},
                'border-gray-700/50 shadow-xl hover:-translate-y-1 hover:shadow-brand/20 hover:border-brand/30': !{{ $isActive ? 'true' : 'false' }}
             }">
            
            <!-- Top Status Bar -->
            <div class="h-1.5 w-full bg-gradient-to-r {{ $bannerClass }}"></div>

            <!-- Status Badges -->
            <div class="absolute top-6 right-6 flex flex-col items-end gap-2">
                @if($isActive)
                    <span class="bg-brand text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg border border-white/10 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                        Active
                    </span>
                @elseif($isCompleted)
                    <span class="bg-blue-500 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg">
                        ✓ Finished
                    </span>
                @elseif($isRecommended)
                    <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-black text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg">
                        ⭐ Recommended
                    </span>
                @endif
            </div>

            <div class="p-8 flex flex-col flex-1 space-y-6">
                <!-- Meta Info -->
                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] px-2.5 py-1 rounded-lg bg-white/5 border border-white/5 text-gray-500">
                        {{ $level }}
                    </span>
                    <span class="text-gray-700">•</span>
                    <div class="flex items-center gap-1.5 text-gray-500">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">{{ $workout->duration_weeks }} Weeks</span>
                    </div>
                </div>

                <!-- Icon + Title -->
                <div class="flex items-start gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-gray-700 to-gray-800 border border-white/5 flex items-center justify-center shrink-0 group-hover:border-brand/30 transition-all shadow-inner">
                        <svg class="w-7 h-7 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white leading-tight tracking-tight group-hover:text-brand transition-colors">
                            {{ $workout->title }}
                        </h3>
                        @if($isLogged)
                            <p class="text-[10px] font-black text-brand uppercase tracking-widest mt-1">{{ $progressCount }} / {{ $totalExpected }} sessions completed</p>
                        @else
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mt-1">High Intensity Pro</p>
                        @endif
                    </div>
                </div>

                <!-- Progress Bar (Visible if started) -->
                @if($isLogged)
                <div class="space-y-2">
                    <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full bg-brand transition-all duration-1000 rounded-full shadow-[0_0_10px_rgba(34,197,94,0.3)]" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
                @endif

                <!-- Description -->
                <p class="text-sm text-[#B0B8C5] leading-relaxed line-clamp-2">
                    {{ $workout->description }}
                </p>

                <!-- Stats Divider -->
                <div class="grid grid-cols-2 gap-4 pt-6 border-t border-white/5 mt-auto">
                    <div class="flex flex-col">
                        <span class="text-[9px] font-black text-gray-600 uppercase tracking-[0.2em] mb-1">Total Exercises</span>
                        <span class="text-lg font-black text-white">{{ $workout->exercises_count ?? $workout->exercises->count() }}</span>
                    </div>
                    <div class="flex flex-col border-l border-white/5 pl-4">
                        <span class="text-[9px] font-black text-gray-600 uppercase tracking-[0.2em] mb-1">Focus Area</span>
                        <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Full Body</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-4">
                    <a href="{{ route('workouts.show', $workout) }}"
                       class="w-full px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-center transition-all duration-300 shadow-lg block {{ $isCompleted ? 'bg-white text-gray-900' : 'bg-green-500 text-white hover:bg-green-600 hover:scale-[1.02] shadow-green-500/20' }}">
                        {{ $btnText }}
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 card py-20 text-center">
            <p class="text-gray-500 font-black uppercase tracking-widest">No programs available.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
