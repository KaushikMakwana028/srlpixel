<style>
/* POS & Autocomplete Styling */
.srl-autocomplete-wrapper {
  position: relative;
}
.srl-autocomplete-dropdown {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
  max-height: 280px;
  overflow-y: auto;
  z-index: 1050;
  margin-top: 4px;
  display: none;
}
.srl-autocomplete-item {
  padding: 10px 14px;
  cursor: pointer;
  border-bottom: 1px solid #f1f5f9;
  transition: background 0.15s ease;
  display: flex;
  align-items: center;
  gap: 12px;
}
.srl-autocomplete-item:last-child {
  border-bottom: none;
}
.srl-autocomplete-item:hover,
.srl-autocomplete-item.active {
  background: #f8fafc;
}
.srl-autocomplete-item:hover .item-title,
.srl-autocomplete-item.active .item-title {
  color: var(--srl-pink);
}
.srl-pos-table th {
  font-size: 0.75rem;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  background: #f8fafc;
  color: #475569;
  border-bottom: 1px solid #e2e8f0;
}
.srl-pos-table td {
  vertical-align: middle;
}
.pos-qty-input {
  width: 54px;
  text-align: center;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  padding: 4px;
  font-weight: 700;
}
.pos-price-input {
  width: 90px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  padding: 4px 8px;
  font-weight: 600;
}
</style>

