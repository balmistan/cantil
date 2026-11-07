@extends('auth.layout')
@section('content')
<h2>Verifica e-mail</h2>
<p>Prima di continuare, verifica il tuo indirizzo e-mail tramite il link che ti abbiamo inviato.</p>
<form method="POST" action="{{ route('verification.send') }}">@csrf<button type="submit">Invia nuovamente l'e-mail</button></form>
<form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Esci</button></form>
@endsection
