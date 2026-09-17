<style>
/* Celebratory Success Circle & Pulse */
.success-icon-wrap {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: #ffffff;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 2.8rem;
  box-shadow: 0 0 30px rgba(16, 185, 129, 0.4);
  animation: srlPulse 2s infinite;
}

@keyframes srlPulse {
  0% {
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6);
  }
  70% {
    box-shadow: 0 0 0 20px rgba(16, 185, 129, 0);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
  }
}

.order-info-pill {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 14px 18px;
}
</style>

<div class="container py-4 py-md-5">
  <!-- Celebratory Hero Card -->
  <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 text-center mb-4 overflow-hidden position-relative" style="background: linear-gradient(180deg, #ffffff 0%, #fdf9fb 100%); border: 1px solid rgba(225, 29, 116, 0.15) !important;">
    <div class="mb-3">
      <div class="success-icon-wrap">
        <i class="bi bi-check-lg"></i>
      </div>
    </div>

    <span class="badge rounded-pill px-3 py-1 mb-2" style="background: rgba(16, 185, 129, 0.12); color: #059669; font-weight: 700; font-size: 0.8rem;">
      <i class="bi bi-patch-check-fill me-1"></i>ORDER CONFIRMED & REGISTERED
    </span>

    <h2 class="fw-extrabold text-dark mb-2">Thank You! Your Order Has Been Placed</h2>
    <p class="text-muted mx-auto mb-4" style="max-width: 580px; font-size: 1.05rem; line-height: 1.6;">
      We've received your order <strong class="text-dark">#<?= html_escape($order->order_number) ?></strong>. Our dispatch team is preparing your addressable pixel LED products with genuine quality testing.
    </p>

    <!-- Prominent Action Buttons Bar (Invoice Download + Tracking) -->
    <div class="d-flex justify-content-center align-items-center flex-wrap gap-3 mb-4">
      <!-- Download Tax Invoice / Bill Button -->
      <a href="<?= base_url('order/invoice/' . $order->id) ?>" target="_blank" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
        <i class="bi bi-file-earmark-arrow-down-fill text-danger" style="color: var(--srl-pink) !important; font-size: 1.1rem;"></i>
        Download Bill / Invoice (PDF)
      </a>

      <!-- View & Track in Profile Button -->
      <a href="<?= base_url('profile/order/' . $order->id) ?>" class="btn-srl-primary rounded-pill px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2">
        <i class="bi bi-geo-alt-fill"></i>Track Order Status
      </a>
    </div>

    <!-- Order Metadata Pill Strip -->
    <div class="row g-3 text-start justify-content-center" style="max-width: 900px; margin: 0 auto;">
      <div class="col-sm-6 col-md-3">
        <div class="order-info-pill h-100">
          <small class="text-muted d-block" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Order Reference</small>
          <strong class="text-dark fs-6 text-break">#<?= html_escape($order->order_number) ?></strong>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="order-info-pill h-100">
          <small class="text-muted d-block" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Order Date</small>
          <strong class="text-dark fs-6"><?= date('d M Y, h:i A', strtotime($order->created_at)) ?></strong>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="order-info-pill h-100">
          <small class="text-muted d-block" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Payment Method</small>
          <div class="d-flex align-items-center gap-1">
            <strong class="text-dark fs-6"><?= html_escape($order->payment_method) ?></strong>
          </div>
          <span class="badge bg-<?= ($order->payment_status === 'Paid') ? 'success' : 'warning text-dark' ?> px-2 py-0" style="font-size: 0.68rem;">
            <?= html_escape($order->payment_status) ?>
          </span>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="order-info-pill h-100">
          <small class="text-muted d-block" style="font-size: 0.72rem; text-transform: uppercase; font-weight: 700;">Est. Delivery</small>
          <strong class="text-success fs-6"><?= date('d M', strtotime('+3 days')) ?> - <?= date('d M Y', strtotime('+5 days')) ?></strong>
          <small class="text-muted d-block" style="font-size: 0.7rem;">Free Express Shipping</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Detailed Breakdown Columns -->
  <div class="row g-4">
    <!-- Left Column: Purchased Items Summary -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
          <h5 class="fw-bold text-dark mb-0">
            <i class="bi bi-box-seam text-primary me-2"></i>Ordered Items (<?= count($items) ?>)
          </h5>
          <span class="badge bg-light text-muted border">INR (₹)</span>
        </div>

        <div class="d-flex flex-column gap-3">
          <?php foreach ($items as $it): ?>
            <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between flex-wrap gap-3 bg-white">
              <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center border shadow-2xs" style="width: 64px; height: 64px; background: #0d1017;">
                  <?php if (!empty($it->product_image) && file_exists('./uploads/products/' . $it->product_image)): ?>
                    <img src="<?= base_url('uploads/products/' . $it->product_image) ?>" alt="<?= html_escape($it->product_name) ?>" class="w-100 h-100 object-fit-cover">
                  <?php else: ?>
                    <i class="bi bi-image text-muted fs-4"></i>
                  <?php endif; ?>
                </div>
                <div>
                  <h6 class="fw-bold text-dark mb-1 small"><?= html_escape($it->product_name) ?></h6>
                  <?php if (!empty($it->sku)): ?>
                    <span class="badge bg-light text-secondary border mb-1" style="font-size: 0.68rem;">SKU: <?= html_escape($it->sku) ?></span>
                  <?php endif; ?>
                  <div class="text-muted small">
                    Unit Price: ₹<?= number_format($it->unit_price, 2) ?> × <strong><?= $it->quantity ?></strong>
                  </div>
                </div>
              </div>

              <div class="text-end">
                <span class="fw-extrabold fs-6" style="color: var(--srl-pink);">
                  ₹<?= number_format($it->line_total, 2) ?>
                </span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <?php if (!empty($order->notes)): ?>
          <div class="mt-3 p-3 rounded-3 bg-light border small text-muted">
            <strong class="text-dark d-block mb-1"><i class="bi bi-journal-text me-1"></i>Delivery Notes:</strong>
            <?= nl2br(html_escape($order->notes)) ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- What Happens Next Guide -->
      <div class="card border-0 shadow-sm rounded-4 p-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-lightning-charge-fill me-2" style="color: var(--srl-pink);"></i>What Happens Next?</h6>
        <div class="row g-3">
          <div class="col-md-4">
            <div class="d-flex align-items-start gap-2">
              <span class="badge rounded-circle bg-dark text-white p-2" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">1</span>
              <div>
                <strong class="small text-dark d-block">Quality Testing</strong>
                <small class="text-muted">LED modules and power circuitry are bench tested for optimal luminance.</small>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex align-items-start gap-2">
              <span class="badge rounded-circle bg-dark text-white p-2" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">2</span>
              <div>
                <strong class="small text-dark d-block">Express Dispatch</strong>
                <small class="text-muted">Packed in anti-static cushioned packaging and handed to express couriers.</small>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex align-items-start gap-2">
              <span class="badge rounded-circle bg-dark text-white p-2" style="width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center;">3</span>
              <div>
                <strong class="small text-dark d-block">Doorstep Delivery</strong>
                <small class="text-muted">Delivered to your selected shipping address with real-time tracking.</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Delivery Address & Summary -->
    <div class="col-lg-4">
      <div class="d-flex flex-column gap-4">
        <!-- Delivery Address Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
            <i class="bi bi-geo-alt-fill me-2" style="color: var(--srl-pink);"></i>Delivery Address
          </h6>
          <div class="fw-bold text-dark mb-1"><?= html_escape($order->shipping_full_name) ?></div>
          <div class="text-muted small mb-2"><i class="bi bi-telephone me-1"></i><?= html_escape($order->shipping_mobile) ?></div>
          <p class="text-secondary small mb-0" style="line-height: 1.5;">
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

        <!-- Payment & Total Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
            <i class="bi bi-receipt me-2 text-primary"></i>Financial Summary
          </h6>

          <div class="d-flex justify-content-between align-items-center mb-2 text-secondary small">
            <span>Items Subtotal:</span>
            <strong class="text-dark">₹<?= number_format($order->subtotal, 2) ?></strong>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-2 small">
            <span class="text-secondary">Delivery Charges:</span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">FREE</span>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3 small">
            <span class="text-secondary">Payment Method:</span>
            <strong class="text-dark"><?= html_escape($order->payment_method) ?></strong>
          </div>

          <hr class="my-2" style="opacity: 0.1;">

          <div class="d-flex justify-content-between align-items-baseline mb-4">
            <span class="fw-bold text-dark fs-6">Grand Total:</span>
            <span class="fw-extrabold fs-4" style="color: var(--srl-pink);">
              ₹<?= number_format($order->total_amount, 2) ?>
            </span>
          </div>

          <!-- Action Buttons -->
          <div class="d-flex flex-column gap-2">
            <a href="<?= base_url('order/invoice/' . $order->id) ?>" target="_blank" class="btn btn-outline-dark rounded-pill px-4 py-2 w-100 text-center fw-bold">
              <i class="bi bi-printer me-2"></i>Print / Download Bill
            </a>
            <a href="<?= base_url('products') ?>" class="btn-srl-primary rounded-pill px-4 py-2 w-100 justify-content-center">
              <i class="bi bi-bag-plus me-1"></i>Continue Shopping
            </a>
          </div>
        </div>

        <!-- Support Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-light border text-center">
          <i class="bi bi-headset fs-2 text-muted mb-2"></i>
          <h6 class="fw-bold text-dark mb-1">Need Help With Your Order?</h6>
          <p class="text-muted small mb-2">Our customer support engineers are available Monday to Saturday (9:30 AM - 7:30 PM).</p>
          <div class="d-flex justify-content-center gap-2">
            <a href="tel:+919099780463" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
              <i class="bi bi-telephone me-1"></i>Call Support
            </a>
            <a href="https://wa.me/919099780463" target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
              <i class="bi bi-whatsapp me-1"></i>WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
