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
                    <input type="number" class="form-control price-input" value="{{ $detail->qty * $detail->menu->price }}" readonly>
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
function updatePricePerRow(row) {
    const qty = parseInt(row.querySelector('.qty-input').value) || 0;
    const menuSelect = row.querySelector('.menu-select');
    const selectedOption = menuSelect.options[menuSelect.selectedIndex];
    const pricePerItem = parseInt(selectedOption.getAttribute('data-price')) || 0;

    const subtotal = qty * pricePerItem;
    row.querySelector('.price-input').value = subtotal;
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(function (row) {
        const price = parseInt(row.querySelector('.price-input').value) || 0;
        total += price;
    });

    // Tambahkan 10% PPN
    const ppn = total * 0.10;
    const totalWithTax = total + ppn;

    // Input form menampilkan total + PPN
    document.getElementById('total_transaction').value = totalWithTax;

}

// Tambah item
document.getElementById('add-item').addEventListener('click', function () {
    let container = document.getElementById('item-container');
    let row = container.querySelector('.item-row').cloneNode(true);
    row.querySelectorAll('select, input').forEach(input => {
        input.value = '';
    });
    container.appendChild(row);
    updatePricePerRow(row); // hitung subtotal awal untuk row baru
    updateTotal(); // Update total setelah tambah item
});

// Hapus item
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-item')) {
        if (document.querySelectorAll('.item-row').length > 1) {
            e.target.closest('.item-row').remove();
            updateTotal(); // Update total setelah hapus item
        }
    }
});

// Saat menu atau qty berubah
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('qty-input') || e.target.classList.contains('menu-select')) {
        const row = e.target.closest('.item-row');
        updatePricePerRow(row);
        updateTotal();
    }
});

// Persiapan sebelum submit
function prepareData() {
    let items = [];
    let total = 0;

    document.querySelectorAll('.item-row').forEach(function (row) {
        const menuId = row.querySelector('.menu-select').value;
        const qty = parseInt(row.querySelector('.qty-input').value);
        const price = parseInt(row.querySelector('.price-input').value);

        if (menuId && qty && price) {
            items.push({
                menu_id: menuId,
                qty: qty,
                price: price
            });
            total += price;
        }
    });

    // Hitung total + PPN 10%
    const ppn = total * 0.10;
    const totalWithTax = total + ppn;

    document.getElementById('menu_id_field').value = JSON.stringify(items);
    // Input form dikirim dengan nilai setelah PPN
    document.getElementById('total_transaction').value = totalWithTax;
    return true;
}

// Hitung harga awal saat halaman dibuka
document.querySelectorAll('.item-row').forEach(updatePricePerRow);
updateTotal();
</script>
@endpush

