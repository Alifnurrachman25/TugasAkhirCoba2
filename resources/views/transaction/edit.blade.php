@extends('layouts.main')

@section('container')
<h1>Edit Transaction #{{ $transaction->id }}</h1>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('transaction.update', $transaction->id) }}" onsubmit="return prepareData()">
    @csrf
    @method('PUT')

    <input type="hidden" name="menu_id" id="menu_id_field">

    <div class="mb-3">
        <label for="no_table" class="form-label">Table Number</label>
        <input type="text" name="no_table" class="form-control" value="{{ $transaction->no_table }}" required>
    </div>

    <div class="mb-3">
        <label for="total_transaction" class="form-label">Total Transaction</label>
        <input type="number" name="total_transaction" id="total_transaction" class="form-control" value="{{ $transaction->total_transaction }}" required>
    </div>

    <div class="mb-3">
        <label for="payment_method" class="form-label">Payment Method</label>
        <select name="payment_method" class="form-select" required>
            <option value="cash" {{ $transaction->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
            <option value="cashless" {{ $transaction->payment_method == 'cashless' ? 'selected' : '' }}>Cashless</option>
        </select>
    </div>

    <h5>Transaction Items</h5>
    <div id="item-container">
        @foreach ($transaction->transaction_details as $detail)
            <div class="row mb-2 item-row">
                <div class="col-md-5">
                    <select class="form-select menu-select" required>
                        <option value="">Select Menu</option>
                        @foreach (array_merge($foods->all(), $drinks->all(), $desserts->all()) as $menu)
                            <option value="{{ $menu->id }}" data-price="{{ $menu->price }}" {{ $menu->id == $detail->menu_id ? 'selected' : '' }}>
                                {{ $menu->name }} - IDR {{ number_format($menu->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control qty-input" min="1" value="{{ $detail->qty }}" required>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control price-input" value="{{ $detail->price }}" readonly>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-secondary mb-3" id="add-item">Add Another</button>
    <br>
    <button type="submit" class="btn btn-primary">Update Transaction</button>
</form>
@endsection

@push('scripts')
<script>
    // Tambahkan baris item baru
    document.getElementById('add-item').addEventListener('click', function () {
        let container = document.getElementById('item-container');
        let row = container.querySelector('.item-row').cloneNode(true);
        row.querySelectorAll('select, input').forEach(input => input.value = '');
        container.appendChild(row);
    });

    // Hapus baris item
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            if (document.querySelectorAll('.item-row').length > 1) {
                e.target.closest('.item-row').remove();
            }
        }
    });

    // Update harga ketika menu dipilih
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('menu-select')) {
            let selected = e.target.options[e.target.selectedIndex];
            let price = selected.getAttribute('data-price');
            e.target.closest('.item-row').querySelector('.price-input').value = price;
        }
    });

    // Persiapkan data sebelum dikirim
    function prepareData() {
        let items = [];
        let total = 0;
        document.querySelectorAll('.item-row').forEach(function (row) {
            let menuId = row.querySelector('.menu-select').value;
            let qty = parseInt(row.querySelector('.qty-input').value);
            let price = parseInt(row.querySelector('.price-input').value);

            if (menuId && qty && price) {
                items.push({
                    menu_id: menuId,
                    qty: qty,
                    price: price
                });
                total += qty * price;
            }
        });

        document.getElementById('menu_id_field').value = JSON.stringify(items);
        document.getElementById('total_transaction').value = total;
        return true;
    }
</script>
@endpush
