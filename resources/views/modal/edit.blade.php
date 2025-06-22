@extends('layouts.main')

@section('container')
<div class="container mt-4">
    <h1>Edit Modal</h1>

    <form action="{{ route('modal.update', $modal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" value="{{ $modal->deskripsi }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="text" name="jumlah" id="jumlah" class="form-control"
                value="Rp {{ number_format($modal->jumlah, 0, ',', '.') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('modal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

{{-- Format rupiah --}}
<script>
    const jumlah = document.getElementById('jumlah');
    jumlah.addEventListener('input', function () {
        let value = this.value.replace(/[^0-9]/g, '');
        if (!value) return this.value = '';
        this.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
    });

    document.querySelector('form').addEventListener('submit', function () {
        jumlah.value = jumlah.value.replace(/[^0-9]/g, '');
    });
</script>
@endsection
