<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Cantil') }}</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f3f4f6;margin:0;min-height:100vh;display:grid;place-items:center}
        main{background:#fff;width:min(92%,420px);padding:2rem;border-radius:12px;box-shadow:0 8px 28px #0001}
        h1{margin-top:0;color:#263b53}label{display:block;margin:1rem 0 .35rem}
        input{box-sizing:border-box;width:100%;padding:.75rem;border:1px solid #cbd5e1;border-radius:6px}
        button{margin-top:1.2rem;padding:.75rem 1.2rem;background:#24496b;color:white;border:0;border-radius:6px;cursor:pointer}
        a{color:#24496b}.error{color:#b91c1c}.links{margin-top:1rem;display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap}
    </style>
</head>
<body>
<main>
    <h1>Cantil</h1>
    @if ($errors->any())
        <div class="error"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    @if (session('status'))<p>{{ session('status') }}</p>@endif
    @yield('content')
</main>
</body>
</html>
