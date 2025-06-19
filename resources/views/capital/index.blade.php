@extends('layouts.main')

@section('container')
<div class="col-auto">
    <h1 class="app-page-title mb-0">Perhitungan Modal</h1>
</div>
@endsection

@section('section')
<nav id="modal-table-tab" class="app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
    <a class="flex-sm-fill text-sm-center nav-link active" id="modal-today-tab" data-bs-toggle="tab" href="#modal-today" role="tab" aria-controls="modal-today" aria-selected="true">Hari Ini</a>
    <a class="flex-sm-fill text-sm-center nav-link" id="modal-week-tab" data-bs-toggle="tab" href="#modal-week" role="tab" aria-controls="modal-week" aria-selected="false">Minggu Ini</a>
    <a class="flex-sm-fill text-sm-center nav-link" id="modal-month-tab" data-bs-toggle="tab" href="#modal-month" role="tab" aria-controls="modal-month" aria-selected="false">Bulan Ini</a>
</nav>

<div class="tab-content" id="modal-table-tab-content">
    {{-- Hari Ini --}}
    <div class="tab-pane fade show active" id="modal-today" role="tabpanel" aria-labelledby="modal-today-tab">
        <div class="app-card app-card-orders-table mb-5">
            <div class="app-card-body">
                <h5>Total Pengeluaran Hari Ini: <strong>Rp {{ number_format($totalHariIni, 0, ',', '.') }}</strong></h5>
                <div class="table-responsive mt-3">
                    <table class="table mb-0 text-left">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Modal per Item</th>
                                <th>Total Modal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modalHariIni as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->menu->name ?? '[Menu Dihapus]' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->menu->modal, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->menu->modal * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Minggu Ini --}}
    <div class="tab-pane fade" id="modal-week" role="tabpanel" aria-labelledby="modal-week-tab">
        <div class="app-card app-card-orders-table mb-5">
            <div class="app-card-body">
                <h5>Total Pengeluaran Minggu Ini: <strong>Rp {{ number_format($totalMingguIni, 0, ',', '.') }}</strong></h5>
                <div class="table-responsive mt-3">
                    <table class="table mb-0 text-left">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Modal per Item</th>
                                <th>Total Modal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modalMingguIni as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->menu->name ?? '[Menu Dihapus]' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->menu->modal, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->menu->modal * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Bulan Ini --}}
    <div class="tab-pane fade" id="modal-month" role="tabpanel" aria-labelledby="modal-month-tab">
        <div class="app-card app-card-orders-table mb-5">
            <div class="app-card-body">
                <h5>Total Pengeluaran Bulan Ini: <strong>Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</strong></h5>
                <div class="table-responsive mt-3">
                    <table class="table mb-0 text-left">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Modal per Item</th>
                                <th>Total Modal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modalBulanIni as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->menu->name ?? '[Menu Dihapus]' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->menu->modal, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->menu->modal * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
