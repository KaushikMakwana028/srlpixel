<style>
/* Checkout Stepper Progress Bar */
.checkout-stepper-wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  margin: 10px 0 35px;
}
.checkout-stepper-wrap::before {
  content: '';
  position: absolute;
  top: 24px;
  left: 60px;
  right: 60px;
  height: 3px;
  background: #e2e8f0;
  z-index: 1;
}
.checkout-step-node {
  position: relative;
  z-index: 2;
  text-align: center;
  flex: 1;
  cursor: pointer;
}
.checkout-step-circle {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: #ffffff;
  border: 2px solid #cbd5e1;
  color: #64748b;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.1rem;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.checkout-step-label {
  font-size: 0.85rem;
  font-weight: 600;
  margin-top: 8px;
  color: #64748b;
  transition: color 0.3s ease;
}
.checkout-step-node.active .checkout-step-circle {
  background: var(--srl-pink-gradient);
  border-color: var(--srl-pink);
  color: #ffffff;
  box-shadow: 0 0 16px rgba(225, 29, 116, 0.4);
}
.checkout-step-node.active .checkout-step-label {
  color: var(--srl-pink);
  font-weight: 800;
}
.checkout-step-node.completed .checkout-step-circle {
  background: #10b981;
  border-color: #10b981;
  color: #ffffff;
}
.checkout-step-node.completed .checkout-step-label {
  color: #10b981;
}

/* Address Card Selection */
.address-card-option {
  border: 2px solid #e2e8f0;
  border-radius: 16px;
  padding: 18px;
  cursor: pointer;
  transition: all 0.25s ease;
  background: #ffffff;
  position: relative;
}
.address-card-option:hover {
  border-color: #cbd5e1;
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}
.address-card-option.selected {
  border-color: var(--srl-pink) !important;
  background: #fff8fb;
  box-shadow: 0 4px 18px rgba(225, 29, 116, 0.12);
}
.address-card-option .selection-check {
  position: absolute;
  top: 16px;
  right: 16px;
  font-size: 1.25rem;
  color: #cbd5e1;
}
.address-card-option.selected .selection-check {
  color: var(--srl-pink);
}

/* Payment Method Selection */
.payment-card-option {
  border: 2px solid #e2e8f0;
  border-radius: 16px;
  padding: 20px;
  cursor: pointer;
  transition: all 0.25s ease;
  background: #ffffff;
  position: relative;
}
.payment-card-option:hover {
  border-color: #cbd5e1;
  box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}
.payment-card-option.selected {
  border-color: var(--srl-pink) !important;
  background: #fff8fb;
  box-shadow: 0 4px 18px rgba(225, 29, 116, 0.12);
}
.payment-card-option .payment-check {
  position: absolute;
  top: 20px;
  right: 20px;
  font-size: 1.25rem;
  color: #cbd5e1;
}
.payment-card-option.selected .payment-check {
  color: var(--srl-pink);
}

@media (max-width: 576px) {
  .checkout-stepper-wrap::before {
    left: 30px;
    right: 30px;
  }
  .checkout-step-circle {
    width: 40px;
    height: 40px;
    font-size: 0.95rem;
  }
  .checkout-step-label {
    font-size: 0.75rem;
  }
}

/* Responsive Action Buttons */
.checkout-action-strip {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 1rem;
  border-top: 1px solid #e2e8f0;
  flex-wrap: wrap;
  gap: 12px;
}

.checkout-btn-cta {
  min-height: 46px;
  padding: 10px 24px;
  font-size: 0.95rem;
  font-weight: 700;
  border-radius: 30px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  line-height: 1.3;
  box-shadow: 0 4px 14px rgba(225, 29, 116, 0.35);
  transition: all 0.2s ease;
}

@media (max-width: 576px) {
  .checkout-action-strip {
    flex-direction: column-reverse;
    align-items: stretch;
    gap: 10px;
  }
  .checkout-action-strip .btn,
  .checkout-action-strip .checkout-btn-cta {
    width: 100% !important;
    text-align: center;
    justify-content: center;
    padding: 11px 16px !important;
    font-size: 0.88rem !important;
    border-radius: 12px !important;
  }
}
</style>

