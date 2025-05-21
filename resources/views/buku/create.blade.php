@extends('layouts.app')

@section('content')
    <h1>Tambah Buku</h1>
    <form action="{{ route('buku.store') }}" method="POST">
        @csrf
        <label>Judul:</label><br>
        <input type="text" name="judul"><br>
        <label>Penulis:</label><br>
        <input type="text" name="penulis"><br>
        <label>Tahun Terbit:</label><br>
        <input type="text" name="tahun_terbit"><br><br>
        <button type="submit">Simpan</button>
    </form>
@endsection