<div class="container-fluid px-3 px-md-4 py-4">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h3 class="fw-extrabold text-dark mb-0">Create Offline Order</h3>
        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1" style="font-size: 0.75rem;">
          POS Counter Sale
        </span>
      </div>
      <p class="text-muted small mb-0">Search existing customer or enter new walk-in details, add products, and generate official invoice.</p>
    </div>

    <!-- Back to List -->
    <a href="<?= base_url('admin/offline_orders') ?>" class="btn btn-outline-dark rounded-pill px-4 py-2 text-decoration-none fw-semibold">
      <i class="bi bi-arrow-left me-1"></i>Back to Offline Orders
    </a>
  </div>

  <?= form_open('admin/offline_orders/store', ['id' => 'offlineOrderForm']) ?>
    <input type="hidden" name="customer_id" id="selectedCustomerId" value="">
    <input type="hidden" name="country" value="India">

    <div class="row g-4">
      <!-- Left Column: Customer & Products (7 Columns on Large) -->
      <div class="col-lg-7 col-xl-8">

        <!-- ============================================================
             CARD 1: CUSTOMER SELECTION & AUTO-FILL
             ============================================================ -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
          <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: rgba(225, 29, 116, 0.1); color: var(--srl-pink);">
                <i class="bi bi-person-badge fs-5"></i>
              </div>
              <h5 class="fw-bold text-dark mb-0">Customer Information</h5>
            </div>
            <!-- Linked Customer Indicator Pill -->
            <div id="customerStatusBadge" style="display: none;">
              <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                <i class="bi bi-check-circle-fill me-1"></i><span id="linkedCustomerText">Existing Customer Linked</span>
                <button type="button" class="btn-close ms-2" style="font-size: 0.6rem;" onclick="clearSelectedCustomer()" aria-label="Clear"></button>
              </span>
            </div>
          </div>

          <div class="card-body p-3 p-md-4">
            <!-- Autocomplete Search Bar for Existing Customers -->
            <div class="mb-4">
              <label class="form-label fw-bold small text-secondary text-uppercase mb-1" style="letter-spacing: 0.5px;">
                <i class="bi bi-search me-1 text-pink" style="color: var(--srl-pink);"></i>Quick Search Existing Customer (Auto-Fill)
              </label>
              <div class="srl-autocomplete-wrapper">
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                  <input type="text" id="customerSearchInput" class="form-control border-start-0" placeholder="Type customer name, phone number, or email to search..." autocomplete="off">
                  <button type="button" class="btn btn-outline-secondary" id="btnClearCustomerSearch" onclick="clearCustomerSearch()" style="display: none;">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </div>
                <!-- Dropdown Suggestions Container -->
                <div id="customerSuggestions" class="srl-autocomplete-dropdown"></div>
              </div>
              <div class="form-text text-muted small mt-1">
                <i class="bi bi-info-circle me-1"></i>Click any suggestion to auto-fill all details below. If customer is new, simply type details directly.
              </div>
            </div>

            <!-- Customer Editable Fields (Auto-filled on selection) -->
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold small text-dark">Customer Full Name <span class="text-danger">*</span></label>
                <input type="text" name="full_name" id="custFullName" class="form-control cust-form-input" placeholder="e.g. Kaushik Makwana" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold small text-dark">Mobile Number <span class="text-danger">*</span></label>
                <input type="text" name="mobile" id="custMobile" class="form-control cust-form-input" placeholder="10-digit mobile number" required>
              </div>

              <div class="col-12">
                <label class="form-label fw-bold small text-dark">Email Address <span class="text-muted fw-normal">(Optional for walk-in)</span></label>
                <input type="email" name="email" id="custEmail" class="form-control cust-form-input" placeholder="e.g. customer@example.com">
                <div class="text-muted small mt-1" style="font-size: 0.75rem;">
                  If blank, a secure walk-in customer account is generated automatically.
                </div>
              </div>

              <div class="col-12">
                <label class="form-label fw-bold small text-dark">Address Line 1 (Street / Shop / House) <span class="text-danger">*</span></label>
                <input type="text" name="address_line1" id="custAddress1" class="form-control cust-form-input" placeholder="Flat, House No., Building, Street address" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold small text-dark">Address Line 2 <span class="text-muted fw-normal">(Optional)</span></label>
                <input type="text" name="address_line2" id="custAddress2" class="form-control cust-form-input" placeholder="Apartment, suite, unit, etc.">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold small text-dark">Landmark <span class="text-muted fw-normal">(Optional)</span></label>
                <input type="text" name="landmark" id="custLandmark" class="form-control cust-form-input" placeholder="e.g. Near Metro Pillar 124">
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold small text-dark">City <span class="text-danger">*</span></label>
                <input type="text" name="city" id="custCity" class="form-control cust-form-input" value="Ahmedabad" required>
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold small text-dark">State <span class="text-danger">*</span></label>
                <input type="text" name="state" id="custState" class="form-control cust-form-input" value="Gujarat" required>
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold small text-dark">Pincode <span class="text-danger">*</span></label>
                <input type="text" name="pincode" id="custPincode" class="form-control cust-form-input" placeholder="e.g. 380001" required>
              </div>
            </div>
          </div>
        </div>

        <!-- ============================================================
             CARD 2: PRODUCT SEARCH & LIVE CART LINE ITEMS
             ============================================================ -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
          <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: rgba(225, 29, 116, 0.1); color: var(--srl-pink);">
                <i class="bi bi-box-seam fs-5"></i>
              </div>
              <h5 class="fw-bold text-dark mb-0">Order Items</h5>
            </div>
            <span class="badge rounded-pill bg-light text-dark border px-3 py-1" id="itemsCountBadge">
              0 items added
            </span>
          </div>

          <div class="card-body p-3 p-md-4">
            <!-- Autocomplete Search Bar for Products -->
            <div class="mb-4">
              <label class="form-label fw-bold small text-secondary text-uppercase mb-1" style="letter-spacing: 0.5px;">
                <i class="bi bi-search me-1 text-pink" style="color: var(--srl-pink);"></i>Search & Add Products
              </label>
              <div class="srl-autocomplete-wrapper">
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-barcode"></i></span>
                  <input type="text" id="productSearchInput" class="form-control border-start-0" placeholder="Type product name, SKU, or model to search & add..." autocomplete="off">
                  <button type="button" class="btn btn-outline-secondary" id="btnClearProductSearch" onclick="clearProductSearch()" style="display: none;">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </div>
                <!-- Product Dropdown Suggestions Container -->
                <div id="productSuggestions" class="srl-autocomplete-dropdown"></div>
              </div>
              <div class="form-text text-muted small mt-1">
                <i class="bi bi-info-circle me-1"></i>Click on any product from suggestions to instantly add it to the table below.
              </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive">
              <table class="table align-middle srl-pos-table mb-0" id="orderItemsTable">
                <thead>
                  <tr>
                    <th style="width: 40px;">#</th>
                    <th>Product</th>
                    <th style="width: 120px;">Price (₹)</th>
                    <th style="width: 80px;" class="text-center">Stock</th>
                    <th style="width: 130px;" class="text-center">Quantity</th>
                    <th style="width: 110px;" class="text-end">Total (₹)</th>
                    <th style="width: 40px;" class="text-center"></th>
                  </tr>
                </thead>
                <tbody id="orderItemsTableBody">
                  <!-- Empty State Row -->
                  <tr id="emptyItemsRow">
                    <td colspan="7" class="text-center py-5 text-muted">
                      <i class="bi bi-cart-x fs-1 d-block mb-2 opacity-50"></i>
                      <div class="fw-semibold">No items added to this order yet.</div>
                      <div class="small">Use the search box above to find and add products.</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

      <!-- Right Column: Payment Details & Order Summary (5 Columns) -->
      <div class="col-lg-5 col-xl-4">

        <!-- ============================================================
             CARD 3: PAYMENT METHOD & PAYMENT STATUS
             ============================================================ -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
          <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom">
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: rgba(225, 29, 116, 0.1); color: var(--srl-pink);">
                <i class="bi bi-credit-card-2-front fs-5"></i>
              </div>
              <h5 class="fw-bold text-dark mb-0">Payment Details</h5>
            </div>
          </div>

          <div class="card-body p-3 p-md-4">
            <!-- Payment Method -->
            <div class="mb-3">
              <label class="form-label fw-bold small text-dark">Payment Method <span class="text-danger">*</span></label>
              <select name="payment_method" id="paymentMethodSelect" class="form-select srl-filter-select" required>
                <?php foreach ($payment_methods as $pm): ?>
                  <option value="<?= html_escape($pm) ?>" <?= ($pm === 'Cash') ? 'selected' : '' ?>>
                    <?= html_escape($pm) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Payment Status: Default to Pending -->
            <div class="mb-3">
              <label class="form-label fw-bold small text-dark">Payment Status <span class="text-danger">*</span></label>
              <select name="payment_status" id="paymentStatusSelect" class="form-select srl-filter-select fw-bold" required>
                <option value="Pending" selected class="text-warning fw-bold">⏳ Pending (Payment Due / Later)</option>
                <option value="Paid" class="text-success fw-bold">✓ Paid (Payment Received)</option>
                <option value="Partial" class="text-info fw-bold">Partially Paid</option>
              </select>
              <div class="form-text text-muted small mt-1" style="line-height: 1.4;">
                <i class="bi bi-shield-check text-success me-1"></i>No online gateway required. You can toggle between <strong>Pending</strong> and <strong>Paid</strong> anytime from the order list.
              </div>
            </div>

            <!-- Order Fulfillment Status -->
            <div class="mb-0">
              <label class="form-label fw-bold small text-dark">Initial Order Status</label>
              <select name="order_status" id="orderStatusSelect" class="form-select srl-filter-select">
                <?php foreach ($order_statuses as $os): ?>
                  <option value="<?= html_escape($os) ?>" <?= ($os === 'Confirmed') ? 'selected' : '' ?>>
                    <?= html_escape($os) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

        <!-- ============================================================
             CARD 4: ORDER FINANCIAL SUMMARY & SUBMISSION
             ============================================================ -->
        <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
          <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom">
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background: rgba(225, 29, 116, 0.1); color: var(--srl-pink);">
                <i class="bi bi-calculator fs-5"></i>
              </div>
              <h5 class="fw-bold text-dark mb-0">Order Summary</h5>
            </div>
          </div>

          <div class="card-body p-3 p-md-4">
            <!-- Items Subtotal -->
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="text-muted small">Items Subtotal:</span>
              <span class="fw-bold text-dark" id="summarySubtotal">₹0.00</span>
            </div>

            <!-- Shipping Fee Input -->
            <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
              <span class="text-muted small">Shipping / Delivery Fee:</span>
              <div class="input-group input-group-sm" style="width: 120px;">
                <span class="input-group-text bg-light text-muted">₹</span>
                <input type="number" step="0.01" min="0" name="shipping_fee" id="summaryShipping" class="form-control text-end" value="0.00" oninput="recalculateTotals()">
              </div>
            </div>

            <!-- Discount Input -->
            <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
              <span class="text-muted small">Discount / Adjustment:</span>
              <div class="input-group input-group-sm" style="width: 120px;">
                <span class="input-group-text bg-light text-muted">-₹</span>
                <input type="number" step="0.01" min="0" name="discount_amount" id="summaryDiscount" class="form-control text-end" value="0.00" oninput="recalculateTotals()">
              </div>
            </div>

            <hr class="my-3" style="border-color: #e2e8f0;">

            <!-- Grand Total -->
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="fw-bold text-dark fs-6">Grand Total:</span>
              <span class="fw-extrabold text-pink fs-4" id="summaryGrandTotal" style="color: var(--srl-pink);">₹0.00</span>
            </div>

            <!-- Notes / Remarks -->
            <div class="mb-4">
              <label class="form-label fw-bold small text-dark">Order Notes / Counter Remarks</label>
              <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Counter sale, walk-in cash customer, GST bill requested..."></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-srl-primary w-100 py-3 rounded-pill fw-bold fs-6 shadow-sm" id="btnSubmitOrder">
              <i class="bi bi-check2-circle me-2"></i>Create & Confirm Order
            </button>
            <div class="text-center text-muted small mt-2" style="font-size: 0.76rem;">
              Product stock will be deducted automatically from inventory.
            </div>
          </div>
        </div>

      </div>
    </div>
  <?= form_close() ?>