<!-- Include Razorpay Checkout JS SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="container py-4 py-md-5">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('cart') ?>" class="text-decoration-none text-muted">Shopping Cart</a></li>
      <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Step-by-Step Checkout</li>
    </ol>
  </nav>

  <!-- Page Title Header -->
  <div class="mb-4">
    <h2 class="fw-extrabold text-dark mb-1">
      <i class="bi bi-shield-lock-fill me-2" style="color: var(--srl-pink);"></i>Checkout
    </h2>
    <p class="text-muted mb-0">Follow our quick 3-step secure process to confirm your order.</p>
  </div>

  <!-- Interactive Stepper Progress Indicator -->
  <div class="checkout-stepper-wrap">
    <!-- Step 1 Node -->
    <div class="checkout-step-node active" id="stepperNode1" onclick="jumpToStep(1)">
      <div class="checkout-step-circle" id="stepCircle1">
        <i class="bi bi-geo-alt-fill"></i>
      </div>
      <div class="checkout-step-label">1. Delivery Address</div>
    </div>

    <!-- Step 2 Node -->
    <div class="checkout-step-node" id="stepperNode2" onclick="jumpToStep(2)">
      <div class="checkout-step-circle" id="stepCircle2">
        <i class="bi bi-credit-card-2-front-fill"></i>
      </div>
      <div class="checkout-step-label">2. Payment Method</div>
    </div>

    <!-- Step 3 Node -->
    <div class="checkout-step-node" id="stepperNode3" onclick="jumpToStep(3)">
      <div class="checkout-step-circle" id="stepCircle3">
        <i class="bi bi-bag-check-fill"></i>
      </div>
      <div class="checkout-step-label">3. Review & Place</div>
    </div>
  </div>

  <div class="row g-4">
    <!-- Left Column: Steps Form Container -->
    <div class="col-lg-8">

      <!-- ============================================================
           STEP 1: DELIVERY ADDRESS SELECTION & QUICK ADD
           ============================================================ -->
      <div class="checkout-step-content" id="stepContent1">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
            <div>
              <h4 class="fw-bold text-dark mb-1">Select Delivery Address</h4>
              <p class="text-muted small mb-0">Choose where you'd like your pixel LED products delivered.</p>
            </div>
            <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-3 py-2" id="btnToggleNewAddress">
              <i class="bi bi-plus-lg me-1"></i>+ Add New Address
            </button>
          </div>

          <!-- Alert Container for AJAX -->
          <div id="addressAlertBox" style="display: none;"></div>

          <!-- Inline Quick Add Address Form (Collapsible) -->
          <div id="newAddressFormWrapper" class="card border p-4 rounded-4 mb-4" style="display: <?= empty($addresses) ? 'block' : 'none' ?>; background: #f8fafc; border-color: #cbd5e1 !important;">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="fw-bold text-dark mb-0"><i class="bi bi-pin-map-fill me-2" style="color: var(--srl-pink);"></i>Enter New Shipping Address</h6>
              <?php if (!empty($addresses)): ?>
                <button type="button" class="btn-close btn-sm" id="btnCloseNewAddress" aria-label="Close"></button>
              <?php endif; ?>
            </div>

            <form id="ajaxAddAddressForm">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-secondary">Full Name *</label>
                  <input type="text" name="full_name" class="form-control" placeholder="Recipient's full name" required value="<?= $user ? html_escape($user->name) : '' ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-secondary">Mobile Number *</label>
                  <input type="tel" name="mobile" class="form-control" placeholder="10-digit mobile number" required value="<?= $user ? html_escape($user->phone) : '' ?>">
                </div>
                <div class="col-12">
                  <label class="form-label small fw-bold text-secondary">Address Line 1 (Flat, House No, Building, Company) *</label>
                  <input type="text" name="address_line1" class="form-control" placeholder="e.g. Shop #12, Electronica Market" required>
                </div>
                <div class="col-12">
                  <label class="form-label small fw-bold text-secondary">Address Line 2 (Area, Colony, Street, Sector)</label>
                  <input type="text" name="address_line2" class="form-control" placeholder="e.g. Ring Road, Near Metro Station">
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-secondary">Landmark (Optional)</label>
                  <input type="text" name="landmark" class="form-control" placeholder="e.g. Opposite City Mall">
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-secondary">Pincode (6 digits) *</label>
                  <input type="text" name="pincode" class="form-control" placeholder="e.g. 380001" maxlength="6" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-secondary">City *</label>
                  <input type="text" name="city" class="form-control" placeholder="e.g. Ahmedabad" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label small fw-bold text-secondary">State *</label>
                  <input type="text" name="state" class="form-control" placeholder="e.g. Gujarat" required>
                </div>
                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_default" value="1" id="checkSetDefault" checked>
                    <label class="form-check-label small text-muted" for="checkSetDefault">
                      Set as my default shipping address
                    </label>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                  <?php if (!empty($addresses)): ?>
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" id="btnCancelAddAddress">Cancel</button>
                  <?php endif; ?>
                  <button type="submit" class="btn-srl-primary rounded-pill px-4" id="btnSaveAddressSubmit">
                    <i class="bi bi-check2 me-1"></i>Save & Select Address
                  </button>
                </div>
              </div>
            </form>
          </div>

          <!-- Existing Addresses Grid -->
          <div id="addressesListContainer" class="row g-3 mb-4">
            <?php if (!empty($addresses)): ?>
              <?php foreach ($addresses as $addr): ?>
                <?php $isSelected = ($default_address && $default_address->id == $addr->id); ?>
                <div class="col-md-6">
                  <div class="address-card-option <?= $isSelected ? 'selected' : '' ?>" data-id="<?= $addr->id ?>" onclick="selectAddress(<?= $addr->id ?>, this)">
                    <div class="selection-check">
                      <i class="bi <?= $isSelected ? 'bi-check-circle-fill' : 'bi-circle' ?>"></i>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-1">
                      <strong class="text-dark fs-6"><?= html_escape($addr->full_name) ?></strong>
                      <?php if ($addr->is_default): ?>
                        <span class="badge rounded-pill bg-dark text-white px-2 py-0" style="font-size: 0.68rem;">Default</span>
                      <?php endif; ?>
                    </div>

                    <div class="text-muted small mb-2">
                      <i class="bi bi-telephone-fill me-1 text-secondary" style="font-size: 0.75rem;"></i><?= html_escape($addr->mobile) ?>
                    </div>

                    <p class="text-secondary small mb-0" style="line-height: 1.45; font-size: 0.82rem;">
                      <?= html_escape($addr->address_line1) ?><br>
                      <?php if (!empty($addr->address_line2)): ?>
                        <?= html_escape($addr->address_line2) ?><br>
                      <?php endif; ?>
                      <?php if (!empty($addr->landmark)): ?>
                        Landmark: <?= html_escape($addr->landmark) ?><br>
                      <?php endif; ?>
                      <?= html_escape($addr->city) ?>, <?= html_escape($addr->state) ?> - <strong><?= html_escape($addr->pincode) ?></strong>
                    </p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-12" id="noAddressPrompt">
                <div class="alert alert-warning rounded-3 small mb-0 d-flex align-items-center gap-2">
                  <i class="bi bi-exclamation-triangle-fill fs-5 text-warning"></i>
                  <div>Please enter your shipping address above to continue to the payment step.</div>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <!-- Step 1 Bottom Action Strip -->
          <div class="checkout-action-strip">
            <a href="<?= base_url('cart') ?>" class="btn btn-outline-dark rounded-pill px-4">
              <i class="bi bi-arrow-left me-1"></i>Back to Cart
            </a>
            <button type="button" class="btn-srl-primary checkout-btn-cta" id="btnContinueToStep2" onclick="proceedToStep(2)">
              <span>Continue to Payment</span><i class="bi bi-arrow-right ms-2"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- ============================================================
           STEP 2: PAYMENT METHOD SELECTION
           ============================================================ -->
      <div class="checkout-step-content" id="stepContent2" style="display: none;">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <div class="mb-4 pb-3 border-bottom">
            <h4 class="fw-bold text-dark mb-1">Select Payment Method</h4>
            <p class="text-muted small mb-0">Choose your preferred payment option to complete your order.</p>
          </div>

          <div class="d-flex flex-column gap-3 mb-4">
            <!-- Option 1: Cash on Delivery (COD) - Default Active -->
            <div class="payment-card-option selected" id="optCOD" onclick="selectPaymentMethod('Cash on Delivery', this)">
              <div class="payment-check">
                <i class="bi bi-check-circle-fill"></i>
              </div>

              <div class="d-flex align-items-center gap-3 pe-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-success" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.1); font-size: 1.25rem;">
                  <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                  <h6 class="fw-bold text-dark mb-1 fs-6">Cash on Delivery</h6>
                  <p class="text-muted small mb-0">Pay with Cash or UPI upon delivery at your doorstep</p>
                </div>
              </div>
            </div>

            <!-- Option 2: Razorpay Online Payment (UPI, Cards, Netbanking) -->
            <div class="payment-card-option" id="optRazorpay" onclick="selectPaymentMethod('Razorpay', this)">
              <div class="payment-check">
                <i class="bi bi-circle"></i>
              </div>

              <div class="d-flex align-items-center gap-3 pe-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-primary" style="width: 44px; height: 44px; background: rgba(13, 110, 253, 0.1); font-size: 1.25rem;">
                  <i class="bi bi-credit-card-2-front"></i>
                </div>
                <div>
                  <h6 class="fw-bold text-dark mb-1 fs-6">Online Payment (Razorpay)</h6>
                  <p class="text-muted small mb-0">UPI (Google Pay, PhonePe, Paytm), Cards & NetBanking</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 2 Bottom Action Strip -->
          <div class="checkout-action-strip">
            <button type="button" class="btn btn-outline-dark rounded-pill px-4" onclick="proceedToStep(1)">
              <i class="bi bi-arrow-left me-1"></i>Back to Address
            </button>
            <button type="button" class="btn-srl-primary checkout-btn-cta" id="btnContinueToStep3" onclick="proceedToStep(3)">
              <span>Continue to Review</span><i class="bi bi-arrow-right ms-2"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- ============================================================
           STEP 3: REVIEW & PLACE ORDER
           ============================================================ -->
      <div class="checkout-step-content" id="stepContent3" style="display: none;">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <div class="mb-4 pb-3 border-bottom">
            <h4 class="fw-bold text-dark mb-1">Review & Confirm Your Order</h4>
            <p class="text-muted small mb-0">Please verify your delivery address, payment method, and item details before final placement.</p>
          </div>

          <!-- Address & Payment Quick Summary Boxes -->
          <div class="row g-3 mb-4">
            <!-- Shipping Box -->
            <div class="col-md-6">
              <div class="p-3 rounded-4 bg-light border h-100 position-relative">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="small fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                    <i class="bi bi-geo-alt-fill me-1" style="color: var(--srl-pink);"></i>Delivery Address
                  </span>
                  <button type="button" class="btn btn-link text-decoration-none p-0 small fw-bold" style="color: var(--srl-pink); font-size: 0.8rem;" onclick="proceedToStep(1)">
                    Change
                  </button>
                </div>
                <div id="reviewAddressBox" class="small text-secondary" style="line-height: 1.45;">
                  <!-- Dynamically populated via JS -->
                  <div class="fw-bold text-dark" id="revName">Makwana Kaushik</div>
                  <div id="revPhone" class="text-muted"><i class="bi bi-telephone me-1"></i>9099780463</div>
                  <div id="revAddress">Nobal nagar, Ahmedabad - 382340</div>
                </div>
              </div>
            </div>

            <!-- Payment Box -->
            <div class="col-md-6">
              <div class="p-3 rounded-4 bg-light border h-100 position-relative">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="small fw-bold text-dark text-uppercase" style="letter-spacing: 0.5px;">
                    <i class="bi bi-credit-card-2-front-fill me-1 text-primary"></i>Payment Method
                  </span>
                  <button type="button" class="btn btn-link text-decoration-none p-0 small fw-bold" style="color: var(--srl-pink); font-size: 0.8rem;" onclick="proceedToStep(2)">
                    Change
                  </button>
                </div>
                <div id="reviewPaymentBox">
                  <div class="fw-bold text-dark fs-6" id="revPaymentTitle">Cash on Delivery</div>
                  <small class="text-muted" id="revPaymentSubtitle">Pay upon delivery of package at doorstep.</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Items Review List -->
          <div class="mb-4">
            <h6 class="fw-bold text-dark mb-3">Order Items (<?= count($cart_items) ?>)</h6>
            <div class="d-flex flex-column gap-2">
              <?php foreach ($cart_items as $ci): ?>
                <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between flex-wrap gap-3 bg-white">
                  <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center border shadow-2xs" style="width: 52px; height: 52px; background: #0d1017;">
                      <?php if (!empty($ci['image']) && file_exists('./uploads/products/' . $ci['image'])): ?>
                        <img src="<?= base_url('uploads/products/' . $ci['image']) ?>" alt="<?= html_escape($ci['name']) ?>" class="w-100 h-100 object-fit-cover">
                      <?php else: ?>
                        <i class="bi bi-image text-muted fs-5"></i>
                      <?php endif; ?>
                    </div>
                    <div>
                      <div class="fw-bold text-dark small mb-0"><?= html_escape($ci['name']) ?></div>
                      <small class="text-muted">Qty: <?= $ci['quantity'] ?> × ₹<?= number_format($ci['price'], 2) ?></small>
                    </div>
                  </div>
                  <div class="text-end">
                    <span class="fw-bold" style="color: var(--srl-pink);">
                      ₹<?= number_format($ci['line_total'], 2) ?>
                    </span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Order Notes Field (Optional) -->
          <div class="mb-4">
            <label class="form-label small fw-bold text-secondary">
              <i class="bi bi-journal-text me-1 text-primary"></i>Delivery Notes / Special Instructions (Optional)
            </label>
            <textarea id="orderNotesInput" class="form-control small" rows="2" placeholder="e.g. Call before delivery, landmark instructions, or delivery time preference..."></textarea>
          </div>

          <!-- Step 3 Bottom Action Strip -->
          <div class="checkout-action-strip">
            <button type="button" class="btn btn-outline-dark rounded-pill px-4" onclick="proceedToStep(2)">
              <i class="bi bi-arrow-left me-1"></i>Back to Payment
            </button>

            <!-- Final Place Order Button -->
            <button type="button" class="btn-srl-primary checkout-btn-cta" id="btnPlaceOrderFinal" onclick="executeFinalOrder()">
              <i class="bi bi-shield-check me-2 fs-5"></i>
              <span>Confirm & Place Order (₹<?= number_format($total, 2) ?>)</span>
            </button>
          </div>
        </div>
      </div>

    </div>

    <!-- Right Column: Sticky Live Order Summary -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-4 p-4 srl-sticky-summary" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
          <i class="bi bi-receipt text-primary"></i>Order Summary
        </h5>

        <div class="d-flex justify-content-between align-items-center mb-2 text-secondary small">
          <span>Items Subtotal (<?= $total_quantity ?> units)</span>
          <strong class="text-dark">₹<?= number_format($subtotal, 2) ?></strong>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2 small">
          <span class="text-secondary">Delivery Charges</span>
          <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">FREE</span>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3 small">
          <span class="text-secondary">Estimated GST / Taxes</span>
          <span class="text-muted">Included</span>
        </div>

        <hr class="my-3" style="opacity: 0.1;">

        <div class="d-flex justify-content-between align-items-baseline mb-4">
          <span class="fw-bold text-dark fs-5">Grand Total</span>
          <span class="fw-extrabold" style="color: var(--srl-pink); font-size: 1.85rem;">
            ₹<?= number_format($total, 2) ?>
          </span>
        </div>

        <div class="rounded-3 p-3 bg-light text-muted small border mb-3">
          <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-patch-check-fill text-success fs-5"></i>
            <span class="text-dark"><strong>100% Genuine SRL Pixel</strong> Products</span>
          </div>
          <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-truck text-danger fs-5" style="color: var(--srl-pink) !important;"></i>
            <span class="text-dark"><strong>Express Dispatch</strong> in 24 Hours</span>
          </div>
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-lock-fill text-primary fs-5"></i>
            <span class="text-dark"><strong>256-Bit SSL</strong> Encrypted Checkout</span>
          </div>
        </div>

        <div class="text-center">
          <a href="<?= base_url('cart') ?>" class="text-decoration-none text-muted small">
            <i class="bi bi-pencil-square me-1"></i>Edit items in cart
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Hidden Checkout Submission Form -->
<form id="finalOrderForm" action="<?= base_url('checkout/place_order') ?>" method="POST" style="display: none;">
  <input type="hidden" name="address_id" id="formAddressId" value="<?= $default_address ? $default_address->id : '' ?>">
  <input type="hidden" name="payment_method" id="formPaymentMethod" value="Cash on Delivery">
  <input type="hidden" name="razorpay_order_id" id="formRazorpayOrderId" value="">
  <input type="hidden" name="razorpay_payment_id" id="formRazorpayPaymentId" value="">
  <input type="hidden" name="order_notes" id="formOrderNotes" value="">
