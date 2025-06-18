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
                <th>Harga Modal / Item</th>
                <th>Total Modal</th>
                <th>Harga Jual / Item</th>
                <th>Total Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($todayTransactions as $trx)
                @foreach($trx->transaction_details as $detail)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $detail->menu->name ?? '[Menu Dihapus]' }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp {{ number_format($detail->menu->modal ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format(($detail->menu->modal ?? 0) * $detail->qty, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->price / max($detail->qty, 1), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->price * $detail->qty, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
