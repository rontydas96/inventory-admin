@extends('layouts.app')

@section('title', 'Edit Sale')

@section('styles')
<style>
    h2 { font-size: 18px; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    h2 i { color: var(--accent); }
    .row { display: flex; gap: 20px; }
    .col { flex: 1; }
    input, textarea, select { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; font-family: inherit; transition: border .15s ease; background: #fff; color: var(--text); box-sizing: border-box; }
    input:focus, textarea:focus, select:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
    label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 8px; margin-top: 10px; }

    .search-results { background: #fff; border: 1px solid var(--border); border-radius: 8px; max-height: 250px; overflow-y: auto; position: relative; z-index: 10; }
    .search-item { padding: 10px 14px; cursor: pointer; border-bottom: 1px solid var(--border); font-size: 14px; }
    .search-item:last-child { border-bottom: none; }
    .search-item:hover { background: #f1f5f9; }
    .total-box { max-width: 300px; margin-left: auto; margin-top: 20px; }
    .total-box p { display: flex; justify-content: space-between; margin: 8px 0; font-size: 14px; }
    .total-box p:last-child { font-weight: 700; font-size: 16px; border-top: 2px solid var(--text); padding-top: 8px; }
    @media (max-width: 768px) { .row { flex-direction: column; gap: 0; } }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1><i class="fas fa-edit"></i> Edit Sale</h1>
        <a href="{{ route('sales.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Sales</a>
    </div>
</div>

<form id="saleForm" method="POST" action="{{ route('sales.update', ) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="cart_data" id="cartData">

    <div class="card">
        <h2><i class="fas fa-info-circle"></i> Sale Information</h2>

        <div class="row">
            <div class="col">
                <label>Invoice No *</label>
                <input type="text" name="invoice_no" value="{{ old('invoice_no', ->invoice_no) }}" required>
            </div>
            <div class="col">
                <label>Customer Name *</label>
                <input type="text" name="customer_name" id="customerName" autocomplete="off" value="{{ old('customer_name', ->customer_name) }}" required>
                <div id="customerSearchResults" class="search-results" style="display:none;"></div>
            </div>
            <div class="col">
                <label>Phone</label>
                <input type="text" name="customer_phone" id="customerPhone" value="{{ old('customer_phone', ->customer_phone) }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Email</label>
                <input type="email" name="customer_email" value="{{ old('customer_email', ->customer_email) }}">
            </div>
            <div class="col">
                <label>GST Number</label>
                <input type="text" name="customer_gst" value="{{ old('customer_gst', ->customer_gst) }}">
            </div>
            <div class="col">
                <label>PAN Number</label>
                <input type="text" name="customer_pan" value="{{ old('customer_pan', ->customer_pan) }}">
            </div>
        </div>

        <label>Billing Address</label>
        <textarea name="billing_address" rows="3">{{ old('billing_address', ->billing_address) }}</textarea>

        <label>Shipping Address</label>
        <textarea name="shipping_address" id="customerShippingAddress" rows="3">{{ old('shipping_address', ->shipping_address) }}</textarea>
    </div>

    <div class="card">
        <h2><i class="fas fa-file-invoice"></i> Invoice Fields</h2>

        <div class="row">
            <div class="col">
                <label>PO No</label>
                <input type="text" name="po_no" value="{{ old('po_no', ->po_no) }}">
            </div>
            <div class="col">
                <label>PO Date</label>
                <input type="date" name="po_date" value="{{ old('po_date', optional(->po_date)->format('Y-m-d')) }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Supplier Code</label>
                <input type="text" name="supplier_code" value="{{ old('supplier_code', ->supplier_code) }}">
            </div>
            <div class="col">
                <label>Ref Memo No</label>
                <input type="text" name="ref_memo_no" value="{{ old('ref_memo_no', ->ref_memo_no) }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Sale Date</label>
                <input type="date" name="sale_date" value="{{ old('sale_date', optional(->sale_date)->format('Y-m-d')) }}">
            </div>
            <div class="col">
                <label>Challan No</label>
                <input type="text" name="challan_no" value="{{ old('challan_no', ->challan_no) }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Vehicle No</label>
                <input type="text" name="vehicle_no" value="{{ old('vehicle_no', ->vehicle_no) }}">
            </div>
            <div class="col">
                <label>E-Waybill No</label>
                <input type="text" name="ewaybill_no" value="{{ old('ewaybill_no', ->ewaybill_no) }}">
            </div>
        </div>

        <label>Subject</label>
        <textarea name="subject" rows="2">{{ old('subject', ->subject) }}</textarea>
    </div>

    <div class="card">
        <h2><i class="fas fa-search"></i> Search Products</h2>
        <input type="text" id="productSearch" placeholder="Search by Material No or Product Name">
        <div id="searchResults" class="search-results"></div>
    </div>

    <div class="card">
        <h2><i class="fas fa-shopping-bag"></i> Cart</h2>

        <table id="cartTable">
            <thead>
                <tr>
                    <th>Material No</th>
                    <th>Product</th>
                    <th>HSN Code</th>
                    <th>Price</th>
                    <th width="140">Selling Price</th>
                    <th width="120">Qty</th>
                    <th>Total</th>
                    <th width="80">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="total-box">
            <p><strong>Subtotal:</strong> <span id="subtotal">&#8377;0.00</span></p>
            <p><strong>GST (<span id="gstPercentLabel">18%</span>):</strong> <span id="gstAmount">&#8377;0.00</span></p>
            <p><strong>Grand Total:</strong> <span id="grandTotal">&#8377;0.00</span></p>
        </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Sale</button>
    </div>
</form>

@php
     = ->items->map(function () {
         = optional(->product)->stock_level;
        return [
            'id' => ->product_id,
            'material_code' => ->material_code,
            'name' => ->product_name,
            'hsn_code' => optional(->product)->hsn_code ?? ->hsn_code,
            'price' => (float) ->unit_price,
            'selling_price' => (float) ->unit_price,
            'gst_percentage' => (float) ->gst_percentage,
            'quantity' => ->quantity,
            'base_price' => (float) ->unit_price,
            'max_stock' =>  !== null ?  + ->quantity : ->quantity,
        ];
    });
@endphp
@endsection

@section('scripts')
<script>
const searchInput = document.getElementById('productSearch');
const searchResults = document.getElementById('searchResults');
const cartBody = document.querySelector('#cartTable tbody');

let cart = @json();
const DEFAULT_GST = 18;

const customerNameInput = document.getElementById('customerName');
const customerSearchResults = document.getElementById('customerSearchResults');
const customerPhoneInput = document.getElementById('customerPhone');
const customerEmailInput = document.querySelector('input[name="customer_email"]');
const customerGstInput = document.querySelector('input[name="customer_gst"]');
const customerPanInput = document.querySelector('input[name="customer_pan"]');
const customerBillingText = document.querySelector('textarea[name="billing_address"]');
const customerShippingText = document.getElementById('customerShippingAddress');

customerNameInput.addEventListener('input', async function () {
    const q = this.value.trim();
    if (q.length < 2) { customerSearchResults.innerHTML = ''; customerSearchResults.style.display = 'none'; return; }
    const response = await fetch('{{ route("sales.customers.search") }}?q=' + encodeURIComponent(q));
    const customers = await response.json();
    customerSearchResults.innerHTML = '';
    if (customers.length === 0) { customerSearchResults.style.display = 'none'; return; }
    customers.forEach(customer => {
        const div = document.createElement('div');
        div.className = 'search-item';
        div.innerHTML = '<strong>' + customer.customer_name + '</strong><br>' + (customer.customer_phone || customer.customer_email || '');
        div.onclick = () => {
            customerNameInput.value = customer.customer_name;
            customerPhoneInput.value = customer.customer_phone || '';
            customerEmailInput.value = customer.customer_email || '';
            customerGstInput.value = customer.customer_gst || '';
            customerPanInput.value = customer.customer_pan || '';
            customerBillingText.value = customer.billing_address || '';
            customerShippingText.value = customer.shipping_address || '';
            customerSearchResults.innerHTML = '';
            customerSearchResults.style.display = 'none';
        };
        customerSearchResults.appendChild(div);
    });
    customerSearchResults.style.display = 'block';
});

document.addEventListener('click', function (event) {
    if (!customerSearchResults.contains(event.target) && event.target !== customerNameInput) {
        customerSearchResults.innerHTML = '';
        customerSearchResults.style.display = 'none';
    }
});

searchInput.addEventListener('input', async function () {
    const q = this.value.trim();
    if (q.length < 2) { searchResults.innerHTML = ''; return; }
    const response = await fetch('{{ route("sales.search") }}?q=' + encodeURIComponent(q));
    const products = await response.json();
    searchResults.innerHTML = '';
    products.forEach(product => {
        const basePrice = parseFloat(product.selling_price ?? product.price ?? 0);
        let gstPercent = parseFloat(product.gst_percentage);
        if (isNaN(gstPercent) || gstPercent <= 0) gstPercent = DEFAULT_GST;
        const gstPerUnit = basePrice * gstPercent / 100;
        const finalPrice = basePrice + gstPerUnit;
        const div = document.createElement('div');
        div.className = 'search-item';
        div.innerHTML = '<strong>' + product.material_code + '</strong> - ' + product.name + '<br>Taxable Price: ₹' + basePrice.toFixed(2) + ' | GST ' + gstPercent + '%: ₹' + gstPerUnit.toFixed(2) + ' | Final Price: ₹' + finalPrice.toFixed(2) + ' | Stock: ' + product.stock_level;
        div.onclick = () => addToCart(product, gstPercent);
        searchResults.appendChild(div);
    });
});

function addToCart(product, gstPercent) {
    const existing = cart.find(item => item.id === product.id);
    if (existing) {
        if (existing.quantity < product.stock_level) existing.quantity++;
        else alert('Not enough stock.');
    } else {
        const basePrice = parseFloat(product.selling_price ?? product.price ?? 0);
        cart.push({ id: product.id, material_code: product.material_code, name: product.name, hsn_code: product.hsn_code, price: basePrice, base_price: basePrice, selling_price: product.selling_price !== null ? parseFloat(product.selling_price) : null, gst_percentage: gstPercent, quantity: 1, max_stock: parseInt(product.stock_level || 0) });
    }
    renderCart();
}

function renderCart() {
    cartBody.innerHTML = '';
    cart.forEach((item, index) => {
        const basePrice = parseFloat(item.price || 0);
        const gstPercent = parseFloat(item.gst_percentage || DEFAULT_GST);
        const gstPerUnit = basePrice * gstPercent / 100;
        const lineTotal = (basePrice + gstPerUnit) * item.quantity;
        const row = document.createElement('tr');
        row.innerHTML = '<td><input type="text" value="' + item.material_code + '" onchange="updateMaterialCode(' + index + ', this.value)"></td><td>' + item.name + '</td><td><input type="text" value="' + (item.hsn_code || '') + '" onchange="updateHsnCode(' + index + ', this.value)"></td><td>₹' + basePrice.toFixed(2) + '<br><small>GST ' + gstPercent + '% = ₹' + gstPerUnit.toFixed(2) + '</small></td><td><input type="number" min="0" step="0.01" value="' + (item.selling_price !== null ? item.selling_price : '') + '" placeholder="' + (item.selling_price === null ? 'Use product price' : '') + '" onchange="updateSellingPrice(' + index + ', this.value)"></td><td><input type="number" min="1" max="' + item.max_stock + '" value="' + item.quantity + '" onchange="updateQty(' + index + ', this.value)"></td><td>₹' + lineTotal.toFixed(2) + '</td><td><button type=\\"button\\" class=\\"btn btn-danger\\" onclick=\\"removeItem(' + index + ')\\"><i class=\\"fas fa-trash\\"></i></button></td>';
        cartBody.appendChild(row);
    });
    updateTotals();
}

function updateQty(index, value) {
    let qty = parseInt(value);
    if (isNaN(qty) || qty < 1) qty = 1;
    if (qty > cart[index].max_stock) qty = cart[index].max_stock;
    cart[index].quantity = qty;
    renderCart();
}

function updateSellingPrice(index, value) {
    if (value === null || value === '') { cart[index].selling_price = null; cart[index].price = cart[index].base_price; }
    else { const price = parseFloat(value); if (isNaN(price) || price < 0) { cart[index].selling_price = null; cart[index].price = cart[index].base_price; } else { cart[index].selling_price = price; cart[index].price = price; } }
    renderCart();
}

function updateMaterialCode(index, value) { cart[index].material_code = value; renderCart(); }
function updateHsnCode(index, value) { cart[index].hsn_code = value; renderCart(); }
function removeItem(index) { cart.splice(index, 1); renderCart(); }

function updateTotals() {
    let subtotal = 0, gst = 0, grandTotal = 0;
    cart.forEach(item => {
        const basePrice = parseFloat(item.price || 0);
        const gstPercent = parseFloat(item.gst_percentage || DEFAULT_GST);
        const qty = parseInt(item.quantity || 1);
        const lineSubtotal = basePrice * qty;
        const lineGst = lineSubtotal * gstPercent / 100;
        subtotal += lineSubtotal; gst += lineGst; grandTotal += lineSubtotal + lineGst;
    });
    subtotal = Math.round(subtotal * 100) / 100;
    gst = Math.round(gst * 100) / 100;
    grandTotal = Math.round(grandTotal * 100) / 100;
    const gstPercents = Array.from(new Set(cart.map(item => parseFloat(item.gst_percentage || DEFAULT_GST))));
    const gstLabel = gstPercents.length === 1 ? gstPercents[0].toFixed(2) + '%' : 'varies';
    document.getElementById('subtotal').textContent = '₹' + subtotal.toFixed(2);
    document.getElementById('gstPercentLabel').textContent = gstLabel;
    document.getElementById('gstAmount').textContent = '₹' + gst.toFixed(2);
    document.getElementById('grandTotal').textContent = '₹' + grandTotal.toFixed(2);
}

document.getElementById('saleForm').addEventListener('submit', function (e) {
    if (cart.length === 0) { e.preventDefault(); alert('Please add at least one product.'); return; }
    document.getElementById('cartData').value = JSON.stringify(cart);
});

renderCart();
</script>
@endsection
