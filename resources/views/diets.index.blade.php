@extends('layouts.dashboard')

@section('page-title', 'Diet Plans')
@section('page-subtitle', 'Fuel your body with the right nutrition plan')

@section('content')
<div class="space-y-10 fade-up" x-data="{ filter: 'all' }">

    <!-- Header + Filter Tabs with Icons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h2 class="text-2xl font-black text-white tracking-tight">Nutrition Plans</h2>
            <p class="text-sm text-gray-400 mt-1">Select a meal plan that aligns with your fitness goals</p>
        </div>

        <!-- Premium Filter Tabs -->
        <div class="flex p-1.5 bg-surface-2 rounded-2xl border border-border-col">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-brand text-white shadow-lg scale-105' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                All
            </button>
            <button @click="filter = 'muscle_gain'" :class="filter === 'muscle_gain' ? 'bg-orange-500 text-white shadow-lg scale-105' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                💪 Gain
            </button>
            <button @click="filter = 'weight_loss'" :class="filter === 'weight_loss' ? 'bg-green-500 text-white shadow-lg scale-105' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                🔥 Loss
            </button>
            <button @click="filter = 'maintenance'" :class="filter === 'maintenance' ? 'bg-blue-500 text-white shadow-lg scale-105' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 flex items-center gap-2">
                ⚖️ Maintain
            </button>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @forelse($diets as $index => $diet)
        @php
            $isFollowing = isset($followingDietId) && $followingDietId == $diet->id;
            $isMatch = isset($userGoal) && $diet->goal === $userGoal;
            $isPopular = $index === 1; // Mock popular status
            
            $mealsArray = is_string($diet->meals_json) ? json_decode($diet->meals_json, true) : (array)$diet->meals_json;
            $preview = array_slice($mealsArray ?: [], 0, 3);
            
            $mealIcons = ['Breakfast' => '🍳', 'Morning Snack' => '🥜', 'Lunch' => '🥗', 'Afternoon Snack' => '🥤', 'Dinner' => '🍗'];

            $barColor = match($diet->goal) {
                'weight_loss'  => 'from-green-500 to-emerald-400',
                'muscle_gain'  => 'from-orange-500 to-red-500',
                'maintenance'  => 'from-blue-500 to-cyan-400',
                default        => 'from-gray-500 to-gray-400',
            };
        @endphp
        
        <div class="flex flex-col h-full bg-gray-800 border transition-all duration-500 rounded-[2rem] overflow-hidden group relative"
             x-show="filter === 'all' || filter === '{{ $diet->goal }}'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             :class="{
                'border-brand shadow-[0_0_40px_rgba(34,197,94,0.15)] scale-[1.01] z-10': {{ $isFollowing ? 'true' : 'false' }},
                'border-gray-700/50 shadow-xl hover:-translate-y-1 hover:shadow-brand/10 hover:border-brand/30': !{{ $isFollowing ? 'true' : 'false' }}
             }">
            
            <!-- Top gradient bar -->
            <div class="h-1.5 w-full bg-gradient-to-r {{ $barColor }}"></div>

            <!-- Smart Personalization Badges -->
            <div class="absolute top-6 right-6 flex flex-col items-end gap-2">
                @if($isFollowing)
                    <span class="bg-brand text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg border border-white/10 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                        Following
                    </span>
                @elseif($isMatch)
                    <span class="bg-green-500/10 text-green-400 border border-green-500/20 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full backdrop-blur-md">
                        🎯 Best for You
                    </span>
                @elseif($isPopular)
                    <span class="bg-orange-500/10 text-orange-400 border border-orange-500/20 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full backdrop-blur-md">
                        🔥 Popular
                    </span>
                @endif
            </div>

            <div class="p-8 flex flex-col flex-1 space-y-6">
                <!-- Header Info -->
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black uppercase tracking-widest text-gray-500 bg-white/5 px-2.5 py-1 rounded-lg border border-white/5">
                        {{ strtoupper(str_replace('_', ' ', $diet->goal)) }}
                    </span>
                    <div class="flex items-baseline gap-1">
                        <p class="text-2xl font-black text-white tracking-tighter">{{ number_format($diet->daily_calories) }}</p>
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">kcal</p>
                    </div>
                </div>

                <!-- Title & Progress -->
                <div>
                    <h3 class="text-xl font-black text-white leading-tight tracking-tight group-hover:text-brand transition-colors mb-1">
                        {{ $diet->title }}
                    </h3>
                    @if($isFollowing)
                        <p class="text-[10px] font-black text-brand uppercase tracking-widest">
                            Progress: Day {{ $dietDay }} of cycle
                        </p>
                    @else
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Recommended Plan</p>
                    @endif
                </div>

                <!-- Subtitle -->
                <p class="text-sm text-[#B0B8C5] leading-relaxed line-clamp-2">
                    {{ $diet->description }}
                </p>

                <!-- Meal Preview Section -->
                <div class="space-y-4 pt-6 border-t border-white/5 flex-1">
                    @foreach($preview as $type => $food)
                    @php
                        $cleanFood = preg_replace('/\s+,\s+/', ', ', is_string($food) ? $food : 'Check plan');
                        $cleanFood = preg_replace('/\s+,/', ', ', $cleanFood);
                    @endphp
                    <div class="flex items-center gap-3 group/meal">
                        <span class="text-lg shrink-0 w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center border border-white/5 group-hover/meal:border-brand/30 transition-all">
                            {{ $mealIcons[$type] ?? '🍽️' }}
                        </span>
                        <div class="min-w-0">
                            <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-0.5">{{ $type }}</p>
                            <p class="text-xs text-gray-200 truncate font-medium">{{ $cleanFood }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Action Section -->
                <div class="flex gap-3 pt-4">
                    <form action="{{ route('diets.follow', $diet) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                           class="w-full px-5 py-4 rounded-2xl font-black text-xs transition-all duration-300 uppercase tracking-widest text-center shadow-lg {{ $isFollowing ? 'bg-white text-gray-900' : 'bg-green-500 text-white hover:bg-green-600 hover:scale-[1.02] shadow-green-500/20' }}">
                            {{ $isFollowing ? 'Following ✓' : 'Follow Plan →' }}
                        </button>
                    </form>
                    
                    <a href="{{ route('diets.download', $diet) }}"
                       class="w-14 h-14 rounded-2xl bg-surface-2 border border-border-col flex flex-col items-center justify-center text-gray-500 hover:text-white hover:border-gray-400 transition-all group/pdf"
                       title="Download PDF Plan">
                        <svg class="w-5 h-5 group-hover/pdf:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span class="text-[8px] font-black mt-1 uppercase">PDF</span>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 card py-20 text-center">
            <p class="text-gray-500 font-black uppercase tracking-widest">No diet plans available yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
