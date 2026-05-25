<!DOCTYPE html>
<html>

<head>
    <title>New Sale</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .row {
            display: flex;
            gap: 20px;
        }

        .col {
            flex: 1;
        }

        .search-results {
            border: 1px solid #ddd;
            max-height: 250px;
            overflow-y: auto;
            margin-top: 10px;
        }

        .search-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .search-item:hover {
            background: #f1f5f9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px;
        }

        th {
            background: #f8fafc;
        }

        .btn {
            padding: 10px 18px;
            background: #0f172a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-danger {
            background: #dc2626;
        }

        .text-right {
            text-align: right;
        }

        .total-box {
            max-width: 300px;
            margin-left: auto;
            margin-top: 20px;
        }

        .total-box p {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
        }

        h1,
        h2 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="card">
            <h1>New Sale</h1>
            <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
        </div>

        <form id="saleForm" method="POST" action="{{ route('sales.store') }}">
            @csrf
            <input type="hidden" name="cart_data" id="cartData">

            <!-- Customer Information -->
            <div class="card">
                <h2>Customer Information</h2>

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
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">PO No</label>
                        <input type="text" name="po_no" class="form-control" value="{{ old('po_no') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Challan No</label>
                        <input type="text" name="challan_no" class="form-control" value="{{ old('challan_no') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle No</label>
                        <input type="text" name="vehicle_no" class="form-control" value="{{ old('vehicle_no') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">E-Waybill No</label>
                        <input type="text" name="ewaybill_no" class="form-control" value="{{ old('ewaybill_no') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Subject</label>
                        <textarea name="subject" class="form-control" rows="2">{{ old('subject') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Product Search -->
            <div class="card">
                <h2>Search Products</h2>

                <input type="text" id="productSearch" placeholder="Search by Material No or Product Name">

                <div id="searchResults" class="search-results"></div>
            </div>

            <!-- Cart -->
            <div class="card">
                <h2>Cart</h2>

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

                <button type="submit" class="btn">Finalize Sale</button>
            </div>
        </form>
    </div>

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
                // Price from product (selling_price preferred)
                const inclusivePrice = parseFloat(product.effective_price || 0);

                // Read GST from DB using gst_percentage then fallback to default
                let gstPercent = parseFloat(product.gst_percentage);
                if (isNaN(gstPercent) || gstPercent <= 0) {
                    gstPercent = DEFAULT_GST;
                }

                // Extract taxable price
                const gstPerUnit = inclusivePrice * gstPercent / (100 + gstPercent);
                const basePrice = inclusivePrice - gstPerUnit;

                const div = document.createElement('div');
                div.className = 'search-item';

                div.innerHTML = `
                <strong>${product.material_code}</strong> - ${product.name}
                <br>
                Taxable Price: ₹${basePrice.toFixed(2)}
                | GST ${gstPercent}%: ₹${gstPerUnit.toFixed(2)}
                | Final Price: ₹${inclusivePrice.toFixed(2)}
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
                cart.push({
                    id: product.id,
                    material_code: product.material_code,
                    name: product.name,
                    hsn_code: product.hsn_code,
                    // GST-inclusive price from product
                    price: parseFloat(product.effective_price || 0),
                    selling_price: product.selling_price ? parseFloat(product.selling_price) : null,
                    base_price: parseFloat(product.price || 0),

                    // GST percentage from DB
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
                const inclusivePrice = parseFloat(item.price || 0);
                const gstPercent = parseFloat(item.gst_percentage || DEFAULT_GST);

                // GST amount included in one unit price
                const gstPerUnit =
                    inclusivePrice * gstPercent / (100 + gstPercent);

                // Taxable unit price
                const basePrice = inclusivePrice - gstPerUnit;

                // Final line total (inclusive)
                const lineTotal = inclusivePrice * item.quantity;

                const row = document.createElement('tr');

                row.innerHTML = `
                <td>${item.material_code}</td>
                <td>${item.name}</td>
                <td>${item.hsn_code}</td>
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
                        X
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
        function removeItem(index) {
            cart.splice(index, 1);
            renderCart();
        }

        // Update totals
        function updateTotals() {
            let subtotal = 0;   // Taxable value
            let gst = 0;        // GST amount
            let grandTotal = 0; // Final inclusive total

            cart.forEach(item => {
                const inclusivePrice = parseFloat(item.price || 0);
                const gstPercent = parseFloat(item.gst_percentage || DEFAULT_GST);
                const qty = parseInt(item.quantity || 1);

                // GST included in final amount
                const lineGrandTotal = inclusivePrice * qty;
                const lineGst =
                    lineGrandTotal * gstPercent / (100 + gstPercent);
                const lineSubtotal = lineGrandTotal - lineGst;

                subtotal += lineSubtotal;
                gst += lineGst;
                grandTotal += lineGrandTotal;
            });

            // Round to 2 decimals
            subtotal = Math.round(subtotal * 100) / 100;
            gst = Math.round(gst * 100) / 100;
            grandTotal = Math.round(grandTotal * 100) / 100;

            const gstPercents = Array.from(new Set(
                cart.map(item => parseFloat(item.gst_percentage || DEFAULT_GST))
            ));
            const gstLabel = gstPercents.length === 1
                ? `${gstPercents[0].toFixed(2)}%`
                : 'varies';

            document.getElementById('subtotal').textContent =
                `₹${subtotal.toFixed(2)}`;

            document.getElementById('gstPercentLabel').textContent = gstLabel;
            document.getElementById('gstAmount').textContent =
                `₹${gst.toFixed(2)}`;

            document.getElementById('grandTotal').textContent =
                `₹${grandTotal.toFixed(2)}`;
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
</body>

</html>