@extends('layouts.main')

@section('container')
<div class="col-auto">
    <h1 class="app-page-title mb-0">Perhitungan Modal</h1>
</div>

{{-- Tabs --}}
<nav class="app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4" id="modal-tabs">
    <a class="flex-sm-fill text-sm-center nav-link active" data-bs-toggle="tab" href="#modal-today" role="tab">Hari Ini</a>
    <a class="flex-sm-fill text-sm-center nav-link" data-bs-toggle="tab" href="#modal-week" role="tab">Minggu Ini</a>
    <a class="flex-sm-fill text-sm-center nav-link" data-bs-toggle="tab" href="#modal-month" role="tab">Bulan Ini</a>
</nav>

<div class="tab-content" id="modal-tab-content">
    {{-- HARI INI --}}
    <div class="tab-pane fade show active" id="modal-today" role="tabpanel">
        <div class="app-card shadow-sm mb-4 p-3">
            <h5>Total Modal Hari Ini: Rp {{ number_format($totalHariIni, 0, ',', '.') }}</h5>
            <ul class="mt-3">
                @forelse($modalHariIni as $item)
                    <li>{{ $item->created_at->format('d M Y H:i') }} - {{ $item->deskripsi }}: Rp {{ number_format($item->jumlah, 0, ',', '.') }}</li>
                @empty
                    <li>Tidak ada data.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- MINGGU INI --}}
    <div class="tab-pane fade" id="modal-week" role="tabpanel">
        <div class="app-card shadow-sm mb-4 p-3">
            <h5>Total Modal Minggu Ini: Rp {{ number_format($totalMingguIni, 0, ',', '.') }}</h5>
            <ul class="mt-3">
                @forelse($modalMingguIni as $item)
                    <li>{{ $item->created_at->format('d M Y H:i') }} - {{ $item->deskripsi }}: Rp {{ number_format($item->jumlah, 0, ',', '.') }}</li>
                @empty
                    <li>Tidak ada data.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- BULAN INI --}}
    <div class="tab-pane fade" id="modal-month" role="tabpanel">
        <div class="app-card shadow-sm mb-4 p-3">
            <h5>Total Modal Bulan Ini: Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</h5>
            <ul class="mt-3">
                @forelse($modalBulanIni as $item)
                    <li>{{ $item->created_at->format('d M Y H:i') }} - {{ $item->deskripsi }}: Rp {{ number_format($item->jumlah, 0, ',', '.') }}</li>
                @empty
                    <li>Tidak ada data.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

{{-- FORM TAMBAH MODAL --}}
<div class="app-card shadow-sm p-4 mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('modal.store') }}" method="POST">
        @csrf
        <div class="mb-2">
            <input type="text" name="deskripsi" placeholder="Item" class="form-control" required>
        </div>
        <div class="mb-2">
            <input type="text" name="jumlah" id="jumlah" placeholder="Jumlah (Rp)" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Modal</button>
    </form>
</div>

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
