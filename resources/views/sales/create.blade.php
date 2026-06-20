@extends('layouts.app')

@section('title', 'New Sale')

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
        <h1><i class="fas fa-shopping-cart"></i> New Sale</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>
</div>

<form id="saleForm" method="POST" action="{{ route('sales.store') }}">
    @csrf
    <input type="hidden" name="cart_data" id="cartData">

    <!-- Customer Information -->
    <div class="card">
        <h2><i class="fas fa-user"></i> Customer Information</h2>

        <div class="row">
            <div class="col">
                <label>Customer Name *</label>
                <input type="text" name="customer_name" id="customerName" autocomplete="off" required>
                <div id="customerSearchResults" class="search-results" style="display:none;"></div>
            </div>

            <div class="col">
                <label>Phone</label>
                <input type="text" name="customer_phone" id="customerPhone">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Email</label>
                <input type="email" name="customer_email">
            </div>

            <div class="col">
                <label>GST Number</label>
                <input type="text" name="customer_gst">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>PAN Number</label>
                <input type="text" name="customer_pan">
            </div>
        </div>

        <label>Billing Address</label>
        <textarea name="billing_address" rows="3"></textarea>

        <label>Shipping Address</label>
        <textarea name="shipping_address" id="customerShippingAddress" rows="3"></textarea>
    </div>

    <div class="card">
        <h2><i class="fas fa-file-invoice"></i> Invoice Fields</h2>
        <div class="row">
            <div class="col">
                <label>PO No</label>
                <input type="text" name="po_no" value="{{ old('po_no') }}">
            </div>

            <div class="col">
                <label>PO Date</label>
                <input type="date" name="po_date" value="{{ old('po_date') }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Supplier Code</label>
                <input type="text" name="supplier_code" value="{{ old('supplier_code') }}">
            </div>

            <div class="col">
                <label>Ref Memo No</label>
                <input type="text" name="ref_memo_no" value="{{ old('ref_memo_no') }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Sale Date</label>
                <input type="date" name="sale_date" value="{{ old('sale_date') }}">
            </div>

            <div class="col">
                <label>Challan No</label>
                <input type="text" name="challan_no" value="{{ old('challan_no', $nextChallanNo ?? '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label>Vehicle No</label>
                <input type="text" name="vehicle_no" value="{{ old('vehicle_no') }}">
            </div>

            <div class="col">
                <label>E-Waybill No</label>
                <input type="text" name="ewaybill_no" value="{{ old('ewaybill_no') }}">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>Subject</label>
                <textarea name="subject" rows="2">{{ old('subject') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Product Search -->
    <div class="card">
        <h2><i class="fas fa-search"></i> Search Products</h2>

        <input type="text" id="productSearch" placeholder="Search by Material No or Product Name">

        <div id="searchResults" class="search-results"></div>
    </div>

    <!-- Cart -->
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
            <p><strong>Subtotal:</strong> <span id="subtotal">₹0.00</span></p>
            <p><strong>GST (<span id="gstPercentLabel">18%</span>):</strong> <span id="gstAmount">₹0.00</span></p>
            <p><strong>Grand Total:</strong> <span id="grandTotal">₹0.00</span></p>
        </div>

        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Finalize Sale</button>
    </div>
</form>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('productSearch');
    const searchResults = document.getElementById('searchResults');
    const cartBody = document.querySelector('#cartTable tbody');

    let cart = [];
    const DEFAULT_GST = 18;

    // Customer autocomplete
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

        if (q.length < 2) {
            customerSearchResults.innerHTML = '';
            customerSearchResults.style.display = 'none';
            return;
        }

        const response = await fetch(
            `{{ route('sales.customers.search') }}?q=${encodeURIComponent(q)}`
        );

        const customers = await response.json();

        customerSearchResults.innerHTML = '';

        if (customers.length === 0) {
            customerSearchResults.style.display = 'none';
            return;
        }

        customers.forEach(customer => {
            const div = document.createElement('div');
            div.className = 'search-item';
            div.innerHTML = `
                <strong>${customer.customer_name}</strong>
                <br>
                ${customer.customer_phone || customer.customer_email || ''}
            `;

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

    // Search products
    searchInput.addEventListener('input', async function () {
        const q = this.value.trim();

        if (q.length < 2) {
            searchResults.innerHTML = '';
            return;
        }

        const response = await fetch(
            `{{ route('sales.search') }}?q=${encodeURIComponent(q)}`
        );

        const products = await response.json();

        searchResults.innerHTML = '';


        products.forEach(product => {
            const basePrice = parseFloat(product.selling_price ?? product.price ?? 0);

            let gstPercent = parseFloat(product.gst_percentage);
            if (isNaN(gstPercent) || gstPercent <= 0) {
                gstPercent = DEFAULT_GST;
            }

            const gstPerUnit = basePrice * gstPercent / 100;
            const finalPrice = basePrice + gstPerUnit;

            const div = document.createElement('div');
            div.className = 'search-item';

            div.innerHTML = `
            <strong>${product.material_code}</strong> - ${product.name}
            <br>
            Taxable Price: ₹${basePrice.toFixed(2)}
            | GST ${gstPercent}%: ₹${gstPerUnit.toFixed(2)}
            | Final Price: ₹${finalPrice.toFixed(2)}
            | Stock: ${product.stock_level}
            `;

            div.onclick = () => addToCart(product, gstPercent);
            searchResults.appendChild(div);
        });
    });

    // Add to cart
    function addToCart(product, gstPercent) {
        const existing = cart.find(item => item.id === product.id);

        if (existing) {
            if (existing.quantity < product.stock_level) {
                existing.quantity++;
            } else {
                alert('Not enough stock.');
            }
        } else {
            const basePrice = parseFloat(product.selling_price ?? product.price ?? 0);

            cart.push({
                id: product.id,
                material_code: product.material_code,
                name: product.name,
                hsn_code: product.hsn_code,
                price: basePrice,
                base_price: basePrice,
                selling_price: product.selling_price !== null ? parseFloat(product.selling_price) : null,
                gst_percentage: gstPercent,
                quantity: 1,
                max_stock: parseInt(product.stock_level || 0)
            });
        }

        renderCart();
    }

    // Render cart
    function renderCart() {
        cartBody.innerHTML = '';

        cart.forEach((item, index) => {
            const basePrice = parseFloat(item.price || 0);
            const gstPercent = parseFloat(item.gst_percentage || DEFAULT_GST);
            const gstPerUnit = basePrice * gstPercent / 100;
            const lineTotal = (basePrice + gstPerUnit) * item.quantity;

            const row = document.createElement('tr');

            row.innerHTML = `
            <td><input type="text" value="${item.material_code}" onchange="updateMaterialCode(${index}, this.value)"></td>
            <td>${item.name}</td>
            <td><input type="text" value="${item.hsn_code || ''}" onchange="updateHsnCode(${index}, this.value)"></td>
            <td>
                ₹${basePrice.toFixed(2)}
                <br>
                <small>
                    GST ${gstPercent}% = ₹${gstPerUnit.toFixed(2)}
                </small>
            </td>
            <td>
                <input type="number"
                       min="0"
                       step="0.01"
                       value="${item.selling_price !== null ? item.selling_price : ''}"
                       placeholder="${item.selling_price === null ? 'Use product price' : ''}"
                       onchange="updateSellingPrice(${index}, this.value)">
            </td>
            <td>
                <input type="number"
                       min="1"
                       max="${item.max_stock}"
                       value="${item.quantity}"
                       onchange="updateQty(${index}, this.value)">
            </td>
            <td>₹${lineTotal.toFixed(2)}</td>
            <td>
                <button type="button"
                        class="btn btn-danger"
                        onclick="removeItem(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
            `;

            cartBody.appendChild(row);
        });

        updateTotals();
    }

    // Update quantity
    function updateQty(index, value) {
        let qty = parseInt(value);

        if (isNaN(qty) || qty < 1) {
            qty = 1;
        }

        if (qty > cart[index].max_stock) {
            qty = cart[index].max_stock;
        }

        cart[index].quantity = qty;
        renderCart();
    }

    // Update selling price
    function updateSellingPrice(index, value) {
        if (value === null || value === '') {
            cart[index].selling_price = null;
            cart[index].price = cart[index].base_price;
        } else {
            const price = parseFloat(value);
            if (isNaN(price) || price < 0) {
                cart[index].selling_price = null;
                cart[index].price = cart[index].base_price;
            } else {
                cart[index].selling_price = price;
                cart[index].price = price;
            }
        }
        renderCart();
    }

    // Remove item
    function updateMaterialCode(index, value) {
        cart[index].material_code = value;
        renderCart();
    }

    function updateHsnCode(index, value) {
        cart[index].hsn_code = value;
        renderCart();
    }

    function removeItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    // Update totals (GST-exclusive pricing)
    function updateTotals() {
        let subtotal = 0;
        let gst = 0;
        let grandTotal = 0;

        cart.forEach(item => {
            const basePrice = parseFloat(item.price || 0);
            const gstPercent = parseFloat(item.gst_percentage || DEFAULT_GST);
            const qty = parseInt(item.quantity || 1);

            const lineSubtotal = basePrice * qty;
            const lineGst = lineSubtotal * gstPercent / 100;
            const lineGrandTotal = lineSubtotal + lineGst;

            subtotal += lineSubtotal;
            gst += lineGst;
            grandTotal += lineGrandTotal;
        });

        subtotal = Math.round(subtotal * 100) / 100;
        gst = Math.round(gst * 100) / 100;
        grandTotal = Math.round(grandTotal * 100) / 100;

        const gstPercents = Array.from(new Set(
            cart.map(item => parseFloat(item.gst_percentage || DEFAULT_GST))
        ));
        const gstLabel = gstPercents.length === 1
            ? `${gstPercents[0].toFixed(2)}%`
            : 'varies';

        document.getElementById('subtotal').textContent = `₹${subtotal.toFixed(2)}`;
        document.getElementById('gstPercentLabel').textContent = gstLabel;
        document.getElementById('gstAmount').textContent = `₹${gst.toFixed(2)}`;
        document.getElementById('grandTotal').textContent = `₹${grandTotal.toFixed(2)}`;
    }

    // Submit cart data
    document.getElementById('saleForm').addEventListener('submit', function (e) {
        if (cart.length === 0) {
            e.preventDefault();
            alert('Please add at least one product.');
            return;
        }

        document.getElementById('cartData').value =
            JSON.stringify(cart);
    });
</script>
@endsection
