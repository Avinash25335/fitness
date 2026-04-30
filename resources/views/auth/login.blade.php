@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Panel - Branding -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-surface">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=1920&auto=format&fit=crop"
                 class="w-full h-full object-cover opacity-30" alt="Gym">
            <div class="absolute inset-0 bg-gradient-to-br from-brand/20 via-surface/60 to-surface"></div>
        </div>
        <div class="relative z-10 flex flex-col justify-between p-12 w-full">
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <span class="text-2xl font-extrabold text-white">Fitness<span class="text-brand">Pro</span></span>
                </a>
            </div>
            <div>
                <blockquote class="text-2xl font-bold text-white leading-snug mb-4">
                    "The only bad workout<br>is the one that didn't happen."
                </blockquote>
                <div class="flex items-center gap-2 mt-6">
                    @foreach(['💪', '🏋️', '🔥', '⚡'] as $emoji)
                    <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-lg border border-white/10">{{ $emoji }}</div>
                    @endforeach
                </div>
                <div class="mt-8 grid grid-cols-3 gap-4">
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center">
                        <p class="text-2xl font-extrabold text-brand">500+</p>
                        <p class="text-xs text-gray-400 mt-1">Members</p>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center">
                        <p class="text-2xl font-extrabold text-brand">50+</p>
                        <p class="text-xs text-gray-400 mt-1">Workouts</p>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center">
                        <p class="text-2xl font-extrabold text-brand">20+</p>
                        <p class="text-xs text-gray-400 mt-1">Trainers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel - Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
        <div class="w-full max-w-md fade-up">
            <!-- Mobile Logo -->
            <div class="lg:hidden mb-8 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="text-xl font-extrabold text-white">Fitness<span class="text-brand">Pro</span></span>
            </div>

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-white mb-2">Welcome back</h1>
                <p class="text-gray-500">Sign in to continue your fitness journey</p>
            </div>

            @if($errors->any())
            <div class="mb-6 flex items-start gap-3 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="you@example.com"
                           class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 placeholder-gray-600 text-sm">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Password</label>
                        <a href="#" class="text-xs text-brand hover:text-green-400 transition-colors">Forgot password?</a>
                    </div>
                    <input type="password" name="password" required
                           placeholder="••••••••"
                           class="w-full bg-surface-2 border border-border-col text-white rounded-xl px-4 py-3 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand/30 transition-all duration-200 placeholder-gray-600 text-sm">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-border-col bg-surface-2 text-brand focus:ring-brand">
                    <label for="remember" class="text-sm text-gray-400">Remember me for 30 days</label>
                </div>

                <button type="submit"
                        class="w-full btn-primary text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-500/20 hover:shadow-green-500/30 hover:scale-[1.02] transition-all duration-200 text-sm">
                    Sign In to FitnessPro
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-border-col"></div></div>
                <div class="relative flex justify-center"><span class="px-4 bg-[#0a0f1a] text-xs text-gray-600 font-medium">OR CONTINUE WITH</span></div>
            </div>

            <a href="{{ route('auth.google') }}"
               class="w-full flex items-center justify-center gap-3 bg-surface-2 hover:bg-surface-3 border border-border-col hover:border-gray-500 text-white font-semibold py-3 rounded-xl transition-all duration-200 text-sm">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Continue with Google
            </a>

            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-brand font-semibold hover:text-green-400 transition-colors">Create one free →</a>
            </p>
        </div>
    </div>
</div>
@endsection
