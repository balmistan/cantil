@extends('auth.layout')
@section('content')
<h2>Accesso</h2>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required autocomplete="current-password">
    <label><input style="width:auto" type="checkbox" name="remember"> Ricordami</label>
    <button type="submit">Accedi</button>
</form>
<div class="links"><a href="{{ route('password.request') }}">Password dimenticata?</a><a href="{{ route('register') }}">Registrati</a></div>
@endsection
