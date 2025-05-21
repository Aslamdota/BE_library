@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <h2>Register</h2>
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div>
            <label>Nama</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Register</button>
    </form>
</div>
@endsection
