<div class="container-fluid px-3 px-md-4 py-4">
  <!-- Top Breadcrumb & Actions -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <a href="<?= base_url('admin/offline_orders') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
          <i class="bi bi-arrow-left me-1"></i>Back to Offline Orders
        </a>
        <span class="text-muted">/</span>
        <span class="fw-bold text-dark fs-5">Offline Order #<?= html_escape($order->order_number) ?></span>
        <span class="badge rounded-pill bg-pink-subtle text-pink border px-3 py-1" style="background: rgba(225, 29, 116, 0.1); color: var(--srl-pink); font-size: 0.72rem; font-weight: 700;">
          <i class="bi bi-shop me-1"></i>COUNTER SALE
        </span>
      </div>
      <p class="text-muted small mb-0">Created on <?= date('d M Y, h:i A', strtotime($order->created_at)) ?></p>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap">
      <a href="<?= base_url('admin/offline_orders/edit/' . $order->id) ?>" class="btn btn-outline-warning text-dark rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-pencil-square text-warning"></i>Edit Order
      </a>
      <a href="<?= base_url('admin/offline_orders/invoice/' . $order->id) ?>" target="_blank" class="btn btn-outline-dark rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-printer-fill text-pink" style="color: var(--srl-pink);"></i>Print Invoice
      </a>
      <button type="button" class="btn btn-outline-danger rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" onclick="deleteOfflineOrder(<?= $order->id ?>, '<?= html_escape($order->order_number) ?>')">
        <i class="bi bi-trash3"></i>Delete Order
      </button>
      <span class="order-status-badge status-badge-confirmed fs-6 py-2 px-3" id="currentStatusBadge">
        <i class="bi bi-check-circle" id="currentStatusIcon"></i> <span id="currentStatusText"><?= html_escape($order->order_status) ?></span>
      </span>
    </div>
  </div>

  <div class="row g-4">
    <!-- Left Column: Ordered Items & Notes -->
    <div class="col-lg-8">
      <!-- Products List Card -->
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
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
                        <img src="<?= base_url('uploads/products/' . $item->product_image) ?>" alt="<?= html_escape($item->product_name) ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; background: #0d1017;">
                      <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted rounded-2" style="width: 48px; height: 48px;">
                          <i class="bi bi-box-seam fs-5"></i>
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
            <tfoot class="border-top">
              <tr>
                <td colspan="4" class="text-end text-muted">Items Subtotal:</td>
                <td class="text-end fw-bold text-dark">₹<?= number_format($order->subtotal, 2) ?></td>
              </tr>
              <tr>
                <td colspan="4" class="text-end text-muted">Shipping Charges:</td>
                <td class="text-end text-dark">₹<?= number_format($order->shipping_fee, 2) ?></td>
              </tr>
              <tr class="bg-light">
                <td colspan="4" class="text-end fw-bold fs-6 text-dark">Grand Total:</td>
                <td class="text-end fw-extrabold fs-5" style="color: var(--srl-pink);">₹<?= number_format($order->total_amount, 2) ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <!-- Notes Card -->
      <?php if (!empty($order->notes)): ?>
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
          <h6 class="fw-bold text-dark mb-2"><i class="bi bi-chat-left-text me-2 text-pink"></i>Order Notes / Remarks</h6>
          <p class="text-secondary mb-0" style="white-space: pre-line; line-height: 1.5;"><?= html_escape($order->notes) ?></p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Right Column: Customer Details, Payment & Status Updater -->
    <div class="col-lg-4">
      <!-- Customer Information Card -->
      <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person me-2 text-pink"></i>Customer Details</h6>
        <div class="mb-3">
          <div class="fw-bold text-dark fs-6"><?= html_escape($order->shipping_full_name) ?></div>
          <div class="text-muted small"><i class="bi bi-telephone me-1"></i><?= html_escape($order->shipping_mobile) ?></div>
          <?php if ($customer && !empty($customer->email)): ?>
            <div class="text-muted small"><i class="bi bi-envelope me-1"></i><?= html_escape($customer->email) ?></div>
          <?php endif; ?>
        </div>

        <hr class="my-2" style="border-color: #f1f5f9;">

        <div class="small">
          <strong class="text-dark d-block mb-1">Delivery / Counter Address:</strong>
          <span class="text-secondary" style="line-height: 1.5;">
            <?= html_escape($order->shipping_address_line1) ?><br>
            <?php if (!empty($order->shipping_address_line2)): ?>
              <?= html_escape($order->shipping_address_line2) ?><br>
            <?php endif; ?>
            <?php if (!empty($order->shipping_landmark)): ?>
              <span class="text-muted">Landmark: <?= html_escape($order->shipping_landmark) ?></span><br>
            <?php endif; ?>
            <?= html_escape($order->shipping_city) ?>, <?= html_escape($order->shipping_state) ?> - <?= html_escape($order->shipping_pincode) ?><br>
            <?= html_escape($order->shipping_country) ?>
          </span>
        </div>
      </div>

      <!-- Payment Information & Quick Toggle Card -->
      <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="fw-bold text-dark mb-0"><i class="bi bi-credit-card me-2 text-pink"></i>Payment Status</h6>
          <span id="paymentStatusBadge">
            <?php if ($order->payment_status === 'Paid'): ?>
              <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1">
                <i class="bi bi-check-circle-fill me-1"></i>Paid
              </span>
            <?php else: ?>
              <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1">
                <i class="bi bi-clock-history me-1"></i>Pending
              </span>
            <?php endif; ?>
          </span>
        </div>

        <div class="mb-3">
          <div class="text-muted small mb-1">Payment Method:</div>
          <div class="fw-bold text-dark"><?= html_escape($order->payment_method) ?></div>
        </div>

        <div class="mb-3">
          <div class="text-muted small mb-1">Total Amount:</div>
          <div class="fw-extrabold fs-5 text-dark">₹<?= number_format($order->total_amount, 2) ?></div>
        </div>

        <!-- Payment Toggle Button (Admin changes status after customer pays) -->
        <button type="button" 
                id="btnTogglePayment"
                class="btn <?= ($order->payment_status === 'Paid') ? 'btn-outline-warning' : 'btn-success' ?> w-100 rounded-pill py-2 fw-bold"
                onclick="changePaymentStatus(<?= $order->id ?>, '<?= ($order->payment_status === 'Paid') ? 'Pending' : 'Paid' ?>')">
          <?php if ($order->payment_status === 'Paid'): ?>
            <i class="bi bi-arrow-counterclockwise me-1"></i>Change Back to Pending
          <?php else: ?>
            <i class="bi bi-check2-circle me-1"></i>Customer Paid: Mark as Paid
          <?php endif; ?>
        </button>
      </div>

      <!-- Order Fulfillment Status Updater Card -->
      <div class="card border-0 shadow-sm rounded-4 p-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-truck me-2 text-pink"></i>Update Order Status</h6>

        <?= form_open('admin/offline_orders/update_status', ['id' => 'statusUpdateForm']) ?>
          <input type="hidden" name="order_id" value="<?= $order->id ?>">

          <div class="mb-3">
            <label class="form-label small text-muted">Fulfillment Status:</label>
            <select name="status" id="statusSelect" class="form-select srl-filter-select">
              <?php foreach (['Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'] as $st): ?>
                <option value="<?= $st ?>" <?= ($order->order_status === $st) ? 'selected' : '' ?>>
                  <?= $st ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label small text-muted">Admin Notes (Optional):</label>
            <textarea name="notes" class="form-control form-control-sm" rows="2" placeholder="Update remarks..."><?= html_escape($order->notes) ?></textarea>
          </div>

          <button type="submit" class="btn btn-srl-primary w-100 rounded-pill py-2 fw-bold" id="btnUpdateStatus">
            <i class="bi bi-arrow-clockwise me-1"></i>Save Status Update
          </button>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>

