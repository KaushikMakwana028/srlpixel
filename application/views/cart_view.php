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
  <!-- Shipping Alert - Dynamic based on order value -->
<?php if ($is_free_shipping): ?>
<div class="d-flex align-items-center justify-content-between p-2 p-sm-3 mb-4 rounded-3 border flex-wrap gap-2" style="background: linear-gradient(135deg, #d4f4dd 0%, #e8f8ed 100%);">
    <div class="d-flex align-items-center gap-2">
        <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);">
            <i class="bi bi-check-circle-fill" style="font-size: 0.9rem;"></i>
        </span>
        <span class="small fw-semibold text-dark">
            <strong style="color: #059669;">Congratulations!</strong> You qualify for FREE Pan India delivery. Dispatch within 24 hours.
        </span>
    </div>
    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1" style="font-size: 0.72rem;">
        <i class="bi bi-truck me-1"></i>Free Shipping
    </span>
</div>
<?php else: ?>
<?php 
$remaining = 10000 - $subtotal;
$progress = ($subtotal / 10000) * 100;
?>
<div class="d-flex align-items-center justify-content-between p-2 p-sm-3 mb-4 rounded-3 border flex-wrap gap-2" style="background: linear-gradient(135deg, #fef3c7 0%, #fef9e7 100%);">
    <div class="d-flex align-items-center gap-2">
        <span class="rounded-circle d-inline-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 32px; height: 32px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 2px 8px rgba(245, 158, 11, 0.35);">
            <i class="bi bi-gift" style="font-size: 0.9rem;"></i>
        </span>
        <span class="small fw-semibold text-dark">
            Add <strong style="color: #d97706;">₹<?= number_format($remaining, 2) ?></strong> more to get <strong>FREE Pan India delivery!</strong>
        </span>
    </div>
    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2 py-1" style="font-size: 0.72rem;">
        <i class="bi bi-truck me-1"></i>₹<?= number_format($shipping, 2) ?>
    </span>
