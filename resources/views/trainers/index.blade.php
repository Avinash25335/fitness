@extends('layouts.dashboard')

@section('page-title', 'Expert Trainers')
@section('page-subtitle', 'Book a 1-on-1 session with a certified professional')

@section('content')
<div class="space-y-8 fade-up" x-data="{ 
    showModal: false, 
    selectedTrainer: null,
    trainers: [],
    filter: 'all'
}">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-white">Our Trainers</h2>
            <p class="text-sm text-gray-400 mt-1">World-class certified fitness professionals ready to coach you</p>
        </div>
        <!-- Specialization filter pills -->
        <div class="flex flex-wrap gap-2">
            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-brand text-white shadow-lg' : 'bg-surface-2 text-gray-400 hover:text-white'"
                class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300 border border-border-col">
                All
            </button>
            <button @click="filter = 'strength'" :class="filter === 'strength' ? 'bg-brand text-white shadow-lg' : 'bg-surface-2 text-gray-400 hover:text-white'"
                class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300 border border-border-col">
                💪 Strength
            </button>
            <button @click="filter = 'cardio'" :class="filter === 'cardio' ? 'bg-brand text-white shadow-lg' : 'bg-surface-2 text-gray-400 hover:text-white'"
                class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300 border border-border-col">
                🏃 Cardio
            </button>
            <button @click="filter = 'yoga'" :class="filter === 'yoga' ? 'bg-brand text-white shadow-lg' : 'bg-surface-2 text-gray-400 hover:text-white'"
                class="px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300 border border-border-col">
                🧘 Yoga
            </button>
        </div>
    </div>

    <!-- Trainer Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($trainers as $trainer)
        @php
            $spec = strtolower($trainer->specialization ?? 'general');
            $filterKey = str_contains($spec, 'strength') ? 'strength' : (str_contains($spec, 'cardio') ? 'cardio' : (str_contains($spec, 'yoga') ? 'yoga' : 'general'));
            
            // Random-ish ratings for realism
            $rating = number_format(4.5 + (rand(0, 5) / 10), 1);
            $reviews = rand(40, 150);
            $isAvailable = rand(0, 1);
        @endphp
        <div class="flex flex-col h-full bg-gray-800 border border-gray-700 rounded-2xl shadow-xl hover:shadow-brand/10 hover:scale-[1.02] transition-all duration-500 overflow-hidden group"
             x-show="filter === 'all' || filter === '{{ $filterKey }}'"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">

            <!-- Trainer Image -->
            <div class="relative h-64 overflow-hidden bg-gray-900 shrink-0">
                <img src="{{ $trainer->image ?? 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?q=80&w=600&auto=format&fit=crop' }}"
                     alt="{{ $trainer->user->name ?? 'Trainer' }}"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                
                <!-- Availability Badge -->
                @if($isAvailable)
                <div class="absolute top-4 left-4">
                    <span class="flex items-center gap-1.5 bg-green-500 text-white text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full shadow-lg">
                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                        Available Today
                    </span>
                </div>
                @endif

                <!-- Rating Overlay -->
                <div class="absolute bottom-4 left-4 bg-gray-900/60 backdrop-blur-md rounded-lg px-2.5 py-1.5 border border-white/10">
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-black text-white">{{ $rating }}</span>
                        <div class="flex gap-0.5">
                            @for($i=0; $i<5; $i++)
                            <svg class="w-2.5 h-2.5 {{ $i < floor($rating) ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter">({{ $reviews }})</span>
                    </div>
                </div>

                <!-- Price overlay -->
                <div class="absolute top-4 right-4 bg-brand rounded-xl px-3 py-1 shadow-lg border border-brand-dark/20">
                    <p class="text-lg font-black text-white tracking-tighter">${{ $trainer->hourly_rate ?? '50' }}</p>
                    <p class="text-[9px] text-white/80 font-black uppercase tracking-widest text-center -mt-1">Session</p>
                </div>
            </div>

            <div class="p-6 flex flex-col flex-1">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="font-black text-white text-xl tracking-tight group-hover:text-brand transition-colors">{{ $trainer->user->name ?? 'Trainer' }}</h3>
                        <span class="text-[10px] font-black text-gray-400 border border-gray-700 px-2 py-0.5 rounded-md uppercase tracking-widest">
                            {{ $trainer->experience ?? '5' }}+ YRS
                        </span>
                    </div>
                    
                    <p class="text-[10px] font-bold text-brand uppercase tracking-widest mb-3">{{ $trainer->specialization ?? 'General Fitness' }}</p>

                    <p class="text-sm text-gray-400 leading-relaxed line-clamp-2 mb-6">
                        {{ $trainer->bio ?? 'Passionate about helping you achieve your fitness goals with personalized coaching.' }}
                    </p>

                    <!-- Trust Tags -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="text-[9px] font-bold text-gray-500 bg-white/5 border border-white/5 px-2 py-1 rounded">✓ NSCA Certified</span>
                        <span class="text-[9px] font-bold text-gray-500 bg-white/5 border border-white/5 px-2 py-1 rounded">✓ CPR/AED</span>
                    </div>
                </div>

                <!-- Button -->
                @auth
                <button @click="selectedTrainer = { id: {{ $trainer->id }}, name: '{{ $trainer->user->name }}', price: '{{ $trainer->hourly_rate }}' }; showModal = true"
                   class="w-full bg-brand text-white font-black py-3.5 rounded-xl hover:bg-brand-dark shadow-lg shadow-brand/20 transition-all duration-300 text-sm tracking-wide uppercase">
                    Book Session
                </button>
                @else
                <a href="{{ route('login') }}"
                   class="w-full bg-surface-2 border border-border-col text-gray-400 hover:text-white hover:border-gray-500 py-3.5 rounded-xl font-black text-sm tracking-wide uppercase text-center transition-all">
                    Login to Book
                </a>
                @endauth
            </div>
        </div>
        @empty
        <div class="col-span-3 card py-20 text-center">
            <p class="text-gray-500 font-black uppercase tracking-widest">No trainers available right now.</p>
        </div>
        @endforelse
    </div>

    <!-- BOOKING MODAL -->
    <div x-show="showModal" 
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        
        <div class="bg-gray-800 border border-gray-700 w-full max-w-md rounded-3xl overflow-hidden shadow-2xl shadow-brand/10"
             @click.away="showModal = false"
             x-transition:enter="transition ease-out duration-300 translate-y-4"
             x-transition:enter-start="opacity-0 translate-y-8"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <!-- Modal Header -->
            <div class="relative bg-gradient-to-r from-gray-800 to-gray-900 p-8 border-b border-gray-700">
                <button @click="showModal = false" class="absolute top-4 right-4 text-gray-500 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-brand/10 flex items-center justify-center">
                        <svg class="w-8 h-8 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-white tracking-tight">Book a Session</h3>
                        <p class="text-sm text-gray-400">with <span class="text-brand font-bold" x-text="selectedTrainer?.name"></span></p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('trainers.book') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="trainer_id" :value="selectedTrainer?.id">
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest">Select Date</label>
                        <input type="date" name="date" min="{{ date('Y-m-d') }}" required
                               class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand transition-all text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest">Time Slot</label>
                        <select name="time_slot" required
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand transition-all text-sm appearance-none">
                            <option value="">Select Time</option>
                            <option>06:00 AM</option><option>07:00 AM</option><option>08:00 AM</option>
                            <option>09:00 AM</option><option>10:00 AM</option><option>11:00 AM</option>
                            <option>05:00 PM</option><option>06:00 PM</option><option>07:00 PM</option>
                        </select>
                    </div>
                </div>

                <div class="bg-white/5 rounded-2xl p-4 border border-white/5 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Total Price</p>
                        <p class="text-2xl font-black text-white tracking-tighter" x-text="'$' + selectedTrainer?.price"></p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Duration</p>
                        <p class="text-sm font-bold text-gray-300">60 Minutes</p>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-brand text-white font-black py-4 rounded-2xl hover:bg-brand-dark shadow-xl shadow-brand/20 transition-all duration-300 text-sm uppercase tracking-widest">
                    Confirm Booking
                </button>

                <p class="text-[10px] text-center text-gray-500 leading-relaxed px-4">
                    By confirming, you agree to our 24-hour cancellation policy. A confirmation email will be sent to your inbox.
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