<script>
function changePaymentStatus(orderId, newStatus) {
  const confirmText = (newStatus === 'Paid') 
    ? 'Mark this offline order as PAID?' 
    : 'Change payment status back to PENDING?';

  Swal.fire({
    title: 'Update Payment Status?',
    text: confirmText,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: (newStatus === 'Paid') ? 'Yes, Mark as Paid' : 'Yes, Change to Pending',
    cancelButtonText: 'Cancel',
    customClass: {
      popup: 'srl-swal-popup',
      title: 'srl-swal-title',
      confirmButton: (newStatus === 'Paid') ? 'btn btn-success rounded-pill px-4 me-2' : 'btn btn-warning text-dark rounded-pill px-4 me-2',
      cancelButton: 'btn btn-secondary rounded-pill px-4'
    },
    buttonsStyling: false
  }).then(result => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('order_id', orderId);
      formData.append('payment_status', newStatus);

      fetch('<?= base_url('admin/offline_orders/update_payment_status') ?>', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          if (data && data.success) {
            Swal.fire({
              title: 'Success!',
              text: data.message,
              icon: 'success',
              timer: 1500,
              showConfirmButton: false,
              customClass: { popup: 'srl-swal-popup' }
            }).then(() => location.reload());
          } else {
            Swal.fire({
              title: 'Error',
              text: data.message || 'Unable to update payment status.',
              icon: 'error',
              customClass: { popup: 'srl-swal-popup' }
            });
          }
        })
        .catch(err => {
          console.error(err);
          Swal.fire({
            title: 'Error',
            text: 'Network error occurred.',
            icon: 'error',
            customClass: { popup: 'srl-swal-popup' }
          });
        });
    }
  });
}