</div>
<?php endif; ?>

    <div class="row g-4" id="cartContentRow">
      <!-- Left Column: Cart Items List -->
      <div class="col-lg-8">
        <!-- Desktop / Tablet Table View (>= 768px) -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-md-block" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
         <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
    <span class="fw-bold text-dark">Item Details</span>
    <!-- GST text removed -->
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

          <!-- Coupon Discount (Visible when coupon is applied) -->
          <div class="d-flex justify-content-between align-items-center mb-2 text-success" id="cartDiscountRow" style="<?= (!empty($applied_coupon) && $coupon_discount > 0) ? '' : 'display: none !important;' ?>">
            <span class="d-flex align-items-center gap-1.5 fw-semibold">
              <i class="bi bi-tag-fill"></i> Coupon (<span id="cartDiscountCode"><?= !empty($applied_coupon) ? html_escape($applied_coupon['code']) : '' ?></span>)
            </span>
            <span class="fw-bold" id="cartSummaryDiscount">-₹<?= number_format($coupon_discount, 2) ?></span>
          </div>

          <!-- Delivery Charge -->
          <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted">Delivery Charges</span>
            <span id="cartSummaryShipping">
              <?php if ($is_free_shipping): ?>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">FREE</span>
              <?php else: ?>
                <span class="fw-bold text-dark">₹<?= number_format($shipping, 2) ?></span>
              <?php endif; ?>
            </span>
          </div>
          <?php if (!$is_free_shipping): ?>
          <!-- Free Shipping Progress Bar -->
          <div class="mb-3 p-2 rounded-3 bg-light border" id="shippingProgressBarContainer">
            <?php 
            $remaining = 10000 - $subtotal;
            $progress = min(100, ($subtotal / 10000) * 100);
            ?>
            <small class="text-muted d-block mb-1" id="shippingProgressText">
              <i class="bi bi-info-circle me-1"></i>Add ₹<?= number_format(max(0, $remaining), 2) ?> more for FREE shipping!
            </small>
            <div class="progress" style="height: 6px;">
              <div class="progress-bar bg-success" id="shippingProgressBar" role="progressbar" style="width: <?= $progress ?>%"></div>
            </div>
          </div>
          <?php endif; ?>

          <!-- Enhanced Promo / Coupon Code Section -->
          <div class="srl-coupon-box p-3 rounded-4 mb-3 border shadow-sm" style="background: linear-gradient(135deg, rgba(255, 42, 133, 0.05) 0%, rgba(18, 22, 33, 0.02) 100%); border-color: rgba(255, 42, 133, 0.22) !important;">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="small fw-bold text-dark d-flex align-items-center gap-2" style="letter-spacing: -0.1px;">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 24px; height: 24px; background: rgba(255, 42, 133, 0.14); color: var(--srl-pink);">
                  <i class="bi bi-ticket-perforated-fill" style="font-size: 0.82rem;"></i>
                </span>
                <span>Promo / Coupon Code</span>
              </span>
              <span class="badge rounded-pill text-uppercase px-2 py-1" style="background: rgba(255, 42, 133, 0.12); color: var(--srl-pink); font-size: 0.68rem; font-weight: 700; letter-spacing: 0.5px;">Offers</span>
            </div>
            
            <!-- Applied Coupon State Banner -->
            <div id="appliedCouponBox" class="p-2.5 rounded-3 mb-2" style="background: #ecfdf5; border: 1px solid #a7f3d0; <?= !empty($applied_coupon) ? '' : 'display: none;' ?>">
              <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                  <span class="d-inline-flex align-items-center justify-content-center rounded-circle text-success" style="width: 28px; height: 28px; background: #d1fae5;">
                    <i class="bi bi-check-lg fw-bold"></i>
                  </span>
                  <div>
                    <span class="fw-bold text-success d-block" style="font-size: 0.85rem;" id="appliedCouponCodeDisplay"><?= !empty($applied_coupon) ? html_escape($applied_coupon['code']) : '' ?></span>
                    <small class="text-muted" style="font-size: 0.72rem;" id="appliedCouponSavings">Discount applied: ₹<?= number_format($coupon_discount, 2) ?></small>
                  </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2.5 rounded-pill" id="btnRemoveCoupon" style="font-size: 0.75rem;">
                  <i class="bi bi-x-circle me-1"></i>Remove
                </button>
              </div>
            </div>

            <!-- Coupon Input Group -->
            <div id="couponInputContainer" style="<?= !empty($applied_coupon) ? 'display: none;' : '' ?>">
              <div class="input-group input-group-sm srl-coupon-input-group position-relative shadow-sm rounded-pill overflow-hidden border p-1" style="background: #ffffff; border-color: #e2e8f0 !important;">
                <span class="input-group-text bg-transparent border-0 ps-3 pe-1 text-muted">
                  <i class="bi bi-tag-fill" style="color: var(--srl-pink); font-size: 0.85rem;"></i>
                </span>
                <input type="text" class="form-control border-0 bg-transparent py-2 text-uppercase fw-semibold" id="cartCouponInput" placeholder="ENTER COUPON CODE" style="letter-spacing: 0.5px; font-size: 0.82rem; box-shadow: none;">
                <button class="btn btn-srl-primary rounded-pill px-3 py-1 fw-bold text-uppercase" type="button" id="btnApplyCoupon" style="font-size: 0.78rem; letter-spacing: 0.4px;">
                  Apply
                </button>
              </div>
              
              <!-- Quick Suggestion Badges -->
              <?php if (!empty($available_coupons)): ?>
                <div class="d-flex align-items-center gap-1.5 mt-2 flex-wrap">
                  <small class="text-muted" style="font-size: 0.72rem;">Available:</small>
                  <?php foreach ($available_coupons as $ac): ?>
                    <button type="button" class="btn btn-sm py-0 px-2 rounded-pill border-0 srl-quick-coupon-btn" data-code="<?= html_escape($ac->code) ?>" style="background: rgba(255, 42, 133, 0.1); color: var(--srl-pink); font-size: 0.72rem; font-weight: 700;">
                      <i class="bi bi-tag me-1"></i><?= html_escape($ac->code) ?>
                      <span class="text-muted fw-normal" style="font-size: 0.65rem;">(<?= $ac->discount_type === 'percent' ? $ac->discount_value.'%' : '₹'.number_format($ac->discount_value, 0) ?> OFF)</span>
                    </button>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <div class="d-flex align-items-center gap-1.5 mt-2 flex-wrap">
                  <small class="text-muted" style="font-size: 0.72rem;">Available:</small>
                  <button type="button" class="btn btn-sm py-0 px-2 rounded-pill border-0 srl-quick-coupon-btn" data-code="WELCOME10" style="background: rgba(16, 185, 129, 0.12); color: #059669; font-size: 0.72rem; font-weight: 700;">
                    <i class="bi bi-percent me-1"></i>WELCOME10
                  </button>
                  <button type="button" class="btn btn-sm py-0 px-2 rounded-pill border-0 srl-quick-coupon-btn" data-code="FLAT500" style="background: rgba(255, 42, 133, 0.1); color: var(--srl-pink); font-size: 0.72rem; font-weight: 700;">
                    <i class="bi bi-stars me-1"></i>FLAT500
                  </button>
                </div>
              <?php endif; ?>
            </div>
            
            <div id="couponFeedback" class="small mt-2" style="display: none;"></div>
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
    <span class="text-dark"><strong>Pan India Delivery</strong> (Free above ₹10,000)</span>
