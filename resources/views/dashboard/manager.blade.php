<div class="col-lg-8 mb-4 shadow rounded d-flex align-items-center bg-transparent">
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7 ps-3">
                <div class="card-body">
                    <h5 class="card-title text-primary">Welcome Back {{ auth()->user()->name }} 🎉</h5>
                    <p class="mb-4 text-dark">
                        Selamat menjalani hari ini!
                    </p>
                </div>
            </div>
            {{-- <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img src="/images/dash-logo.png" height="200">
                </div>
            </div> --}}
            <div id="carouselExampleFade" class="col-sm-5 text-center text-sm-left carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner" style="padding-left: 25%;">
                    <div class="carousel-item active">
                        <img src="/images/foodicon/food-icon1.png" class="d-block" height="180" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/images/foodicon/food-icon2.png" class="d-block" height="180" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/images/foodicon/food-icon3.png" class="d-block" height="180" alt="...">
                    </div>
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
                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>Rp {{ number_format($total_income[0]->total_income,0,',','.') }} </small>
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
