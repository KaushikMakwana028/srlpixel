<style>
/* ============================================================
   SRL PIXEL - ORDER DETAIL PAGE REDESIGN
   ============================================================ */

.order-detail-card {
  background: #ffffff;
  border-radius: 18px;
  border: 1px solid var(--srl-border);
  box-shadow: 0 2px 14px rgba(0, 0, 0, 0.03);
  padding: 24px 28px;
  margin-bottom: 24px;
}

/* Status Badges */
.order-status-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 0.76rem;
  font-weight: 700;
  padding: 4px 12px;
  border-radius: 50px;
  letter-spacing: 0.3px;
  white-space: nowrap;
}

.status-badge-awaiting-payment { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.status-badge-placed           { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.status-badge-confirmed        { background: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe; }
.status-badge-packed           { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }
.status-badge-out-for-delivery { background: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }
.status-badge-delivered        { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.status-badge-cancelled        { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

/* Delivery Status Stepper Tracker */
.tracker-container {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 18px 22px;
  margin-bottom: 24px;
}

.tracker-header-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 8px;
  padding-bottom: 14px;
  margin-bottom: 16px;
  border-bottom: 1px solid #eef2f6;
}

.order-stepper-wrap {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  position: relative;
  width: 100%;
}

.stepper-progress-bg {
  position: absolute;
  top: 17px;
  left: 10%;
  right: 10%;
  height: 4px;
  background: #e2e8f0;
  z-index: 1;
  border-radius: 3px;
}

.stepper-progress-fill {
  position: absolute;
  top: 17px;
  left: 10%;
  height: 4px;
  background: var(--srl-pink-gradient);
  z-index: 2;
  border-radius: 3px;
  transition: width 0.4s ease;
}

.order-step-node {
  position: relative;
  z-index: 3;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  flex: 1 1 0;
  min-width: 0;
  padding: 0 2px;
}

.step-circle {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #ffffff;
  border: 2.5px solid #cbd5e1;
  color: #94a3b8;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  font-weight: 700;
  transition: all 0.25s ease;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

.order-step-node.completed .step-circle {
  background: var(--srl-pink-gradient);
  border-color: var(--srl-pink);
  color: #ffffff;
  box-shadow: 0 2px 10px rgba(225, 29, 116, 0.35);
}

.order-step-node.active .step-circle {
  background: #ffffff;
  border-color: var(--srl-pink);
  color: var(--srl-pink);
  box-shadow: 0 0 0 4px rgba(225, 29, 116, 0.18);
}

.step-label {
  font-size: 0.74rem;
  font-weight: 600;
  color: #64748b;
  margin-top: 8px;
  line-height: 1.25;
  text-align: center;
  width: 100%;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
}

.order-step-node.completed .step-label {
  color: #0f172a;
  font-weight: 700;
}

.order-step-node.active .step-label {
  color: var(--srl-pink);
  font-weight: 800;
}

/* Side Info Cards */
.side-info-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
  word-break: break-word;
}

.side-info-title {
  font-size: 0.88rem;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 14px;
  display: flex;
  align-items: center;
  gap: 8px;
}

/* Purchased Item Card */
.purchased-item-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 14px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
  margin-bottom: 10px;
  transition: all 0.2s ease;
  width: 100%;
  box-sizing: border-box;
}

.purchased-item-card:last-child {
  margin-bottom: 0;
}

.purchased-item-card:hover {
  border-color: #cbd5e1;
  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
}

.purchased-item-thumb {
  width: 58px;
  height: 58px;
  border-radius: 12px;
  overflow: hidden;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.purchased-item-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.purchased-item-content {
  flex: 1 1 0;
  min-width: 0;
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 12px;
}

.purchased-item-info {
  flex: 1 1 0;
  min-width: 0;
}

.purchased-item-name {
  font-size: 0.9rem;
  font-weight: 700;
  color: #0f172a;
  line-height: 1.35;
  margin-bottom: 5px;
  word-break: break-word;
  overflow-wrap: break-word;
}

.purchased-item-meta {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 6px;
  font-size: 0.74rem;
}

.purchased-item-price {
  text-align: right;
  flex-shrink: 0;
}

.item-subtotal-val {
  font-size: 1rem;
  font-weight: 800;
  color: var(--srl-pink);
  line-height: 1.2;
}

.item-subtotal-lbl {
  font-size: 0.68rem;
  color: #64748b;
  margin-top: 2px;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
  .order-detail-card {
    padding: 14px 12px;
    border-radius: 14px;
  }
  .side-info-card {
    padding: 14px 12px;
    border-radius: 14px;
  }
  .tracker-container {
    padding: 12px 10px;
    border-radius: 14px;
  }
  .stepper-progress-bg,
  .stepper-progress-fill {
    top: 13px;
    left: 10%;
    right: 10%;
    height: 3px;
  }
  .step-circle {
    width: 26px;
    height: 26px;
    font-size: 0.72rem;
    border-width: 2px;
  }
  .order-step-node {
    padding: 0 1px;
  }
  .step-label {
    font-size: 0.62rem;
    margin-top: 5px;
    letter-spacing: -0.2px;
  }
}

@media (max-width: 576px) {
  .purchased-item-card {
    padding: 12px 10px;
    gap: 10px;
    border-radius: 12px;
  }
  .purchased-item-thumb {
    width: 48px;
    height: 48px;
    border-radius: 10px;
  }
  .purchased-item-content {
    flex-direction: column;
    gap: 6px;
  }
  .purchased-item-name {
    font-size: 0.84rem;
    margin-bottom: 4px;
  }
  .purchased-item-meta {
    font-size: 0.72rem;
    gap: 6px;
  }
  .purchased-item-price {
    display: flex;
    align-items: baseline;
    gap: 6px;
    text-align: left;
    margin-top: 2px;
  }
  .item-subtotal-val {
    font-size: 0.92rem;
  }
  .item-subtotal-lbl {
    font-size: 0.7rem;
    margin-top: 0;
  }
}
</style>

<div class="container my-3 my-md-4">
  <!-- Breadcrumbs -->
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb small mb-0">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('profile') ?>" class="text-decoration-none text-muted">My Account</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('profile?tab=orders') ?>" class="text-decoration-none text-muted">Orders</a></li>
      <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">#<?= html_escape($order->order_number) ?></li>
    </ol>
  </nav>

  <?php
    // Status Badge mapping
    $status_class = 'status-badge-placed';
    $status_icon  = 'bi bi-receipt';

    switch ($order->order_status) {
      case 'Awaiting Payment':
        $status_class = 'status-badge-awaiting-payment';
        $status_icon  = 'bi bi-clock-history';
        break;
      case 'Placed':
        $status_class = 'status-badge-placed';
        $status_icon  = 'bi bi-receipt';
        break;
      case 'Confirmed':
        $status_class = 'status-badge-confirmed';
        $status_icon  = 'bi bi-check-circle';
        break;
      case 'Packed':
        $status_class = 'status-badge-packed';
        $status_icon  = 'bi bi-box-seam';
        break;
      case 'Out for Delivery':
        $status_class = 'status-badge-out-for-delivery';
        $status_icon  = 'bi bi-truck';
        break;
      case 'Delivered':
        $status_class = 'status-badge-delivered';
        $status_icon  = 'bi bi-check-circle-fill';
        break;
      case 'Cancelled':
        $status_class = 'status-badge-cancelled';
        $status_icon  = 'bi bi-x-circle';
        break;
    }

    // Step rank & progress fill percentage for timeline stepper
    $step_ranks = [
      'Awaiting Payment' => 1,
      'Placed'           => 1,
      'Confirmed'        => 2,
      'Packed'           => 3,
      'Out for Delivery' => 4,
      'Delivered'        => 5
    ];
    $current_rank = isset($step_ranks[$order->order_status]) ? $step_ranks[$order->order_status] : 1;

    $progress_fill_pct = 0;
    switch ($current_rank) {
      case 1: $progress_fill_pct = 0; break;
      case 2: $progress_fill_pct = 20; break;
      case 3: $progress_fill_pct = 40; break;
      case 4: $progress_fill_pct = 60; break;
      case 5: $progress_fill_pct = 80; break;
    }
  ?>

  <!-- Order Detail Main Wrapper Card -->
  <div class="order-detail-card">
    <!-- Header Block: Order ID, Date, Status & Top Action -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pb-3 mb-3 border-bottom">
      <div>
        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
          <h4 class="fw-extrabold text-dark mb-0 fs-5 fs-md-4">
            Order #<?= html_escape($order->order_number) ?>
          </h4>
          <span class="order-status-badge <?= $status_class ?>">
            <i class="<?= $status_icon ?>"></i> <?= html_escape($order->order_status) ?>
          </span>
        </div>
        <div class="text-muted small" style="font-size: 0.78rem;">
          Placed on <strong class="text-dark"><?= date('d M Y, h:i A', strtotime($order->created_at)) ?></strong>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a href="<?= base_url('order/invoice/' . $order->id) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.78rem;">
          <i class="bi bi-file-earmark-pdf text-danger"></i> Tax Invoice
        </a>
      </div>
    </div>

    <!-- Order Progress Stepper (Compact & Responsive on Mobile) -->
    <?php if ($order->order_status === 'Cancelled'): ?>
      <div class="alert alert-danger rounded-3 p-3 border-0 d-flex align-items-center gap-2 mb-3" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca !important;">
        <i class="bi bi-x-circle-fill fs-3 text-danger"></i>
        <div>
          <h6 class="fw-bold mb-0.5 text-danger">This Order Has Been Cancelled</h6>
          <p class="mb-0 small text-secondary" style="font-size: 0.76rem;">
            If you need help or have questions regarding cancellation, please contact our customer support.
          </p>
        </div>
      </div>
    <?php else: ?>
      <div class="tracker-container">
        <div class="tracker-header-row">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-truck text-pink fs-6"></i>
            <span class="fw-bold text-dark small" style="font-size: 0.82rem;">Delivery Progress</span>
          </div>
          <span class="text-muted small" style="font-size: 0.72rem;">
            Current Status: <strong style="color: var(--srl-pink);"><?= html_escape($order->order_status) ?></strong>
          </span>
        </div>

        <div class="order-stepper-wrap">
          <div class="stepper-progress-bg"></div>
          <div class="stepper-progress-fill" style="width: <?= $progress_fill_pct ?>%;"></div>

          <!-- Step 1: Placed -->
          <div class="order-step-node <?= ($current_rank >= 1) ? (($current_rank == 1) ? 'active' : 'completed') : '' ?>">
            <div class="step-circle">
              <?php if ($current_rank > 1): ?>
                <i class="bi bi-check-lg"></i>
              <?php else: ?>
                <i class="bi bi-receipt"></i>
              <?php endif; ?>
            </div>
            <div class="step-label">Placed</div>
          </div>

          <!-- Step 2: Confirmed -->
          <div class="order-step-node <?= ($current_rank >= 2) ? (($current_rank == 2) ? 'active' : 'completed') : '' ?>">
            <div class="step-circle">
              <?php if ($current_rank > 2): ?>
                <i class="bi bi-check-lg"></i>
              <?php else: ?>
                <i class="bi bi-check2"></i>
              <?php endif; ?>
            </div>
            <div class="step-label">Confirmed</div>
          </div>

          <!-- Step 3: Packed -->
          <div class="order-step-node <?= ($current_rank >= 3) ? (($current_rank == 3) ? 'active' : 'completed') : '' ?>">
            <div class="step-circle">
              <?php if ($current_rank > 3): ?>
                <i class="bi bi-check-lg"></i>
              <?php else: ?>
                <i class="bi bi-box-seam"></i>
              <?php endif; ?>
            </div>
            <div class="step-label">Packed</div>
          </div>

          <!-- Step 4: Shipped -->
          <div class="order-step-node <?= ($current_rank >= 4) ? (($current_rank == 4) ? 'active' : 'completed') : '' ?>">
            <div class="step-circle">
              <?php if ($current_rank > 4): ?>
                <i class="bi bi-check-lg"></i>
              <?php else: ?>
                <i class="bi bi-truck"></i>
              <?php endif; ?>
            </div>
            <div class="step-label">Shipped</div>
          </div>

          <!-- Step 5: Delivered -->
          <div class="order-step-node <?= ($current_rank >= 5) ? 'active completed' : '' ?>">
            <div class="step-circle">
              <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="step-label">Delivered</div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Two Column Grid: Items (Left) & Address + Summary (Right) -->
    <div class="row g-3 g-md-4">
      <!-- Left Column: Purchased Items -->
      <div class="col-lg-7">
        <div class="side-info-card h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="side-info-title mb-0">
              <i class="bi bi-bag-check text-pink"></i> Ordered Items (<?= count($items) ?>)
            </h6>
            <span class="text-muted small" style="font-size: 0.72rem;">Verified Purchase</span>
          </div>

          <div class="d-flex flex-column">
            <?php foreach ($items as $item): ?>
              <div class="purchased-item-card">
                <div class="purchased-item-thumb">
                  <?php if (!empty($item->product_image) && file_exists('./uploads/products/' . $item->product_image)): ?>
                    <img src="<?= base_url('uploads/products/' . $item->product_image) ?>" alt="<?= html_escape($item->product_name) ?>">
                  <?php else: ?>
                    <i class="bi bi-image text-muted fs-5"></i>
                  <?php endif; ?>
                </div>

                <div class="purchased-item-content">
                  <div class="purchased-item-info">
                    <h6 class="purchased-item-name">
                      <?= html_escape($item->product_name) ?>
                    </h6>
                    <div class="purchased-item-meta">
                      <?php if (!empty($item->sku)): ?>
                        <span class="badge bg-light text-secondary border px-1.5 py-0.5" style="font-size: 0.68rem;">SKU: <?= html_escape($item->sku) ?></span>
                      <?php endif; ?>
                      <span class="text-muted">
                        Qty: <strong class="text-dark"><?= (int)$item->quantity ?></strong> × ₹<?= number_format($item->unit_price, 2) ?>
                      </span>
                    </div>
                  </div>

                  <div class="purchased-item-price">
                    <div class="item-subtotal-val">
                      ₹<?= number_format($item->line_total, 2) ?>
                    </div>
                    <div class="item-subtotal-lbl">Subtotal</div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Right Column: Shipping Details & Summary Breakdown -->
      <div class="col-lg-5">
        <div class="d-flex flex-column gap-3">
          <!-- 1. Delivery Address Card -->
          <div class="side-info-card">
            <h6 class="side-info-title">
              <i class="bi bi-geo-alt-fill text-pink"></i> Delivery Address
            </h6>
            <div class="fw-bold text-dark" style="font-size: 0.88rem;"><?= html_escape($order->shipping_full_name) ?></div>
            <div class="text-muted small mb-2" style="font-size: 0.75rem;">
              <i class="bi bi-telephone text-pink me-1"></i><?= html_escape($order->shipping_mobile) ?>
            </div>
            <p class="text-secondary small mb-0" style="line-height: 1.5; font-size: 0.78rem;">
              <?= html_escape($order->shipping_address_line1) ?><br>
              <?php if (!empty($order->shipping_address_line2)): ?>
                <?= html_escape($order->shipping_address_line2) ?><br>
              <?php endif; ?>
              <?php if (!empty($order->shipping_landmark)): ?>
                <span class="text-muted">Landmark: <?= html_escape($order->shipping_landmark) ?></span><br>
              <?php endif; ?>
              <?= html_escape($order->shipping_city) ?>, <?= html_escape($order->shipping_state) ?> - <strong><?= html_escape($order->shipping_pincode) ?></strong><br>
              <?= html_escape($order->shipping_country) ?>
            </p>
          </div>

          <!-- 2. Payment & Financial Summary Card -->
          <div class="side-info-card">
            <h6 class="side-info-title">
              <i class="bi bi-credit-card text-pink"></i> Payment & Summary
            </h6>

            <ul class="list-unstyled small mb-3" style="font-size: 0.8rem;">
              <li class="d-flex justify-content-between py-1 text-secondary">
                <span>Payment Method:</span>
                <strong class="text-dark"><?= html_escape($order->payment_method) ?></strong>
              </li>
              <li class="d-flex justify-content-between py-1 text-secondary">
                <span>Payment Status:</span>
                <span class="badge <?= ($order->payment_status === 'Paid') ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' ?> px-2 py-0.5" style="font-size: 0.7rem;">
                  <?= html_escape($order->payment_status ?? 'Pending') ?>
                </span>
              </li>
              <li class="d-flex justify-content-between py-1 text-secondary">
                <span>Items Subtotal:</span>
                <strong class="text-dark">₹<?= number_format($order->subtotal, 2) ?></strong>
              </li>
              <li class="d-flex justify-content-between py-1 text-secondary">
                <span>Delivery Charges:</span>
                <span class="text-success fw-bold">FREE</span>
              </li>
            </ul>

            <hr class="my-2 border-secondary border-opacity-10">

            <div class="d-flex justify-content-between align-items-baseline mb-3">
              <span class="fw-bold text-dark fs-6">Grand Total:</span>
              <span class="fw-extrabold fs-5" style="color: var(--srl-pink);">
                ₹<?= number_format($order->total_amount, 2) ?>
              </span>
            </div>

            <!-- Balanced, Modern Action Buttons -->
            <a href="<?= base_url('order/invoice/' . $order->id) ?>" target="_blank" class="btn btn-outline-dark rounded-pill py-2 w-100 fw-bold d-inline-flex align-items-center justify-content-center gap-1.5 mb-2" style="font-size: 0.82rem;">
              <i class="bi bi-file-earmark-arrow-down text-pink fs-6"></i> Download Tax Invoice
            </a>

            <div class="d-flex gap-2 flex-wrap">
              <a href="<?= base_url('profile?tab=orders') ?>" class="btn btn-outline-secondary rounded-pill py-2 flex-grow-1 fw-semibold d-inline-flex align-items-center justify-content-center gap-1" style="font-size: 0.78rem; min-width: 120px;">
                <i class="bi bi-arrow-left"></i> My Orders
              </a>
              <a href="<?= base_url('products') ?>" class="btn btn-srl-primary rounded-pill py-2 flex-grow-1 fw-bold d-inline-flex align-items-center justify-content-center gap-1 shadow-sm" style="font-size: 0.78rem; min-width: 120px;">
                <i class="bi bi-bag-plus"></i> Shop More
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