</div>
<div class="d-flex align-items-center gap-2 mb-2">
    <i class="bi bi-globe text-info fs-5"></i>
    <span class="text-dark"><strong>International Delivery</strong> available</span>
</div>
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-cash-stack text-success fs-5"></i>
              <span class="text-dark"><strong>Cash on Delivery</strong> available</span>
            </div>
            <div class="d-flex align-items-center gap-2 mb-2">
              <i class="bi bi-credit-card-2-front text-primary fs-5"></i>
              <span class="text-dark"><strong>Razorpay Online Payment</strong> (UPI, Cards, NetBanking)</span>
            </div>
            <!-- <div class="d-flex align-items-center gap-2">
              <i class="bi bi-arrow-repeat text-warning fs-5"></i>
              <span class="text-dark"><strong>7-Day Replacement</strong> guarantee</span>
            </div> -->
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

          const shippingElement = document.getElementById('cartSummaryShipping');
          if (shippingElement) {
            if (data.is_free_shipping) {
              shippingElement.innerHTML = '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">FREE</span>';
            } else {
              shippingElement.innerHTML = '<span class="fw-bold text-dark">₹' + data.shipping + '</span>';
            }
          }

          // Dynamic Shipping Progress Bar
          const numSubtotal = parseFloat(data.subtotal.replace(/,/g, '')) || 0;
          const progContainer = document.getElementById('shippingProgressBarContainer');
          const progText = document.getElementById('shippingProgressText');
          const progBar = document.getElementById('shippingProgressBar');
          if (progContainer) {
            if (data.is_free_shipping) {
              progContainer.style.display = 'none';
            } else {
              progContainer.style.display = 'block';
              const remaining = Math.max(0, 10000 - numSubtotal);
              const pct = Math.min(100, (numSubtotal / 10000) * 100);
              if (progText) progText.innerHTML = '<i class="bi bi-info-circle me-1"></i>Add ₹' + remaining.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' more for FREE shipping!';
              if (progBar) progBar.style.width = pct + '%';
            }
          }

          // Dynamic Coupon Discount Update on Quantity Change
          const discountRow = document.getElementById('cartDiscountRow');
          const summaryDiscount = document.getElementById('cartSummaryDiscount');
          const appliedCouponBox = document.getElementById('appliedCouponBox');
          const couponInputContainer = document.getElementById('couponInputContainer');
          const appliedCouponCodeDisplay = document.getElementById('appliedCouponCodeDisplay');
          const appliedCouponSavings = document.getElementById('appliedCouponSavings');
          const cartDiscountCode = document.getElementById('cartDiscountCode');

          if (data.has_coupon && parseFloat(data.coupon_discount) > 0) {
            if (discountRow) discountRow.style.setProperty('display', 'flex', 'important');
            if (summaryDiscount) summaryDiscount.innerText = '-₹' + data.coupon_discount;
            if (cartDiscountCode) cartDiscountCode.innerText = data.coupon_code;
            if (appliedCouponBox) appliedCouponBox.style.display = 'block';
            if (couponInputContainer) couponInputContainer.style.display = 'none';
            if (appliedCouponCodeDisplay) appliedCouponCodeDisplay.innerText = data.coupon_code;
            if (appliedCouponSavings) appliedCouponSavings.innerText = 'Discount applied: ₹' + data.coupon_discount;
          } else {
            if (discountRow) discountRow.style.setProperty('display', 'none', 'important');
            if (appliedCouponBox) appliedCouponBox.style.display = 'none';
            if (couponInputContainer) couponInputContainer.style.display = 'block';
          }

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

  // Real-time Coupon Code AJAX Engine
  const btnApplyCoupon = document.getElementById('btnApplyCoupon');
  const couponInput = document.getElementById('cartCouponInput');
  const couponFeedback = document.getElementById('couponFeedback');
  const appliedCouponBox = document.getElementById('appliedCouponBox');
  const couponInputContainer = document.getElementById('couponInputContainer');
  const btnRemoveCoupon = document.getElementById('btnRemoveCoupon');
  const discountRow = document.getElementById('cartDiscountRow');
  const summaryDiscount = document.getElementById('cartSummaryDiscount');
  const cartSummaryTotal = document.getElementById('cartSummaryTotal');
  const cartDiscountCode = document.getElementById('cartDiscountCode');
  const appliedCouponCodeDisplay = document.getElementById('appliedCouponCodeDisplay');
  const appliedCouponSavings = document.getElementById('appliedCouponSavings');

  // Quick suggestion click
  document.querySelectorAll('.srl-quick-coupon-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const code = this.getAttribute('data-code');
      if (couponInput) {
        couponInput.value = code;
        if (btnApplyCoupon) btnApplyCoupon.click();
      }
    });
  });

  // Apply Coupon AJAX
  if (btnApplyCoupon && couponInput) {
    btnApplyCoupon.addEventListener('click', function () {
      const code = couponInput.value.trim().toUpperCase();
      if (!code) {
        if (couponFeedback) {
          couponFeedback.style.display = 'block';
          couponFeedback.className = 'small mt-2 text-danger fw-semibold';
          couponFeedback.innerText = 'Please enter a coupon code.';
        }
        return;
      }

      btnApplyCoupon.disabled = true;
      btnApplyCoupon.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Applying...';

      const formData = new FormData();
      formData.append('coupon_code', code);

      fetch('<?= base_url('cart/apply_coupon') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => res.json())
      .then(data => {
        btnApplyCoupon.disabled = false;
        btnApplyCoupon.innerHTML = 'Apply';

        if (data.success) {
          if (couponFeedback) {
            couponFeedback.style.display = 'none';
          }
          if (appliedCouponBox) {
            appliedCouponBox.style.display = 'block';
          }
          if (couponInputContainer) {
            couponInputContainer.style.display = 'none';
          }
          if (appliedCouponCodeDisplay) {
            appliedCouponCodeDisplay.innerText = data.coupon_code;
          }
          if (appliedCouponSavings) {
            appliedCouponSavings.innerText = 'Discount applied: ₹' + data.discount_amount;
          }
          if (discountRow) {
            discountRow.style.setProperty('display', 'flex', 'important');
          }
          if (summaryDiscount) {
            summaryDiscount.innerText = '-₹' + data.discount_amount;
          }
          if (cartDiscountCode) {
            cartDiscountCode.innerText = data.coupon_code;
          }
          if (cartSummaryTotal) {
            cartSummaryTotal.innerText = '₹' + data.total;
          }

          Swal.fire({
            title: 'Coupon Applied!',
            text: data.message,
            icon: 'success',
            timer: 2500,
            showConfirmButton: false,
            customClass: { popup: 'srl-swal-popup' }
          });
        } else {
          if (couponFeedback) {
            couponFeedback.style.display = 'block';
            couponFeedback.className = 'small mt-2 text-danger fw-semibold';
            couponFeedback.innerText = data.message || 'Invalid coupon code or expired.';
          }
        }
      })
      .catch(err => {
        btnApplyCoupon.disabled = false;
        btnApplyCoupon.innerHTML = 'Apply';
        console.error('Coupon apply error:', err);
        if (couponFeedback) {
          couponFeedback.style.display = 'block';
          couponFeedback.className = 'small mt-2 text-danger';
          couponFeedback.innerText = 'Error applying coupon. Please try again.';
        }
      });
    });

    couponInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        btnApplyCoupon.click();
      }
    });
  }

  // Remove Coupon AJAX
  if (btnRemoveCoupon) {
    btnRemoveCoupon.addEventListener('click', function () {
      btnRemoveCoupon.disabled = true;
      btnRemoveCoupon.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Removing...';

      fetch('<?= base_url('cart/remove_coupon') ?>', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => res.json())
      .then(data => {
        btnRemoveCoupon.disabled = false;
        btnRemoveCoupon.innerHTML = '<i class="bi bi-x-circle me-1"></i>Remove';

        if (data.success) {
          if (appliedCouponBox) {
            appliedCouponBox.style.display = 'none';
          }
          if (couponInputContainer) {
            couponInputContainer.style.display = 'block';
          }
          if (couponInput) {
            couponInput.value = '';
          }
          if (discountRow) {
            discountRow.style.setProperty('display', 'none', 'important');
          }
          if (cartSummaryTotal) {
            cartSummaryTotal.innerText = '₹' + data.total;
          }

          Swal.fire({
            title: 'Coupon Removed',
            text: 'Coupon has been removed from your cart.',
            icon: 'info',
            timer: 2000,
            showConfirmButton: false,
            customClass: { popup: 'srl-swal-popup' }
          });
        }
      })
      .catch(err => {
        btnRemoveCoupon.disabled = false;
        btnRemoveCoupon.innerHTML = '<i class="bi bi-x-circle me-1"></i>Remove';
        console.error('Coupon remove error:', err);
      });
    });
  }
});
</script>
