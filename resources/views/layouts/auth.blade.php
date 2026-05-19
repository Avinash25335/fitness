<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0a0f1a; color: #f9fafb; font-family: 'Inter', sans-serif; }
        .input-field { 
            width: 100%;
            background-color: var(--surface);
            border: 1px solid var(--border-col);
            color: #ffffff;
            border-radius: 0.75rem;
            padding-left: 1rem;
            padding-right: 1rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .input-field:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 1px rgba(34, 197, 94, 0.5);
        }
        .btn-primary { background: linear-gradient(135deg, #22c55e, #16a34a); }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp 0.5s ease forwards; }
    </style>
</head>
<body class="min-h-screen antialiased">
    @yield('content')
</body>
</html>
