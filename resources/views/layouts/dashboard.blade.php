<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'FitnessPro' }} | FitnessPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': '#22c55e',
                        'brand-dark': '#16a34a',
                        'brand-orange': '#f97316',
                        'surface': '#111827',
                        'surface-2': '#1f2937',
                        'surface-3': '#374151',
                        'border-col': '#374151',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style type="text/tailwindcss">
        body { background-color: #0a0f1a; color: #f9fafb; font-family: 'Inter', sans-serif; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-3.5 rounded-xl text-gray-400 hover:text-white hover:bg-gray-800/50 hover:shadow-inner transition-all duration-300 text-sm font-medium relative overflow-hidden; }
        .sidebar-link.active { @apply text-white bg-gray-800 shadow-xl font-bold border-l-4 border-green-500; }
        .sidebar-link:hover:not(.active) { @apply bg-gray-800/30; }
        .stat-card { @apply bg-gray-800 border border-gray-700 rounded-xl p-6 shadow-lg hover:shadow-green-500/20 transition-all duration-300 hover:scale-[1.02]; }
        .btn-primary { @apply bg-green-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-600 shadow-lg hover:scale-105 transition-all duration-300; }
        .btn-ghost { @apply border border-gray-600 text-gray-300 hover:bg-gray-700 font-semibold px-4 py-2 rounded-lg transition-all duration-300; }
        .card { @apply bg-gray-800 border border-gray-700 rounded-xl shadow-lg hover:shadow-green-500/20 hover:scale-[1.01] transition-all duration-300; }
        .input-field { @apply w-full bg-gray-800 border border-gray-600 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500 transition-all duration-300 placeholder-gray-500 text-sm; }
        .badge-green { @apply inline-flex items-center px-3 py-1 rounded-full bg-green-500/10 text-green-400 text-xs font-semibold border border-green-500/20; }
        .badge-orange { @apply inline-flex items-center px-3 py-1 rounded-full bg-orange-500/10 text-orange-400 text-xs font-semibold border border-orange-500/20; }
        .glow-text { background: linear-gradient(135deg, #22c55e, #86efac); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        ::-webkit-scrollbar { width: 4px; } ::-webkit-scrollbar-track { background: #111827; } ::-webkit-scrollbar-thumb { background: #374151; border-radius: 2px; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp 0.4s ease forwards; }
    </style>
</head>
<body class="antialiased">
    <!-- Mobile Menu Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black/60 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-surface flex flex-col border-r border-border-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 py-5 border-b border-border-col">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="text-xl font-extrabold text-white tracking-tight">Fitness<span class="text-brand">Pro</span></span>
            </div>

            <!-- Nav -->
            <nav class="flex-1 px-3 py-6 space-y-2.5 overflow-y-auto">
                <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4 opacity-80">Main Area</p>

                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('workouts.index') }}" class="sidebar-link {{ request()->routeIs('workouts.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    My Workouts
                </a>

                <a href="{{ route('diets.index') }}" class="sidebar-link {{ request()->routeIs('diets.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Diet Plan
                </a>

                <a href="{{ route('progress.index') }}" class="sidebar-link {{ request()->routeIs('progress.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    Progress
                </a>

                <a href="{{ route('trainers.index') }}" class="sidebar-link {{ request()->routeIs('trainers.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Book Trainer
                </a>

                <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-8 mb-4 opacity-80">Content Library</p>

                <a href="{{ route('blog.index') }}" class="sidebar-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Blog & Tips
                </a>

                @if(auth()->user()?->role === 'admin')
                <p class="px-4 text-xs font-semibold text-gray-600 uppercase tracking-widest mt-5 mb-3">Admin</p>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Admin Panel
                </a>
                @endif
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-border-col mt-4 bg-gray-900/20">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-surface-2 border border-gray-700/50 shadow-inner hover:bg-surface-3 transition-all duration-200 cursor-pointer group">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()?->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()?->email ?? '' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-red-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- TOP NAVBAR -->
            <header class="h-16 bg-surface/80 backdrop-blur-md border-b border-border-col flex items-center justify-between px-4 lg:px-6 shrink-0 sticky top-0 z-10">
                <!-- Mobile menu toggle -->
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <!-- Page Title -->
                <div class="hidden lg:block">
                    <h1 class="text-base font-semibold text-white">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-gray-500">@yield('page-subtitle', 'Welcome back!')</p>
                </div>

                <!-- Right side actions -->
                <div class="flex items-center gap-3 ml-auto lg:ml-0">
                    <!-- Search -->
                    <form action="{{ route('search') }}" method="GET" class="hidden md:flex items-center gap-2 bg-surface-2 border border-border-col rounded-xl px-3 py-2 focus-within:border-brand/50 transition-all">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Quick search..." class="bg-transparent text-sm text-white placeholder-gray-600 focus:outline-none w-36">
                    </form>

                    <!-- Notification Bell -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="w-9 h-9 rounded-xl bg-surface-2 border border-border-col flex items-center justify-center text-gray-400 hover:text-white hover:border-brand/50 transition-all relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-brand rounded-full"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-80 bg-surface-2 border border-border-col rounded-2xl shadow-2xl z-50 overflow-hidden backdrop-blur-xl"
                             style="display: none;">
                            <div class="p-4 border-b border-border-col flex items-center justify-between bg-white/5">
                                <h3 class="font-bold text-sm text-white">Notifications</h3>
                                <span class="text-[10px] bg-brand/10 text-brand px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">3 New</span>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <!-- Notification Item 1 -->
                                <div class="p-4 border-b border-border-col hover:bg-white/5 transition-colors cursor-pointer group">
                                    <div class="flex gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-white font-semibold group-hover:text-brand transition-colors">Booking Confirmed</p>
                                            <p class="text-xs text-gray-500 mt-0.5">Trainer Mike has accepted your session for tomorrow at 10:00 AM.</p>
                                            <p class="text-[10px] text-gray-600 mt-2">2 hours ago</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification Item 2 -->
                                <div class="p-4 border-b border-border-col hover:bg-white/5 transition-colors cursor-pointer group">
                                    <div class="flex gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-brand/10 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-white font-semibold group-hover:text-brand transition-colors">Workout Completed!</p>
                                            <p class="text-xs text-gray-500 mt-0.5">Great job! You just smashed your 'Leg Day' routine. Keep it up!</p>
                                            <p class="text-[10px] text-gray-600 mt-2">5 hours ago</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification Item 3 -->
                                <div class="p-4 hover:bg-white/5 transition-colors cursor-pointer group">
                                    <div class="flex gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-white font-semibold group-hover:text-brand transition-colors">Goal Update</p>
                                            <p class="text-xs text-gray-500 mt-0.5">You're only 2kg away from your weight loss goal. Stay focused!</p>
                                            <p class="text-[10px] text-gray-600 mt-2">Yesterday</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 bg-white/5 text-center">
                                <a href="#" class="text-[11px] font-bold text-brand hover:underline uppercase tracking-widest">View All Notifications</a>
                            </div>
                        </div>
                    </div>

                    <!-- Avatar -->
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-brand to-brand-dark flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 bg-green-500/10 border border-green-500/20 text-green-400 px-5 py-4 rounded-xl text-sm font-medium fade-up">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 flex items-center gap-3 bg-red-500/10 border border-red-500/20 text-red-400 px-5 py-4 rounded-xl text-sm font-medium fade-up">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    @yield('scripts')
</body>
</html>