</form>

<script>
// State variables
let currentStep = 1;
let selectedAddressId = <?= $default_address ? $default_address->id : 'null' ?>;
let selectedPaymentMethod = 'Cash on Delivery';
let razorpayKeyId = '<?= $razorpay_key_id ?>';
let totalAmountPaise = <?= round($total * 100) ?>;
let currency = '<?= $currency ?>';

// Address selection function
function selectAddress(id, element) {
  selectedAddressId = id;
  document.getElementById('formAddressId').value = id;

  document.querySelectorAll('.address-card-option').forEach(card => {
    card.classList.remove('selected');
    const icon = card.querySelector('.selection-check i');
    if (icon) {
      icon.className = 'bi bi-circle';
    }
  });

  element.classList.add('selected');
  const icon = element.querySelector('.selection-check i');
  if (icon) {
    icon.className = 'bi bi-check-circle-fill';
  }

  // Update Review step preview
  const name = element.querySelector('strong').innerText;
  const phone = element.querySelector('.text-muted.small').innerText;
  const address = element.querySelector('p').innerHTML;

  document.getElementById('revName').innerText = name;
  document.getElementById('revPhone').innerText = phone;
  document.getElementById('revAddress').innerHTML = address;
}

// Payment method selection function
function selectPaymentMethod(method, element) {
  selectedPaymentMethod = method;
  document.getElementById('formPaymentMethod').value = method;

  document.querySelectorAll('.payment-card-option').forEach(card => {
    card.classList.remove('selected');
    const icon = card.querySelector('.payment-check i');
    if (icon) icon.className = 'bi bi-circle';
  });

  element.classList.add('selected');
  const icon = element.querySelector('.payment-check i');
  if (icon) icon.className = 'bi bi-check-circle-fill';

  // Update Review step preview
  if (method === 'Razorpay') {
    document.getElementById('revPaymentTitle').innerText = 'Online Payment (Razorpay)';
    document.getElementById('revPaymentSubtitle').innerText = 'UPI, Credit/Debit Cards, or NetBanking';
  } else {
    document.getElementById('revPaymentTitle').innerText = 'Cash on Delivery';
    document.getElementById('revPaymentSubtitle').innerText = 'Pay cash or UPI upon delivery at doorstep.';
  }
}

