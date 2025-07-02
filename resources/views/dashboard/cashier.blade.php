{{-- Header Welcome --}}
<div class="col-12 mb-4">
    <div class="card shadow-sm rounded text-center">
        <div class="card-body my-5">
            <h4 class="text-primary mb-1">Welcome Back, {{ auth()->user()->name }} 🎉</h4>
            <p class="text-black mb-2">Selamat menjalani hari ini!</p>
            <a href="{{ route('transaction.create') }}" class="btn btn-primary mt-3">
                Mulai penjualan
            </a>
        </div>
    </div>
</div>

{{-- Kategori Hari Ini --}}
<div class="col-12">
    <h5 class="fw-bold text-dark">📅 Data Hari Ini</h5>
</div>

<div class="col-md-6 col-lg-3 mb-4">
    <div class="card shadow-sm text-center py-4">
        <div class="card-body">
            <img src="images/icons/unicons/chart-success.png" width="36" class="mb-2" />
            <div class="fw-semibold text-dark">Telah Terbayar</div>
            <div class="text-success fw-semibold small">
                {{ $total_paid[0]->total_paid }}
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-3 mb-4">
    <div class="card shadow-sm text-center py-4">
        <div class="card-body">
            <img src="images/icons/unicons/wallet-info.png" width="36" class="mb-2" />
            <div class="fw-semibold text-dark">Belum Terbayar</div>
            <div class="text-danger fw-semibold small">
                {{ $total_unpaid[0]->total_unpaid }}
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-3 mb-4">
    <div class="card shadow-sm text-center py-4">
        <div class="card-body">
            <img src="images/icons/unicons/table.png" width="36" class="mb-2" />
            <div class="fw-semibold text-dark">Meja Tersedia</div>
            <div class="text-success fw-semibold small">
                {{ 20 - (int)$tables[0]->tables }}
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-3 mb-4">
    <div class="card shadow-sm text-center py-4">
        <div class="card-body">
            <img src="images/icons/unicons/wallet-info.png" width="36" class="mb-2" />
            <div class="fw-semibold text-dark">Penjualan</div>
            <div class="text-success fw-semibold small">
                Rp {{ number_format($total_sales[0]->total_sales, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>
