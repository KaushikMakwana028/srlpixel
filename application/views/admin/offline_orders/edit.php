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
      <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
        <a href="<?= base_url('admin/offline_orders') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
          <i class="bi bi-arrow-left me-1"></i>Back
        </a>
        <h3 class="fw-extrabold text-dark mb-0">Edit Offline Order #<?= html_escape($order->order_number) ?></h3>
        <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1" style="font-size: 0.75rem;">
          Edit Mode
        </span>
      </div>
      <p class="text-muted small mb-0">Modify customer delivery info, line items, and fulfillment settings.</p>
    </div>

    <!-- Quick Shortcuts -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
      <a href="<?= base_url('admin/offline_orders/detail/' . $order->id) ?>" class="btn btn-outline-primary rounded-pill px-3 py-2 text-decoration-none fw-semibold">
        <i class="bi bi-eye me-1"></i>View Details
      </a>
      <a href="<?= base_url('admin/offline_orders/invoice/' . $order->id) ?>" target="_blank" class="btn btn-outline-dark rounded-pill px-3 py-2 text-decoration-none fw-semibold">
        <i class="bi bi-printer me-1"></i>Print Invoice
      </a>
    </div>
  </div>

  <?= form_open('admin/offline_orders/update/' . $order->id, ['id' => 'offlineOrderForm']) ?>
    <input type="hidden" name="order_id" value="<?= $order->id ?>">
    <input type="hidden" name="customer_id" id="selectedCustomerId" value="<?= $order->user_id ?>">
    <input type="hidden" name="country" value="<?= html_escape($order->shipping_country ?: 'India') ?>">

    <div class="row g-4">
      <!-- Left Column: Customer & Products -->
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
            <div id="customerStatusBadge">
              <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                <i class="bi bi-check-circle-fill me-1"></i><span id="linkedCustomerText"><?= html_escape($order->shipping_full_name) ?></span>
              </span>
            </div>
          </div>

          <div class="card-body p-3 p-md-4">
            <!-- Autocomplete Search Bar for Switching Customer -->
            <div class="mb-4">
              <label class="form-label fw-bold small text-secondary text-uppercase mb-1" style="letter-spacing: 0.5px;">
                <i class="bi bi-search me-1 text-pink" style="color: var(--srl-pink);"></i>Switch or Search Customer (Auto-Fill)
              </label>
              <div class="srl-autocomplete-wrapper">
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                  <input type="text" id="customerSearchInput" class="form-control border-start-0" placeholder="Type name, phone, or email to search..." autocomplete="off">
                  <button type="button" class="btn btn-outline-secondary" id="btnClearCustomerSearch" onclick="clearCustomerSearch()" style="display: none;">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </div>
                <!-- Dropdown Suggestions Container -->
                <div id="customerSuggestions" class="srl-autocomplete-dropdown"></div>
              </div>
            </div>

            <!-- Customer Editable Fields -->
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-bold small text-dark">Customer Full Name <span class="text-danger">*</span></label>
                <input type="text" name="full_name" id="custFullName" class="form-control cust-form-input" value="<?= html_escape($order->shipping_full_name) ?>" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold small text-dark">Mobile Number <span class="text-danger">*</span></label>
                <input type="text" name="mobile" id="custMobile" class="form-control cust-form-input" value="<?= html_escape($order->shipping_mobile) ?>" required>
              </div>

              <div class="col-12">
                <label class="form-label fw-bold small text-dark">Email Address <span class="text-muted fw-normal">(Optional)</span></label>
                <input type="email" name="email" id="custEmail" class="form-control cust-form-input" value="<?= ($customer && !empty($customer->email)) ? html_escape($customer->email) : '' ?>">
              </div>

              <div class="col-12">
                <label class="form-label fw-bold small text-dark">Address Line 1 <span class="text-danger">*</span></label>
                <input type="text" name="address_line1" id="custAddress1" class="form-control cust-form-input" value="<?= html_escape($order->shipping_address_line1) ?>" required>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold small text-dark">Address Line 2 <span class="text-muted fw-normal">(Optional)</span></label>
                <input type="text" name="address_line2" id="custAddress2" class="form-control cust-form-input" value="<?= html_escape($order->shipping_address_line2) ?>">
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold small text-dark">Landmark <span class="text-muted fw-normal">(Optional)</span></label>
                <input type="text" name="landmark" id="custLandmark" class="form-control cust-form-input" value="<?= html_escape($order->shipping_landmark) ?>">
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold small text-dark">City <span class="text-danger">*</span></label>
                <input type="text" name="city" id="custCity" class="form-control cust-form-input" value="<?= html_escape($order->shipping_city) ?>" required>
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold small text-dark">State <span class="text-danger">*</span></label>
                <input type="text" name="state" id="custState" class="form-control cust-form-input" value="<?= html_escape($order->shipping_state) ?>" required>
              </div>

              <div class="col-md-4">
                <label class="form-label fw-bold small text-dark">Pincode <span class="text-danger">*</span></label>
                <input type="text" name="pincode" id="custPincode" class="form-control cust-form-input" value="<?= html_escape($order->shipping_pincode) ?>" required>
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
              <?= count($items) ?> items
            </span>
          </div>

          <div class="card-body p-3 p-md-4">
            <!-- Autocomplete Search Bar for Products -->
            <div class="mb-4">
              <label class="form-label fw-bold small text-secondary text-uppercase mb-1" style="letter-spacing: 0.5px;">
                <i class="bi bi-search me-1 text-pink" style="color: var(--srl-pink);"></i>Search & Add More Products
              </label>
              <div class="srl-autocomplete-wrapper">
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-barcode"></i></span>
                  <input type="text" id="productSearchInput" class="form-control border-start-0" placeholder="Type product name, SKU, or model to search & add..." autocomplete="off">
                  <button type="button" class="btn btn-outline-secondary" id="btnClearProductSearch" onclick="clearProductSearch()" style="display: none;">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </div>
                <!-- Dropdown Suggestions Container -->
                <div id="productSuggestions" class="srl-autocomplete-dropdown"></div>
              </div>
            </div>

            <!-- Line Items Table -->
            <div class="table-responsive">
              <table class="table srl-pos-table align-middle mb-0">
                <thead>
                  <tr>
                    <th>Product Details</th>
                    <th class="text-center" style="width: 140px;">Quantity</th>
                    <th class="text-end" style="width: 130px;">Unit Price (₹)</th>
                    <th class="text-end" style="width: 130px;">Line Total (₹)</th>
                    <th class="text-center" style="width: 50px;"></th>
                  </tr>
                </thead>
                <tbody id="orderItemsTableBody">
                  <!-- Rendered dynamically by JavaScript -->
                </tbody>
              </table>
            </div>

            <!-- Empty Items Placeholder -->
            <div id="noItemsPlaceholder" class="text-center py-5 text-muted" style="display: none;">
              <i class="bi bi-cart-x fs-1 text-secondary opacity-50 mb-2"></i>
              <p class="mb-0 fw-semibold">No items in this order yet.</p>
              <small>Use the search box above to add products.</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Order Settings & Pricing Summary -->
      <div class="col-lg-5 col-xl-4">

        <!-- ============================================================
             CARD 3: PAYMENT & STATUS SETTINGS
             ============================================================ -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
          <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-sliders me-2 text-pink" style="color: var(--srl-pink);"></i>Order & Payment Settings</h5>
          </div>
          <div class="card-body p-3 p-md-4">
            <!-- Payment Method -->
            <div class="mb-3">
              <label class="form-label fw-bold small text-dark">Payment Method <span class="text-danger">*</span></label>
              <select name="payment_method" class="form-select srl-filter-select" required>
                <?php foreach ($payment_methods as $pm): ?>
                  <option value="<?= $pm ?>" <?= ($order->payment_method === $pm) ? 'selected' : '' ?>><?= $pm ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Payment Status -->
            <div class="mb-3">
              <label class="form-label fw-bold small text-dark">Payment Status <span class="text-danger">*</span></label>
              <select name="payment_status" class="form-select srl-filter-select" required>
                <option value="Paid" <?= ($order->payment_status === 'Paid') ? 'selected' : '' ?>>Paid (Customer Paid In Full)</option>
                <option value="Pending" <?= ($order->payment_status === 'Pending') ? 'selected' : '' ?>>Pending (Payment Pending)</option>
                <option value="Partial" <?= ($order->payment_status === 'Partial') ? 'selected' : '' ?>>Partial</option>
              </select>
            </div>

            <!-- Order Status -->
            <div class="mb-3">
              <label class="form-label fw-bold small text-dark">Fulfillment Status <span class="text-danger">*</span></label>
              <select name="order_status" class="form-select srl-filter-select" required>
                <?php foreach ($order_statuses as $st): ?>
                  <option value="<?= $st ?>" <?= ($order->order_status === $st) ? 'selected' : '' ?>><?= $st ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Admin Notes -->
            <div class="mb-2">
              <label class="form-label fw-bold small text-dark">Order Notes / Remarks <span class="text-muted fw-normal">(Optional)</span></label>
              <textarea name="notes" class="form-control form-control-sm" rows="3" placeholder="Counter sale remarks or invoice notes..."><?= html_escape($order->notes) ?></textarea>
            </div>
          </div>
        </div>

        <!-- ============================================================
             CARD 4: FINANCIAL SUMMARY & SUBMIT
             ============================================================ -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
          <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-receipt-cutoff me-2 text-pink" style="color: var(--srl-pink);"></i>Financial Summary</h5>
          </div>
          <div class="card-body p-3 p-md-4">
            <div class="d-flex justify-content-between mb-2 small">
              <span class="text-muted">Items Subtotal:</span>
              <span class="fw-bold text-dark" id="summarySubtotal">₹0.00</span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-2 small">
              <span class="text-muted">Delivery / Shipping:</span>
              <div class="input-group input-group-sm" style="width: 110px;">
                <span class="input-group-text">₹</span>
                <input type="number" name="shipping_fee" id="inputShippingFee" class="form-control text-end" min="0" step="1" value="<?= (float)$order->shipping_fee ?>" oninput="recalculateTotals()">
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 small">
              <span class="text-muted">Discount:</span>
              <div class="input-group input-group-sm" style="width: 110px;">
                <span class="input-group-text">₹</span>
                <input type="number" name="discount_amount" id="inputDiscount" class="form-control text-end" min="0" step="1" value="0.00" oninput="recalculateTotals()">
              </div>
            </div>

            <hr class="my-3" style="border-color: #e2e8f0;">

            <div class="d-flex justify-content-between align-items-center mb-4">
              <span class="fw-extrabold text-dark fs-5">Grand Total:</span>
              <span class="fw-extrabold fs-4" style="color: var(--srl-pink);" id="summaryGrandTotal">₹<?= number_format($order->total_amount, 2) ?></span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-srl-primary w-100 rounded-pill py-3 fw-bold fs-6 shadow-sm" id="btnSubmitOrder">
              <i class="bi bi-check2-circle me-2"></i>Update Offline Order
            </button>
          </div>
        </div>
      </div>
    </div>
  <?= form_close() ?>
