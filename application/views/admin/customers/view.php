<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <div class="d-flex align-items-center gap-2 mb-1">
      <h4 class="fw-bold text-dark mb-0">
        <i class="bi bi-person-badge-fill me-2" style="color: var(--srl-pink);"></i><?= html_escape($customer->name) ?>
      </h4>
      <?php if ($customer->status == 1): ?>
        <span class="badge bg-success rounded-pill px-3 py-1"><i class="bi bi-check-circle me-1"></i>Active Account</span>
      <?php else: ?>
        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1 border border-danger-subtle"><i class="bi bi-slash-circle me-1"></i>Inactive</span>
      <?php endif; ?>
    </div>
    <p class="text-muted small mb-0">Customer ID #<?= $customer->id ?> &bull; Joined <?= date('d M Y, h:i A', strtotime($customer->created_at)) ?></p>
  </div>
  <div class="d-flex align-items-center gap-2">
    <?php if ($customer->status == 1): ?>
      <a href="<?= base_url('admin/customers/status/' . $customer->id) ?>" 
         class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center shadow-sm"
         onclick="return confirm('Are you sure you want to deactivate this customer account? The customer will not be able to log in.');"
         title="Click to Deactivate Account">
        <i class="bi bi-person-x-fill me-1.5"></i>Change Status: Deactivate
      </a>
    <?php else: ?>
      <a href="<?= base_url('admin/customers/status/' . $customer->id) ?>" 
         class="btn btn-sm btn-success rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center shadow-sm"
         onclick="return confirm('Are you sure you want to activate this customer account?');"
         title="Click to Activate Account">
        <i class="bi bi-person-check-fill me-1.5"></i>Change Status: Activate
      </a>
    <?php endif; ?>
    <a href="<?= base_url('admin/customers') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 d-inline-flex align-items-center">
      <i class="bi bi-arrow-left me-1"></i>Back to Customers
    </a>
  </div>
</div>

