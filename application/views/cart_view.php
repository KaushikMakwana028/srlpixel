<style>
/* ============================================================
   CART VIEW STYLES
   ============================================================ */

.text-hover-pink {
  transition: color 0.2s ease;
}
.text-hover-pink:hover {
  color: var(--srl-pink) !important;
}

.srl-sticky-summary {
  position: sticky;
  top: 90px;
  z-index: 10;
}

/* Mobile Shopping Cart Card */
@media (max-width: 767.98px) {
  .srl-mobile-cart-card {
    border: 1px solid #e2e8f0 !important;
    border-radius: 14px;
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    max-width: 100%;
    box-sizing: border-box;
    overflow: hidden;
  }
  .srl-mobile-cart-img {
    width: 64px;
    height: 64px;
    border-radius: 10px;
    object-fit: cover;
    background: #0d1017;
    flex-shrink: 0;
  }
  .srl-mobile-cart-details {
    flex: 1 1 0;
    min-width: 0;
    overflow: hidden;
  }
}
</style>

<div class="container py-3 py-md-4">
  <!-- Clean Breadcrumb Navigation -->
  <nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb mb-1" style="font-size: 0.82rem;">
      <li class="breadcrumb-item">
        <a href="<?= base_url() ?>" class="text-decoration-none text-muted">
          <i class="bi bi-house-door me-1"></i>Home
        </a>
      </li>
      <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Shopping Cart</li>
    </ol>
  </nav>

  <!-- Clean Cart Header & Actions -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div class="d-flex align-items-center gap-2">
      <h3 class="fw-extrabold text-dark mb-0 d-flex align-items-center gap-2 fs-4">
        <i class="bi bi-cart3" style="color: var(--srl-pink);"></i>Shopping Cart
      </h3>
      <?php if (!empty($cart_items)): ?>
        <span class="badge rounded-pill bg-light text-dark border px-2 py-1 small fw-bold" id="cartItemBadgeCount" style="font-size: 0.78rem;">
          <?= $total_quantity ?> <?= ($total_quantity === 1) ? 'item' : 'items' ?>
        </span>
      <?php endif; ?>
    </div>

    <?php if (!empty($cart_items)): ?>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= base_url('products') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1" style="font-size: 0.82rem;">
          <i class="bi bi-arrow-left"></i>Continue Shopping
        </a>
        <button type="button" class="btn btn-sm btn-light border text-danger rounded-pill px-3 py-1 btn-clear-cart d-inline-flex align-items-center gap-1" id="btnClearCart" data-url="<?= base_url('cart/clear') ?>" style="font-size: 0.82rem;">
          <i class="bi bi-trash3"></i>Clear Cart
        </button>
      </div>
    <?php endif; ?>
  </div>

  <?php if (!empty($cart_items)): ?>
    <!-- Sleek Free Delivery Alert -->
    <div class="d-flex align-items-center justify-content-between p-2 p-sm-3 mb-4 rounded-3 border flex-wrap gap-2" style="background: #f8fafc; border-color: rgba(225, 29, 116, 0.22) !important;">
      <div class="d-flex align-items-center gap-2">
        <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 32px; height: 32px; background: var(--srl-pink-gradient); box-shadow: 0 2px 8px rgba(225, 29, 116, 0.35);">
          <i class="bi bi-truck" style="font-size: 0.9rem;"></i>
        </span>
        <span class="small fw-semibold text-dark">
          <strong style="color: var(--srl-pink);">Free Express Delivery:</strong> All orders dispatched within 24 hours with ₹0 shipping fee across India.
        </span>
      </div>
      <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1" style="font-size: 0.72rem;">
        <i class="bi bi-check-circle-fill me-1"></i>Free Shipping
      </span>
    </div>

    <div class="row g-4" id="cartContentRow">
      <!-- Left Column: Cart Items List -->
      <div class="col-lg-8">
        <!-- Desktop / Tablet Table View (>= 768px) -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="fw-bold text-dark">Item Details</span>
            <span class="text-muted small">Standard GST Included</span>
          </div>

          <div class="table-responsive">
            <table class="table align-middle mb-0" id="cartTable">
              <thead class="table-light text-uppercase small text-secondary" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                <tr>
                  <th style="width: 90px;" class="ps-4">Product</th>
                  <th>Description</th>
                  <th style="width: 120px;" class="text-center">Price</th>
                  <th style="width: 150px;" class="text-center">Quantity</th>
                  <th style="width: 130px;" class="text-end">Subtotal</th>
                  <th style="width: 60px;" class="text-center pe-4">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cart_items as $pid => $item): ?>
                  <tr id="cartRow-<?= $pid ?>" class="border-bottom">
                    <!-- Product Thumbnail -->
                    <td class="ps-4 py-3">
                      <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center border shadow-sm position-relative" style="width: 72px; height: 72px; background: #0d1017;">
                        <?php if (!empty($item['image']) && file_exists('./uploads/products/' . $item['image'])): ?>
                          <img src="<?= base_url('uploads/products/' . $item['image']) ?>" alt="<?= html_escape($item['name']) ?>" class="w-100 h-100 object-fit-cover">
                        <?php else: ?>
                          <i class="bi bi-image text-muted fs-4"></i>
                        <?php endif; ?>
                      </div>
                    </td>

                    <!-- Product Name & SKU -->
                    <td class="py-3">
                      <a href="<?= base_url('product/' . $item['id']) ?>" class="fw-bold text-dark text-decoration-none d-inline-block mb-1 text-hover-pink" style="line-height: 1.35; font-size: 0.96rem;">
                        <?= html_escape($item['name']) ?>
                      </a>
                      <div class="d-flex align-items-center gap-2 flex-wrap">
                        <?php if (!empty($item['sku'])): ?>
                          <span class="badge bg-light text-secondary border" style="font-size: 0.7rem;">
                            SKU: <?= html_escape($item['sku']) ?>
                          </span>
                        <?php endif; ?>
                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.7rem;">
                          <i class="bi bi-check2 me-1"></i>In Stock
                        </span>
                      </div>
                    </td>

                    <!-- Unit Price -->
                    <td class="text-center py-3">
                      <div class="fw-bold text-dark" style="font-size: 0.95rem;">
                        ₹<?= number_format($item['price'], 2) ?>
                      </div>
                      <small class="text-muted" style="font-size: 0.75rem;">per unit</small>
                    </td>

                    <!-- Quantity Stepper -->
                    <td class="text-center py-3">
                      <div class="d-inline-flex flex-column align-items-center">
                        <div class="input-group input-group-sm shadow-2xs rounded-3 overflow-hidden" style="width: 120px; border: 1px solid #cbd5e1;">
                          <button class="btn btn-light border-0 btn-cart-minus px-2 text-dark fw-bold" type="button" data-id="<?= $pid ?>" style="background: #f8fafc;" title="Decrease quantity">−</button>
                          <input type="text" class="form-control text-center fw-bold cart-qty-input border-0 bg-white" id="cartQty-<?= $pid ?>" value="<?= $item['quantity'] ?>" readonly style="font-size: 0.9rem;">
                          <button class="btn btn-light border-0 btn-cart-plus px-2 text-dark fw-bold" type="button" data-id="<?= $pid ?>" data-max="<?= $item['stock'] ?>" style="background: #f8fafc;" title="Increase quantity">+</button>
                        </div>
                        <small class="text-muted mt-1" style="font-size: 0.72rem;">
                          <?= $item['stock'] ?> units max
                        </small>
                      </div>
                    </td>

                    <!-- Line Total -->
                    <td class="text-end py-3">
                      <span class="fw-extrabold fs-6" id="itemTotal-<?= $pid ?>" style="color: var(--srl-pink);">
                        ₹<?= number_format($item['line_total'], 2) ?>
                      </span>
                    </td>

                    <!-- Delete Button -->
                    <td class="text-center pe-4 py-3">
                      <a href="<?= base_url('cart/remove/' . $pid) ?>" class="btn btn-sm btn-outline-danger rounded-circle p-0 d-inline-flex align-items-center justify-content-center btn-remove-item" data-name="<?= html_escape($item['name']) ?>" title="Remove item" style="width: 32px; height: 32px;">
                        <i class="bi bi-trash3" style="font-size: 0.85rem;"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Mobile Card-Based List View (< 768px) -->
        <div class="d-md-none" id="mobileCartList">
          <?php foreach ($cart_items as $pid => $item): ?>
            <div class="card srl-mobile-cart-card border-0 shadow-sm rounded-4 p-3 mb-3 position-relative" id="mobileCartRow-<?= $pid ?>">
              <div class="d-flex gap-2 gap-sm-3 align-items-start">
                <!-- Thumbnail -->
                <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center border shadow-2xs flex-shrink-0" style="width: 64px; height: 64px; background: #0d1017;">
                  <?php if (!empty($item['image']) && file_exists('./uploads/products/' . $item['image'])): ?>
                    <img src="<?= base_url('uploads/products/' . $item['image']) ?>" alt="<?= html_escape($item['name']) ?>" class="w-100 h-100 object-fit-cover">
                  <?php else: ?>
                    <i class="bi bi-image text-muted fs-4"></i>
                  <?php endif; ?>
                </div>

                <!-- Product Details -->
                <div class="srl-mobile-cart-details">
                  <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                    <a href="<?= base_url('product/' . $item['id']) ?>" class="fw-bold text-dark text-decoration-none text-truncate-2" style="line-height: 1.3; font-size: 0.85rem;">
                      <?= html_escape($item['name']) ?>
                    </a>
                    <a href="<?= base_url('cart/remove/' . $pid) ?>" class="text-danger p-1 btn-remove-item flex-shrink-0" data-name="<?= html_escape($item['name']) ?>" title="Remove" style="margin-top: -2px;">
                      <i class="bi bi-trash3 fs-6"></i>
                    </a>
                  </div>

                  <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                    <?php if (!empty($item['sku'])): ?>
                      <span class="badge bg-light text-secondary border" style="font-size: 0.65rem;">SKU: <?= html_escape($item['sku']) ?></span>
                    <?php endif; ?>
                    <span class="text-muted" style="font-size: 0.78rem;">₹<?= number_format($item['price'], 2) ?>/unit</span>
                  </div>

                  <div class="d-flex justify-content-between align-items-center pt-2 border-top flex-wrap gap-2">
                    <!-- Mobile Stepper -->
                    <div>
                      <div class="input-group input-group-sm rounded-3 overflow-hidden" style="width: 96px; border: 1px solid #cbd5e1;">
                        <button class="btn btn-light btn-cart-minus py-0 px-2 fw-bold" type="button" data-id="<?= $pid ?>" style="font-size: 0.85rem;">−</button>
                        <input type="text" class="form-control text-center fw-bold cart-qty-input py-0 px-1 border-0" id="mobileCartQty-<?= $pid ?>" value="<?= $item['quantity'] ?>" readonly style="font-size: 0.82rem;">
                        <button class="btn btn-light btn-cart-plus py-0 px-2 fw-bold" type="button" data-id="<?= $pid ?>" data-max="<?= $item['stock'] ?>" style="font-size: 0.85rem;">+</button>
                      </div>
                    </div>

                    <!-- Mobile Line Total -->
                    <div class="text-end">
                      <small class="text-muted d-block" style="font-size: 0.65rem; line-height: 1;">Subtotal</small>
                      <span class="fw-bold" style="color: var(--srl-pink); font-size: 0.98rem;" id="mobileItemTotal-<?= $pid ?>">
                        ₹<?= number_format($item['line_total'], 2) ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Bottom Action Strip -->
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
          <a href="<?= base_url('products') ?>" class="btn btn-outline-dark rounded-pill px-4 py-2">
            <i class="bi bi-arrow-left me-2"></i>Continue Shopping
          </a>
          <span class="text-muted small d-none d-sm-inline">
            <i class="bi bi-shield-lock-fill text-success me-1"></i>100% Encrypted & Safe Checkout
          </span>
        </div>
      </div>

      <!-- Right Column: Order Summary & Checkout Action -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 srl-sticky-summary" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
              <i class="bi bi-receipt text-primary"></i>Order Summary
            </h5>
            <span class="badge bg-light text-muted border">INR (₹)</span>
          </div>

          <!-- Items Subtotal -->
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted">Items Subtotal</span>
            <span class="fw-bold text-dark" id="cartSummarySubtotal">₹<?= number_format($subtotal, 2) ?></span>
          </div>

          <!-- Delivery Charge -->
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted">Delivery Charges</span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">FREE</span>
          </div>

          <!-- Taxes -->
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Estimated GST</span>
            <span class="text-muted small">Included in price</span>
          </div>

          <!-- Promo Code Input Group -->
          <div class="mb-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Promo / Coupon Code</label>
            <div class="input-group input-group-sm">
              <input type="text" class="form-control rounded-start-3" id="cartCouponInput" placeholder="Enter coupon code (e.g. SRLPIXEL)">
              <button class="btn btn-outline-dark rounded-end-3 px-3" type="button" id="btnApplyCoupon">Apply</button>
            </div>
            <div id="couponFeedback" class="small mt-1" style="display: none;"></div>
          </div>

          <hr class="my-3" style="opacity: 0.1;">

          <!-- Grand Total -->
          <div class="d-flex justify-content-between align-items-baseline mb-4">
            <div>
              <span class="fw-bold text-dark fs-5 d-block">Grand Total</span>
              <small class="text-muted">Total payable amount</small>
            </div>
            <div class="text-end">
              <span class="display-6 fw-extrabold" style="color: var(--srl-pink); font-size: 1.85rem;" id="cartSummaryTotal">
                ₹<?= number_format($total, 2) ?>
              </span>
            </div>
          </div>

          <!-- Primary Call to Action: Proceed to Dedicated Step-by-Step Checkout -->
          <a href="<?= base_url('checkout') ?>" class="btn-srl-primary w-100 py-3 fs-6 justify-content-center text-decoration-none shadow-sm mb-3 text-center d-flex align-items-center" id="btnProceedToCheckout">
            <i class="bi bi-shield-lock-fill me-2"></i>Proceed to Checkout
            <i class="bi bi-arrow-right ms-2"></i>
          </a>

          <p class="text-center text-muted small mb-3">
            <i class="bi bi-info-circle me-1"></i>You will select shipping address & payment method in the next steps.
          </p>

          <!-- Store Guarantees / Badges -->
          <div class="rounded-3 p-3 bg-light text-muted small border">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-truck text-danger fs-5" style="color: var(--srl-pink) !important;"></i>
              <span class="text-dark"><strong>Free Delivery</strong> on all orders across India</span>
            </div>
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-cash-stack text-success fs-5"></i>
              <span class="text-dark"><strong>Cash on Delivery</strong> available</span>
            </div>
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-credit-card-2-front text-primary fs-5"></i>
              <span class="text-dark"><strong>Razorpay Online Payment</strong> (UPI, Cards, NetBanking)</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-arrow-repeat text-warning fs-5"></i>
              <span class="text-dark"><strong>7-Day Replacement</strong> guarantee</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Empty Cart State -->
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
      <div class="py-5">
        <div class="rounded-circle p-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; background: rgba(255, 42, 133, 0.1); color: var(--srl-pink);">
          <i class="bi bi-cart-x fs-1"></i>
        </div>
        <h3 class="fw-extrabold text-dark mb-2">Your Shopping Cart is Empty</h3>
        <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto; line-height: 1.6;">
          Looks like you haven't added any digital pixel LED strips, smart controllers, power converters, or neon lights to your cart yet.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
          <a href="<?= base_url() ?>" class="btn btn-outline-dark rounded-pill px-4 py-2">
            <i class="bi bi-house me-1"></i>Back to Home
          </a>
          <a href="<?= base_url('products') ?>" class="btn-srl-primary px-4 py-2 rounded-pill">
            <i class="bi bi-bag-plus me-1"></i>Explore Products
          </a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  function updateHeaderBadge(count) {
    const num = parseInt(count) || 0;
    document.querySelectorAll('.cart-badge-count').forEach(badge => {
      badge.innerText = num;
      badge.style.setProperty('display', (num > 0) ? 'flex' : 'none', 'important');
    });
    const itemBadge = document.getElementById('cartItemBadgeCount');
    if (itemBadge) {
      itemBadge.innerText = num + (num === 1 ? ' item' : ' items');
    }
  }

  // Handle Quantity Increment / Decrement inside Cart Table via AJAX
  function sendQtyUpdate(productId, newQty) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', newQty);

    fetch('<?= base_url('cart/update') ?>', {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const qtyInput = document.getElementById('cartQty-' + productId);
          const mobileQtyInput = document.getElementById('mobileCartQty-' + productId);
          const itemTotal = document.getElementById('itemTotal-' + productId);
          const mobileItemTotal = document.getElementById('mobileItemTotal-' + productId);
          const subtotal = document.getElementById('cartSummarySubtotal');
          const total = document.getElementById('cartSummaryTotal');

          if (data.is_empty) {
            window.location.reload();
            return;
          }

          if (newQty <= 0) {
            const row = document.getElementById('cartRow-' + productId);
            const mRow = document.getElementById('mobileCartRow-' + productId);
            if (row) row.remove();
            if (mRow) mRow.remove();
          } else {
            if (qtyInput) qtyInput.value = newQty;
            if (mobileQtyInput) mobileQtyInput.value = newQty;
            if (itemTotal) itemTotal.innerText = '₹' + data.item_total;
            if (mobileItemTotal) mobileItemTotal.innerText = '₹' + data.item_total;
          }

          if (subtotal) subtotal.innerText = '₹' + data.subtotal;
          if (total) total.innerText = '₹' + data.total;

          updateHeaderBadge(data.cart_count);
        } else if (data.require_login) {
          window.location.href = data.login_url;
        } else {
          Swal.fire({
            title: 'Notice',
            text: data.message || 'Could not update quantity.',
            icon: 'warning',
            customClass: { popup: 'srl-swal-popup' }
          });
        }
      })
      .catch(err => {
        console.error('Cart update error:', err);
      });
  }

  // Clear Cart with SweetAlert2 Confirmation
  const btnClearCart = document.getElementById('btnClearCart');
  if (btnClearCart) {
    btnClearCart.addEventListener('click', function (e) {
      e.preventDefault();
      const clearUrl = this.getAttribute('data-url');
      Swal.fire({
        title: 'Clear Shopping Cart?',
        text: 'Are you sure you want to remove all items from your cart? This cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-trash3 me-1"></i> Yes, Clear Cart',
        cancelButtonText: 'Keep Items',
        customClass: {
          popup: 'srl-swal-popup',
          title: 'srl-swal-title',
          htmlContainer: 'srl-swal-html',
          confirmButton: 'btn btn-danger rounded-pill px-4 me-2',
          cancelButton: 'btn btn-secondary rounded-pill px-4'
        },
        buttonsStyling: false
      }).then(result => {
        if (result.isConfirmed) {
          window.location.href = clearUrl;
        }
      });
    });
  }

  // Remove individual item with SweetAlert2
  document.querySelectorAll('.btn-remove-item').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      const itemName = this.getAttribute('data-name') || 'this item';
      Swal.fire({
        title: 'Remove Item?',
        html: `Do you want to remove <strong>${itemName}</strong> from your cart?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Remove',
        cancelButtonText: 'Keep',
        customClass: {
          popup: 'srl-swal-popup',
          title: 'srl-swal-title',
          htmlContainer: 'srl-swal-html',
          confirmButton: 'btn btn-danger rounded-pill px-4 me-2',
          cancelButton: 'btn btn-secondary rounded-pill px-4'
        },
        buttonsStyling: false
      }).then(result => {
        if (result.isConfirmed) {
          window.location.href = href;
        }
      });
    });
  });

  // Bind Plus Button
  document.querySelectorAll('.btn-cart-plus').forEach(btn => {
    btn.addEventListener('click', function () {
      const pid = this.getAttribute('data-id');
      const max = parseInt(this.getAttribute('data-max'), 10) || 999;
      const input = document.getElementById('cartQty-' + pid) || document.getElementById('mobileCartQty-' + pid);
      if (input) {
        let current = parseInt(input.value, 10) || 1;
        if (current < max) {
          sendQtyUpdate(pid, current + 1);
        } else {
          Swal.fire({
            title: 'Stock Limit Reached',
            text: 'Maximum available stock reached for this product (' + max + ' units).',
            icon: 'info',
            confirmButtonText: 'Understood',
            customClass: { popup: 'srl-swal-popup' }
          });
        }
      }
    });
  });

  // Bind Minus Button
  document.querySelectorAll('.btn-cart-minus').forEach(btn => {
    btn.addEventListener('click', function () {
      const pid = this.getAttribute('data-id');
      const input = document.getElementById('cartQty-' + pid) || document.getElementById('mobileCartQty-' + pid);
      if (input) {
        let current = parseInt(input.value, 10) || 1;
        if (current > 1) {
          sendQtyUpdate(pid, current - 1);
        } else {
          Swal.fire({
            title: 'Remove Item?',
            text: 'Do you want to remove this item from your shopping cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Remove',
            cancelButtonText: 'Cancel',
            customClass: {
              popup: 'srl-swal-popup',
              title: 'srl-swal-title',
              htmlContainer: 'srl-swal-html',
              confirmButton: 'btn btn-danger rounded-pill px-4 me-2',
              cancelButton: 'btn btn-secondary rounded-pill px-4'
            },
            buttonsStyling: false
          }).then(result => {
            if (result.isConfirmed) {
              window.location.href = '<?= base_url('cart/remove/') ?>' + pid;
            }
          });
        }
      }
    });
  });

  // Coupon code simulation
  const btnApplyCoupon = document.getElementById('btnApplyCoupon');
  const couponInput = document.getElementById('cartCouponInput');
  const couponFeedback = document.getElementById('couponFeedback');
  if (btnApplyCoupon && couponInput && couponFeedback) {
    btnApplyCoupon.addEventListener('click', function () {
      const code = couponInput.value.trim().toUpperCase();
      if (!code) {
        couponFeedback.style.display = 'block';
        couponFeedback.className = 'small mt-1 text-danger';
        couponFeedback.innerText = 'Please enter a valid coupon code.';
        return;
      }
      if (code === 'SRLPIXEL' || code === 'WELCOME10') {
        couponFeedback.style.display = 'block';
        couponFeedback.className = 'small mt-1 text-success fw-semibold';
        couponFeedback.innerHTML = '<i class="bi bi-check-circle me-1"></i>Coupon code "' + code + '" applied! Free delivery & priority packing active.';
      } else {
        couponFeedback.style.display = 'block';
        couponFeedback.className = 'small mt-1 text-danger';
        couponFeedback.innerText = 'Invalid coupon code or expired.';
      }
    });
  }
});
</script>