// Step Navigation
function proceedToStep(step) {
  if (step === 2) {
    if (!selectedAddressId) {
      Swal.fire({
        title: 'Delivery Address Required',
        text: 'Please select or add a delivery address before proceeding to payment.',
        icon: 'warning',
        confirmButtonText: 'Select Address',
        customClass: { popup: 'srl-swal-popup' }
      });
      return;
    }
  }

  jumpToStep(step);
}

function jumpToStep(step) {
  currentStep = step;

  // Hide all contents
  document.getElementById('stepContent1').style.display = 'none';
  document.getElementById('stepContent2').style.display = 'none';
  document.getElementById('stepContent3').style.display = 'none';

  // Show target content
  document.getElementById('stepContent' + step).style.display = 'block';

  // Update Stepper Nodes
  for (let i = 1; i <= 3; i++) {
    const node = document.getElementById('stepperNode' + i);
    const circle = document.getElementById('stepCircle' + i);

    node.classList.remove('active', 'completed');

    if (i < step) {
      node.classList.add('completed');
      circle.innerHTML = '<i class="bi bi-check-lg"></i>';
    } else if (i === step) {
      node.classList.add('active');
      if (i === 1) circle.innerHTML = '<i class="bi bi-geo-alt-fill"></i>';
      if (i === 2) circle.innerHTML = '<i class="bi bi-credit-card-2-front-fill"></i>';
      if (i === 3) circle.innerHTML = '<i class="bi bi-bag-check-fill"></i>';
    } else {
      if (i === 1) circle.innerHTML = '<i class="bi bi-geo-alt-fill"></i>';
      if (i === 2) circle.innerHTML = '<i class="bi bi-credit-card-2-front-fill"></i>';
      if (i === 3) circle.innerHTML = '<i class="bi bi-bag-check-fill"></i>';
    }
  }

  window.scrollTo({ top: 120, behavior: 'smooth' });
}

