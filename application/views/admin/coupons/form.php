<?php
$is_edit = !empty($coupon);
$form_action = $is_edit ? base_url('admin/coupons/update/' . $coupon->id) : base_url('admin/coupons/store');
$discount_type = set_value('discount_type', $coupon->discount_type ?? 'percentage');
?>

<style>
  :root {
    --srl-pink: #e11d74;
    --srl-pink-glow: #ff2a85;
    --srl-pink-gradient: linear-gradient(135deg, #ff2a85 0%, #e11d74 100%);
    --srl-pink-light: rgba(255, 42, 133, 0.08);
    --srl-border: #e2e8f0;
    --srl-bg-light: #f8fafc;
    --srl-text-dark: #1e293b;
    --srl-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    --srl-shadow-lg: 0 10px 25px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
  }

  .coupon-header {
    margin-bottom: 1.5rem;
  }

  .coupon-header h4 {
    font-size: 1.5rem;
    line-height: 1.3;
  }

  .coupon-header p {
    font-size: 0.875rem;
    line-height: 1.5;
  }

  .coupon-card {
    border-radius: 1rem !important;
    overflow: hidden;
    box-shadow: var(--srl-shadow-lg);
    background: #ffffff;
    transition: box-shadow 0.3s ease;
  }

  .coupon-card .card-header {
    background: var(--srl-pink-gradient, linear-gradient(135deg, #ff2a85 0%, #e11d74 100%)) !important;
    border-bottom: none !important;
    padding: 1.25rem 1.75rem;
    box-shadow: 0 4px 16px rgba(255, 42, 133, 0.22);
  }

  .coupon-card .card-header h6 {
    color: #ffffff !important;
    margin: 0;
    font-size: 1.05rem;
    letter-spacing: 0.3px;
  }

  .coupon-card .card-header i {
    color: #ffffff !important;
  }

  .form-label {
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--srl-text-dark);
    font-size: 0.813rem;
    letter-spacing: 0.5px;
  }

  .form-control,
  .form-select {
    border: 1.5px solid var(--srl-border);
    border-radius: 0.5rem;
    padding: 0.65rem 0.9rem;
    font-size: 0.938rem;
    transition: all 0.25s ease;
  }

  .form-control:focus,
  .form-select:focus {
    border-color: var(--srl-pink-glow);
    box-shadow: 0 0 0 3px rgba(255, 42, 133, 0.15);
  }

  .input-group-text {
    border: 1.5px solid var(--srl-border);
    border-radius: 0.5rem 0 0 0.5rem;
    background-color: #f8fafc;
    font-size: 0.938rem;
    transition: all 0.25s ease;
  }

  .input-group:focus-within .input-group-text {
    border-color: var(--srl-pink-glow);
    background-color: var(--srl-pink-light);
    color: var(--srl-pink);
  }

  .discount-type-card {
    cursor: pointer;
    transition: all 0.25s ease;
    border: 2px solid var(--srl-border) !important;
    position: relative;
    border-radius: 0.75rem !important;
  }

  .discount-type-card:hover {
    border-color: var(--srl-pink-glow) !important;
    transform: translateY(-2px);
    box-shadow: var(--srl-shadow);
  }

  .discount-type-card input[type="radio"]:checked ~ label {
    color: var(--srl-pink) !important;
  }

  .discount-type-card.selected {
    border-color: var(--srl-pink) !important;
    background: rgba(255, 42, 133, 0.05) !important;
    box-shadow: 0 4px 14px rgba(255, 42, 133, 0.12);
  }

  .section-wrapper {
    border-radius: 0.85rem;
    padding: 1.5rem;
    margin-bottom: 1.75rem;
    background: #ffffff;
    border: 1.5px solid var(--srl-border);
    transition: all 0.25s ease;
  }

  .section-wrapper:hover {
    box-shadow: var(--srl-shadow);
    border-color: #cbd5e1;
  }

  .section-title {
    font-size: 1.02rem;
    font-weight: 700;
    color: var(--srl-text-dark);
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
  }

  .section-title i {
    font-size: 1.25rem;
  }

  .btn-srl-primary {
    background: var(--srl-pink-gradient, linear-gradient(135deg, #ff2a85 0%, #e11d74 100%));
    border: none;
    color: #ffffff !important;
    font-weight: 600;
    transition: all 0.25s ease;
    box-shadow: 0 4px 14px rgba(255, 42, 133, 0.3);
  }

  .btn-srl-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 42, 133, 0.45);
    background: linear-gradient(135deg, #e11d74 0%, #c2185b 100%);
  }

  .form-check-input {
    cursor: pointer;
    border: 2px solid var(--srl-border);
  }

  .form-check-input:checked {
    background-color: var(--srl-pink);
    border-color: var(--srl-pink);
  }

  .badge {
    padding: 0.375rem 0.75rem;
    font-weight: 600;
    border-radius: 0.375rem;
  }

  .random-code-btn {
    border-radius: 0 0.5rem 0.5rem 0 !important;
    border: 1.5px solid var(--srl-border);
    border-left: none;
    transition: all 0.25s ease;
  }

  .random-code-btn:hover {
    background: var(--srl-pink-gradient, linear-gradient(135deg, #ff2a85 0%, #e11d74 100%));
    border-color: var(--srl-pink);
    color: #ffffff;
  }

  .btn-outline-secondary {
    border: 1.5px solid var(--srl-border);
    transition: all 0.25s ease;
  }

  .btn-outline-secondary:hover {
    background-color: var(--srl-text-dark);
    border-color: var(--srl-text-dark);
    color: #ffffff;
  }

  .form-switch .form-check-input {
    width: 2.5em;
    height: 1.3em;
    cursor: pointer;
    background-color: #cbd5e1;
    border: none;
  }

  .form-switch .form-check-input:checked {
    background-color: #10b981;
  }

  .form-switch .form-check-input:focus {
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
  }

  small.text-muted {
    display: block;
    margin-top: 0.375rem;
    line-height: 1.4;
    font-size: 0.813rem;
  }

  .bg-secondary-subtle {
    background-color: #f1f5f9 !important;
  }

  .bg-info-subtle {
    background-color: #fdf2f8 !important;
  }

  .text-secondary {
    color: #64748b !important;
  }

  .text-info {
    color: var(--srl-pink) !important;
  }

  /* Responsive Adjustments */
  @media (max-width: 768px) {
    .coupon-card .card-header {
      padding: 1rem 1.25rem;
    }
    .coupon-card .card-body {
      padding: 1.25rem !important;
    }
    .section-wrapper {
      padding: 1.15rem;
      margin-bottom: 1.25rem;
    }
    .section-title {
      font-size: 0.95rem;
    }
    .form-control, .form-select, .input-group-text {
      font-size: 0.875rem;
      padding: 0.55rem 0.75rem;
    }
  }
</style>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2 coupon-header">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-ticket-perforated-fill me-2" style="color: var(--srl-pink-glow, #ff2a85);"></i>
      <span><?= $is_edit ? 'Edit Coupon Code' : 'Create New Coupon Code' ?></span>
    </h4>
    <p class="text-muted small mb-0">
      <?= $is_edit ? 'Modify discount values, limits, and expiration criteria.' : 'Configure promotional discount codes with flat or percentage savings and usage caps.' ?>
    </p>
  </div>
  <a href="<?= base_url('admin/coupons') ?>" class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm d-inline-flex align-items-center">
    <i class="bi bi-arrow-left me-1"></i>Back to Coupons
  </a>
</div>

<!-- Flash Alerts -->
<?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
      <div><?= $this->session->flashdata('error') ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="bi bi-check-circle-fill fs-5 me-2"></i>
      <div><?= $this->session->flashdata('success') ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<!-- Full Page Width Coupon Configuration Card -->
<div class="card border-0 shadow-sm rounded-4 coupon-card w-100 mb-4" style="border: 1px solid var(--srl-border) !important;">
  <!-- Card Header with SRL Theme Glow Gradient -->
  <div class="card-header d-flex justify-content-between align-items-center">
    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
      <i class="bi bi-sliders"></i>
      <span>Coupon Configuration</span>
    </h6>
    <span class="badge rounded-pill bg-white text-dark bg-opacity-75 px-3 py-1.5 fw-semibold small shadow-sm" style="font-size: 0.75rem; letter-spacing: 0.5px;">
      <i class="bi bi-tag-fill me-1" style="color: var(--srl-pink);"></i><?= $is_edit ? 'EDIT MODE' : 'PROMO BUILDER' ?>
    </span>
  </div>

  <!-- Card Body -->
  <div class="card-body p-3 p-md-4 p-lg-5">
    <?= form_open($form_action, ['id' => 'couponForm']) ?>

    <!-- Section 1: Basic Information -->
    <div class="section-wrapper">
      <h6 class="section-title">
        <i class="bi bi-tag-fill" style="color: var(--srl-pink);"></i>
        Basic Information
      </h6>

      <div class="row g-3 g-md-4">
        <!-- Coupon Code -->
        <div class="col-12 col-md-6">
          <label class="form-label text-uppercase">
            Coupon Code <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <span class="input-group-text fw-bold">
              <i class="bi bi-tag-fill"></i>
            </span>
            <input
              type="text"
              name="code"
              id="couponCodeInput"
              class="form-control text-uppercase fw-bold font-monospace"
              placeholder="e.g. WELCOME10"
              value="<?= set_value('code', $coupon->code ?? '') ?>"
              required
              style="letter-spacing: 1px;"
              oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9_-]/g, '');">
            <button
              type="button"
              class="btn btn-outline-secondary random-code-btn"
              onclick="generateRandomCouponCode()"
              title="Generate Random Code">
              <i class="bi bi-shuffle"></i>
            </button>
          </div>
          <small class="text-muted">
            Customer enters this code at checkout (uppercase, letters & digits).
          </small>
        </div>

        <!-- Coupon Title -->
        <div class="col-12 col-md-6">
          <label class="form-label text-uppercase">
            Coupon Title / Campaign Name
          </label>
          <input
            type="text"
            name="title"
            class="form-control"
            placeholder="e.g. Festival 10% Off"
            value="<?= set_value('title', $coupon->title ?? '') ?>">
          <small class="text-muted">
            Friendly campaign label shown to customers and in reports.
          </small>
        </div>

        <!-- Description -->
        <div class="col-12">
          <label class="form-label text-uppercase">
            Description (Optional)
          </label>
          <textarea
            name="description"
            rows="3"
            class="form-control"
            placeholder="Brief explanation of terms or who can use this coupon..."><?= set_value('description', $coupon->description ?? '') ?></textarea>
          <small class="text-muted">
            Additional details about this coupon's terms and conditions.
          </small>
        </div>
      </div>
    </div>

    <!-- Section 2: Discount Mechanism -->
    <div class="section-wrapper" style="background: var(--srl-bg-light);">
      <h6 class="section-title">
        <i class="bi bi-percent" style="color: var(--srl-pink);"></i>
        Discount Mechanism
      </h6>

      <div class="row g-3 g-md-4">
        <!-- Discount Type -->
        <div class="col-12">
          <label class="form-label text-uppercase">
            Discount Type <span class="text-danger">*</span>
          </label>
          <div class="row g-2 g-md-3">
            <div class="col-12 col-sm-6">
              <div class="form-check discount-type-card p-3 bg-white h-100 <?= ($discount_type === 'percentage') ? 'selected' : '' ?>" onclick="selectDiscountType('percentage')">
                <input
                  class="form-check-input"
                  type="radio"
                  name="discount_type"
                  id="typePercentage"
                  value="percentage"
                  <?= ($discount_type === 'percentage') ? 'checked' : '' ?>
                  onchange="handleDiscountTypeChange()">
                <label class="form-check-label fw-semibold text-dark d-block w-100" for="typePercentage" style="cursor: pointer;">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-percent fs-5" style="color: var(--srl-pink);"></i>
                    <span>Percentage (%) Discount</span>
                  </div>
                  <small class="text-muted d-block fw-normal">
                    e.g. 10% or 20% off total cart subtotal
                  </small>
                </label>
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-check discount-type-card p-3 bg-white h-100 <?= ($discount_type === 'flat') ? 'selected' : '' ?>" onclick="selectDiscountType('flat')">
                <input
                  class="form-check-input"
                  type="radio"
                  name="discount_type"
                  id="typeFlat"
                  value="flat"
                  <?= ($discount_type === 'flat') ? 'checked' : '' ?>
                  onchange="handleDiscountTypeChange()">
                <label class="form-check-label fw-semibold text-dark d-block w-100" for="typeFlat" style="cursor: pointer;">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-currency-rupee text-success fs-5"></i>
                    <span>Flat Amount (₹) Discount</span>
                  </div>
                  <small class="text-muted d-block fw-normal">
                    e.g. ₹200 or ₹500 fixed deduction off total
                  </small>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- Discount Value -->
        <div class="col-12 col-md-4">
          <label class="form-label text-uppercase" id="discountValueLabel">
            <?= ($discount_type === 'percentage') ? 'Discount Percentage (%)' : 'Flat Discount Amount (₹)' ?>
            <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <span class="input-group-text fw-bold" id="discountValuePrefix">
              <?= ($discount_type === 'percentage') ? '%' : '₹' ?>
            </span>
            <input
              type="number"
              step="0.01"
              min="0.01"
              max="<?= ($discount_type === 'percentage') ? '100' : '999999' ?>"
              name="discount_value"
              id="discountValueInput"
              class="form-control fw-bold"
              placeholder="<?= ($discount_type === 'percentage') ? 'e.g. 10' : 'e.g. 500' ?>"
              value="<?= set_value('discount_value', $coupon->discount_value ?? '') ?>"
              required>
          </div>
          <small class="text-muted" id="discountValueHelp">
            <?= ($discount_type === 'percentage') ? 'Percentage deducted from cart subtotal (1 to 100%).' : 'Exact flat rupee amount deducted from total.' ?>
          </small>
        </div>

        <!-- Min Order Amount -->
        <div class="col-12 col-md-4">
          <label class="form-label text-uppercase">
            Minimum Order Amount (₹)
          </label>
          <div class="input-group">
            <span class="input-group-text">₹</span>
            <input
              type="number"
              step="0.01"
              min="0"
              name="min_order_amount"
              class="form-control"
              placeholder="0 for no minimum"
              value="<?= set_value('min_order_amount', $coupon->min_order_amount ?? 0) ?>">
          </div>
          <small class="text-muted">
            Cart subtotal required before this coupon applies (0 = any amount).
          </small>
        </div>

        <!-- Max Discount Cap -->
        <div class="col-12 col-md-4" id="maxCapWrapper" style="<?= ($discount_type === 'flat') ? 'display: none;' : '' ?>">
          <label class="form-label text-uppercase">
            Maximum Discount Cap (₹)
          </label>
          <div class="input-group">
            <span class="input-group-text">₹</span>
            <input
              type="number"
              step="0.01"
              min="0"
              name="max_discount_amount"
              class="form-control"
              placeholder="Leave blank for no limit"
              value="<?= set_value('max_discount_amount', $coupon->max_discount_amount ?? '') ?>">
          </div>
          <small class="text-muted">
            Optional ceiling for % discounts (e.g. 20% off up to ₹1,000 max).
          </small>
        </div>
      </div>
    </div>

    <!-- Section 3: Usage Limits -->
    <div class="section-wrapper">
      <h6 class="section-title">
        <i class="bi bi-people-fill" style="color: var(--srl-pink);"></i>
        Usage Limits & Caps
      </h6>

      <div class="row g-3 g-md-4">
        <!-- Total Usage Limit -->
        <div class="col-12 col-md-6">
          <label class="form-label text-uppercase">
            Total Usage Limit <span class="text-danger">*</span>
          </label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="bi bi-123"></i>
            </span>
            <input
              type="number"
              min="0"
              step="1"
              name="usage_limit"
              class="form-control fw-bold"
              placeholder="e.g. 10, 20, 50"
              value="<?= set_value('usage_limit', $coupon->usage_limit ?? 10) ?>"
              required>
          </div>
          <small class="text-muted">
            Total times coupon can be redeemed across all customers. Set 0 for unlimited.
          </small>
          <?php if ($is_edit): ?>
            <div class="mt-2 d-flex flex-wrap gap-2">
              <span class="badge bg-secondary-subtle text-secondary">
                <i class="bi bi-check-circle me-1"></i>Used: <?= (int)$coupon->used_count ?> times
              </span>
              <?php if ($coupon->usage_limit > 0): ?>
                <span class="badge bg-info-subtle text-info border" style="border-color: rgba(225, 29, 116, 0.2) !important;">
                  <i class="bi bi-hourglass-split me-1"></i>Remaining: <?= max(0, $coupon->usage_limit - $coupon->used_count) ?>
                </span>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Per User Limit -->
        <div class="col-12 col-md-6">
          <label class="form-label text-uppercase">
            Uses Per Customer
          </label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="bi bi-person"></i>
            </span>
            <input
              type="number"
              min="1"
              step="1"
              name="per_user_limit"
              class="form-control"
              placeholder="Default is 1"
              value="<?= set_value('per_user_limit', $coupon->per_user_limit ?? 1) ?>"
              required>
          </div>
          <small class="text-muted">
            Maximum times an individual registered customer can use this code.
          </small>
        </div>
      </div>
    </div>

    <!-- Section 4: Validity Schedule & Status -->
    <div class="section-wrapper" style="background: var(--srl-bg-light);">
      <h6 class="section-title">
        <i class="bi bi-calendar2-week-fill" style="color: var(--srl-pink);"></i>
        Validity Schedule & Status
      </h6>

      <div class="row g-3 g-md-4">
        <!-- Start Date -->
        <div class="col-12 col-md-4">
          <label class="form-label text-uppercase">
            Start Date & Time (Optional)
          </label>
          <input
            type="datetime-local"
            name="start_date"
            class="form-control"
            value="<?= set_value('start_date', !empty($coupon->start_date) ? date('Y-m-d\TH:i', strtotime($coupon->start_date)) : '') ?>">
          <small class="text-muted">
            When coupon becomes active (leave blank for immediate).
          </small>
        </div>

        <!-- End Date -->
        <div class="col-12 col-md-4">
          <label class="form-label text-uppercase">
            Expiry Date & Time (Optional)
          </label>
          <input
            type="datetime-local"
            name="end_date"
            class="form-control"
            value="<?= set_value('end_date', !empty($coupon->end_date) ? date('Y-m-d\TH:i', strtotime($coupon->end_date)) : '') ?>">
          <small class="text-muted">
            When coupon expires (leave blank for no expiration).
          </small>
        </div>

        <!-- Status Toggle -->
        <div class="col-12 col-md-4">
          <label class="form-label text-uppercase">
            Coupon Status
          </label>
          <div class="p-2.5 px-3 rounded-3 border d-flex align-items-center justify-content-between bg-white" style="border-color: var(--srl-border) !important; min-height: 48px;">
            <div class="d-flex align-items-center gap-2">
              <i class="bi <?= (!isset($coupon) || $coupon->status == 1) ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' ?> fs-5" id="statusIcon"></i>
              <span class="fw-semibold text-dark small" id="statusText">
                <?= (!isset($coupon) || $coupon->status == 1) ? 'Active (Ready)' : 'Inactive (Disabled)' ?>
              </span>
            </div>
            <div class="form-check form-switch m-0 p-0">
              <input
                class="form-check-input ms-0"
                type="checkbox"
                role="switch"
                id="couponStatusSwitch"
                name="status"
                value="1"
                <?= (!isset($coupon) || $coupon->status == 1) ? 'checked' : '' ?>
                style="width: 2.6em; height: 1.3em; cursor: pointer;">
            </div>
          </div>
          <small class="text-muted">
            Only active coupons can be applied by customers at checkout.
          </small>
        </div>
      </div>
    </div>

    <!-- Section 5: Action Buttons -->
    <div class="d-flex align-items-center justify-content-between pt-3 border-top gap-3 flex-wrap">
      <a href="<?= base_url('admin/coupons') ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
        <i class="bi bi-x-circle"></i>
        <span>Cancel</span>
      </a>
      <button type="submit" class="btn-srl-primary px-5 py-2.5 rounded-pill d-inline-flex align-items-center gap-2 fw-bold shadow-sm">
        <i class="bi bi-check2-circle fs-5"></i>
        <span><?= $is_edit ? 'Update Coupon Code' : 'Save & Activate Coupon' ?></span>
      </button>
    </div>

    <?= form_close() ?>
  </div>
</div>

<script>
  // Handle Discount Type Change
  function handleDiscountTypeChange() {
    const isPercentage = document.getElementById('typePercentage').checked;
    const label = document.getElementById('discountValueLabel');
    const prefix = document.getElementById('discountValuePrefix');
    const input = document.getElementById('discountValueInput');
    const help = document.getElementById('discountValueHelp');
    const maxCapWrapper = document.getElementById('maxCapWrapper');

    // Update discount type cards
    document.querySelectorAll('.discount-type-card').forEach(card => {
      card.classList.remove('selected');
    });

    if (isPercentage) {
      document.querySelector('#typePercentage').closest('.discount-type-card').classList.add('selected');
      label.innerHTML = 'Discount Percentage (%) <span class="text-danger">*</span>';
      prefix.innerText = '%';
      input.placeholder = 'e.g. 10 or 20';
      input.max = '100';
      help.innerText = 'Percentage deducted from cart subtotal (1 to 100%).';
      if (maxCapWrapper) maxCapWrapper.style.display = 'block';
    } else {
      document.querySelector('#typeFlat').closest('.discount-type-card').classList.add('selected');
      label.innerHTML = 'Flat Discount Amount (₹) <span class="text-danger">*</span>';
      prefix.innerText = '₹';
      input.placeholder = 'e.g. 200 or 500';
      input.removeAttribute('max');
      help.innerText = 'Exact flat rupee amount deducted from total.';
      if (maxCapWrapper) maxCapWrapper.style.display = 'none';
    }
  }

  // Select Discount Type by clicking card
  function selectDiscountType(type) {
    if (type === 'percentage') {
      document.getElementById('typePercentage').checked = true;
    } else {
      document.getElementById('typeFlat').checked = true;
    }
    handleDiscountTypeChange();
  }

  // Generate Random Coupon Code
  function generateRandomCouponCode() {
    const prefixes = ['SRL', 'SAVE', 'PROMO', 'OFFER', 'FEST', 'MEGA', 'DEAL', 'SPECIAL'];
    const prefix = prefixes[Math.floor(Math.random() * prefixes.length)];
    const num = Math.floor(100 + Math.random() * 900);
    const input = document.getElementById('couponCodeInput');
    input.value = prefix + num;

    // Add animation effect
    input.classList.add('border-success');
    setTimeout(() => {
      input.classList.remove('border-success');
    }, 1000);
  }

  // Status Switch Handler
  const statusSwitch = document.getElementById('couponStatusSwitch');
  if (statusSwitch) {
    statusSwitch.addEventListener('change', function() {
      const statusText = document.getElementById('statusText');
      const icon = document.getElementById('statusIcon');

      if (this.checked) {
        if (statusText) statusText.innerText = 'Active (Ready)';
        if (icon) {
          icon.className = 'bi bi-check-circle-fill text-success fs-5';
        }
      } else {
        if (statusText) statusText.innerText = 'Inactive (Disabled)';
        if (icon) {
          icon.className = 'bi bi-x-circle-fill text-danger fs-5';
        }
      }
    });
  }

  // Form Validation Enhancement
  const couponForm = document.getElementById('couponForm');
  if (couponForm) {
    couponForm.addEventListener('submit', function(e) {
      const discountValue = parseFloat(document.querySelector('input[name="discount_value"]').value);
      const isPercentage = document.getElementById('typePercentage').checked;

      if (isPercentage && (discountValue < 1 || discountValue > 100)) {
        e.preventDefault();
        alert('Percentage discount must be between 1 and 100');
        return false;
      }

      if (!isPercentage && discountValue <= 0) {
        e.preventDefault();
        alert('Flat discount amount must be greater than 0');
        return false;
      }

      // Show loading state
      const submitBtn = this.querySelector('button[type="submit"]');
      if (submitBtn) {
        const originalHTML = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

        setTimeout(() => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalHTML;
        }, 5000);
      }
    });
  }

  // Initialize on page load
  document.addEventListener('DOMContentLoaded', function() {
    handleDiscountTypeChange();
  });
</script>