<?php
  $is_expired = (!empty($coupon->end_date) && strtotime($coupon->end_date) < time());
  $is_limit_reached = ($coupon->usage_limit > 0 && $coupon->used_count >= $coupon->usage_limit);
  $remaining_uses = ($coupon->usage_limit > 0) ? max(0, $coupon->usage_limit - $coupon->used_count) : 'Unlimited';
  $quota_percent = ($coupon->usage_limit > 0) ? min(100, round(($coupon->used_count / $coupon->usage_limit) * 100)) : 0;
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

  /* Coupon KPI Stat Cards */
  .coupon-kpi-card {
    background: #ffffff;
    border-radius: 1rem;
    border: 1px solid var(--srl-border) !important;
    padding: 1.25rem 1.35rem;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: var(--srl-shadow);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
  }

  .coupon-kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--srl-shadow-lg);
    border-color: #cbd5e1 !important;
  }

  .coupon-kpi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: transparent;
    transition: background 0.25s ease;
  }

  .coupon-kpi-card.kpi-pink::before { background: var(--srl-pink-gradient); }
  .coupon-kpi-card.kpi-green::before { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
  .coupon-kpi-card.kpi-purple::before { background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); }
  .coupon-kpi-card.kpi-blue::before { background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); }

  .kpi-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.3rem;
    flex-shrink: 0;
  }

  .kpi-icon-pink {
    background: var(--srl-pink-gradient);
    box-shadow: 0 4px 14px rgba(255, 42, 133, 0.35);
  }

  .kpi-icon-green {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
  }

  .kpi-icon-purple {
    background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    box-shadow: 0 4px 14px rgba(139, 92, 246, 0.3);
  }

  .kpi-icon-blue {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
  }

  /* Digital Voucher Ticket Card */
  .voucher-ticket-box {
    background: linear-gradient(135deg, #ffffff 0%, #fff0f6 100%);
    border: 2px dashed rgba(225, 29, 116, 0.35);
    border-radius: 16px;
    padding: 1.5rem 1.25rem;
    position: relative;
    text-align: center;
    box-shadow: 0 4px 16px rgba(225, 29, 116, 0.06);
  }

  .voucher-code-badge {
    font-size: 1.55rem;
    font-weight: 800;
    letter-spacing: 2px;
    color: var(--srl-pink);
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    padding: 6px 18px;
    border-radius: 10px;
    border: 1px solid rgba(225, 29, 116, 0.2);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  }

  .copy-btn {
    border: none;
    background: var(--srl-pink-light);
    color: var(--srl-pink);
    border-radius: 8px;
    padding: 4px 8px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .copy-btn:hover {
    background: var(--srl-pink);
    color: #ffffff;
  }

  /* Redemptions Table */
  .redemptions-table-wrapper {
    position: relative;
    min-height: 200px;
  }

  .table-loading-overlay {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(2px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10;
    border-radius: 1rem;
  }

  .table-loading-overlay.active {
    display: flex;
  }

  .page-item.active .page-link {
    background: var(--srl-pink-gradient, linear-gradient(135deg, #ff2a85 0%, #e11d74 100%)) !important;
    border-color: var(--srl-pink) !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(255, 42, 133, 0.35);
  }

  .page-link {
    color: var(--srl-text-dark);
    border-color: var(--srl-border);
  }

  .page-link:hover {
    color: var(--srl-pink);
    background-color: var(--srl-pink-light);
    border-color: var(--srl-pink);
  }
</style>

<!-- Page Header Bar -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
  <div>
    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
      <h4 class="fw-bold text-dark mb-0 d-inline-flex align-items-center">
        <i class="bi bi-ticket-perforated-fill me-2" style="color: var(--srl-pink);"></i>
        <span>Coupon: <span class="font-monospace text-uppercase" style="color: var(--srl-pink);"><?= html_escape($coupon->code) ?></span></span>
      </h4>
      <?php if ($is_expired): ?>
        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1 border border-danger-subtle fw-semibold">
          <i class="bi bi-clock-history me-1"></i>Expired
        </span>
      <?php elseif ($is_limit_reached): ?>
        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1 border border-warning-subtle fw-semibold">
          <i class="bi bi-exclamation-triangle me-1"></i>Limit Reached
        </span>
      <?php elseif ($coupon->status == 1): ?>
        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1 border border-success-subtle fw-semibold">
          <i class="bi bi-check-circle-fill me-1"></i>Active
        </span>
      <?php else: ?>
        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-1 border fw-semibold">
          <i class="bi bi-slash-circle me-1"></i>Inactive
        </span>
      <?php endif; ?>
    </div>
    <p class="text-muted small mb-0">
      Created on <?= date('d M Y, h:i A', strtotime($coupon->created_at)) ?> &bull; 
      <?= !empty($coupon->title) ? html_escape($coupon->title) : 'Promotional Discount Campaign' ?>
    </p>
  </div>

  <div class="d-flex align-items-center gap-2 flex-wrap">
    <a href="<?= base_url('admin/coupons/edit/' . $coupon->id) ?>" class="btn-srl-primary btn-sm rounded-pill px-3 py-2 fw-semibold text-decoration-none d-inline-flex align-items-center gap-1.5 shadow-sm">
      <i class="bi bi-pencil"></i>Edit Coupon
    </a>
    <a href="<?= base_url('admin/coupons/status/' . $coupon->id) ?>" class="btn btn-sm <?= ($coupon->status == 1) ? 'btn-outline-danger' : 'btn-success' ?> rounded-pill px-3 py-2 fw-semibold" onclick="return confirm('Toggle status for this coupon?');">
      <i class="bi bi-arrow-repeat me-1"></i><?= ($coupon->status == 1) ? 'Deactivate' : 'Activate' ?>
    </a>
    <a href="<?= base_url('admin/coupons') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-2 d-inline-flex align-items-center">
      <i class="bi bi-arrow-left me-1"></i>Back to Coupons
    </a>
  </div>
</div>

<!-- ============================================================
     COUPON PERFORMANCE KPI METRIC CARDS (DASHBOARD)
     ============================================================ -->
<div class="row g-3 mb-4">
  <!-- 1. Total Redemptions -->
  <div class="col-sm-6 col-xl-3">
    <div class="coupon-kpi-card kpi-pink">
      <div>
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Times Redeemed</span>
          <div class="kpi-icon-box kpi-icon-pink">
            <i class="bi bi-ticket-perforated-fill"></i>
          </div>
        </div>
        <h3 class="fw-bold text-dark mb-1">
          <?= number_format($total_uses) ?>
          <span class="text-muted fs-6 fw-normal">/ <?= ($coupon->usage_limit > 0) ? $coupon->usage_limit : '∞' ?></span>
        </h3>
      </div>
      <div class="pt-2 border-top">
        <?php if ($coupon->usage_limit > 0): ?>
          <div class="d-flex justify-content-between align-items-center small text-muted mb-1" style="font-size: 0.72rem;">
            <span>Quota used</span>
            <span class="fw-bold text-dark"><?= $quota_percent ?>%</span>
          </div>
          <div class="progress" style="height: 5px; border-radius: 10px;">
            <div class="progress-bar <?= ($quota_percent >= 100) ? 'bg-danger' : 'bg-primary' ?>" style="width: <?= $quota_percent ?>%; background: var(--srl-pink) !important;"></div>
          </div>
        <?php else: ?>
          <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5" style="font-size: 0.72rem;">
            <i class="bi bi-infinity me-1"></i>Unlimited Cap
          </span>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- 2. Total Money Saved -->
  <div class="col-sm-6 col-xl-3">
    <div class="coupon-kpi-card kpi-pink">
      <div>
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Discount Given</span>
          <div class="kpi-icon-box kpi-icon-pink" style="background: linear-gradient(135deg, #ff2a85 0%, #1e1526 100%);">
            <i class="bi bi-currency-rupee"></i>
          </div>
        </div>
        <h3 class="fw-bold mb-1" style="color: var(--srl-pink);">₹<?= number_format($total_discount_given, 2) ?></h3>
      </div>
      <div class="pt-2 border-top">
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-0.5" style="font-size: 0.72rem;">
          <i class="bi bi-piggy-bank me-1"></i>Total Customer Savings
        </span>
      </div>
    </div>
  </div>

  <!-- 3. Net Orders Revenue -->
  <div class="col-sm-6 col-xl-3">
    <div class="coupon-kpi-card kpi-green">
      <div>
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Orders Revenue</span>
          <div class="kpi-icon-box kpi-icon-green">
            <i class="bi bi-graph-up-arrow"></i>
          </div>
        </div>
        <h3 class="fw-bold text-success mb-1">₹<?= number_format($total_orders_revenue, 2) ?></h3>
      </div>
      <div class="pt-2 border-top">
        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5" style="font-size: 0.72rem;">
          <i class="bi bi-cash-stack me-1"></i>Sales Generated
        </span>
      </div>
    </div>
  </div>

  <!-- 4. Remaining Uses -->
  <div class="col-sm-6 col-xl-3">
    <div class="coupon-kpi-card kpi-purple">
      <div>
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Remaining Uses</span>
          <div class="kpi-icon-box kpi-icon-purple">
            <i class="bi bi-hourglass-split"></i>
          </div>
        </div>
        <h3 class="fw-bold <?= ($remaining_uses === 0) ? 'text-danger' : 'text-dark' ?> mb-1">
          <?= $remaining_uses ?>
        </h3>
      </div>
      <div class="pt-2 border-top">
        <?php if ($coupon->usage_limit > 0 && $coupon->used_count >= $coupon->usage_limit): ?>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-0.5" style="font-size: 0.72rem;">
            <i class="bi bi-x-circle me-1"></i>Limit Reached
          </span>
        <?php elseif ($coupon->usage_limit > 0): ?>
          <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-0.5" style="font-size: 0.72rem;">
            <?= max(0, $coupon->usage_limit - $coupon->used_count) ?> left before expiry
          </span>
        <?php else: ?>
          <span class="badge bg-light text-secondary border px-2 py-0.5" style="font-size: 0.72rem;">
            No usage ceiling
          </span>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================
     MAIN DETAIL & REDEMPTIONS SECTION
     Left Column: Digital Voucher & Specs
     Right Column: Customer Redemptions Log with AJAX Pagination
     ============================================================ -->
<div class="row g-4">
  <!-- Left Column: Coupon Specification Details -->
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
          <i class="bi bi-info-circle-fill" style="color: var(--srl-pink);"></i>
          <span>Coupon Details</span>
        </h6>
        <span class="badge bg-light text-secondary border small">Voucher Spec</span>
      </div>

      <div class="card-body p-4">
        <!-- Digital Voucher Ticket Card -->
        <div class="voucher-ticket-box mb-4">
          <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
            <span class="voucher-code-badge" id="voucherCodeText"><?= html_escape($coupon->code) ?></span>
            <button type="button" class="copy-btn" onclick="copyVoucherCode('<?= html_escape($coupon->code) ?>', this)" title="Copy Code">
              <i class="bi bi-clipboard"></i>
            </button>
          </div>

          <div class="mt-2">
            <span class="badge rounded-pill fw-bold px-3 py-1.5 shadow-xs" style="background: var(--srl-pink-gradient); color: #ffffff; font-size: 0.85rem;">
              <?= ($coupon->discount_type === 'percentage') ? (float)$coupon->discount_value . '% OFF' : '₹' . number_format($coupon->discount_value, 2) . ' FLAT OFF' ?>
            </span>
          </div>

          <?php if (!empty($coupon->title)): ?>
            <h6 class="fw-bold text-dark mt-2 mb-0" style="font-size: 0.95rem;"><?= html_escape($coupon->title) ?></h6>
          <?php endif; ?>
          <?php if (!empty($coupon->description)): ?>
            <p class="text-muted small mb-0 mt-1" style="font-size: 0.78rem; line-height: 1.4;"><?= html_escape($coupon->description) ?></p>
          <?php endif; ?>
        </div>

        <!-- Specifications Breakdown -->
        <ul class="list-unstyled mb-0 d-flex flex-column gap-2.5" style="font-size: 0.85rem;">
          <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-light">
            <span class="text-muted"><i class="bi bi-sliders me-1.5 text-secondary"></i>Discount Type:</span>
            <span class="fw-bold text-dark text-capitalize badge bg-light text-dark border"><?= $coupon->discount_type ?></span>
          </li>

          <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-light">
            <span class="text-muted"><i class="bi bi-percent me-1.5 text-secondary"></i>Discount Value:</span>
            <span class="fw-bold text-success">
              <?= ($coupon->discount_type === 'percentage') ? (float)$coupon->discount_value . '% OFF' : '₹' . number_format($coupon->discount_value, 2) . ' OFF' ?>
            </span>
          </li>

          <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-light">
            <span class="text-muted"><i class="bi bi-cart me-1.5 text-secondary"></i>Min. Order:</span>
            <span class="fw-semibold text-dark">
              <?= ($coupon->min_order_amount > 0) ? '₹' . number_format($coupon->min_order_amount, 2) : 'No Minimum' ?>
            </span>
          </li>

          <?php if ($coupon->discount_type === 'percentage' && !empty($coupon->max_discount_amount)): ?>
            <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-light">
              <span class="text-muted"><i class="bi bi-shield-check me-1.5 text-secondary"></i>Max Cap:</span>
              <span class="fw-semibold text-dark">₹<?= number_format($coupon->max_discount_amount, 2) ?></span>
            </li>
          <?php endif; ?>

          <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-light">
            <span class="text-muted"><i class="bi bi-123 me-1.5 text-secondary"></i>Total Limit:</span>
            <span class="fw-bold text-dark"><?= ($coupon->usage_limit > 0) ? $coupon->usage_limit . ' times' : 'Unlimited' ?></span>
          </li>

          <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-light">
            <span class="text-muted"><i class="bi bi-check2-circle me-1.5 text-secondary"></i>Times Used:</span>
            <span class="badge bg-secondary-subtle text-secondary fw-bold"><?= $coupon->used_count ?> orders</span>
          </li>

          <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-light">
            <span class="text-muted"><i class="bi bi-person me-1.5 text-secondary"></i>Per Customer:</span>
            <span class="fw-semibold text-dark"><?= $coupon->per_user_limit ?> time(s)</span>
          </li>

          <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-light">
            <span class="text-muted"><i class="bi bi-calendar-check me-1.5 text-secondary"></i>Valid From:</span>
            <span class="text-dark small fw-semibold"><?= !empty($coupon->start_date) ? date('d M Y, h:i A', strtotime($coupon->start_date)) : 'Immediate' ?></span>
          </li>

          <li class="d-flex justify-content-between align-items-center py-1">
            <span class="text-muted"><i class="bi bi-calendar-x me-1.5 text-secondary"></i>Valid Until:</span>
            <span class="small fw-semibold <?= $is_expired ? 'text-danger fw-bold' : 'text-dark' ?>">
              <?= !empty($coupon->end_date) ? date('d M Y, h:i A', strtotime($coupon->end_date)) : 'No Expiry Date' ?>
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Right Column: Customer Redemptions Log with AJAX Pagination -->
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--srl-border) !important; background: #ffffff;">
      <div class="card-header bg-white border-bottom py-3 px-3 px-sm-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
          <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-people-fill" style="color: var(--srl-pink);"></i>
            <span>Customer Redemptions Log</span>
          </h6>
          <span class="badge rounded-pill bg-light text-secondary border px-2.5 py-1" style="font-size: 0.74rem;">
            <?= $total_records ?> Total
          </span>
        </div>
        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1 small" style="font-size: 0.72rem;">
          <i class="bi bi-lightning-charge-fill me-1"></i>5 Per Page
        </span>
      </div>

      <!-- Redemptions Table Wrapper with Loading Spinner -->
      <div class="redemptions-table-wrapper" id="redemptionsContainer">
        <!-- Loading Overlay -->
        <div class="table-loading-overlay" id="tableLoadingOverlay">
          <div class="text-center">
            <div class="spinner-border text-danger" style="width: 2rem; height: 2rem; color: var(--srl-pink) !important;" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <div class="small fw-bold mt-2" style="color: var(--srl-pink);">Loading Redemptions...</div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead style="background: #f8fafc; font-size: 0.74rem; letter-spacing: 0.6px;" class="text-uppercase text-muted border-bottom">
              <tr>
                <th class="ps-3 ps-sm-4" style="width: 45px;">#</th>
                <th>Customer</th>
                <th>Order Number</th>
                <th>Discount Saved</th>
                <th>Order Total</th>
                <th class="pe-3 pe-sm-4">Redeemed At</th>
              </tr>
            </thead>
            <tbody class="border-top-0" id="redemptionsTableBody" style="font-size: 0.88rem;">
              <?php
                $this->load->view('admin/coupons/_redemptions_rows', [
                  'usages' => $usages,
                  'offset' => $offset,
                  'coupon' => $coupon
                ]);
              ?>
            </tbody>
          </table>
        </div>

        <!-- AJAX Pagination Footer Container -->
        <div id="redemptionsPaginationWrapper">
          <?php
            $this->load->view('admin/coupons/_redemptions_pagination', [
              'page'          => $page,
              'total_pages'   => $total_pages,
              'total_records' => $total_records,
              'limit'         => $limit,
              'offset'        => $offset,
              'coupon'        => $coupon
            ]);
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Copy Voucher Code to Clipboard
  function copyVoucherCode(code, btn) {
    if (!navigator.clipboard) {
      const el = document.createElement('textarea');
      el.value = code;
      document.body.appendChild(el);
      el.select();
      document.execCommand('copy');
      document.body.removeChild(el);
    } else {
      navigator.clipboard.writeText(code);
    }

    const origHTML = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check2"></i>';
    btn.classList.add('bg-success', 'text-white');

    setTimeout(() => {
      btn.innerHTML = origHTML;
      btn.classList.remove('bg-success', 'text-white');
    }, 1500);
  }

  // Seamless AJAX Pagination without Page Reload
  document.addEventListener('DOMContentLoaded', function() {
    const couponId = <?= (int)$coupon->id ?>;
    const paginationWrapper = document.getElementById('redemptionsPaginationWrapper');
    const tableBody = document.getElementById('redemptionsTableBody');
    const overlay = document.getElementById('tableLoadingOverlay');

    function loadRedemptionsPage(pageNum) {
      if (!pageNum || pageNum < 1) return;

      if (overlay) overlay.classList.add('active');

      const url = `<?= base_url('admin/coupons/view/') ?>${couponId}?page=${pageNum}&ajax=1`;

      fetch(url, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => {
        if (!response.ok) throw new Error('Network response error');
        return response.json();
      })
      .then(data => {
        if (data.success) {
          if (tableBody) tableBody.innerHTML = data.html;
          if (paginationWrapper) paginationWrapper.innerHTML = data.pagination_html;
        }
      })
      .catch(err => {
        console.error('AJAX Pagination Error:', err);
      })
      .finally(() => {
        if (overlay) overlay.classList.remove('active');
      });
    }

    // Event Delegation for pagination clicks
    document.addEventListener('click', function(e) {
      const pageLink = e.target.closest('.ajax-page-link');
      if (pageLink) {
        e.preventDefault();
        const pageNum = pageLink.getAttribute('data-page');
        if (pageNum) {
          loadRedemptionsPage(pageNum);
        }
      }
    });
  });
</script>
