@extends('auth.layout')
@section('content')
<h2>Registrazione</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <label for="name">Nome</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
    <label for="password">Password</label>
    <input id="password" type="password" name="password" required autocomplete="new-password">
    <label for="password_confirmation">Conferma password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
    <button type="submit">Crea account</button>
</form>
<div class="links"><a href="{{ route('login') }}">Torna all'accesso</a></div>
@endsection
