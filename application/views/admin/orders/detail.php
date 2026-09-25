<style>
  :root {
    --srl-pink: #ec1e79;
    --srl-pink-dark: #c9106a;
    --ink: #0f172a;
    --muted: #64748b;
    --line: #e7eaf0;
    --bg-soft: #f6f7fb;
    --card-r: 16px;
  }

  .od-wrap {
    background: var(--bg-soft);
    padding: 20px 16px 40px;
  }

  @media (min-width:768px) {
    .od-wrap {
      padding: 28px 28px 48px;
    }
  }

  /* ---------- Top bar ---------- */
  .od-topbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
  }

  .od-crumb {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  .od-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: .82rem;
    font-weight: 600;
    color: var(--muted);
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 999px;
    padding: 6px 14px;
    text-decoration: none;
    transition: .15s;
  }

  .od-back:hover {
    background: #fff0f6;
    color: var(--srl-pink);
    border-color: #fbcfe4;
  }

  .od-title-block h1 {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--ink);
    margin: 2px 0 0;
    letter-spacing: .2px;
  }

  .od-placed {
    font-size: .78rem;
    color: var(--muted);
    margin: 0;
  }

  .od-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  .btn-invoice {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: .85rem;
    font-weight: 600;
    color: var(--ink);
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 999px;
    padding: 9px 18px;
    text-decoration: none;
    transition: .15s;
  }

  .btn-invoice:hover {
    border-color: var(--srl-pink);
    color: var(--srl-pink-dark);
  }

  .btn-invoice i {
    color: var(--srl-pink);
  }

  .order-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: .82rem;
    font-weight: 700;
    border-radius: 999px;
    padding: 9px 16px;
    white-space: nowrap;
  }

  .status-badge-awaiting-payment {
    background: #fff7ed;
    color: #c2410c;
  }

  .status-badge-placed {
    background: #eef2ff;
    color: #4338ca;
  }

  .status-badge-confirmed {
    background: #ecfdf5;
    color: #047857;
  }

  .status-badge-packed {
    background: #eff6ff;
    color: #1d4ed8;
  }

  .status-badge-out-for-delivery {
    background: #fdf4ff;
    color: #a21caf;
  }

  .status-badge-delivered {
    background: #f0fdf4;
    color: #15803d;
  }

  .status-badge-cancelled {
    background: #fef2f2;
    color: #b91c1c;
  }

  /* ---------- Cards ---------- */
  .od-card {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: var(--card-r);
    box-shadow: 0 1px 2px rgba(15, 23, 42, .03);
  }

  .od-card+.od-card {
    margin-top: 16px;
  }

  .od-card-hd {
    display: flex;
    align-items: center;
    justify-content: between;
    gap: 10px;
    padding: 16px 18px;
    border-bottom: 1px solid var(--line);
  }

  .od-card-hd h2 {
    font-size: .95rem;
    font-weight: 800;
    color: var(--ink);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .od-card-hd h2 i {
    color: var(--srl-pink);
    font-size: .95rem;
  }

  .od-card-body {
    padding: 18px;
  }

  .od-card-body.tight {
    padding: 14px 18px;
  }

  .chip {
    font-size: .72rem;
    font-weight: 700;
    color: var(--muted);
    background: var(--bg-soft);
    border: 1px solid var(--line);
    border-radius: 999px;
    padding: 4px 10px;
  }

  /* ---------- Items table ---------- */
  .od-items {
    width: 100%;
    border-collapse: collapse;
  }

  .od-items thead th {
    font-size: .68rem;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--muted);
    font-weight: 700;
    padding: 10px 18px;
    background: var(--bg-soft);
    border-bottom: 1px solid var(--line);
  }

  .od-items tbody td {
    padding: 14px 18px;
    border-bottom: 1px solid var(--line);
    vertical-align: middle;
  }

  .od-items tbody tr:last-child td {
    border-bottom: none;
  }

  .od-thumb {
    width: 46px;
    height: 46px;
    object-fit: cover;
    border-radius: 9px;
    background: #0d1017;
    flex: 0 0 auto;
  }

  .od-thumb-ph {
    width: 46px;
    height: 46px;
    border-radius: 9px;
    background: var(--bg-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #a1a8b3;
  }

  .od-pname {
    font-weight: 600;
    color: var(--ink);
    font-size: .9rem;
  }

  .od-sku {
    font-size: .78rem;
    color: var(--muted);
  }

  .qty-pill {
    font-size: .76rem;
    font-weight: 700;
    color: var(--ink);
    background: var(--bg-soft);
    border: 1px solid var(--line);
    border-radius: 999px;
    padding: 3px 10px;
    display: inline-block;
  }

  .od-summary {
    padding: 6px 18px 18px;
  }

  .od-summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    font-size: .86rem;
    color: var(--muted);
  }

  .od-summary-row strong {
    color: var(--ink);
    font-weight: 700;
  }

  .od-summary-row.total {
    border-top: 1px dashed var(--line);
    margin-top: 4px;
    padding-top: 14px;
  }

  .od-summary-row.total span:first-child {
    font-weight: 800;
    color: var(--ink);
    font-size: .95rem;
  }

  .od-summary-row.total strong {
    font-size: 1.25rem;
    color: var(--srl-pink);
    font-weight: 800;
  }

  .od-free {
    color: #16a34a;
    font-weight: 700;
  }

  /* ---------- Status updater ---------- */
  .form-label-sm {
    font-size: .75rem;
    font-weight: 700;
    color: var(--muted);
    margin-bottom: 6px;
    display: block;
  }

  .od-select,
  .od-textarea {
    width: 100%;
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 10px 12px;
    font-size: .88rem;
    color: var(--ink);
    background: #fff;
  }

  .od-select:focus,
  .od-textarea:focus {
    outline: none;
    border-color: var(--srl-pink);
    box-shadow: 0 0 0 3px rgba(236, 30, 121, .12);
  }

  .btn-srl-primary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    border: none;
    border-radius: 12px;
    padding: 12px;
    font-weight: 700;
    font-size: .9rem;
    color: #fff;
    background: linear-gradient(135deg, var(--srl-pink), var(--srl-pink-dark));
    box-shadow: 0 6px 16px rgba(236, 30, 121, .28);
    transition: .15s;
  }

  .btn-srl-primary:hover {
    filter: brightness(1.05);
    transform: translateY(-1px);
  }

  .btn-srl-primary:disabled {
    opacity: .7;
    transform: none;
  }

  /* ---------- Info list (customer / shipping / payment combined) ---------- */
  .info-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 9px 0;
    border-bottom: 1px solid var(--line);
    font-size: .85rem;
  }

  .info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }

  .info-row .k {
    color: var(--muted);
    flex: 0 0 auto;
  }

  .info-row .v {
    color: var(--ink);
    font-weight: 600;
    text-align: right;
    word-break: break-word;
  }

  .addr-name {
    font-weight: 700;
    color: var(--ink);
    font-size: .92rem;
  }

  .addr-phone {
    font-size: .8rem;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 4px 0 10px;
  }

  .addr-text {
    font-size: .85rem;
    color: #475569;
    line-height: 1.55;
  }

  .pay-badge {
    font-size: .76rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
  }

  .pay-paid {
    background: #ecfdf5;
    color: #047857;
  }

  .pay-pending {
    background: #fffbeb;
    color: #b45309;
  }

  /* ---------- Layout grid ---------- */
  .od-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
    align-items: start;
  }

  @media (min-width:992px) {
    .od-grid {
      grid-template-columns: minmax(0, 1.65fr) minmax(300px, 1fr);
      gap: 22px;
    }
  }

  /* ---------- Mobile tweaks ---------- */
  @media (max-width:767.98px) {
    .od-topbar {
      flex-direction: column;
      align-items: stretch;
    }

    .od-actions {
      justify-content: space-between;
    }

    .od-title-block h1 {
      font-size: 1rem;
    }

    .od-items thead {
      display: none;
    }

    .od-items tbody tr {
      display: block;
      padding: 14px 16px;
    }

    .od-items tbody td {
      display: block;
      padding: 3px 0;
      border: none;
    }

    .od-items tbody tr+tr {
      border-top: 1px solid var(--line);
    }

    .od-row-prod {
      display: flex;
      gap: 12px;
      align-items: center;
      margin-bottom: 8px;
    }

    .od-row-meta {
      display: flex;
      justify-content: space-between;
      font-size: .82rem;
      color: var(--muted);
    }

    .od-row-total {
      display: flex;
      justify-content: space-between;
      margin-top: 6px;
      font-size: .9rem;
    }
  }
