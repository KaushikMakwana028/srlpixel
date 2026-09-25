<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-ticket-perforated-fill me-2" style="color: var(--srl-pink);"></i>Coupons & Promo Codes
    </h4>
    <p class="text-muted small mb-0">Create and manage flat/percentage discount codes, set usage limits, and track redemptions.</p>
  </div>
  <a href="<?= base_url('admin/coupons/add') ?>" class="btn-srl-primary px-3 py-2 rounded-pill fw-bold text-decoration-none shadow-sm d-inline-flex align-items-center gap-1.5">
    <i class="bi bi-plus-circle-fill"></i>Create New Coupon
  </a>
</div>

<!-- Performance Metrics Row -->
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Coupons</span>
          <h3 class="fw-bold text-dark mb-0"><?= number_format($total_coupons) ?></h3>
        </div>
        <div class="rounded-4 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: linear-gradient(135deg, #ff2a85 0%, #1e1526 100%); box-shadow: 0 4px 12px rgba(255, 42, 133, 0.3);">
          <i class="bi bi-ticket-perforated fs-5"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Active Coupons</span>
          <h3 class="fw-bold text-success mb-0"><?= number_format($active_coupons) ?></h3>
        </div>
        <div class="rounded-4 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
          <i class="bi bi-check2-circle fs-5"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Redemptions</span>
          <h3 class="fw-bold text-dark mb-0"><?= number_format($total_redemptions) ?></h3>
        </div>
        <div class="rounded-4 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);">
          <i class="bi bi-bag-check-fill fs-5"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Discount Given</span>
          <h3 class="fw-bold mb-0" style="color: var(--srl-pink);">₹<?= number_format($total_savings, 2) ?></h3>
        </div>
        <div class="rounded-4 d-flex align-items-center justify-content-center text-white" style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);">
          <i class="bi bi-currency-rupee fs-5"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Search & Filter Controls -->
<div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
  <div class="card-body p-3">
    <form method="get" action="<?= base_url('admin/coupons') ?>" class="row g-2 align-items-center">
      <div class="col-md-4">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control form-control-sm border-start-0" placeholder="Search by Code or Title..." value="<?= html_escape($search) ?>">
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <select name="discount_type" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Discount Types</option>
          <option value="percentage" <?= ($discount_type === 'percentage') ? 'selected' : '' ?>>Percentage (%) Discount</option>
          <option value="flat" <?= ($discount_type === 'flat') ? 'selected' : '' ?>>Flat (₹) Amount Discount</option>
        </select>
      </div>
      <div class="col-sm-6 col-md-3">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="1" <?= ($status === '1') ? 'selected' : '' ?>>Active Only</option>
          <option value="0" <?= ($status === '0') ? 'selected' : '' ?>>Inactive Only</option>
          <option value="expired" <?= ($status === 'expired') ? 'selected' : '' ?>>Expired Coupons</option>
        </select>
      </div>
      <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-dark w-100 rounded-3">Filter</button>
        <?php if (!empty($search) || !empty($discount_type) || ($status !== '' && $status !== null)): ?>
          <a href="<?= base_url('admin/coupons') ?>" class="btn btn-sm btn-outline-secondary rounded-3" title="Clear Filters"><i class="bi bi-x-lg"></i></a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>