</div>

<script>
// Live Cart State
const orderItems = {}; // key: product_id -> { id, name, sku, price, stock, image_url, qty }

document.addEventListener('DOMContentLoaded', function () {
  // ==========================================================
  // CUSTOMER AUTOCOMPLETE
  // ==========================================================
  const custSearchInput    = document.getElementById('customerSearchInput');
  const custDropdown       = document.getElementById('customerSuggestions');
  const btnClearCustSearch = document.getElementById('btnClearCustomerSearch');
  let custSearchTimeout    = null;

  custSearchInput.addEventListener('input', function () {
    const val = this.value.trim();
    btnClearCustSearch.style.display = val.length > 0 ? 'block' : 'none';

    clearTimeout(custSearchTimeout);
    if (val.length < 1) {
      custDropdown.style.display = 'none';
      return;
    }

    custSearchTimeout = setTimeout(() => {
      fetch('<?= base_url('admin/offline_orders/search_customers') ?>?term=' + encodeURIComponent(val), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(res => res.json())
        .then(data => {
          if (data && data.length > 0) {
            let html = '';
            data.forEach(c => {
              const initial = c.name.charAt(0).toUpperCase();
              html += `
                <div class="srl-autocomplete-item" onclick="selectCustomer(${JSON.stringify(c).replace(/"/g, '&quot;')})">
                  <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 38px; height: 38px; background: var(--srl-pink-gradient); font-size: 0.95rem;">
                    ${initial}
                  </div>
                  <div class="flex-grow-1 text-truncate">
                    <div class="fw-bold text-dark item-title mb-0">${escapeHtml(c.name)}</div>
                    <div class="small text-muted">
                      <i class="bi bi-telephone me-1"></i>${escapeHtml(c.phone || 'No phone')} | <i class="bi bi-geo-alt me-1"></i>${escapeHtml(c.city || 'No city')}
                    </div>
                  </div>
                  <span class="badge bg-light text-dark border px-2 py-1 small">Select</span>
                </div>
              `;
            });
            custDropdown.innerHTML = html;
            custDropdown.style.display = 'block';
          } else {
            custDropdown.innerHTML = `
              <div class="p-3 text-center text-muted small">
                <i class="bi bi-person-x me-1"></i>No registered customer matches "<strong>${escapeHtml(val)}</strong>".<br>
                <span class="text-secondary">Type details below to auto-create this customer.</span>
              </div>
            `;
            custDropdown.style.display = 'block';
          }
        })
        .catch(err => console.error('Customer search error:', err));
    }, 250);
  });

  // Hide dropdown on click outside
  document.addEventListener('click', function (e) {
    if (!custSearchInput.contains(e.target) && !custDropdown.contains(e.target)) {
      custDropdown.style.display = 'none';
    }
  });

  // ==========================================================
  // PRODUCT AUTOCOMPLETE
  // ==========================================================
  const prodSearchInput    = document.getElementById('productSearchInput');
  const prodDropdown       = document.getElementById('productSuggestions');
  const btnClearProdSearch = document.getElementById('btnClearProductSearch');
  let prodSearchTimeout    = null;

  prodSearchInput.addEventListener('input', function () {
    const val = this.value.trim();
    btnClearProdSearch.style.display = val.length > 0 ? 'block' : 'none';

    clearTimeout(prodSearchTimeout);
    if (val.length < 1) {
      prodDropdown.style.display = 'none';
      return;
    }

    prodSearchTimeout = setTimeout(() => {
      fetch('<?= base_url('admin/offline_orders/search_products') ?>?term=' + encodeURIComponent(val), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(res => res.json())
        .then(data => {
          if (data && data.length > 0) {
            let html = '';
            data.forEach(p => {
              const stockBadge = p.stock > 0
                ? `<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">${p.stock} in stock</span>`
                : `<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Out of stock</span>`;

              html += `
                <div class="srl-autocomplete-item" onclick="addProductToOrder(${JSON.stringify(p).replace(/"/g, '&quot;')})">
                  <img src="${p.image_url}" alt="${escapeHtml(p.name)}" class="rounded-2 border flex-shrink-0" style="width: 44px; height: 44px; object-fit: cover;">
                  <div class="flex-grow-1 text-truncate">
                    <div class="fw-bold text-dark item-title mb-0 text-truncate">${escapeHtml(p.name)}</div>
                    <div class="small text-muted">
                      <span class="text-secondary fw-semibold">SKU:</span> ${escapeHtml(p.sku)} | 
                      <span class="fw-bold text-dark">₹${p.effective_price.toFixed(2)}</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    ${stockBadge}
                    <button type="button" class="btn btn-sm btn-srl-primary rounded-pill px-3 py-1">
                      <i class="bi bi-plus"></i> Add
                    </button>
                  </div>
                </div>
              `;
            });
            prodDropdown.innerHTML = html;
            prodDropdown.style.display = 'block';
          } else {
            prodDropdown.innerHTML = `
              <div class="p-3 text-center text-muted small">
                <i class="bi bi-box-seam me-1"></i>No products found matching "<strong>${escapeHtml(val)}</strong>".
              </div>
            `;
            prodDropdown.style.display = 'block';
          }
        })
        .catch(err => console.error('Product search error:', err));
    }, 250);
  });

  // Hide product dropdown on click outside
  document.addEventListener('click', function (e) {
    if (!prodSearchInput.contains(e.target) && !prodDropdown.contains(e.target)) {
      prodDropdown.style.display = 'none';
    }
  });

  // Form Submit Handler
  document.getElementById('offlineOrderForm').addEventListener('submit', function (e) {
    e.preventDefault();

    if (Object.keys(orderItems).length === 0) {
      Swal.fire({
        title: 'Empty Order',
        text: 'Please add at least one product to create an order.',
        icon: 'warning',
        customClass: { popup: 'srl-swal-popup' }
      });
      return;
    }

    const btn = document.getElementById('btnSubmitOrder');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating Order...';

    const formData = new FormData(this);

    fetch(this.action, {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      body: formData
    })
      .then(res => res.text())
      .then(rawText => {
        let data;
        try {
          data = JSON.parse(rawText);
        } catch (e) {
          // If any PHP notice was output before JSON, extract JSON substring
          const jsonStart = rawText.indexOf('{');
          const jsonEnd = rawText.lastIndexOf('}');
          if (jsonStart !== -1 && jsonEnd !== -1 && jsonEnd > jsonStart) {
            try {
              data = JSON.parse(rawText.substring(jsonStart, jsonEnd + 1));
            } catch (err) {
              console.error('Failed to parse extracted JSON:', err, rawText);
            }
          }
        }

        if (data && data.success) {
          Swal.fire({
            title: 'Order Created!',
            html: `
              <div class="mb-3 text-secondary" style="color: #cbd5e1 !important; font-size: 0.95rem;">
                Offline Order has been created successfully.
              </div>
              <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 mb-1" style="background: rgba(255, 42, 133, 0.08); border: 1px solid rgba(255, 42, 133, 0.25);">
                <span style="color: #94a3b8; font-size: 0.85rem;">Order No:</span>
                <span class="fw-bold" style="color: #ff5b9d; font-family: monospace; font-size: 1rem;">#${data.order_number}</span>
              </div>
            `,
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-printer-fill me-2"></i>Print Invoice',
            cancelButtonText: '<i class="bi bi-receipt me-2"></i>View All Orders',
            customClass: {
              popup: 'srl-swal-popup',
              title: 'srl-swal-title',
              actions: 'srl-swal-actions',
              confirmButton: 'srl-swal-confirm',
              cancelButton: 'srl-swal-cancel'
            },
            buttonsStyling: false
          }).then(result => {
            if (result.isConfirmed) {
              window.open(data.invoice_url, '_blank');
              window.location.href = data.redirect_url;
            } else {
              window.location.href = data.redirect_url;
            }
          });
        } else {
          Swal.fire({
            title: 'Unable to Create Order',
            text: (data && data.message) ? data.message : 'Please verify all required fields.',
            icon: 'error',
            customClass: { popup: 'srl-swal-popup' }
          });
          btn.disabled = false;
          btn.innerHTML = '<i class="bi bi-check2-circle me-2"></i>Create & Confirm Order';
        }
      })
      .catch(err => {
        console.error('Submission error:', err);
        Swal.fire({
          title: 'Error',
          text: 'An error occurred while saving the order. Please try again.',
          icon: 'error',
          customClass: { popup: 'srl-swal-popup' }
        });
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check2-circle me-2"></i>Create & Confirm Order';
      });
  });
});

// Select Customer Callback (Auto-fills inputs)
function selectCustomer(c) {
  document.getElementById('selectedCustomerId').value = c.id;
  document.getElementById('custFullName').value = c.name || '';
  document.getElementById('custMobile').value = c.phone || '';
  document.getElementById('custEmail').value = c.email || '';
  document.getElementById('custAddress1').value = c.address_line1 || '';
  document.getElementById('custAddress2').value = c.address_line2 || '';
  document.getElementById('custLandmark').value = c.landmark || '';
  document.getElementById('custCity').value = c.city || 'Ahmedabad';
  document.getElementById('custState').value = c.state || 'Gujarat';
  document.getElementById('custPincode').value = c.pincode || '';

  // Show status badge
  document.getElementById('linkedCustomerText').textContent = `Linked: ${c.name} (#${c.id})`;
  document.getElementById('customerStatusBadge').style.display = 'block';

  // Clear search bar and hide dropdown
  clearCustomerSearch();

  // Subtle highlight effect
  const inputs = ['custFullName', 'custMobile', 'custEmail', 'custAddress1', 'custCity', 'custState', 'custPincode'];
  inputs.forEach(id => {
    const el = document.getElementById(id);
    if (el) {
      el.style.borderColor = 'var(--srl-pink)';
      setTimeout(() => el.style.borderColor = '', 1200);
    }
  });
}

function clearSelectedCustomer() {
  document.getElementById('selectedCustomerId').value = '';
  document.getElementById('customerStatusBadge').style.display = 'none';
  document.getElementById('custFullName').value = '';
  document.getElementById('custMobile').value = '';
  document.getElementById('custEmail').value = '';
  document.getElementById('custAddress1').value = '';
  document.getElementById('custAddress2').value = '';
  document.getElementById('custLandmark').value = '';
  document.getElementById('custCity').value = 'Ahmedabad';
  document.getElementById('custState').value = 'Gujarat';
  document.getElementById('custPincode').value = '';
}

function clearCustomerSearch() {
  const input = document.getElementById('customerSearchInput');
  if (input) input.value = '';
  document.getElementById('customerSuggestions').style.display = 'none';
  document.getElementById('btnClearCustomerSearch').style.display = 'none';
}

function clearProductSearch() {
  const input = document.getElementById('productSearchInput');
  if (input) input.value = '';
  document.getElementById('productSuggestions').style.display = 'none';
  document.getElementById('btnClearProductSearch').style.display = 'none';
}

// Add Product To Order
function addProductToOrder(prod) {
  if (orderItems[prod.id]) {
    // Already in cart -> increment quantity
    orderItems[prod.id].qty += 1;
  } else {
    orderItems[prod.id] = {
      id: prod.id,
      name: prod.name,
      sku: prod.sku,
      price: prod.effective_price,
      stock: prod.stock,
      image_url: prod.image_url,
      qty: 1
    };
  }

  clearProductSearch();
  renderOrderItemsTable();
  recalculateTotals();
}

function updateItemQty(prodId, delta) {
  if (!orderItems[prodId]) return;
  orderItems[prodId].qty += delta;
  if (orderItems[prodId].qty <= 0) {
    delete orderItems[prodId];
  }
  renderOrderItemsTable();
  recalculateTotals();
}

function setItemQty(prodId, val) {
  if (!orderItems[prodId]) return;
  const num = parseInt(val);
  if (isNaN(num) || num <= 0) {
    orderItems[prodId].qty = 1;
  } else {
    orderItems[prodId].qty = num;
  }
  renderOrderItemsTable();
  recalculateTotals();
}

function updateItemPrice(prodId, val) {
  if (!orderItems[prodId]) return;
  const num = parseFloat(val);
  if (!isNaN(num) && num >= 0) {
    orderItems[prodId].price = num;
    recalculateTotals();
    const lineTotalEl = document.getElementById('line-total-' + prodId);
    if (lineTotalEl) {
      lineTotalEl.textContent = '₹' + (orderItems[prodId].price * orderItems[prodId].qty).toFixed(2);
    }
  }
}

function removeOrderItem(prodId) {
  delete orderItems[prodId];
  renderOrderItemsTable();
  recalculateTotals();
}

function renderOrderItemsTable() {
  const tbody = document.getElementById('orderItemsTableBody');
  const countBadge = document.getElementById('itemsCountBadge');
  const keys = Object.keys(orderItems);

  if (keys.length === 0) {
    tbody.innerHTML = `
      <tr id="emptyItemsRow">
        <td colspan="7" class="text-center py-5 text-muted">
          <i class="bi bi-cart-x fs-1 d-block mb-2 opacity-50"></i>
          <div class="fw-semibold">No items added to this order yet.</div>
          <div class="small">Use the search box above to find and add products.</div>
        </td>
      </tr>
    `;
    if (countBadge) countBadge.textContent = '0 items added';
    return;
  }

  let html = '';
  let idx = 1;
  let totalQty = 0;

  keys.forEach(pId => {
    const item = orderItems[pId];
    totalQty += item.qty;
    const lineTotal = (item.price * item.qty).toFixed(2);
    const stockBadge = item.stock > 0
      ? `<span class="badge bg-success-subtle text-success border px-2 py-1">${item.stock}</span>`
      : `<span class="badge bg-danger-subtle text-danger border px-2 py-1">0</span>`;

    html += `
      <tr>
        <td class="text-center text-muted small">
          ${idx++}
          <input type="hidden" name="item_product_id[]" value="${item.id}">
        </td>
        <td>
          <div class="d-flex align-items-center gap-2">
            <img src="${item.image_url}" alt="${escapeHtml(item.name)}" class="rounded-2 border flex-shrink-0" style="width: 42px; height: 42px; object-fit: cover;">
            <div class="text-truncate" style="max-width: 240px;">
              <div class="fw-bold text-dark small text-truncate" title="${escapeHtml(item.name)}">${escapeHtml(item.name)}</div>
              <div class="text-muted" style="font-size: 0.72rem;">SKU: ${escapeHtml(item.sku)}</div>
            </div>
          </div>
        </td>
        <td>
          <div class="input-group input-group-sm">
            <span class="input-group-text bg-light border-end-0 text-muted">₹</span>
            <input type="number" step="0.01" min="0" name="item_unit_price[]" class="form-control pos-price-input text-end" value="${item.price.toFixed(2)}" oninput="updateItemPrice(${item.id}, this.value)">
          </div>
        </td>
        <td class="text-center">
          ${stockBadge}
        </td>
        <td class="text-center">
          <div class="d-inline-flex align-items-center gap-1">
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;" onclick="updateItemQty(${item.id}, -1)">
              <i class="bi bi-dash"></i>
            </button>
            <input type="number" min="1" name="item_quantity[]" class="pos-qty-input" value="${item.qty}" onchange="setItemQty(${item.id}, this.value)">
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 26px; height: 26px;" onclick="updateItemQty(${item.id}, 1)">
              <i class="bi bi-plus"></i>
            </button>
          </div>
        </td>
        <td class="text-end fw-bold text-dark" id="line-total-${item.id}">
          ₹${lineTotal}
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle p-1" onclick="removeOrderItem(${item.id})" title="Remove item">
            <i class="bi bi-trash"></i>
          </button>
        </td>
      </tr>
    `;
  });

  tbody.innerHTML = html;
  if (countBadge) countBadge.textContent = `${keys.length} items (${totalQty} units)`;
}

function recalculateTotals() {
  let subtotal = 0.00;
  Object.keys(orderItems).forEach(id => {
    subtotal += (orderItems[id].price * orderItems[id].qty);
  });

  const shipping = parseFloat(document.getElementById('summaryShipping').value) || 0.00;
  const discount = parseFloat(document.getElementById('summaryDiscount').value) || 0.00;
  const grandTotal = Math.max(0, (subtotal + shipping) - discount);

  document.getElementById('summarySubtotal').textContent = '₹' + subtotal.toFixed(2);
  document.getElementById('summaryGrandTotal').textContent = '₹' + grandTotal.toFixed(2);
}

function escapeHtml(text) {
  if (!text) return '';
  return text.toString()
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
</script>
