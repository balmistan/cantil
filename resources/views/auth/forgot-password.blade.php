@extends('auth.layout')
@section('content')
<h2>Recupero password</h2>
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    <button type="submit">Invia link di recupero</button>
</form>
<div class="links"><a href="{{ route('login') }}">Torna all'accesso</a></div>
@endsection
