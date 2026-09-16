<div class="container-fluid px-3 px-md-4 py-4">
  <!-- Top Breadcrumb & Actions -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
          <i class="bi bi-arrow-left me-1"></i>Back to Orders
        </a>
        <span class="text-muted">/</span>
        <span class="fw-bold text-dark fs-5">Order #<?= html_escape($order->order_number) ?></span>
      </div>
      <p class="text-muted small mb-0">Placed on <?= date('d M Y, h:i A', strtotime($order->created_at)) ?></p>
    </div>

    <div class="d-flex align-items-center gap-2">
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
      ?>
      <span class="order-status-badge <?= $status_class ?> fs-6 py-2 px-3" id="currentStatusBadge">
        <i class="<?= $status_icon ?>" id="currentStatusIcon"></i> <span id="currentStatusText"><?= html_escape($order->order_status) ?></span>
      </span>
    </div>
  </div>

  <div class="row g-4">
    <!-- Left Column: Ordered Items & Timeline -->
    <div class="col-lg-8">
      <!-- Products List Card -->
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="border: 1px solid #e2e8f0 !important;">
        <div class="card-header bg-white border-bottom p-3 p-md-4 d-flex justify-content-between align-items-center">
          <h5 class="fw-bold text-dark mb-0">Ordered Items (<?= count($items) ?>)</h5>
          <span class="badge bg-light text-dark border">Currency: INR (₹)</span>
        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="table-light text-uppercase small" style="font-size: 0.76rem;">
              <tr>
                <th>Product</th>
                <th>SKU</th>
                <th class="text-end">Unit Price</th>
                <th class="text-center">Quantity</th>
                <th class="text-end">Line Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-3">
                      <?php if (!empty($item->product_image) && file_exists('./uploads/products/' . $item->product_image)): ?>
                        <img src="<?= base_url('uploads/products/' . $item->product_image) ?>" alt="<?= html_escape($item->product_name) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; background: #0d1017;">
                      <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted rounded-2" style="width: 50px; height: 50px;">
                          <i class="bi bi-image fs-5"></i>
                        </div>
                      <?php endif; ?>
                      <div class="fw-semibold text-dark"><?= html_escape($item->product_name) ?></div>
                    </div>
                  </td>
                  <td class="text-muted small"><?= !empty($item->sku) ? html_escape($item->sku) : '—' ?></td>
                  <td class="text-end fw-semibold text-dark">₹<?= number_format($item->unit_price, 2) ?></td>
                  <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1">× <?= (int)$item->quantity ?></span></td>
                  <td class="text-end fw-bold text-dark">₹<?= number_format($item->line_total, 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot class="table-light">
              <tr>
                <td colspan="4" class="text-end fw-semibold text-muted">Subtotal:</td>
                <td class="text-end fw-bold text-dark">₹<?= number_format($order->subtotal, 2) ?></td>
              </tr>
              <tr>
                <td colspan="4" class="text-end fw-semibold text-muted">Shipping Charges:</td>
                <td class="text-end text-success fw-bold">FREE</td>
              </tr>
              <tr>
                <td colspan="4" class="text-end fw-extrabold text-dark fs-6">Grand Total:</td>
                <td class="text-end fw-extrabold fs-5" style="color: var(--srl-pink);">
                  ₹<?= number_format($order->total_amount, 2) ?>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- Notes / Internal Log Card -->
      <?php if (!empty($order->notes)): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <h6 class="fw-bold text-dark mb-2"><i class="bi bi-journal-text me-2 text-primary"></i>Customer / Order Notes</h6>
          <p class="text-secondary small mb-0"><?= nl2br(html_escape($order->notes)) ?></p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Right Column: Status Updater & Customer Shipping -->
    <div class="col-lg-4">
      <!-- Status Updater Widget -->
      <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-sliders me-2 text-danger" style="color: var(--srl-pink) !important;"></i>Update Order Status</h6>
        <p class="text-muted small mb-3">Changing status here immediately updates customer tracking in real time.</p>

        <?= form_open('admin/orders/update_status', ['id' => 'statusUpdateForm']) ?>
          <input type="hidden" name="order_id" value="<?= $order->id ?>">

          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary">Order Status</label>
            <select name="status" id="orderStatusSelect" class="form-select" required>
              <?php
                $statuses = ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'];
                foreach ($statuses as $st):
              ?>
                <option value="<?= $st ?>" <?= ($order->order_status === $st) ? 'selected' : '' ?>>
                  <?= $st ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold text-secondary">Admin Remarks / Notes (Optional)</label>
            <textarea name="notes" rows="2" class="form-control small" placeholder="e.g. Courier tracking code or update reason"><?= html_escape($order->notes) ?></textarea>
          </div>

          <button type="submit" class="btn-srl-primary w-100 py-2 justify-content-center" id="btnUpdateStatus">
            <i class="bi bi-check2-circle me-1"></i>Save Status Update
          </button>
        <?= form_close() ?>
      </div>

      <!-- Customer Details Card -->
      <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-badge me-2 text-primary"></i>Customer Profile</h6>
        <ul class="list-unstyled small mb-0">
          <li class="d-flex justify-content-between py-1 border-bottom">
            <span class="text-muted">Name:</span>
            <strong class="text-dark"><?= $customer ? html_escape($customer->name) : html_escape($order->shipping_full_name) ?></strong>
          </li>
          <li class="d-flex justify-content-between py-1 border-bottom">
            <span class="text-muted">Email:</span>
            <span class="text-dark text-break"><?= $customer ? html_escape($customer->email) : 'N/A' ?></span>
          </li>
          <li class="d-flex justify-content-between py-1 border-bottom">
            <span class="text-muted">Mobile:</span>
            <span class="text-dark"><?= html_escape($order->shipping_mobile) ?></span>
          </li>
          <?php if ($customer && !empty($customer->shop_name)): ?>
            <li class="d-flex justify-content-between py-1 border-bottom">
              <span class="text-muted">Shop:</span>
              <span class="text-dark"><?= html_escape($customer->shop_name) ?></span>
            </li>
          <?php endif; ?>
          <?php if ($customer && !empty($customer->gst_number)): ?>
            <li class="d-flex justify-content-between py-1">
              <span class="text-muted">GST:</span>
              <span class="badge bg-light text-dark border"><?= html_escape($customer->gst_number) ?></span>
            </li>
          <?php endif; ?>
        </ul>
      </div>

      <!-- Shipping Address Card -->
      <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill me-2 text-danger" style="color: var(--srl-pink) !important;"></i>Shipping Address</h6>
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

      <!-- Payment Summary Card -->
      <div class="card border-0 shadow-sm rounded-4 p-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-credit-card me-2 text-success"></i>Payment Info</h6>
        <div class="d-flex justify-content-between align-items-center mb-2 small">
          <span class="text-muted">Method:</span>
          <span class="badge bg-light text-dark border"><?= html_escape($order->payment_method) ?></span>
        </div>
        <div class="d-flex justify-content-between align-items-center small">
          <span class="text-muted">Status:</span>
          <span class="badge bg-<?= ($order->payment_status === 'Paid') ? 'success' : 'warning text-dark' ?>">
            <?= html_escape($order->payment_status) ?>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('statusUpdateForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const submitBtn = document.getElementById('btnUpdateStatus');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

      const formData = new FormData(this);

      fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(res => res.json())
        .then(data => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<i class="bi bi-check2-circle me-1"></i>Save Status Update';

          if (data.success) {
            Swal.fire({
              title: 'Status Updated!',
              text: data.message,
              icon: 'success',
              confirmButtonText: 'OK',
              customClass: {
                popup: 'srl-swal-popup',
                title: 'srl-swal-title',
                confirmButton: 'srl-swal-confirm'
              },
              buttonsStyling: false
            });

            // Update badge dynamically on screen
            const textEl = document.getElementById('currentStatusText');
            const badgeEl = document.getElementById('currentStatusBadge');
            const iconEl = document.getElementById('currentStatusIcon');

            if (textEl) textEl.textContent = data.status;

            // Remove all status classes and apply new one
            if (badgeEl) {
              badgeEl.className = 'order-status-badge fs-6 py-2 px-3';
              let sClass = 'status-badge-placed';
              let sIcon = 'bi bi-receipt';

              switch (data.status) {
                case 'Awaiting Payment':
                  sClass = 'status-badge-awaiting-payment'; sIcon = 'bi bi-clock-history'; break;
                case 'Placed':
                  sClass = 'status-badge-placed'; sIcon = 'bi bi-receipt'; break;
                case 'Confirmed':
                  sClass = 'status-badge-confirmed'; sIcon = 'bi bi-check-circle'; break;
                case 'Packed':
                  sClass = 'status-badge-packed'; sIcon = 'bi bi-box-seam'; break;
                case 'Out for Delivery':
                  sClass = 'status-badge-out-for-delivery'; sIcon = 'bi bi-truck'; break;
                case 'Delivered':
                  sClass = 'status-badge-delivered'; sIcon = 'bi bi-check-circle-fill'; break;
                case 'Cancelled':
                  sClass = 'status-badge-cancelled'; sIcon = 'bi bi-x-circle'; break;
              }
              badgeEl.classList.add(sClass);
              if (iconEl) iconEl.className = sIcon;
            }
          } else {
            Swal.fire('Error', data.message || 'Failed to update order status.', 'error');
          }
        })
        .catch(err => {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<i class="bi bi-check2-circle me-1"></i>Save Status Update';
          Swal.fire('Error', 'An unexpected error occurred.', 'error');
        });
    });
  }
});
</script>
