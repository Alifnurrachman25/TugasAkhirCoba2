{{-- Header Welcome --}}
<div class="col-12 mb-4">
    <div class="card shadow-sm rounded text-center">
        <div class="card-body my-5">
            <h4 class="text-primary mb-1">Welcome Back, {{ auth()->user()->name }} 🎉</h4>
            <p class="text-muted mb-0">Selamat menjalani hari ini!</p>
        </div>
    </div>
</div>

{{-- Kategori Hari Ini --}}
<div class="col-12">
    <h5 class="fw-bold text-dark">📅 Data Hari Ini</h5>
</div>

<div class="col-md-6 col-lg-3 mb-4">
    <div class="card shadow-sm text-center">
        <div class="card-body">
            <img src="images/icons/unicons/dollar-sign.png" width="36" class="mb-2" />
            <div class="fw-semibold text-dark">Penjualan</div>
            <div class="text-success fw-semibold small">
                Rp {{ number_format($total_sales[0]->total_sales,0,',','.') }}
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-3 mb-4">
    <div class="card shadow-sm text-center">
        <div class="card-body">
            <img src="images/icons/unicons/menu-info.png" width="36" class="mb-2" />
            <div class="fw-semibold text-dark">Menu</div>
            <div class="text-success fw-semibold small">{{ $total_menus }}</div>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-3 mb-4">
    <div class="card shadow-sm text-center">
        <div class="card-body">
            <img src="images/icons/unicons/wallet.png" width="36" class="mb-2" />
            <div class="fw-semibold text-dark">Keuntungan</div>
            <div class="text-success fw-semibold small">
                Rp {{ number_format($total_income, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-3 mb-4">
    <div class="card shadow-sm text-center">
        <div class="card-body">
            <img src="images/icons/unicons/wallet-info.png" width="36" class="mb-2" />
            <div class="fw-semibold text-dark">Bukti Pembayaran</div>
            <div class="text-success fw-semibold small">{{ $invoice[0]->total_invoice }}</div>
        </div>
    </div>
</div>

{{-- Divider Bulan Ini --}}
<div class="col-12 mt-3">
    <h5 class="fw-bold text-dark">📊 Rekap Bulan Ini</h5>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm text-center bg-light h-100">
            <div class="card-body">
                <h6 class="fw-semibold text-primary">Total Penjualan Bulan Ini</h6>
                <p class="text-success fw-bold mb-0 fs-5">
                    Rp {{ number_format($total_payment_bulan_ini, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm text-center bg-success bg-opacity-10 h-100">
            <div class="card-body">
                <h6 class="fw-semibold text-success">Total Keuntungan Bulan Ini</h6>
                <p class="text-success fw-bold mb-0 fs-5">
                    Rp {{ number_format($total_keuntungan_bulan_ini, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm text-center bg-light h-100">
            <div class="card-body">
                <h6 class="fw-semibold text-danger">Total Modal Bulan Ini</h6>
                <p class="text-danger fw-bold mb-0 fs-5">
                    Rp {{ number_format($total_modal_bulan_ini, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</div>

