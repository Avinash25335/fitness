@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Branding -->
    <div class="hidden lg:flex lg:w-5/12 relative overflow-hidden bg-surface">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=1920&auto=format&fit=crop"
                 class="w-full h-full object-cover opacity-25" alt="Gym">
            <div class="absolute inset-0 bg-gradient-to-br from-brand/20 via-surface/70 to-surface"></div>
        </div>
        <div class="relative z-10 flex flex-col justify-center p-12 w-full">
            <a href="{{ route('home') }}" class="flex items-center gap-3 mb-12">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="text-2xl font-extrabold text-white">Fitness<span class="text-brand">Pro</span></span>
            </a>
            <h2 class="text-4xl font-extrabold text-white leading-tight mb-4">
                Start your<br><span class="text-brand">transformation</span><br>today.
            </h2>
            <p class="text-gray-400 leading-relaxed mb-8">Join thousands of members who track, improve, and crush their fitness goals every day.</p>
            <ul class="space-y-3">
                @foreach(['Personalized workout & diet plans', 'Smart AI recommendations', 'Progress tracking with charts', 'Expert trainer booking'] as $feature)
                <li class="flex items-center gap-3 text-sm text-gray-300">
                    <div class="w-5 h-5 rounded-full bg-brand/20 border border-brand/30 flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    {{ $feature }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Right Form Panel -->
    <div class="w-full lg:w-7/12 flex items-center justify-center p-6 overflow-y-auto">
        <div class="w-full max-w-lg py-8 fade-up">
            <div class="lg:hidden mb-8 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="text-xl font-extrabold text-white">Fitness<span class="text-brand">Pro</span></span>
            </div>

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-white mb-2">Create your account</h1>
                <p class="text-gray-500">It's free — no credit card required</p>
            </div>

            @if($errors->any())
            <div class="mb-6 flex items-start gap-3 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe"
                           class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 placeholder-gray-600 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com"
                           class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 placeholder-gray-600 text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Age</label>
                        <input type="number" name="age" value="{{ old('age') }}" required placeholder="25" min="10" max="100"
                               class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 placeholder-gray-600 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Gender</label>
                        <select name="gender" required class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 text-sm">
                            <option value="">Select</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Height (cm)</label>
                        <input type="number" step="0.1" name="height" value="{{ old('height') }}" required placeholder="170"
                               class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 placeholder-gray-600 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" value="{{ old('weight') }}" required placeholder="70"
                               class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 placeholder-gray-600 text-sm">
                    </div>
                </div>

                <!-- Fitness Goal — used for instant personalised recommendations -->
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Fitness Goal</label>
                    <select name="goal" class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 text-sm">
                        <option value="">Select a goal (optional)</option>
                        <option value="weight_loss"  {{ old('goal') === 'weight_loss'  ? 'selected' : '' }}>🔥 Lose Weight</option>
                        <option value="muscle_gain"  {{ old('goal') === 'muscle_gain'  ? 'selected' : '' }}>💪 Build Muscle</option>
                        <option value="maintenance"  {{ old('goal') === 'maintenance'  ? 'selected' : '' }}>⚖️ Maintain Fitness</option>
                    </select>
                    <p class="text-xs text-gray-600 mt-1.5">Personalises your workout &amp; diet recommendations</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Password</label>
                        <input type="password" name="password" required placeholder="Min. 8 characters"
                               class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 placeholder-gray-600 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Confirm</label>
                        <input type="password" name="password_confirmation" required placeholder="Repeat password"
                               class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 placeholder-gray-600 text-sm">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-brand to-brand-dark text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-500/20 hover:shadow-green-500/30 hover:scale-[1.02] transition-all duration-200 text-sm">
                    Create My Free Account →
                </button>
            </form>


            <p class="text-center text-sm text-gray-500 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-brand font-semibold hover:text-green-400 transition-colors">Sign in →</a>
            </p>
        </div>
    </div>
</div>
@endsection