</div>

<script>
// State: orderItems keyed by product_id
let orderItems = {};

// Initialize existing line items from PHP
<?php if (!empty($items)): ?>
  <?php foreach ($items as $it): ?>
    <?php
      $img_url = (!empty($it->product_image) && file_exists('./uploads/products/' . $it->product_image))
        ? base_url('uploads/products/' . $it->product_image)
        : '';
    ?>
    orderItems[<?= (int)$it->product_id ?>] = {
      id: <?= (int)$it->product_id ?>,
      name: <?= json_encode($it->product_name) ?>,
      sku: <?= json_encode($it->sku ?: 'SKU-' . $it->product_id) ?>,
      price: <?= (float)$it->unit_price ?>,
      stock: 999,
      image_url: <?= json_encode($img_url) ?>,
      qty: <?= (int)$it->quantity ?>
    };
  <?php endforeach; ?>
<?php endif; ?>

document.addEventListener('DOMContentLoaded', function () {
  // Render existing items immediately
  renderOrderItemsTable();
  recalculateTotals();

  // -------------------------------------------------------------
  // 1. Customer Autocomplete Search
  // -------------------------------------------------------------
  const custSearchInput = document.getElementById('customerSearchInput');
  const custDropdown    = document.getElementById('customerSuggestions');
  const btnClearCust    = document.getElementById('btnClearCustomerSearch');
  let custTimeout       = null;

  custSearchInput.addEventListener('input', function () {
    const val = this.value.trim();
    btnClearCust.style.display = val.length > 0 ? 'block' : 'none';

    clearTimeout(custTimeout);
    if (val.length < 1) {
      custDropdown.style.display = 'none';
      return;
    }

    custTimeout = setTimeout(() => {
      fetch('<?= base_url('admin/offline_orders/search_customers') ?>?term=' + encodeURIComponent(val), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(res => res.json())
        .then(data => {
          if (data && data.length > 0) {
            let html = '';
            data.forEach(c => {
              html += `
                <div class="srl-autocomplete-item" onclick="selectCustomer(${escapeAttr(JSON.stringify(c))})">
                  <div class="rounded-circle d-flex align-items-center justify-content-center bg-light text-pink fw-bold" style="width: 36px; height: 36px; flex-shrink: 0; color: var(--srl-pink);">
                    ${c.name ? c.name.charAt(0).toUpperCase() : 'U'}
                  </div>
                  <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-bold text-dark item-title text-truncate">${escapeHtml(c.name)}</div>
                    <div class="text-muted small text-truncate">
                      <i class="bi bi-telephone me-1"></i>${escapeHtml(c.phone || '—')} 
                      ${c.city ? `• <i class="bi bi-geo-alt me-1"></i>${escapeHtml(c.city)}` : ''}
                    </div>
                  </div>
                </div>
              `;
            });
            custDropdown.innerHTML = html;
            custDropdown.style.display = 'block';
          } else {
            custDropdown.innerHTML = `
              <div class="p-3 text-center text-muted small">
                <i class="bi bi-search me-1"></i>No customer found matching "<strong>${escapeHtml(val)}</strong>".
              </div>
            `;
            custDropdown.style.display = 'block';
          }
        })
        .catch(err => console.error('Customer search error:', err));
    }, 250);
  });

  // Hide customer dropdown on click outside
  document.addEventListener('click', function (e) {
    if (!custSearchInput.contains(e.target) && !custDropdown.contains(e.target)) {
      custDropdown.style.display = 'none';
    }
  });

  // -------------------------------------------------------------
  // 2. Product Autocomplete Search
  // -------------------------------------------------------------
  const prodSearchInput = document.getElementById('productSearchInput');
  const prodDropdown    = document.getElementById('productSuggestions');
  const btnClearProd    = document.getElementById('btnClearProductSearch');
  let prodTimeout       = null;

  prodSearchInput.addEventListener('input', function () {
    const val = this.value.trim();
    btnClearProd.style.display = val.length > 0 ? 'block' : 'none';

    clearTimeout(prodTimeout);
    if (val.length < 1) {
      prodDropdown.style.display = 'none';
      return;
    }

    prodTimeout = setTimeout(() => {
      fetch('<?= base_url('admin/offline_orders/search_products') ?>?term=' + encodeURIComponent(val), {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(res => res.json())
        .then(data => {
          if (data && data.length > 0) {
            let html = '';
            data.forEach(p => {
              const imgTag = p.image_url 
                ? `<img src="${p.image_url}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 6px;">`
                : `<div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 38px; height: 38px;"><i class="bi bi-box-seam"></i></div>`;

              html += `
                <div class="srl-autocomplete-item" onclick="addProductToOrder(${escapeAttr(JSON.stringify(p))})">
                  <div class="flex-shrink-0">${imgTag}</div>
                  <div class="flex-grow-1 overflow-hidden">
                    <div class="fw-bold text-dark item-title text-truncate">${escapeHtml(p.name)}</div>
                    <div class="text-muted small text-truncate">
                      <span class="text-secondary">${escapeHtml(p.sku)}</span> • Stock: <strong>${p.stock}</strong>
                    </div>
                  </div>
                  <div class="text-end flex-shrink-0">
                    <div class="fw-bold fs-6" style="color: var(--srl-pink);">₹${parseFloat(p.effective_price).toFixed(2)}</div>
                    <button type="button" class="btn btn-sm btn-outline-pink rounded-pill py-0 px-2 mt-1" style="font-size: 0.72rem;">
                      <i class="bi bi-plus-lg me-1"></i>Add
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

  // -------------------------------------------------------------
  // 3. Form Submit Handler (AJAX update)
  // -------------------------------------------------------------
  document.getElementById('offlineOrderForm').addEventListener('submit', function (e) {
    e.preventDefault();

    if (Object.keys(orderItems).length === 0) {
      Swal.fire({
        title: 'Empty Order',
        text: 'Please keep at least one product in the order.',
        icon: 'warning',
        customClass: { popup: 'srl-swal-popup' }
      });
      return;
    }

    const btn = document.getElementById('btnSubmitOrder');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating Order...';

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
            title: 'Order Updated!',
            html: `
              <div class="mb-3 text-secondary" style="color: #cbd5e1 !important; font-size: 0.95rem;">
                Offline Order has been updated successfully.
              </div>
              <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 mb-1" style="background: rgba(255, 42, 133, 0.08); border: 1px solid rgba(255, 42, 133, 0.25);">
                <span style="color: #94a3b8; font-size: 0.85rem;">Order No:</span>
                <span class="fw-bold" style="color: #ff5b9d; font-family: monospace; font-size: 1rem;">#${data.order_number}</span>
              </div>
            `,
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-printer-fill me-2"></i>Print Invoice',
            cancelButtonText: '<i class="bi bi-arrow-left me-2"></i>Back to List',
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
            title: 'Unable to Update Order',
            text: (data && data.message) ? data.message : 'Please check required fields.',
            icon: 'error',
            customClass: { popup: 'srl-swal-popup' }
          });
          btn.disabled = false;
          btn.innerHTML = '<i class="bi bi-check2-circle me-2"></i>Update Offline Order';
        }
      })
      .catch(err => {
        console.error('Submission error:', err);
        Swal.fire({
          title: 'Error',
          text: 'An error occurred while updating the order. Please try again.',
          icon: 'error',
          customClass: { popup: 'srl-swal-popup' }
        });
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check2-circle me-2"></i>Update Offline Order';
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

  document.getElementById('linkedCustomerText').textContent = `Linked: ${c.name} (#${c.id})`;
  clearCustomerSearch();
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

function setItemQty(prodId, value) {
  if (!orderItems[prodId]) return;
  const qty = parseInt(value) || 1;
  orderItems[prodId].qty = Math.max(1, qty);
  renderOrderItemsTable();
  recalculateTotals();
}

function setItemPrice(prodId, value) {
  if (!orderItems[prodId]) return;
  const price = parseFloat(value) || 0.00;
  orderItems[prodId].price = Math.max(0, price);
  renderOrderItemsTable();
  recalculateTotals();
}

function removeItem(prodId) {
  delete orderItems[prodId];
  renderOrderItemsTable();
  recalculateTotals();
}

// Render Table
function renderOrderItemsTable() {
  const tbody = document.getElementById('orderItemsTableBody');
  const placeholder = document.getElementById('noItemsPlaceholder');
  const badge = document.getElementById('itemsCountBadge');
  const keys = Object.keys(orderItems);

  badge.textContent = `${keys.length} item${keys.length === 1 ? '' : 's'}`;

  if (keys.length === 0) {
    tbody.innerHTML = '';
    placeholder.style.display = 'block';
    return;
  }

  placeholder.style.display = 'none';
  let html = '';

  keys.forEach(pId => {
    const item = orderItems[pId];
    const lineTotal = (item.qty * item.price).toFixed(2);
    const imgHtml = item.image_url 
      ? `<img src="${item.image_url}" style="width: 44px; height: 44px; object-fit: cover; border-radius: 8px;">`
      : `<div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 44px; height: 44px;"><i class="bi bi-box-seam fs-5"></i></div>`;

    html += `
      <tr>
        <td>
          <div class="d-flex align-items-center gap-3">
            ${imgHtml}
            <div>
              <div class="fw-bold text-dark">${escapeHtml(item.name)}</div>
              <div class="text-muted small">${escapeHtml(item.sku)}</div>
              <input type="hidden" name="item_product_id[]" value="${item.id}">
            </div>
          </div>
        </td>
        <td class="text-center">
          <div class="input-group input-group-sm justify-content-center" style="width: 120px; margin: 0 auto;">
            <button type="button" class="btn btn-outline-secondary" onclick="updateItemQty(${item.id}, -1)">
              <i class="bi bi-dash"></i>
            </button>
            <input type="number" name="item_quantity[]" class="form-control pos-qty-input text-center" min="1" value="${item.qty}" onchange="setItemQty(${item.id}, this.value)">
            <button type="button" class="btn btn-outline-secondary" onclick="updateItemQty(${item.id}, 1)">
              <i class="bi bi-plus"></i>
            </button>
          </div>
        </td>
        <td class="text-end">
          <div class="input-group input-group-sm justify-content-end" style="width: 120px; margin-left: auto;">
            <span class="input-group-text">₹</span>
            <input type="number" name="item_unit_price[]" class="form-control pos-price-input text-end" min="0" step="0.01" value="${parseFloat(item.price).toFixed(2)}" onchange="setItemPrice(${item.id}, this.value)">
          </div>
        </td>
        <td class="text-end fw-bold text-dark fs-6">
          ₹${lineTotal}
        </td>
        <td class="text-center">
          <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle" onclick="removeItem(${item.id})" title="Remove">
            <i class="bi bi-trash3"></i>
          </button>
        </td>
      </tr>
    `;
  });

  tbody.innerHTML = html;
}

// Recalculate Totals
function recalculateTotals() {
  let subtotal = 0.00;
  Object.values(orderItems).forEach(it => {
    subtotal += (it.qty * it.price);
  });

  const shippingFee = parseFloat(document.getElementById('inputShippingFee').value) || 0.00;
  const discount    = parseFloat(document.getElementById('inputDiscount').value) || 0.00;
  const grandTotal  = Math.max(0, (subtotal + shippingFee) - discount);

  document.getElementById('summarySubtotal').textContent   = '₹' + subtotal.toFixed(2);
  document.getElementById('summaryGrandTotal').textContent = '₹' + grandTotal.toFixed(2);
}

function escapeHtml(str) {
  if (!str) return '';
  return String(str).replace(/[&<>"']/g, function (m) {
    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
  });
}

function escapeAttr(str) {
  if (!str) return '';
  return String(str).replace(/'/g, '&#39;').replace(/"/g, '&quot;');
}
</script>