document.getElementById('statusUpdateForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const btn = document.getElementById('btnUpdateStatus');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

  const formData = new FormData(this);
  fetch(this.action, {
    method: 'POST',
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      btn.disabled = false;
      btn.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i>Save Status Update';

      if (data && data.success) {
        Swal.fire({
          title: 'Status Updated!',
          text: data.message,
          icon: 'success',
          timer: 1500,
          showConfirmButton: false,
          customClass: { popup: 'srl-swal-popup' }
        }).then(() => location.reload());
      } else {
        Swal.fire({
          title: 'Error',
          text: data.message || 'Unable to update order status.',
          icon: 'error',
          customClass: { popup: 'srl-swal-popup' }
        });
      }
    })
    .catch(err => {
      btn.disabled = false;
      btn.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i>Save Status Update';
      console.error(err);
    });
});

function deleteOfflineOrder(orderId, orderNumber) {
  Swal.fire({
    title: 'Delete Offline Order?',
    html: `Are you sure you want to delete order <strong>#${orderNumber}</strong>?<br><small class="text-danger mt-1 d-block">This action cannot be undone. Product stock will be restored.</small>`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, Delete Order',
    cancelButtonText: 'Cancel',
    customClass: {
      popup: 'srl-swal-popup',
      title: 'srl-swal-title',
      confirmButton: 'btn btn-danger rounded-pill px-4 me-2',
      cancelButton: 'btn btn-secondary rounded-pill px-4'
    },
    buttonsStyling: false
  }).then(result => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('order_id', orderId);

      fetch('<?= base_url('admin/offline_orders/delete') ?>/' + orderId, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
      })
        .then(res => res.json())
        .then(data => {
          if (data && data.success) {
            Swal.fire({
              title: 'Deleted!',
              text: data.message,
              icon: 'success',
              timer: 1600,
              showConfirmButton: false,
              customClass: { popup: 'srl-swal-popup' }
            }).then(() => {
              window.location.href = '<?= base_url('admin/offline_orders') ?>';
            });
          } else {
            Swal.fire({
              title: 'Error',
              text: data.message || 'Failed to delete offline order.',
              icon: 'error',
              customClass: { popup: 'srl-swal-popup' }
            });
          }
        })
        .catch(err => {
          console.error(err);
          Swal.fire({
            title: 'Error',
            text: 'Network error occurred while deleting order.',
            icon: 'error',
            customClass: { popup: 'srl-swal-popup' }
          });
        });
    }
  });
}
</script>
