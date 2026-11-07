@extends('auth.layout')
@section('content')
<h2>Nuova password</h2>
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required>
    <label for="password">Nuova password</label>
    <input id="password" type="password" name="password" required autocomplete="new-password">
    <label for="password_confirmation">Conferma password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
    <button type="submit">Reimposta password</button>
</form>
@endsection
