<style>
/* Order Timeline Tracker */
.order-tracker-wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
  margin: 30px 0 20px;
}
.order-tracker-wrap::before {
  content: '';
  position: absolute;
  top: 24px;
  left: 30px;
  right: 30px;
  height: 4px;
  background: #242c3d;
  z-index: 1;
}
.order-tracker-step {
  position: relative;
  z-index: 2;
  text-align: center;
  flex: 1;
}
.tracker-circle {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background: #141720;
  border: 3px solid #334155;
  color: #64748b;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 1.15rem;
  transition: all 0.3s ease;
}
.tracker-label {
  font-size: 0.78rem;
  font-weight: 600;
  margin-top: 8px;
  color: #64748b;
}
.order-tracker-step.completed .tracker-circle {
  background: var(--srl-pink-gradient);
  border-color: var(--srl-pink-glow);
  color: #ffffff;
  box-shadow: 0 0 16px rgba(225, 29, 116, 0.6);
}
.order-tracker-step.completed .tracker-label {
  color: #ffffff;
}
.order-tracker-step.active .tracker-circle {
  background: #ffffff;
  border-color: var(--srl-pink);
  color: var(--srl-pink);
  box-shadow: 0 0 20px rgba(225, 29, 116, 0.8);
}
.order-tracker-step.active .tracker-label {
  color: var(--srl-pink-glow);
  font-weight: 700;
}

@media (max-width: 576px) {
  .order-tracker-wrap {
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    padding-left: 20px;
  }
  .order-tracker-wrap::before {
    top: 0;
    bottom: 0;
    left: 42px;
    width: 4px;
    height: auto;
    right: auto;
  }
  .order-tracker-step {
    display: flex;
    align-items: center;
    gap: 15px;
    text-align: left;
    flex: none;
    width: 100%;
  }
  .tracker-label {
    margin-top: 0;
  }
}
</style>

