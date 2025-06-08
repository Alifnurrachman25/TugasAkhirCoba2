<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/images/logofood.ico">
    <title>Invoice</title>

    <!-- FontAwesome JS-->
    <script defer src="/plugins/fontawesome/js/all.min.js"></script>

    <!-- App CSS -->
    <link rel="stylesheet" href="/css/portal.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/fontawesome-free-6.2.1-web/css/all.css">
</head>
<body>
    <div class="card">
        <div class="card-body mx-4">
            <div class="container">
            <p class="my-5 mb-0 text-center" style="font-size: 30px;">Bakso Pak TUM</p>
            <p class="mt-0 mb-1 text-center" style="font-size: 15px;">Jl. Parangtritis No.8</p>
            <p class="mt-0 mb-4 text-center" style="font-size: 15px;">221-691-6080</p>
            @foreach ($data as $key)
                @php
                    $datetime = explode(' ', $key->created_at)[0];
                    $date = \Carbon\Carbon::parse($datetime);

                    $times_ex = explode(' ', $key->created_at)[1];
                    $times = \Carbon\Carbon::parse($times_ex);
                    $time = explode(' ', $times->toDayDateTimeString());
                @endphp
                <div class="row">
                    <ul class="list-unstyled">
                        <li class="text-black">Cashier &nbsp : &nbsp{{ $key->user->name }}</li>
                        <li class="text-muted mt-1"><span class="text-black">Table</span> {{ $key->no_table }}</li>
                        <li class="text-black mt-1">Date &nbsp : &nbsp {{ $date->toFormattedDateString() }} {{ $time[4].' '.$time[5] }}</li>
                    </ul>
                    <hr>
                    @foreach ($key->transaction_details as $item)
                    <div class="col-xl-10">
                        <p class="mb-0">{{ $item->menu->name }}</p>
                        <p class="small text-muted">{{ $item->qty }} x {{ $item->menu->price }}</p>
                    </div>
                    <div class="col-xl-2">
                        <p class="float-end">{{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <hr>
                    @endforeach
                </div>
                <div class="row text-black">
                    @php
                        $arr = [];
                        foreach($key->transaction_details as $item) {
                            $arr[] = $item->price;
                        };

                        function myfunction($v1,$v2)
                        {
                            return $v1 + $v2;
                        }

                        $total = array_reduce($arr, "myfunction");
                    @endphp

                    <div class="col-xl-12">
                        <p class="float-end fw-bold">SubTotal &nbsp: &nbsp &nbsp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-xl-12">
                        <p class="float-end fw-bold">PPN &nbsp: &nbsp &nbsp &nbsp 10%</p>
                    </div>
                    <div class="row text-black">
                        <div class="col-xl-12">
                            <p class="float-end fw-bold">Payment Method &nbsp: &nbsp {{ $key->payment_method }}</p>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <p class="float-end fw-bold">Total yang harus dibayar &nbsp: &nbsp {{ number_format($key->total_transaction, 0,',','.') }}</p>
                    </div>
                    <div>
                        <p class="float-end fw-bold total-payment">Total pembayaran &nbsp: &nbsp {{ number_format($key->total_payment, 0, ',', '.') }}</p>
                    </div>
                    <hr style="border: 2px solid black;">
                </div>
                <h2 class="float-end kembalian" style="margin-top: 20px;">Kembalian: -</h2>
            @endforeach
            <div class="text-center" style="margin-top: 90px;">
                <p class="mb-0 d-flex align-items-center justify-content-center"><u class="text-info text-decoration-none"><img src="/images/logofood.png" alt="" srcset="" width="20">Bakso Pak TUM</u></p>
                <p>Thanks for joining us at Bakso Pak Tum. </p>
            </div>

            </div>
        </div>
    </div>
    <script>
    window.onload = function () {
        let totalPaymentEl = document.querySelector('.total-payment');
        let kembalianEl = document.querySelector('.kembalian');
        let fromStorage = localStorage.getItem('payment');

        if (totalPaymentEl.innerText == '0' && fromStorage) {
            totalPaymentEl.innerText = fromStorage;
        } else {
            fromStorage = totalPaymentEl.innerText;
        }

        // Ambil angka dari teks total dan total payment
        let totalStr = "{{ $key->total_transaction }}";
        let total = parseInt(totalStr);
        let paidStr = fromStorage.toString().replace(/[^\d]/g, ''); // ambil hanya angka
        let paid = parseInt(paidStr);

        let kembalian = paid - total;

        if (kembalian >= 0) {
            kembalianEl.innerText = "Kembalian: " + kembalian.toLocaleString('id-ID');
        } else {
            kembalianEl.innerText = "Kembalian: 0";
        }

        localStorage.clear();
        window.print();
    }
</script>

</body>
</html>
