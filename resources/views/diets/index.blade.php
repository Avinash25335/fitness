@extends('layouts.dashboard')

@section('page-title', 'Diet Plans')
@section('page-subtitle', 'Fuel your body with the right nutrition plan')

@section('content')
<div class="space-y-10 fade-up" x-data="{ filter: 'all' }">

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-center gap-3">
        <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        <p class="text-green-400 text-sm font-bold">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Header + Filter Tabs -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-black text-white">Nutrition Plans</h2>
            <p class="text-sm text-gray-400 mt-1">Select a meal plan that aligns with your fitness goals</p>
        </div>

        <!-- Filter Tabs (Matches Image) -->
        <div class="flex items-center gap-2 bg-[#1a1f2c] p-1.5 rounded-2xl border border-gray-800">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-brand text-white shadow-lg' : 'text-gray-500 hover:text-white'"
                class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                All
            </button>
            <button @click="filter = 'muscle_gain'" :class="filter === 'muscle_gain' ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2">
                💪 Gain
            </button>
            <button @click="filter = 'weight_loss'" :class="filter === 'weight_loss' ? 'bg-red-500 text-white shadow-lg' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2">
                🔥 Loss
            </button>
            <button @click="filter = 'maintenance'" :class="filter === 'maintenance' ? 'bg-gray-700 text-white shadow-lg' : 'text-gray-500 hover:text-white'"
                class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2">
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
            $isPopular = $index === 1;
            
            $mealsArray = is_string($diet->meals_json) ? json_decode($diet->meals_json, true) : (array)$diet->meals_json;
            $preview = array_slice($mealsArray ?: [], 0, 3);
            
            $mealIcons = ['Breakfast' => '🍳', 'Morning Snack' => '🥜', 'Lunch' => '🥗', 'Afternoon Snack' => '🥤', 'Dinner' => '🍗'];

            $topBorderColor = match($diet->goal) {
                'weight_loss'  => 'border-green-500',
                'muscle_gain'  => 'border-orange-500',
                'maintenance'  => 'border-blue-500',
                default        => 'border-gray-500',
            };
        @endphp
        
        <div class="flex flex-col h-full bg-[#1e2532] border-t-4 {{ $topBorderColor }} rounded-2xl overflow-hidden shadow-2xl transition-all duration-300 hover:scale-[1.02]"
             x-show="filter === 'all' || filter === '{{ $diet->goal }}'"
             x-transition>
            
            <div class="p-8 flex flex-col flex-1 space-y-6">
                <!-- Badges Row -->
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest px-3 py-1 bg-white/5 rounded-lg">
                        {{ str_replace('_', ' ', $diet->goal) }}
                    </span>
                    <div class="flex items-center gap-2">
                        @if($isFollowing)
                            <span class="flex items-center gap-1.5 bg-brand text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full animate-pulse">
                                <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                Following
                            </span>
                        @elseif($isPopular)
                            <span class="bg-orange-500 text-white text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full flex items-center gap-1">
                                🔥 Popular
                            </span>
                        @endif
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl font-black text-white">{{ number_format($diet->daily_calories) }}</span>
                            <span class="text-[9px] text-gray-500 font-bold uppercase">kcal</span>
                        </div>
                    </div>
                </div>

                <!-- Title & Progress -->
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight mb-1">
                        {{ $diet->title }}
                    </h3>
                    @if($isFollowing)
                        <p class="text-[10px] font-black text-brand uppercase tracking-widest">
                            PROGRESS: DAY {{ floor($dietDay) }} OF CYCLE
                        </p>
                    @endif
                </div>

                <!-- Description -->
                <p class="text-sm text-gray-400 leading-relaxed line-clamp-2">
                    {{ $diet->description }}
                </p>

                <!-- Meal List (Exactly like image) -->
                <div class="space-y-4 pt-4 border-t border-white/5 flex-1">
                    @foreach($preview as $type => $food)
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center shrink-0">
                            <span class="text-lg">{{ $mealIcons[$type] ?? '🍽️' }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest">{{ $type }}</p>
                            <p class="text-xs text-white truncate font-bold">{{ $food }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3 pt-6">
                    @if($isFollowing)
                        <div class="flex-1 bg-white text-black py-4 rounded-xl font-black text-xs uppercase tracking-widest text-center">
                            FOLLOWING ✓
                        </div>
                    @else
                        <form action="{{ route('diets.follow', $diet) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" 
                               class="w-full bg-brand text-white py-4 rounded-xl font-black text-xs uppercase tracking-widest text-center hover:bg-brand-dark transition-all">
                                FOLLOW PLAN →
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('diets.download', $diet) }}"
                       class="w-14 h-14 rounded-xl bg-white/5 border border-white/10 flex flex-col items-center justify-center text-gray-400 hover:text-white transition-all group/pdf">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span class="text-[7px] font-black uppercase mt-1">PDF</span>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 py-20 text-center">
            <p class="text-gray-500 font-black uppercase tracking-widest">No plans found.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
