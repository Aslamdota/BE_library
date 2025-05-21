@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Selamat Datang, {{ auth()->user()->name }}</h1>
    <p>Ini adalah dashboard Anggota.</p>
</div>
@endsection