</style>

<div class="od-wrap">
  <div class="container-fluid p-0">

    <!-- Top Bar -->
    <div class="od-topbar">
      <div class="od-crumb">
        <a href="<?= base_url('admin/orders') ?>" class="od-back">
          <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
        <div class="od-title-block">
          <h1>Order #<?= html_escape($order->order_number) ?></h1>
          <p class="od-placed">Placed on <?= date('d M Y, h:i A', strtotime($order->created_at)) ?></p>
        </div>
      </div>

      <div class="od-actions">
        <a href="<?= base_url('admin/orders/invoice/' . $order->id) ?>" target="_blank" class="btn-invoice">
          <i class="bi bi-printer-fill"></i> Print / Download Invoice
        </a>
        <?php
        $status_class = 'status-badge-placed';
        $status_icon  = 'bi bi-receipt';
        switch ($order->order_status) {
          case 'Awaiting Payment':
            $status_class = 'status-badge-awaiting-payment';
            $status_icon = 'bi bi-clock-history';
            break;
          case 'Placed':
            $status_class = 'status-badge-placed';
            $status_icon = 'bi bi-receipt';
            break;
          case 'Confirmed':
            $status_class = 'status-badge-confirmed';
            $status_icon = 'bi bi-check-circle';
            break;
          case 'Packed':
            $status_class = 'status-badge-packed';
            $status_icon = 'bi bi-box-seam';
            break;
          case 'Out for Delivery':
            $status_class = 'status-badge-out-for-delivery';
            $status_icon = 'bi bi-truck';
            break;
          case 'Delivered':
            $status_class = 'status-badge-delivered';
            $status_icon = 'bi bi-check-circle-fill';
            break;
          case 'Cancelled':
            $status_class = 'status-badge-cancelled';
            $status_icon = 'bi bi-x-circle';
            break;
        }
        ?>
        <span class="order-status-badge <?= $status_class ?>" id="currentStatusBadge">
          <i class="<?= $status_icon ?>" id="currentStatusIcon"></i>
          <span id="currentStatusText"><?= html_escape($order->order_status) ?></span>
        </span>
      </div>
    </div>

    <!-- Grid -->
    <div class="od-grid">

      <!-- LEFT COLUMN -->
      <div>
        <div class="od-card">
          <div class="od-card-hd">
            <h2><i class="bi bi-bag-check"></i> Ordered Items (<?= count($items) ?>)</h2>
            <span class="chip">INR ₹</span>
          </div>

          <div class="table-responsive d-none d-md-block">
            <table class="od-items">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>SKU</th>
                  <th class="text-end">Unit Price</th>
                  <th class="text-center">Qty</th>
                  <th class="text-end">Line Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($items as $item): ?>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-3">
                        <?php if (!empty($item->product_image) && file_exists('./uploads/products/' . $item->product_image)): ?>
                          <img src="<?= base_url('uploads/products/' . $item->product_image) ?>" alt="<?= html_escape($item->product_name) ?>" class="od-thumb">
                        <?php else: ?>
                          <div class="od-thumb-ph"><i class="bi bi-image"></i></div>
                        <?php endif; ?>
                        <span class="od-pname"><?= html_escape($item->product_name) ?></span>
                      </div>
                    </td>
                    <td class="od-sku"><?= !empty($item->sku) ? html_escape($item->sku) : '—' ?></td>
                    <td class="text-end fw-semibold"><?= '₹' . number_format($item->unit_price, 2) ?></td>
                    <td class="text-center"><span class="qty-pill">× <?= (int)$item->quantity ?></span></td>
                    <td class="text-end fw-bold"><?= '₹' . number_format($item->line_total, 2) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Mobile stacked items -->
          <div class="d-md-none">
            <table class="od-items w-100">
              <tbody>
                <?php foreach ($items as $item): ?>
                  <tr>
                    <td>
                      <div class="od-row-prod">
                        <?php if (!empty($item->product_image) && file_exists('./uploads/products/' . $item->product_image)): ?>
                          <img src="<?= base_url('uploads/products/' . $item->product_image) ?>" alt="<?= html_escape($item->product_name) ?>" class="od-thumb">
                        <?php else: ?>
                          <div class="od-thumb-ph"><i class="bi bi-image"></i></div>
                        <?php endif; ?>
                        <div>
                          <div class="od-pname"><?= html_escape($item->product_name) ?></div>
                          <div class="od-sku">SKU: <?= !empty($item->sku) ? html_escape($item->sku) : '—' ?></div>
                        </div>
                      </div>
                      <div class="od-row-meta">
                        <span><?= '₹' . number_format($item->unit_price, 2) ?> × <?= (int)$item->quantity ?></span>
                        <span class="fw-bold text-dark"><?= '₹' . number_format($item->line_total, 2) ?></span>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <div class="od-summary">
            <div class="od-summary-row">
              <span>Subtotal</span>
              <strong><?= '₹' . number_format($order->subtotal, 2) ?></strong>
            </div>
            <?php if (!empty($order->coupon_discount) && (float)$order->coupon_discount > 0): ?>
              <div class="od-summary-row" style="color: #059669; font-weight: 600;">
                <span><i class="bi bi-tag-fill me-1"></i>Coupon Discount (<?= html_escape($order->coupon_code) ?>)</span>
                <strong>-<?= '₹' . number_format($order->coupon_discount, 2) ?></strong>
              </div>
            <?php endif; ?>
            <div class="od-summary-row">
              <span>Shipping Charges</span>
              <?php if (isset($order->shipping_fee) && (float)$order->shipping_fee > 0): ?>
                <strong><?= '₹' . number_format($order->shipping_fee, 2) ?></strong>
              <?php else: ?>
                <span class="od-free">FREE</span>
              <?php endif; ?>
            </div>
            <div class="od-summary-row total">
              <span>Grand Total</span>
              <strong><?= '₹' . number_format($order->total_amount, 2) ?></strong>
            </div>
          </div>
        </div>

        <?php if (!empty($order->notes)): ?>
          <div class="od-card">
            <div class="od-card-hd">
              <h2><i class="bi bi-journal-text"></i> Customer / Order Notes</h2>
            </div>
            <div class="od-card-body tight">
              <p class="mb-0" style="font-size:.86rem;color:#475569;line-height:1.6;">
                <?= nl2br(html_escape($order->notes)) ?>
              </p>
            </div>
          </div>
        <?php endif; ?>

        <!-- Payment Info moved here on desktop to balance columns -->
        <div class="od-card d-none d-lg-block">
          <div class="od-card-hd">
            <h2><i class="bi bi-credit-card"></i> Payment Info</h2>
          </div>
          <div class="od-card-body tight">
            <div class="info-row">
              <span class="k">Method</span>
              <span class="chip"><?= html_escape($order->payment_method) ?></span>
            </div>
            <div class="info-row">
              <span class="k">Status</span>
              <span class="pay-badge <?= ($order->payment_status === 'Paid') ? 'pay-paid' : 'pay-pending' ?>">
                <?= html_escape($order->payment_status) ?>
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT COLUMN -->
      <div>
        <!-- Status Updater -->
        <div class="od-card">
          <div class="od-card-hd">
            <h2><i class="bi bi-sliders"></i> Update Order Status</h2>
          </div>
          <div class="od-card-body">
            <p class="text-muted mb-3" style="font-size:.8rem;">
              Changing status here immediately updates customer tracking in real time.
            </p>

            <?= form_open('admin/orders/update_status', ['id' => 'statusUpdateForm']) ?>
            <input type="hidden" name="order_id" value="<?= $order->id ?>">

            <div class="mb-3">
              <label class="form-label-sm">Order Status</label>
              <select name="status" id="orderStatusSelect" class="od-select" required>
                <?php
                $statuses = ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'];
                foreach ($statuses as $st):
                ?>
                  <option value="<?= $st ?>" <?= ($order->order_status === $st) ? 'selected' : '' ?>><?= $st ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label-sm">Admin Remarks / Notes (Optional)</label>
              <textarea name="notes" rows="3" class="od-textarea" placeholder="e.g. Courier tracking code or update reason"><?= html_escape($order->notes) ?></textarea>
            </div>

            <button type="submit" class="btn-srl-primary" id="btnUpdateStatus">
              <i class="bi bi-check2-circle"></i> Save Status Update
            </button>
            <?= form_close() ?>
          </div>
        </div>

        <!-- Customer + Shipping combined -->
        <div class="od-card">
          <div class="od-card-hd">
            <h2><i class="bi bi-person-badge"></i> Customer</h2>
          </div>
          <div class="od-card-body tight">
            <div class="info-row">
              <span class="k">Name</span>
              <span class="v"><?= $customer ? html_escape($customer->name) : html_escape($order->shipping_full_name) ?></span>
            </div>
            <div class="info-row">
              <span class="k">Email</span>
              <span class="v"><?= $customer ? html_escape($customer->email) : 'N/A' ?></span>
            </div>
            <div class="info-row">
              <span class="k">Mobile</span>
              <span class="v"><?= html_escape($order->shipping_mobile) ?></span>
            </div>
            <?php if ($customer && !empty($customer->shop_name)): ?>
              <div class="info-row">
                <span class="k">Shop</span>
                <span class="v"><?= html_escape($customer->shop_name) ?></span>
              </div>
            <?php endif; ?>
            <?php if ($customer && !empty($customer->gst_number)): ?>
              <div class="info-row">
                <span class="k">GST</span>
                <span class="chip"><?= html_escape($customer->gst_number) ?></span>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <div class="od-card">
          <div class="od-card-hd">
            <h2><i class="bi bi-geo-alt-fill"></i> Shipping Address</h2>
          </div>
          <div class="od-card-body tight">
            <div class="addr-name"><?= html_escape($order->shipping_full_name) ?></div>
            <div class="addr-phone"><i class="bi bi-telephone"></i> <?= html_escape($order->shipping_mobile) ?></div>
            <div class="addr-text">
              <?= html_escape($order->shipping_address_line1) ?><br>
              <?php if (!empty($order->shipping_address_line2)): ?>
                <?= html_escape($order->shipping_address_line2) ?><br>
              <?php endif; ?>
              <?php if (!empty($order->shipping_landmark)): ?>
                Landmark: <?= html_escape($order->shipping_landmark) ?><br>
              <?php endif; ?>
              <?= html_escape($order->shipping_city) ?>, <?= html_escape($order->shipping_state) ?> - <strong><?= html_escape($order->shipping_pincode) ?></strong><br>
              <?= html_escape($order->shipping_country) ?>
            </div>
          </div>
        </div>

        <!-- Payment Info: shown here on mobile/tablet only -->
        <div class="od-card d-lg-none">
          <div class="od-card-hd">
            <h2><i class="bi bi-credit-card"></i> Payment Info</h2>
          </div>
          <div class="od-card-body tight">
            <div class="info-row">
              <span class="k">Method</span>
              <span class="chip"><?= html_escape($order->payment_method) ?></span>
            </div>
            <div class="info-row">
              <span class="k">Status</span>
              <span class="pay-badge <?= ($order->payment_status === 'Paid') ? 'pay-paid' : 'pay-pending' ?>">
                <?= html_escape($order->payment_status) ?>
              </span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('statusUpdateForm');
    if (form) {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('btnUpdateStatus');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(res => res.json())
          .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-check2-circle"></i> Save Status Update';

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

              const textEl = document.getElementById('currentStatusText');
              const badgeEl = document.getElementById('currentStatusBadge');
              const iconEl = document.getElementById('currentStatusIcon');

              if (textEl) textEl.textContent = data.status;

              if (badgeEl) {
                badgeEl.className = 'order-status-badge';
                let sClass = 'status-badge-placed';
                let sIcon = 'bi bi-receipt';

                switch (data.status) {
                  case 'Awaiting Payment':
                    sClass = 'status-badge-awaiting-payment';
                    sIcon = 'bi bi-clock-history';
                    break;
                  case 'Placed':
                    sClass = 'status-badge-placed';
                    sIcon = 'bi bi-receipt';
                    break;
                  case 'Confirmed':
                    sClass = 'status-badge-confirmed';
                    sIcon = 'bi bi-check-circle';
                    break;
                  case 'Packed':
                    sClass = 'status-badge-packed';
                    sIcon = 'bi bi-box-seam';
                    break;
                  case 'Out for Delivery':
                    sClass = 'status-badge-out-for-delivery';
                    sIcon = 'bi bi-truck';
                    break;
                  case 'Delivered':
                    sClass = 'status-badge-delivered';
                    sIcon = 'bi bi-check-circle-fill';
                    break;
                  case 'Cancelled':
                    sClass = 'status-badge-cancelled';
                    sIcon = 'bi bi-x-circle';
                    break;
                }
                badgeEl.classList.add(sClass);
                if (iconEl) iconEl.className = sIcon;
              }
            } else {
              Swal.fire('Error', data.message || 'Failed to update order status.', 'error');
            }
          })
          .catch(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-check2-circle"></i> Save Status Update';
            Swal.fire('Error', 'An unexpected error occurred.', 'error');
          });
      });
    }
  });
</script>