<!-- Coupons List Table -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--srl-border) !important;">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead style="background: #f8fafc; font-size: 0.76rem; letter-spacing: 0.5px;" class="text-uppercase text-muted border-bottom">
        <tr>
          <th class="ps-3 ps-sm-4" style="width: 50px;">#</th>
          <th>Coupon Code & Info</th>
          <th>Discount Value</th>
          <th>Min. Order</th>
          <th>Usage Limit</th>
          <th>Validity</th>
          <th>Status</th>
          <th class="text-end pe-3 pe-sm-4" style="width: 140px;">Actions</th>
        </tr>
      </thead>
      <tbody class="border-top-0" style="font-size: 0.88rem;">
        <?php if (!empty($coupons)): ?>
          <?php foreach ($coupons as $index => $c): ?>
            <?php
              $is_expired = (!empty($c->end_date) && strtotime($c->end_date) < time());
              $is_limit_reached = ($c->usage_limit > 0 && $c->used_count >= $c->usage_limit);
              $remaining = ($c->usage_limit > 0) ? max(0, $c->usage_limit - $c->used_count) : null;
              $usage_pct = ($c->usage_limit > 0) ? min(100, round(($c->used_count / $c->usage_limit) * 100)) : 0;
            ?>
            <tr>
              <td class="ps-3 ps-sm-4 text-muted small"><?= $offset + $index + 1 ?></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <span class="badge px-2.5 py-1.5 rounded-3 fw-bold font-monospace" style="background: rgba(255, 42, 133, 0.1); color: var(--srl-pink); font-size: 0.88rem; letter-spacing: 0.5px; border: 1px dashed rgba(255, 42, 133, 0.3);">
                    <?= html_escape($c->code) ?>
                  </span>
                  <button type="button" class="btn btn-sm btn-link p-0 text-muted" onclick="navigator.clipboard.writeText('<?= html_escape($c->code) ?>'); Swal.fire({toast:true, position:'top-end', showConfirmButton:false, timer:1500, icon:'success', title:'Copied <?= html_escape($c->code) ?>!'});" title="Copy Code">
                    <i class="bi bi-copy"></i>
                  </button>
                </div>
                <?php if (!empty($c->title)): ?>
                  <div class="fw-semibold text-dark small mt-1"><?= html_escape($c->title) ?></div>
                <?php endif; ?>
                <?php if (!empty($c->description)): ?>
                  <div class="text-muted" style="font-size: 0.76rem; max-width: 250px;"><?= html_escape($c->description) ?></div>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($c->discount_type === 'percentage'): ?>
                  <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-1 fw-bold">
                    <i class="bi bi-percent me-1"></i><?= (float)$c->discount_value ?>% OFF
                  </span>
                  <?php if (!empty($c->max_discount_amount)): ?>
                    <small class="text-muted d-block mt-0.5" style="font-size: 0.72rem;">Up to ₹<?= number_format($c->max_discount_amount) ?></small>
                  <?php endif; ?>
                <?php else: ?>
                  <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fw-bold">
                    <i class="bi bi-currency-rupee me-0.5"></i>₹<?= number_format($c->discount_value, 2) ?> FLAT
                  </span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($c->min_order_amount > 0): ?>
                  <span class="small text-dark fw-semibold">₹<?= number_format($c->min_order_amount) ?></span>
                <?php else: ?>
                  <span class="text-muted small">No minimum</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($c->usage_limit > 0): ?>
                  <div style="max-width: 140px;">
                    <div class="d-flex justify-content-between small mb-1">
                      <span class="fw-bold <?= $is_limit_reached ? 'text-danger' : 'text-dark' ?>"><?= $c->used_count ?> / <?= $c->usage_limit ?></span>
                      <span class="text-muted" style="font-size: 0.72rem;"><?= $remaining ?> left</span>
                    </div>
                    <div class="progress" style="height: 5px;">
                      <div class="progress-bar <?= $is_limit_reached ? 'bg-danger' : 'bg-success' ?>" style="width: <?= $usage_pct ?>%;"></div>
                    </div>
                  </div>
                <?php else: ?>
                  <span class="badge bg-light text-secondary border small">Unlimited (<?= $c->used_count ?> used)</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($is_expired): ?>
                  <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-0.5 small border border-danger-subtle d-inline-flex align-items-center gap-1">
                    <i class="bi bi-clock-history"></i>Expired
                  </span>
                  <small class="text-muted d-block mt-0.5" style="font-size: 0.72rem;"><?= date('d M Y', strtotime($c->end_date)) ?></small>
                <?php elseif (!empty($c->end_date)): ?>
                  <span class="small text-dark d-block"><i class="bi bi-calendar-event me-1 text-muted"></i>Till <?= date('d M Y', strtotime($c->end_date)) ?></span>
                  <small class="text-muted" style="font-size: 0.72rem;"><?= date('h:i A', strtotime($c->end_date)) ?></small>
                <?php else: ?>
                  <span class="text-success small"><i class="bi bi-infinity me-1"></i>No Expiry</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($is_expired): ?>
                  <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 small">Expired</span>
                <?php elseif ($is_limit_reached): ?>
                  <span class="badge bg-warning-subtle text-warning rounded-pill px-2.5 py-1 small border border-warning-subtle">Limit Reached</span>
                <?php else: ?>
                  <a href="<?= base_url('admin/coupons/status/' . $c->id) ?>" class="text-decoration-none" title="Click to toggle status" onclick="return confirm('Toggle status for coupon <?= html_escape($c->code) ?>?');">
                    <?php if ($c->status == 1): ?>
                      <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1.5 fw-semibold border border-success-subtle d-inline-flex align-items-center gap-1">
                        <i class="bi bi-check-circle-fill"></i>Active
                      </span>
                    <?php else: ?>
                      <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1.5 fw-semibold border border-danger-subtle d-inline-flex align-items-center gap-1">
                        <i class="bi bi-slash-circle-fill"></i>Inactive
                      </span>
                    <?php endif; ?>
                  </a>
                <?php endif; ?>
              </td>
              <td class="text-end pe-3 pe-sm-4">
                <div class="d-inline-flex gap-1">
                  <!-- View Customer Redemptions & Detailed Analytics -->
                  <a href="<?= base_url('admin/coupons/view/' . $c->id) ?>" class="btn btn-sm btn-outline-info rounded-3 px-2 py-1" title="View Customer Redemptions & Usage Orders">
                    <i class="bi bi-eye"></i>
                  </a>
                  <!-- Edit Coupon -->
                  <a href="<?= base_url('admin/coupons/edit/' . $c->id) ?>" class="btn btn-sm btn-outline-primary rounded-3 px-2 py-1" title="Edit Coupon">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <!-- Delete Coupon -->
                  <a href="<?= base_url('admin/coupons/delete/' . $c->id) ?>" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1" onclick="return confirm('Permanently delete coupon <?= html_escape($c->code) ?>?');" title="Delete Coupon">
                    <i class="bi bi-trash"></i>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center py-5 text-muted">
              <i class="bi bi-ticket-perforated fs-1 d-block mb-2 text-secondary opacity-50"></i>
              No coupons found matching your search or filters.
              <div class="mt-2">
                <a href="<?= base_url('admin/coupons/add') ?>" class="btn btn-sm btn-srl-primary rounded-pill px-3">Create First Coupon</a>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if ($total_pages > 1): ?>
    <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <small class="text-muted">Showing <?= $offset + 1 ?> to <?= min($offset + $limit, $total_records) ?> of <?= $total_records ?> coupons</small>
      <ul class="pagination pagination-sm mb-0">
        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
          <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
            <a class="page-link" href="<?= base_url('admin/coupons?page=' . $p . (!empty($search) ? '&search=' . urlencode($search) : '') . (!empty($discount_type) ? '&discount_type=' . $discount_type : '') . ($status !== '' && $status !== null ? '&status=' . $status : '')) ?>"><?= $p ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </div>
  <?php endif; ?>
</div>
