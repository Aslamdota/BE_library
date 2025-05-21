@extends('layouts.app')

@section('content')
    <h1>Edit Anggota</h1>
    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Nama:</label><br>
        <input type="text" name="nama" value="{{ $anggota->nama }}"><br>
        <label>Email:</label><br>
        <input type="email" name="email" value="{{ $anggota->email }}"><br>
        <label>Telepon:</label><br>
        <input type="text" name="telepon" value="{{ $anggota->telepon }}"><br><br>
        <button type="submit">Update</button>
    </form>
@endsection
