@extends('layouts.app')

@section('content')
    <h1>Tambah Anggota</h1>
    <form action="{{ route('anggota.store') }}" method="POST">
        @csrf
        <label>Nama:</label><br>
        <input type="text" name="nama"><br>
        <label>Email:</label><br>
        <input type="email" name="email"><br>
        <label>Telepon:</label><br>
        <input type="text" name="telepon"><br><br>
        <button type="submit">Simpan</button>
    </form>
@endsection
