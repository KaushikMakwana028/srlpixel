<?php
  $admin_name = $this->session->userdata('admin_name') ? $this->session->userdata('admin_name') : 'Ravi';
  $first_letter = strtoupper(substr($admin_name, 0, 1));
  $today_date = date('D, d M Y');
?>

<!-- Welcome Banner (Replicates Reference Image) -->
<div class="welcome-banner-card">
  <div class="welcome-banner-left">
    <div class="welcome-banner-avatar">
      <?= $first_letter ?>
    </div>
    <div>
      <div class="welcome-title-row">
        <h4>Welcome back, <?= html_escape($admin_name) ?>! 👋</h4>
        <span class="badge-live"><i class="bi bi-circle-fill" style="font-size: 6px;"></i> Live</span>
        <span class="badge-date"><i class="bi bi-calendar3"></i> <?= $today_date ?></span>
      </div>
      <p class="welcome-subtitle">Enterprise business control center & MLM affiliate analytics overview.</p>
    </div>
  </div>
  <div class="welcome-banner-actions">
    <a href="<?= base_url('admin/products/add') ?>" class="btn-srl-primary">
      <i class="bi bi-plus-lg"></i> Add Product
    </a>
    <a href="<?= base_url('admin/categories') ?>" class="btn-srl-outline">
      <i class="bi bi-diagram-3"></i> Categories
    </a>
  </div>
</div>

<!-- Stat Cards Grid (Replicates Reference Image) -->
<div class="row g-4 mb-4">
  <!-- Gross Sales Revenue -->
  <div class="col-xl-4 col-md-6">
    <div class="stat-card">
      <div class="stat-card-header">
        <span class="stat-card-label">Gross Sales Revenue</span>
        <div class="stat-icon-box pink">
          <i class="bi bi-graph-up-arrow"></i>
        </div>
      </div>
      <h3 class="stat-card-value">₹101,300.00</h3>
      <div class="stat-card-footer">
        <span class="text-muted d-flex align-items-center gap-1">
          <i class="bi bi-check-circle-fill text-success" style="font-size: 0.75rem;"></i> Confirmed order volume
        </span>
        <span class="stat-pill success">Verified</span>
      </div>
    </div>
  </div>

  <!-- Admin Revenue Cut -->
  <div class="col-xl-4 col-md-6">
    <div class="stat-card">
      <div class="stat-card-header">
        <span class="stat-card-label">Admin Revenue Cut</span>
        <div class="stat-icon-box yellow">
          <i class="bi bi-cash-stack"></i>
        </div>
      </div>
      <h3 class="stat-card-value">₹34,116.00</h3>
      <div class="stat-card-footer">
        <span class="text-muted d-flex align-items-center gap-1">
          <span class="text-warning fw-bold">%</span> Platform retained profit
        </span>
        <span class="stat-pill warning">Earnings</span>
      </div>
    </div>
  </div>

  <!-- Affiliate Commissions -->
  <div class="col-xl-4 col-md-6">
    <div class="stat-card">
      <div class="stat-card-header">
        <span class="stat-card-label">Affiliate Commissions</span>
        <div class="stat-icon-box teal">
          <i class="bi bi-diagram-3"></i>
        </div>
      </div>
      <h3 class="stat-card-value">₹24,910.00</h3>
      <div class="stat-card-footer">
        <span class="text-muted d-flex align-items-center gap-1">
          <i class="bi bi-people-fill text-primary" style="font-size: 0.75rem;"></i> 12-level network
        </span>
        <span class="stat-pill info">Active</span>
      </div>
    </div>
  </div>

  <!-- Total Orders Placed -->
  <div class="col-xl-4 col-md-6">
    <div class="stat-card">
      <div class="stat-card-header">
        <span class="stat-card-label">Total Orders Placed</span>
        <div class="stat-icon-box blue">
          <i class="bi bi-cart-check"></i>
        </div>
      </div>
      <h3 class="stat-card-value">13 <span class="fs-6 fw-normal text-muted">Orders</span></h3>
      <div class="stat-card-footer">
        <div class="d-flex gap-2">
          <span class="stat-pill success">11 Completed</span>
          <span class="stat-pill warning">2 Pending</span>
        </div>
        <a href="#" class="text-decoration-none fw-semibold small" style="color: var(--srl-pink);">View All &rarr;</a>
      </div>
    </div>
  </div>

  <!-- Network Members -->
  <div class="col-xl-4 col-md-6">
    <div class="stat-card">
      <div class="stat-card-header">
        <span class="stat-card-label">Network Members</span>
        <div class="stat-icon-box green">
          <i class="bi bi-people"></i>
        </div>
      </div>
      <h3 class="stat-card-value"><?= isset($member_count) ? $member_count : '0' ?> <span class="fs-6 fw-normal text-muted">Active Users</span></h3>
      <div class="stat-card-footer">
        <span class="text-muted d-flex align-items-center gap-1">
          <i class="bi bi-box-seam text-success" style="font-size: 0.75rem;"></i> <?= isset($product_count) ? $product_count : '0' ?> Products in catalog
        </span>
        <a href="<?= base_url('admin/customers') ?>" class="text-decoration-none fw-semibold small" style="color: var(--srl-pink);">Directory &rarr;</a>
      </div>
    </div>
  </div>

  <!-- Pending Deposits -->
  <div class="col-xl-4 col-md-6">
    <div class="stat-card">
      <div class="stat-card-header">
        <span class="stat-card-label">Pending Deposits</span>
        <div class="stat-icon-box orange">
          <i class="bi bi-wallet-fill"></i>
        </div>
      </div>
      <h3 class="stat-card-value">₹5,000.00</h3>
      <div class="stat-card-footer">
        <span class="stat-pill warning"><i class="bi bi-exclamation-triangle-fill me-1"></i>1 require action</span>
        <a href="#" class="text-decoration-none fw-semibold small" style="color: #ea580c;">Review &rarr;</a>
      </div>
    </div>
  </div>
</div>