// Execute Final Order
function executeFinalOrder() {
  if (!selectedAddressId) {
    Swal.fire({
      title: 'Shipping Address Required',
      text: 'Please select a delivery address for your order.',
      icon: 'warning',
      confirmButtonText: 'Select Address',
      customClass: { popup: 'srl-swal-popup' }
    });
    jumpToStep(1);
    return;
  }

  const orderNotes = document.getElementById('orderNotesInput').value.trim();
  document.getElementById('formOrderNotes').value = orderNotes;

  const btn = document.getElementById('btnPlaceOrderFinal');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing Order...';

  if (selectedPaymentMethod === 'Razorpay') {
    // Check if Razorpay SDK is available
    if (typeof Razorpay === 'undefined') {
      Swal.fire({
        title: 'Payment Gateway Notice',
        text: 'Razorpay payment gateway script could not be loaded. Please check your internet connection.',
        icon: 'error',
        customClass: { popup: 'srl-swal-popup' }
      });
      btn.disabled = false;
      btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Confirm & Place Order';
      return;
    }

    // Call server to initialize Razorpay Order
    fetch('<?= base_url('checkout/razorpay_create_order') ?>', {
      method: 'POST',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(res => res.json())
      .then(data => {
        if (data && data.success) {
          const options = {
            key: data.key_id || razorpayKeyId,
            amount: data.amount,
            currency: data.currency || 'INR',
            name: data.company_name || "VISION TECHNOLABS",
            description: 'Online Order Payment',
            image: data.logo_url || '<?= base_url("assets/images/new_logo.png") ?>',
            prefill: {
              name: data.customer_name || '',
              email: data.customer_email || '',
              contact: data.customer_phone || ''
            },
            theme: {
              color: data.theme_color || '#2563eb'
            },
            handler: function (response) {
              // On Razorpay payment success
              document.getElementById('formRazorpayPaymentId').value = response.razorpay_payment_id || '';
              document.getElementById('formRazorpayOrderId').value = response.razorpay_order_id || '';
              document.getElementById('finalOrderForm').submit();
            },
            modal: {
              ondismiss: function () {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Confirm & Place Order (₹<?= number_format($total, 2) ?>)';
              }
            }
          };

          // Attach order_id only if valid string returned from server
          if (data.razorpay_order_id && typeof data.razorpay_order_id === 'string' && data.razorpay_order_id.trim() !== '') {
            options.order_id = data.razorpay_order_id.trim();
          }

          try {
            const rzp = new Razorpay(options);
            rzp.on('payment.failed', function (response) {
              Swal.fire({
                title: 'Payment Failed',
                text: (response.error && response.error.description) ? response.error.description : 'Payment could not be completed.',
                icon: 'error',
                customClass: { popup: 'srl-swal-popup' }
              });
              btn.disabled = false;
              btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Confirm & Place Order (₹<?= number_format($total, 2) ?>)';
            });
            rzp.open();
          } catch (e) {
            console.error('Razorpay open error:', e);
            Swal.fire({
              title: 'Checkout Error',
              text: 'Unable to open Razorpay payment gateway. Please try again.',
              icon: 'error',
              customClass: { popup: 'srl-swal-popup' }
            });
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Confirm & Place Order (₹<?= number_format($total, 2) ?>)';
          }
        } else {
          Swal.fire({
            title: 'Payment Error',
            text: data.message || 'Unable to initiate online payment.',
            icon: 'error',
            customClass: { popup: 'srl-swal-popup' }
          });
          btn.disabled = false;
          btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Confirm & Place Order (₹<?= number_format($total, 2) ?>)';
        }
      })
      .catch(err => {
        console.error('Razorpay init error:', err);
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-shield-check me-2"></i>Confirm & Place Order (₹<?= number_format($total, 2) ?>)';
      });

  } else {
    // Cash on Delivery Order placement
    document.getElementById('finalOrderForm').submit();
  }
}

// Inline Add Address Form Toggle & AJAX Submission
document.addEventListener('DOMContentLoaded', function () {
  const btnToggleNewAddress = document.getElementById('btnToggleNewAddress');
  const btnCloseNewAddress = document.getElementById('btnCloseNewAddress');
  const btnCancelAddAddress = document.getElementById('btnCancelAddAddress');
  const newAddressFormWrapper = document.getElementById('newAddressFormWrapper');
  const ajaxAddAddressForm = document.getElementById('ajaxAddAddressForm');
  const addressesListContainer = document.getElementById('addressesListContainer');
  const addressAlertBox = document.getElementById('addressAlertBox');

  if (btnToggleNewAddress) {
    btnToggleNewAddress.addEventListener('click', function () {
      newAddressFormWrapper.style.display = (newAddressFormWrapper.style.display === 'none') ? 'block' : 'none';
      if (newAddressFormWrapper.style.display === 'block') {
        newAddressFormWrapper.scrollIntoView({ behavior: 'smooth' });
      }
    });
  }

  if (btnCloseNewAddress) {
    btnCloseNewAddress.addEventListener('click', function () {
      newAddressFormWrapper.style.display = 'none';
    });
  }

  if (btnCancelAddAddress) {
    btnCancelAddAddress.addEventListener('click', function () {
      newAddressFormWrapper.style.display = 'none';
    });
  }

  // Handle AJAX Add Address Form
  if (ajaxAddAddressForm) {
    ajaxAddAddressForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const submitBtn = document.getElementById('btnSaveAddressSubmit');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

      const formData = new FormData(this);

      fetch('<?= base_url('checkout/add_address') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(res => res.json())
        .then(data => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<i class="bi bi-check2 me-1"></i>Save & Select Address';

          if (data.success && data.address) {
            const addr = data.address;
            newAddressFormWrapper.style.display = 'none';
            ajaxAddAddressForm.reset();

            const noPrompt = document.getElementById('noAddressPrompt');
            if (noPrompt) noPrompt.remove();

            // Create new address card element
            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
              <div class="address-card-option selected" data-id="${addr.id}" onclick="selectAddress(${addr.id}, this)">
                <div class="selection-check">
                  <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="d-flex align-items-center gap-2 mb-1">
                  <strong class="text-dark fs-6">${addr.full_name}</strong>
                  <span class="badge rounded-pill bg-success px-2 py-0" style="font-size: 0.68rem;">New</span>
                </div>
                <div class="text-muted small mb-2">
                  <i class="bi bi-telephone-fill me-1 text-secondary" style="font-size: 0.75rem;"></i>${addr.mobile}
                </div>
                <p class="text-secondary small mb-0" style="line-height: 1.45; font-size: 0.82rem;">
                  ${addr.address_line1}<br>
                  ${addr.address_line2 ? addr.address_line2 + '<br>' : ''}
                  ${addr.landmark ? 'Landmark: ' + addr.landmark + '<br>' : ''}
                  ${addr.city}, ${addr.state} - <strong>${addr.pincode}</strong>
                </p>
              </div>
            `;

            addressesListContainer.prepend(col);
            selectAddress(addr.id, col.querySelector('.address-card-option'));

            // Show success toast
            addressAlertBox.style.display = 'block';
            addressAlertBox.className = 'alert alert-success rounded-3 small p-2 mb-3';
            addressAlertBox.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i>New address added and selected successfully!';
            setTimeout(() => { addressAlertBox.style.display = 'none'; }, 4000);
          } else {
            Swal.fire({
              title: 'Error Saving Address',
              text: data.message || 'Could not save address.',
              icon: 'error',
              customClass: { popup: 'srl-swal-popup' }
            });
          }
        })
        .catch(err => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<i class="bi bi-check2 me-1"></i>Save & Select Address';
          console.error('Address save error:', err);
          Swal.fire({
            title: 'Error',
            text: 'Unable to connect to server. Please try again.',
            icon: 'error',
            customClass: { popup: 'srl-swal-popup' }
          });
        });
    });
  }
});
</script>
