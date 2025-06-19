<div class="col-lg-8 mb-4 shadow rounded d-flex align-items-center bg-transparent">
    <div class="card w-100">
        <div class="d-flex align-items-end row justify-content-center">
            <div class="col-sm-12 ps-3 text-center">
                <div class="card-body">
                    <h5 class="card-title text-primary">Welcome Back {{ auth()->user()->name }} 🎉</h5>
                    <p class="mb-4 text-dark">
                        Selamat menjalani hari ini!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-4 col-md-4 order-1">
    <div class="row ps-2 d-flex justify-content-evenly">
        <div class="col-lg-5 col-md-12 col-6 mb-4 shadow rounded">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="images/icons/unicons/dollar-sign.png" width="40" alt="chart success"
                                class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-dark">Penjualan</span>
                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>Rp {{ number_format($total_sales[0]->total_sales,0,',','.') }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-6 mb-4 shadow rounded">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="images/icons/unicons/menu-info.png" width="40" alt="Credit Card"
                                class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-dark">Menu's</span>
                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ $total_menus }}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-6 mb-4 shadow rounded">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="images/icons/unicons/wallet.png" width="40" alt="Credit Card"
                                class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-dark">Pemasukan</span>
                    {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>Rp {{ number_format($total_income[0]->total_income,0,',','.') }} </small> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12 col-6 mb-4 shadow rounded">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="images/icons/unicons/wallet-info.png" width="40" alt="Credit Card"
                                class="rounded" />
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1 text-dark">Bukti pembayaran</span>
                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ $invoice[0]->total_invoice }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