<div class="container my-4 my-md-5">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Home</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none text-muted">My Account</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard?tab=orders') ?>" class="text-decoration-none text-muted">Orders</a></li>
      <li class="breadcrumb-item active text-light" aria-current="page">#<?= html_escape($order->order_number) ?></li>
    </ol>
  </nav>

  <?php
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

    // Step ranks for order timeline
    $step_ranks = [
      'Placed'           => 1,
      'Confirmed'        => 2,
      'Packed'           => 3,
      'Out for Delivery' => 4,
      'Delivered'        => 5
    ];
    $current_rank = isset($step_ranks[$order->order_status]) ? $step_ranks[$order->order_status] : 1;
  ?>

  <!-- Order Header Card -->
  <div class="card border-0 shadow-sm rounded-4 mb-4 text-white overflow-hidden" style="background: #141720; border: 1px solid rgba(255, 255, 255, 0.08) !important;">
    <div class="card-body p-4 p-md-5">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
        <div>
          <span class="badge px-3 py-1 mb-2" style="background: rgba(255, 42, 133, 0.15); color: var(--srl-pink-glow); font-size: 0.75rem; font-weight: 700;">
            ORDER INVOICE
          </span>
          <h2 class="fw-bold mb-1">Order #<?= html_escape($order->order_number) ?></h2>
          <div class="text-secondary small">
            Placed on <?= date('d M Y, h:i A', strtotime($order->created_at)) ?>
          </div>
        </div>

        <div class="d-flex align-items-center gap-2">
          <span class="order-status-badge <?= $status_class ?> fs-6 py-2 px-4 shadow-sm">
            <i class="<?= $status_icon ?>"></i> <?= html_escape($order->order_status) ?>
          </span>
        </div>
      </div>

      <!-- Live Order Progress Tracker -->
      <?php if ($order->order_status === 'Cancelled'): ?>
        <div class="alert alert-danger rounded-4 p-4 border-0 d-flex align-items-center gap-3 mb-4" style="background: rgba(239, 68, 68, 0.12); color: #fca5a5;">
          <i class="bi bi-x-circle-fill fs-1 text-danger"></i>
          <div>
            <h5 class="fw-bold mb-1 text-white">This Order Has Been Cancelled</h5>
            <p class="mb-0 small text-secondary">
              If you have any questions or require assistance regarding this cancellation, please contact our support team.
            </p>
          </div>
        </div>
      <?php else: ?>
        <div class="card p-3 p-md-4 rounded-4 mb-4" style="background: #0d1017; border: 1px solid #242c3d;">
          <div class="small fw-bold text-uppercase text-secondary mb-2" style="letter-spacing: 0.8px;">
            <i class="bi bi-geo-fill me-1" style="color: var(--srl-pink);"></i>Delivery Status Tracker
          </div>

          <div class="order-tracker-wrap">
            <!-- Step 1: Placed -->
            <div class="order-tracker-step <?= ($current_rank >= 1) ? (($current_rank == 1) ? 'active' : 'completed') : '' ?>">
              <div class="tracker-circle">
                <i class="bi bi-receipt"></i>
              </div>
              <div class="tracker-label">Order Placed</div>
            </div>

            <!-- Step 2: Confirmed -->
            <div class="order-tracker-step <?= ($current_rank >= 2) ? (($current_rank == 2) ? 'active' : 'completed') : '' ?>">
              <div class="tracker-circle">
                <i class="bi bi-check-circle"></i>
              </div>
              <div class="tracker-label">Confirmed</div>
            </div>

            <!-- Step 3: Packed -->
            <div class="order-tracker-step <?= ($current_rank >= 3) ? (($current_rank == 3) ? 'active' : 'completed') : '' ?>">
              <div class="tracker-circle">
                <i class="bi bi-box-seam"></i>
              </div>
              <div class="tracker-label">Packed</div>
            </div>

            <!-- Step 4: Out for Delivery -->
            <div class="order-tracker-step <?= ($current_rank >= 4) ? (($current_rank == 4) ? 'active' : 'completed') : '' ?>">
              <div class="tracker-circle">
                <i class="bi bi-truck"></i>
              </div>
              <div class="tracker-label">Out for Delivery</div>
            </div>

            <!-- Step 5: Delivered -->
            <div class="order-tracker-step <?= ($current_rank >= 5) ? 'active completed' : '' ?>">
              <div class="tracker-circle">
                <i class="bi bi-check-circle-fill"></i>
              </div>
              <div class="tracker-label">Delivered</div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="row g-4">
        <!-- Order Items List -->
        <div class="col-lg-8">
          <div class="card p-4 rounded-4 h-100" style="background: #0d1017; border: 1px solid #242c3d;">
            <h5 class="fw-bold text-white mb-3">Purchased Items (<?= count($items) ?>)</h5>

            <div class="d-flex flex-column gap-3">
              <?php foreach ($items as $item): ?>
                <div class="p-3 rounded-3 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: #141720; border: 1px solid rgba(255,255,255,0.05);">
                  <div class="d-flex align-items-center gap-3">
                    <?php if (!empty($item->product_image) && file_exists('./uploads/products/' . $item->product_image)): ?>
                      <img src="<?= base_url('uploads/products/' . $item->product_image) ?>" alt="<?= html_escape($item->product_name) ?>" style="width: 64px; height: 64px; object-fit: cover; border-radius: 10px; background: #0d1017;">
                    <?php else: ?>
                      <div class="d-flex align-items-center justify-content-center text-muted rounded-3" style="width: 64px; height: 64px; background: #232a3b;">
                        <i class="bi bi-image fs-4"></i>
                      </div>
                    <?php endif; ?>
                    <div>
                      <h6 class="fw-bold text-white mb-1"><?= html_escape($item->product_name) ?></h6>
                      <?php if (!empty($item->sku)): ?>
                        <span class="text-secondary small d-block">SKU: <?= html_escape($item->sku) ?></span>
                      <?php endif; ?>
                      <span class="text-muted small">Qty: <?= (int)$item->quantity ?> × ₹<?= number_format($item->unit_price, 2) ?></span>
                    </div>
                  </div>

                  <div class="text-end">
                    <div class="fw-bold fs-6" style="color: var(--srl-pink-glow);">
                      ₹<?= number_format($item->line_total, 2) ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <!-- Shipping & Payment Breakdown -->
        <div class="col-lg-4">
          <div class="d-flex flex-column gap-4">
            <!-- Delivery Address Card -->
            <div class="card p-4 rounded-4" style="background: #0d1017; border: 1px solid #242c3d;">
              <h6 class="fw-bold text-white mb-3"><i class="bi bi-geo-alt-fill me-2" style="color: var(--srl-pink);"></i>Delivery Address</h6>
              <div class="fw-bold text-white mb-1"><?= html_escape($order->shipping_full_name) ?></div>
              <div class="text-secondary small mb-2"><i class="bi bi-telephone me-1"></i><?= html_escape($order->shipping_mobile) ?></div>
              <p class="text-light small mb-0" style="line-height: 1.5;">
                <?= html_escape($order->shipping_address_line1) ?><br>
                <?php if (!empty($order->shipping_address_line2)): ?>
                  <?= html_escape($order->shipping_address_line2) ?><br>
                <?php endif; ?>
                <?php if (!empty($order->shipping_landmark)): ?>
                  Landmark: <?= html_escape($order->shipping_landmark) ?><br>
                <?php endif; ?>
                <?= html_escape($order->shipping_city) ?>, <?= html_escape($order->shipping_state) ?> - <strong><?= html_escape($order->shipping_pincode) ?></strong><br>
                <?= html_escape($order->shipping_country) ?>
              </p>
            </div>

            <!-- Financial Summary Card -->
            <div class="card p-4 rounded-4" style="background: #0d1017; border: 1px solid #242c3d;">
              <h6 class="fw-bold text-white mb-3"><i class="bi bi-cash-stack me-2" style="color: var(--srl-pink);"></i>Payment & Summary</h6>

              <ul class="list-unstyled small mb-3">
                <li class="d-flex justify-content-between py-1 text-secondary">
                  <span>Payment Method:</span>
                  <strong class="text-white"><?= html_escape($order->payment_method) ?></strong>
                </li>
                <li class="d-flex justify-content-between py-1 text-secondary">
                  <span>Payment Status:</span>
                  <span class="badge bg-secondary rounded-pill"><?= html_escape($order->payment_status) ?></span>
                </li>
                <li class="d-flex justify-content-between py-1 text-secondary">
                  <span>Items Subtotal:</span>
                  <strong class="text-white">₹<?= number_format($order->subtotal, 2) ?></strong>
                </li>
                <li class="d-flex justify-content-between py-1 text-secondary">
                  <span>Delivery Charges:</span>
                  <span class="text-success fw-bold">FREE</span>
                </li>
              </ul>

              <hr class="border-secondary border-opacity-25 my-2">

              <div class="d-flex justify-content-between align-items-baseline mb-4">
                <span class="fw-bold text-white fs-6">Grand Total:</span>
                <span class="fw-extrabold fs-4" style="color: var(--srl-pink-glow);">
                  ₹<?= number_format($order->total_amount, 2) ?>
                </span>
              </div>

              <div class="d-flex flex-column gap-2">
                <a href="<?= base_url('dashboard?tab=orders') ?>" class="btn btn-outline-light rounded-pill px-4 py-2 w-100">
                  <i class="bi bi-arrow-left me-1"></i>Back to My Orders
                </a>
                <a href="<?= base_url('products') ?>" class="btn-srl-primary rounded-pill px-4 py-2 w-100 justify-content-center">
                  <i class="bi bi-bag-plus me-1"></i>Continue Shopping
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
