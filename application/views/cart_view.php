<div class="container py-4">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Home</a></li>
      <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Shopping Cart</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
      <h3 class="fw-extrabold text-dark mb-1">
        <i class="bi bi-cart3 me-2" style="color: var(--srl-pink);"></i>Shopping Cart
      </h3>
      <p class="text-muted mb-0">Review your selected pixel LED items, adjust quantities, or proceed to checkout.</p>
    </div>
    <?php if (!empty($cart_items)): ?>
      <a href="<?= base_url('cart/clear') ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 btn-clear-cart">
        <i class="bi bi-trash me-1"></i>Clear Cart
      </a>
    <?php endif; ?>
  </div>

  <?php if (!empty($cart_items)): ?>
    <div class="row g-4" id="cartContentRow">
      <!-- Cart Items Column -->
      <div class="col-lg-8">
        <!-- Desktop / Tablet Table View (>= 768px) -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block" style="border: 1px solid #e2e8f0 !important;">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="cartTable">
              <thead class="table-light text-uppercase small text-secondary">
                <tr>
                  <th style="width: 80px;">Item</th>
                  <th>Product Details</th>
                  <th style="width: 110px;">Price</th>
                  <th style="width: 140px;">Quantity</th>
                  <th style="width: 110px;">Total</th>
                  <th style="width: 60px;" class="text-end pe-3">Remove</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($cart_items as $pid => $item): ?>
                  <tr id="cartRow-<?= $pid ?>">
                    <td>
                      <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center border shadow-sm" style="width: 60px; height: 60px; background: #0d1017;">
                        <?php if (!empty($item['image']) && file_exists('./uploads/products/' . $item['image'])): ?>
                          <img src="<?= base_url('uploads/products/' . $item['image']) ?>" alt="<?= html_escape($item['name']) ?>" class="w-100 h-100 object-fit-cover">
                        <?php else: ?>
                          <i class="bi bi-image text-muted fs-4"></i>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td>
                      <a href="<?= base_url('product/' . $item['id']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                        <?= html_escape($item['name']) ?>
                      </a>
                      <?php if (!empty($item['sku'])): ?>
                        <small class="badge bg-light text-secondary border">SKU: <?= html_escape($item['sku']) ?></small>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="fw-semibold text-dark">₹<?= number_format($item['price'], 2) ?></span>
                    </td>
                    <td>
                      <div class="input-group input-group-sm" style="width: 115px;">
                        <button class="btn btn-outline-secondary btn-cart-minus" type="button" data-id="<?= $pid ?>">-</button>
                        <input type="text" class="form-control text-center fw-bold cart-qty-input" id="cartQty-<?= $pid ?>" value="<?= $item['quantity'] ?>" readonly>
                        <button class="btn btn-outline-secondary btn-cart-plus" type="button" data-id="<?= $pid ?>" data-max="<?= $item['stock'] ?>">+</button>
                      </div>
                      <small class="text-muted" style="font-size: 0.72rem;"><?= $item['stock'] ?> available</small>
                    </td>
                    <td>
                      <span class="fw-bold text-dark" id="itemTotal-<?= $pid ?>" style="color: var(--srl-pink) !important;">
                        ₹<?= number_format($item['line_total'], 2) ?>
                      </span>
                    </td>
                    <td class="text-end pe-3">
                      <a href="<?= base_url('cart/remove/' . $pid) ?>" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1 btn-remove-item" data-name="<?= html_escape($item['name']) ?>" title="Remove item">
                        <i class="bi bi-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Mobile Card-Based List View (< 768px, NO HORIZONTAL SCROLL) -->
        <div class="d-md-none" id="mobileCartList">
          <?php foreach ($cart_items as $pid => $item): ?>
            <div class="srl-mobile-cart-card p-3 mb-3" id="mobileCartRow-<?= $pid ?>">
              <div class="d-flex gap-3 align-items-start">
                <!-- Thumbnail -->
                <div class="srl-mobile-cart-img d-flex align-items-center justify-content-center overflow-hidden border">
                  <?php if (!empty($item['image']) && file_exists('./uploads/products/' . $item['image'])): ?>
                    <img src="<?= base_url('uploads/products/' . $item['image']) ?>" alt="<?= html_escape($item['name']) ?>" class="w-100 h-100 object-fit-cover">
                  <?php else: ?>
                    <i class="bi bi-image text-muted fs-4"></i>
                  <?php endif; ?>
                </div>

                <!-- Product Details -->
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex justify-content-between align-items-start gap-1">
                    <a href="<?= base_url('product/' . $item['id']) ?>" class="fw-bold text-dark text-decoration-none small text-truncate-2 d-block" style="line-height: 1.25;">
                      <?= html_escape($item['name']) ?>
                    </a>
                    <a href="<?= base_url('cart/remove/' . $pid) ?>" class="text-danger btn-remove-item ms-1 p-1" data-name="<?= html_escape($item['name']) ?>" title="Remove">
                      <i class="bi bi-trash fs-6"></i>
                    </a>
                  </div>

                  <?php if (!empty($item['sku'])): ?>
                    <span class="badge bg-light text-secondary border mt-1" style="font-size: 0.65rem;">SKU: <?= html_escape($item['sku']) ?></span>
                  <?php endif; ?>

                  <div class="text-muted small mt-1">
                    Unit: <span class="fw-semibold text-dark">₹<?= number_format($item['price'], 2) ?></span>
                  </div>

                  <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top flex-wrap gap-2">
                    <!-- Mobile Stepper -->
                    <div>
                      <div class="input-group input-group-sm" style="width: 105px;">
                        <button class="btn btn-outline-secondary btn-cart-minus py-0 px-2" type="button" data-id="<?= $pid ?>">-</button>
                        <input type="text" class="form-control text-center fw-bold cart-qty-input py-0 px-1" id="mobileCartQty-<?= $pid ?>" value="<?= $item['quantity'] ?>" readonly style="font-size: 0.85rem;">
                        <button class="btn btn-outline-secondary btn-cart-plus py-0 px-2" type="button" data-id="<?= $pid ?>" data-max="<?= $item['stock'] ?>">+</button>
                      </div>
                      <small class="text-muted d-block" style="font-size: 0.65rem;"><?= $item['stock'] ?> in stock</small>
                    </div>

                    <!-- Mobile Subtotal -->
                    <div class="text-end">
                      <span class="text-muted d-block" style="font-size: 0.65rem;">Item Total</span>
                      <span class="fw-bold" style="color: var(--srl-pink); font-size: 1.05rem;" id="mobileItemTotal-<?= $pid ?>">
                        ₹<?= number_format($item['line_total'], 2) ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
          <a href="<?= base_url('products') ?>" class="btn btn-outline-dark rounded-pill px-4 btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Continue Shopping
          </a>
        </div>
      </div>

      <!-- Order Summary Column -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <h5 class="fw-bold text-dark mb-3">Order Summary</h5>

          <div class="d-flex justify-content-between align-items-center mb-2 text-muted">
            <span>Items Subtotal</span>
            <span class="fw-semibold text-dark" id="cartSummarySubtotal">₹<?= number_format($subtotal, 2) ?></span>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Delivery Charges</span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">FREE</span>
          </div>

          <hr class="my-3" style="opacity: 0.1;">

          <!-- Shipping Address Selection (Auto-selects default) -->
          <div class="mb-3 text-start">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-bold text-dark small"><i class="bi bi-geo-alt-fill me-1" style="color: var(--srl-pink);"></i>Deliver To:</span>
              <a href="<?= base_url('dashboard?tab=addresses') ?>" class="text-decoration-none small fw-semibold" style="color: var(--srl-pink);">
                + Add / Manage
              </a>
            </div>

            <?php if (!empty($addresses)): ?>
              <select name="selected_address_id" id="checkoutAddressSelect" class="form-select form-select-sm rounded-3 mb-2" onchange="updateSelectedAddressPreview(this)" required>
                <?php foreach ($addresses as $addr): ?>
                  <option value="<?= $addr->id ?>" <?= ($default_address && $default_address->id == $addr->id) ? 'selected' : '' ?>
                    data-name="<?= html_escape($addr->full_name) ?>"
                    data-phone="<?= html_escape($addr->mobile) ?>"
                    data-address="<?= html_escape($addr->address_line1 . ', ' . $addr->city . ' - ' . $addr->pincode) ?>">
                    <?= html_escape($addr->full_name) ?> (<?= html_escape($addr->city) ?>) <?= $addr->is_default ? '★ Default' : '' ?>
                  </option>
                <?php endforeach; ?>
              </select>

              <?php if ($default_address): ?>
                <div id="addressPreviewBox" class="p-2 rounded-3 bg-light border small text-muted">
                  <div class="fw-semibold text-dark" id="previewName"><?= html_escape($default_address->full_name) ?></div>
                  <div id="previewAddress"><?= html_escape($default_address->address_line1) ?>, <?= html_escape($default_address->city) ?> - <?= html_escape($default_address->pincode) ?></div>
                  <div id="previewPhone" class="text-secondary"><i class="bi bi-telephone me-1"></i><?= html_escape($default_address->mobile) ?></div>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <div class="alert alert-warning p-2 rounded-3 small mb-2 d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>
                <div>
                  No address saved yet.<br>
                  <a href="<?= base_url('dashboard?tab=addresses') ?>" class="fw-bold text-dark text-decoration-underline">Add shipping address</a> to complete checkout.
                </div>
              </div>
            <?php endif; ?>
          </div>

          <div class="d-flex justify-content-between align-items-baseline mb-3">
            <span class="fw-bold text-dark fs-5">Grand Total</span>
            <span class="display-6 fw-extrabold" style="color: var(--srl-pink); font-size: 1.8rem;" id="cartSummaryTotal">
              ₹<?= number_format($total, 2) ?>
            </span>
          </div>

          <form action="<?= base_url('cart/checkout') ?>" method="POST" id="checkoutForm">
            <input type="hidden" name="address_id" id="hiddenAddressId" value="<?= $default_address ? $default_address->id : '' ?>">
            <input type="hidden" name="payment_method" value="Cash on Delivery">

            <button type="submit" class="btn-srl-primary w-100 py-3 fs-6 justify-content-center mb-3" <?= empty($addresses) ? 'disabled' : '' ?>>
              <i class="bi bi-shield-check me-2"></i>Place Order (Pay on Delivery)
            </button>
          </form>

          <div class="rounded-3 p-3 bg-light text-muted small">
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-truck text-danger fs-5" style="color: var(--srl-pink) !important;"></i>
              <span>Free Delivery On Orders</span>
            </div>
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-cash-stack text-success fs-5"></i>
              <span>Cash on Delivery (Pay on Delivery) Available</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-arrow-repeat text-primary fs-5"></i>
              <span>Easy 7-Day Replacement Guarantee</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Empty Cart Card -->
    <div class="card border-0 shadow-sm rounded-4 p-5 text-center my-4" style="border: 1px solid #e2e8f0 !important;">
      <div class="py-5">
        <div class="rounded-circle p-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; background: rgba(255, 42, 133, 0.1); color: var(--srl-pink);">
          <i class="bi bi-cart-x fs-1"></i>
        </div>
        <h4 class="fw-bold text-dark mb-2">Your Shopping Cart is Empty</h4>
        <p class="text-muted mb-4" style="max-width: 480px; margin: 0 auto;">
          Looks like you haven't added any digital pixel LED strips, controllers, or neon lights to your cart yet.
        </p>
        <div class="d-flex justify-content-center gap-3">
          <a href="<?= base_url() ?>" class="btn btn-outline-dark rounded-pill px-4 py-2">
            Back to Home
          </a>
          <a href="<?= base_url('products') ?>" class="btn-srl-primary px-4 py-2">
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
    document.querySelectorAll('.cart-badge-count').forEach(badge => {
      badge.innerText = count;
    });
  }

  // Handle Quantity Increment / Decrement inside Cart Table
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
          const itemTotal = document.getElementById('itemTotal-' + productId);
          const subtotal = document.getElementById('cartSummarySubtotal');
          const total = document.getElementById('cartSummaryTotal');

          if (data.is_empty) {
            window.location.reload();
            return;
          }

          if (newQty <= 0) {
            const row = document.getElementById('cartRow-' + productId);
            if (row) row.remove();
            const mobileRow = document.getElementById('mobileCartRow-' + productId);
            if (mobileRow) mobileRow.remove();
          } else {
            if (qtyInput) qtyInput.value = newQty;
            const mobileQtyInput = document.getElementById('mobileCartQty-' + productId);
            if (mobileQtyInput) mobileQtyInput.value = newQty;

            if (itemTotal) itemTotal.innerText = '₹' + data.item_total;
            const mobileItemTotal = document.getElementById('mobileItemTotal-' + productId);
            if (mobileItemTotal) mobileItemTotal.innerText = '₹' + data.item_total;
          }

          if (subtotal) subtotal.innerText = '₹' + data.subtotal;
          if (total) total.innerText = '₹' + data.total;

          updateHeaderBadge(data.cart_count);
        }
      })
      .catch(err => console.error('Cart update error:', err));
  }

  document.querySelectorAll('.btn-cart-minus').forEach(btn => {
    btn.addEventListener('click', function () {
      const pid = this.getAttribute('data-id');
      const inputWrap = this.closest('.input-group');
      const input = inputWrap ? inputWrap.querySelector('.cart-qty-input') : (document.getElementById('cartQty-' + pid) || document.getElementById('mobileCartQty-' + pid));
      let val = parseInt(input ? input.value : 1) || 1;
      if (val > 1) {
        sendQtyUpdate(pid, val - 1);
      } else {
        // Confirm removal
        Swal.fire({
          title: 'Remove Item?',
          text: 'Do you want to remove this item from your cart?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, Remove',
          cancelButtonText: 'Cancel',
          customClass: {
            popup: 'srl-swal-popup',
            confirmButton: 'srl-swal-confirm',
            cancelButton: 'srl-swal-cancel'
          },
          buttonsStyling: false
        }).then(result => {
          if (result.isConfirmed) {
            sendQtyUpdate(pid, 0);
          }
        });
      }
    });
  });

  document.querySelectorAll('.btn-cart-plus').forEach(btn => {
    btn.addEventListener('click', function () {
      const pid = this.getAttribute('data-id');
      const max = parseInt(this.getAttribute('data-max')) || 999;
      const inputWrap = this.closest('.input-group');
      const input = inputWrap ? inputWrap.querySelector('.cart-qty-input') : (document.getElementById('cartQty-' + pid) || document.getElementById('mobileCartQty-' + pid));
      let val = parseInt(input ? input.value : 1) || 1;
      if (val < max) {
        sendQtyUpdate(pid, val + 1);
      } else {
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'warning',
          title: 'Maximum available stock (' + max + ') reached.',
          showConfirmButton: false,
          timer: 2000,
          customClass: { popup: 'srl-swal-toast' }
        });
      }
    });
  });

  // Remove Item SweetAlert Confirmation
  document.querySelectorAll('.btn-remove-item').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      const name = this.getAttribute('data-name');
      Swal.fire({
        title: 'Remove Item?',
        html: `Are you sure you want to remove <strong>"${name}"</strong> from your cart?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Remove',
        cancelButtonText: 'Cancel',
        customClass: {
          popup: 'srl-swal-popup',
          confirmButton: 'srl-swal-confirm',
          cancelButton: 'srl-swal-cancel'
        },
        buttonsStyling: false
      }).then(res => {
        if (res.isConfirmed) {
          window.location.href = href;
        }
      });
    });
  });

  // Clear Cart Confirmation
  const clearBtn = document.querySelector('.btn-clear-cart');
  if (clearBtn) {
    clearBtn.addEventListener('click', function (e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      Swal.fire({
        title: 'Clear Entire Cart?',
        text: 'All items will be removed from your shopping cart.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Clear Cart',
        cancelButtonText: 'Cancel',
        customClass: {
          popup: 'srl-swal-popup',
          confirmButton: 'srl-swal-confirm',
          cancelButton: 'srl-swal-cancel'
        },
        buttonsStyling: false
      }).then(res => {
        if (res.isConfirmed) {
          window.location.href = href;
        }
      });
    });
  }

  // Address Selection switcher
  window.updateSelectedAddressPreview = function(selectEl) {
    const opt = selectEl.options[selectEl.selectedIndex];
    if (opt) {
      const hiddenInput = document.getElementById('hiddenAddressId');
      if (hiddenInput) hiddenInput.value = opt.value;
      const name = opt.getAttribute('data-name');
      const addr = opt.getAttribute('data-address');
      const phone = opt.getAttribute('data-phone');
      const pName = document.getElementById('previewName');
      const pAddr = document.getElementById('previewAddress');
      const pPhone = document.getElementById('previewPhone');
      if (pName && name) pName.textContent = name;
      if (pAddr && addr) pAddr.textContent = addr;
      if (pPhone && phone) pPhone.innerHTML = '<i class="bi bi-telephone me-1"></i>' + phone;
    }
  };
});
</script>
