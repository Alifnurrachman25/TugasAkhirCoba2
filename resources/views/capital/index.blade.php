@extends('layouts.main')

@section('container')
<div class="container mt-4">
    <h2>Perhitungan Modal Hari Ini</h2>

    <div class="alert alert-info mt-3">
        <p><strong>Total Modal Hari Ini:</strong> Rp {{ number_format($modalHariIni, 0, ',', '.') }}</p>
        <p><strong>Total Keuntungan Hari Ini:</strong> Rp {{ number_format($keuntunganHariIni, 0, ',', '.') }}</p>
    </div>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Menu</th>
                <th>Qty</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($todayTransactions as $trx)
                @foreach($trx->transaction_details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->menu->name }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp {{ number_format($detail->menu->modal, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