<!-- Key Performance Metrics Row -->
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Orders</span>
          <h3 class="fw-bold text-dark mb-0"><?= number_format($total_orders) ?></h3>
        </div>
        <div class="rounded-4 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: linear-gradient(135deg, #ff2a85 0%, #d81b60 100%); box-shadow: 0 4px 12px rgba(255, 42, 133, 0.3);">
          <i class="bi bi-bag-check-fill fs-5"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Spent</span>
          <h3 class="fw-bold mb-0" style="color: var(--srl-pink);">₹<?= number_format($total_spent, 2) ?></h3>
        </div>
        <div class="rounded-4 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
          <i class="bi bi-currency-rupee fs-5"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Delivered Orders</span>
          <h3 class="fw-bold text-success mb-0"><?= number_format($completed_orders) ?></h3>
        </div>
        <div class="rounded-4 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);">
          <i class="bi bi-truck fs-5"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Customer Since</span>
          <h5 class="fw-bold text-dark mb-0"><?= date('M Y', strtotime($customer->created_at)) ?></h5>
          <small class="text-muted"><?= date('d F Y', strtotime($customer->created_at)) ?></small>
        </div>
        <div class="rounded-4 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);">
          <i class="bi bi-calendar2-check-fill fs-5"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Left Column: Customer Profile & Delivery Addresses -->
  <div class="col-lg-4">
    <!-- Customer Details Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-person-lines-fill me-2 text-primary"></i>Profile Details
        </h6>
      </div>
      <div class="card-body p-4">
        <div class="text-center mb-4">
          <div class="position-relative d-inline-block mb-2">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold shadow overflow-hidden" style="width: 82px; height: 82px; background: linear-gradient(135deg, #ff2a85 0%, #1e1526 100%); font-size: 2rem; border: 3px solid #ffffff; box-shadow: 0 4px 16px rgba(255, 42, 133, 0.25) !important;">
              <?php if (!empty($customer->profile_image) && file_exists('./uploads/profiles/' . $customer->profile_image)): ?>
                <img src="<?= base_url('uploads/profiles/' . $customer->profile_image) ?>" alt="<?= html_escape($customer->name) ?>" style="width: 100%; height: 100%; object-fit: cover;">
              <?php else: ?>
                <?= strtoupper(substr($customer->name ?? 'U', 0, 1)) ?>
              <?php endif; ?>
            </div>
            <?php if ($customer->status == 1): ?>
              <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle" title="Active" style="width: 18px; height: 18px;"></span>
            <?php else: ?>
              <span class="position-absolute bottom-0 end-0 p-1 bg-danger border border-2 border-white rounded-circle" title="Inactive" style="width: 18px; height: 18px;"></span>
            <?php endif; ?>
          </div>
          <h5 class="fw-bold text-dark mb-1"><?= html_escape($customer->name) ?></h5>
          <span class="badge bg-light text-secondary border small">Customer Account</span>
        </div>

        <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
          <li class="d-flex align-items-start gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-primary flex-shrink-0" style="width: 32px; height: 32px; background: rgba(2, 132, 199, 0.1);">
              <i class="bi bi-envelope"></i>
            </div>
            <div>
              <span class="text-muted small d-block">Email Address</span>
              <a href="mailto:<?= html_escape($customer->email) ?>" class="fw-semibold text-dark text-decoration-none small">
                <?= html_escape($customer->email) ?>
              </a>
            </div>
          </li>

          <li class="d-flex align-items-start gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center text-success flex-shrink-0" style="width: 32px; height: 32px; background: rgba(16, 185, 129, 0.1);">
              <i class="bi bi-telephone"></i>
            </div>
            <div>
              <span class="text-muted small d-block">Mobile Number</span>
              <?php if (!empty($customer->phone)): ?>
                <a href="tel:<?= html_escape($customer->phone) ?>" class="fw-semibold text-dark text-decoration-none small">
                  <?= html_escape($customer->phone) ?>
                </a>
              <?php else: ?>
                <span class="text-secondary opacity-50 small">Not specified</span>
              <?php endif; ?>
            </div>
          </li>

          <?php if (!empty($customer->shop_name)): ?>
            <li class="d-flex align-items-start gap-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center text-warning flex-shrink-0" style="width: 32px; height: 32px; background: rgba(245, 158, 11, 0.1);">
                <i class="bi bi-shop"></i>
              </div>
              <div>
                <span class="text-muted small d-block">Shop / Business Name</span>
                <span class="fw-semibold text-dark small"><?= html_escape($customer->shop_name) ?></span>
              </div>
            </li>
          <?php endif; ?>

          <?php if (!empty($customer->gst_number)): ?>
            <li class="d-flex align-items-start gap-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center text-secondary flex-shrink-0" style="width: 32px; height: 32px; background: rgba(100, 116, 139, 0.1);">
                <i class="bi bi-receipt"></i>
              </div>
              <div>
                <span class="text-muted small d-block">GST Number</span>
                <span class="fw-semibold text-dark small"><?= html_escape($customer->gst_number) ?></span>
              </div>
            </li>
          <?php endif; ?>

          <li class="d-flex align-items-start gap-3">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: rgba(255, 42, 133, 0.1); color: var(--srl-pink);">
              <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div>
              <span class="text-muted small d-block">Current Default Address (User Record)</span>
              <?php if (!empty($customer->address)): ?>
                <span class="fw-semibold text-dark small d-block"><?= html_escape($customer->address) ?></span>
              <?php else: ?>
                <span class="text-secondary opacity-50 small">No address recorded</span>
              <?php endif; ?>
            </div>
          </li>
        </ul>

        <!-- Account Status Box with Direct Change Status Action -->
        <div class="mt-4 pt-3 border-top">
          <div class="p-3 rounded-4 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: <?= ($customer->status == 1) ? 'rgba(16, 185, 129, 0.06)' : 'rgba(239, 68, 68, 0.06)' ?>; border: 1.5px solid <?= ($customer->status == 1) ? 'rgba(16, 185, 129, 0.25)' : 'rgba(239, 68, 68, 0.25)' ?>;">
            <div>
              <span class="text-muted small d-block fw-semibold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">Account Status</span>
              <?php if ($customer->status == 1): ?>
                <span class="fw-bold text-success d-inline-flex align-items-center gap-1">
                  <i class="bi bi-check-circle-fill"></i>Active Account
                </span>
              <?php else: ?>
                <span class="fw-bold text-danger d-inline-flex align-items-center gap-1">
                  <i class="bi bi-x-circle-fill"></i>Inactive / Suspended
                </span>
              <?php endif; ?>
            </div>
            <a href="<?= base_url('admin/customers/status/' . $customer->id) ?>" 
               class="btn btn-sm <?= ($customer->status == 1) ? 'btn-outline-danger' : 'btn-success' ?> rounded-pill px-3 py-1.5 fw-bold"
               onclick="return confirm('Change status for customer <?= html_escape(addslashes($customer->name)) ?>?');"
               title="Click to toggle customer status">
              <i class="bi bi-arrow-repeat me-1"></i>Change Status
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Saved Delivery Addresses Card -->
    <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-geo-alt me-2" style="color: var(--srl-pink);"></i>Saved Addresses (<?= !empty($addresses) ? count($addresses) : 0 ?>)
        </h6>
      </div>
      <div class="card-body p-3">
        <?php if (!empty($addresses)): ?>
          <div class="d-flex flex-column gap-3">
            <?php foreach ($addresses as $addr): ?>
              <div class="p-3 rounded-3 border position-relative" style="<?= ($addr->is_default == 1) ? 'background: rgba(255, 42, 133, 0.03); border-color: rgba(255, 42, 133, 0.3) !important;' : 'background: #f8fafc;' ?>">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="fw-bold text-dark small"><?= html_escape($addr->full_name) ?></span>
                  <?php if ($addr->is_default == 1): ?>
                    <span class="badge bg-success rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">Default Address</span>
                  <?php endif; ?>
                </div>
                <div class="text-muted small mb-1">
                  <i class="bi bi-telephone me-1"></i><?= html_escape($addr->mobile) ?>
                </div>
                <div class="text-secondary small">
                  <?= html_escape($addr->address_line1) ?>
                  <?= !empty($addr->address_line2) ? ', ' . html_escape($addr->address_line2) : '' ?>
                  <?= !empty($addr->landmark) ? '<br><span class="text-muted">Landmark: ' . html_escape($addr->landmark) . '</span>' : '' ?>
                  <br><?= html_escape($addr->city) ?>, <?= html_escape($addr->state) ?> - <strong><?= html_escape($addr->pincode) ?></strong>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="text-center py-4 text-muted">
            <i class="bi bi-geo-fill fs-3 text-secondary opacity-50 d-block mb-1"></i>
            <small>No additional delivery addresses saved.</small>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Right Column: Customer Orders List -->
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
          <h6 class="fw-bold text-dark mb-0">
            <i class="bi bi-receipt me-2" style="color: var(--srl-pink);"></i>Customer Order History
          </h6>
          <small class="text-muted">Total <?= count($orders) ?> order(s) recorded</small>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light text-uppercase small text-secondary">
            <tr>
              <th class="ps-3 ps-sm-4" style="width: 140px;">Order #</th>
              <th>Date</th>
              <th>Total Amount</th>
              <th>Payment</th>
              <th>Status</th>
              <th class="text-end pe-3 pe-sm-4" style="width: 110px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($orders)): ?>
              <?php foreach ($orders as $ord): ?>
                <tr>
                  <td class="ps-3 ps-sm-4">
                    <a href="<?= base_url('admin/orders/detail/' . $ord->id) ?>" class="fw-bold text-dark text-decoration-none text-hover-pink font-monospace small">
                      <?= html_escape($ord->order_number) ?>
                    </a>
                    <?php if (!empty($ord->order_type) && $ord->order_type === 'offline'): ?>
                      <span class="badge bg-secondary-subtle text-secondary rounded-pill d-block mt-0.5" style="font-size: 0.65rem; width: fit-content;">Offline / Walk-in</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-muted small">
                    <?= date('d M Y', strtotime($ord->created_at)) ?>
                    <span class="d-block text-secondary opacity-75" style="font-size: 0.72rem;"><?= date('h:i A', strtotime($ord->created_at)) ?></span>
                  </td>
                  <td>
                    <span class="fw-bold text-dark">₹<?= number_format($ord->total_amount, 2) ?></span>
                  </td>
                  <td>
                    <div class="small fw-semibold text-dark"><?= html_escape($ord->payment_method) ?></div>
                    <?php if (strtolower($ord->payment_status) === 'paid'): ?>
                      <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">Paid</span>
                    <?php else: ?>
                      <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">Pending</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php
                      $status_cls = 'bg-secondary';
                      $st = strtolower($ord->order_status);
                      if ($st === 'delivered') $status_cls = 'bg-success';
                      elseif ($st === 'confirmed' || $st === 'packed') $status_cls = 'bg-info text-dark';
                      elseif ($st === 'out for delivery') $status_cls = 'bg-primary';
                      elseif ($st === 'cancelled') $status_cls = 'bg-danger';
                      elseif ($st === 'placed') $status_cls = 'bg-warning text-dark';
                    ?>
                    <span class="badge <?= $status_cls ?> rounded-pill px-2.5 py-1" style="font-size: 0.72rem;">
                      <?= html_escape($ord->order_status) ?>
                    </span>
                  </td>
                  <td class="text-end pe-3 pe-sm-4">
                    <div class="d-inline-flex gap-1">
                      <a href="<?= base_url('admin/orders/detail/' . $ord->id) ?>" class="btn btn-sm btn-outline-primary rounded-3 px-2 py-1" title="View Order Details">
                        <i class="bi bi-eye"></i>
                      </a>
                      <a href="<?= base_url('admin/orders/invoice/' . $ord->id) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3 px-2 py-1" title="View Invoice">
                        <i class="bi bi-receipt"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                  <i class="bi bi-cart-x fs-1 text-secondary opacity-50 d-block mb-2"></i>
                  No orders have been placed by this customer yet.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
