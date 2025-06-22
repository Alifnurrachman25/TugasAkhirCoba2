@extends('layouts.main')

@section('container')
<div class="col-auto">
    <h1 class="app-page-title mb-4">Tambah Modal</h1>
</div>

<div class="app-card shadow-sm p-4">
    <form action="{{ route('modal.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="text" name="deskripsi" placeholder="Item" class="form-control" required>
        </div>
        <div class="mb-2">
            <input type="text" name="jumlah" id="jumlah" placeholder="Jumlah (Rp)" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary my-3">Tambah Modal</button>
    </form>
</div>

<a href="{{ route('modal.index') }}" class="btn btn-secondary mb-3">Kembali</a>


{{-- Script Format Rupiah --}}
<script>
    const jumlah = document.getElementById('jumlah');
    jumlah.addEventListener('input', function (e) {
        let value = this.value.replace(/[^0-9]/g, '');
        if (!value) return this.value = '';
        let formatted = new Intl.NumberFormat('id-ID').format(value);
        this.value = 'Rp ' + formatted;
    });

    document.querySelector('form').addEventListener('submit', function () {
        jumlah.value = jumlah.value.replace(/[^0-9]/g, '');
    });
</script>
@endsection
