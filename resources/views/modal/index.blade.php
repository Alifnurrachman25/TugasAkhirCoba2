@extends('layouts.main')

@section('container')
<div class="container-fluid mt-4">
    {{-- HEADER + BUTTON --}}
    <div class="row align-items-center mb-4">
        <div class="col">
            <h1 class="app-page-title mb-0">Perhitungan Modal</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('modal.create') }}" class="btn btn-success">
                Tambahkan Modal
            </a>
        </div>
    </div>

    {{-- TABS --}}
    <nav class="app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4" id="modal-tabs">
        <a class="flex-sm-fill text-sm-center nav-link active" data-bs-toggle="tab" href="#modal-today" role="tab">Hari Ini</a>
        <a class="flex-sm-fill text-sm-center nav-link" data-bs-toggle="tab" href="#modal-week" role="tab">Minggu ini</a>
        <a class="flex-sm-fill text-sm-center nav-link" data-bs-toggle="tab" href="#modal-month" role="tab">Bulan Ini</a>
    </nav>

    <div class="tab-content" id="modal-tab-content">
        {{-- HARI INI --}}
        <div class="tab-pane fade show active" id="modal-today" role="tabpanel">
            <div class="app-card shadow-sm mb-4 p-3">
                <div class="card text-black bg-danger mb-3 w-25">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Total Modal Hari Ini : </h5>
                        <p class="card-text fs-5 fw-bold">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</p>
                    </div>
                </div>

                <ul class="mt-3">
                    @forelse($modalHariIni as $item)
                        <li class="d-flex justify-content-between align-items-center my-3">
                            <span>
                                {{ $item->created_at->format('d M Y H:i') }} - {{ $item->deskripsi }}: Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </span>
                            <span>
                                <a href="{{ route('modal.edit', $item->id) }}" class="btn btn-sm btn-warning mx-2">Edit</a>
                                <form action="{{ route('modal.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </span>
                        </li>
                    @empty
                        <li>Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- MINGGU INI --}}
        <div class="tab-pane fade" id="modal-week" role="tabpanel">
            <div class="app-card shadow-sm mb-4 p-3">
                <div class="card text-black bg-danger mb-3 w-25">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Total Modal Minggu Ini :</h5>
                        <p class="card-text fs-5 fw-bold">Rp {{ number_format($totalMingguIni, 0, ',', '.') }}</p>
                    </div>
                </div>

                <ul class="mt-3">
                    @forelse($modalMingguIni as $item)
                        <li class="d-flex justify-content-between align-items-center my-3">
                            <span>
                                {{ $item->created_at->format('d M Y H:i') }} - {{ $item->deskripsi }}: Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </span>
                            <span>
                                <a href="{{ route('modal.edit', $item->id) }}" class="btn btn-sm btn-warning mx-2">Edit</a>
                                <form action="{{ route('modal.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </span>
                        </li>
                    @empty
                        <li>Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>


        {{-- BULAN INI --}}
        <div class="tab-pane fade" id="modal-month" role="tabpanel">
            <div class="app-card shadow-sm mb-4 p-3">
                <div class="card text-black bg-danger mb-3 w-25">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Total Modal Bulan Ini : </h5>
                        <p class="card-text fs-5 fw-bold">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</p>
                    </div>
                </div>

                <ul class="mt-3">
                    @forelse($modalBulanIni as $item)
                        <li class="d-flex justify-content-between align-items-center my-3">
                            <span>
                                {{ $item->created_at->format('d M Y H:i') }} - {{ $item->deskripsi }}: Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </span>
                            <span>
                                <a href="{{ route('modal.edit', $item->id) }}" class="btn btn-sm btn-warning mx-2">Edit</a>
                                <form action="{{ route('modal.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </span>
                        </li>
                    @empty
                        <li>Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- SEMUA --}}
        {{-- <div class="tab-pane fade" id="modal-all" role="tabpanel">
            <div class="app-card shadow-sm mb-4 p-3">
                <div class="card text-black bg-danger mb-3 w-25">
                    <div class="card-body">
                        <h5 class="card-title mb-0">Total Semua Modal</h5>
                        <p class="card-text fs-5 fw-bold">Rp {{ number_format($totalSemua, 0, ',', '.') }}</p>
                    </div>
                </div>

                <ul class="mt-3">
                    @forelse($modalSemua as $item)
                        <li class="d-flex justify-content-between align-items-center my-3">
                            <span>
                                {{ $item->created_at->format('d M Y H:i') }} - {{ $item->deskripsi }}: Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                            </span>
                            <span>
                                <a href="{{ route('modal.edit', $item->id) }}" class="btn btn-sm btn-warning mx-2">Edit</a>
                                <form action="{{ route('modal.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </span>
                        </li>
                    @empty
                        <li>Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div> --}}
    </div>
</div>
@endsection
