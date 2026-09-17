<?php
  $display_admin_name = isset($admin_name) ? $admin_name : (isset($this->session) ? ($this->session->userdata('admin_name') ?? 'Admin') : 'Admin');
  $first_letter = strtoupper(substr($display_admin_name, 0, 1));
  $today_date = date('D, d M Y');
?>

<style>
/* ============================================================
   ADMIN DASHBOARD COMPONENTS & TIGHT COMPACT SPACING
   ============================================================ */

.welcome-banner-card {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid var(--srl-border);
  border-top: 3.5px solid var(--srl-pink);
  padding: 14px 20px;
  margin-bottom: 18px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
}

.welcome-banner-left {
  display: flex;
  align-items: center;
  gap: 14px;
}

.welcome-banner-avatar {
  width: 42px;
  height: 42px;
  border-radius: 10px;
  background: var(--srl-pink-gradient);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 1.2rem;
  box-shadow: 0 3px 10px rgba(225, 29, 116, 0.25);
  flex-shrink: 0;
}

.welcome-title-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 2px;
  flex-wrap: wrap;
}

.welcome-title-row h4 {
  margin: 0;
  font-size: 1.15rem;
  font-weight: 800;
  color: #0f172a;
}

.badge-live {
  background: #ecfdf5;
  color: #10b981;
  font-size: 0.72rem;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 12px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.badge-date {
  background: #f1f5f9;
  color: #64748b;
  font-size: 0.72rem;
  font-weight: 600;
  padding: 2px 8px;
  border-radius: 12px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.welcome-subtitle {
  margin: 0;
  font-size: 0.82rem;
  color: #64748b;
}

.welcome-banner-actions {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
}

.welcome-banner-actions .btn-srl-primary,
.welcome-banner-actions .btn-srl-outline {
  padding: 6px 14px;
  font-size: 0.82rem;
  font-weight: 600;
  border-radius: 50px;
}

/* Compact KPI Stat Cards */
.stat-card-compact {
  background: #ffffff;
  border-radius: 14px;
  border: 1px solid var(--srl-border);
  padding: 14px 16px;
  position: relative;
  transition: all 0.2s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.stat-card-compact:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(15, 23, 42, 0.05);
}

.stat-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 6px;
}

.stat-card-label {
  font-size: 0.68rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  color: #64748b;
  margin: 0;
}

.stat-icon-box {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  flex-shrink: 0;
}

.stat-icon-box.pink   { background: #ffe4e6; color: var(--srl-pink); }
.stat-icon-box.yellow { background: #fef3c7; color: #d97706; }
.stat-icon-box.green  { background: #dcfce7; color: #16a34a; }
.stat-icon-box.blue   { background: #e0f2fe; color: #0284c7; }
.stat-icon-box.teal   { background: #ccfbf1; color: #0d9488; }
.stat-icon-box.orange { background: #ffedd5; color: #ea580c; }

.stat-card-value {
  font-size: 1.35rem;
  font-weight: 800;
  color: #0f172a;
  margin: 0 0 6px;
  line-height: 1.2;
}

.stat-card-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 0.74rem;
  flex-wrap: wrap;
  gap: 4px;
  padding-top: 8px;
  border-top: 1px dashed #f1f5f9;
}

.stat-pill {
  display: inline-flex;
  align-items: center;
  gap: 3px;
  padding: 1.5px 7px;
  border-radius: 5px;
  font-size: 0.7rem;
  font-weight: 600;
}

.stat-pill.success { background: #ecfdf5; color: #059669; }
.stat-pill.warning { background: #fffbeb; color: #d97706; }
.stat-pill.danger  { background: #fee2e2; color: #dc2626; }
.stat-pill.info    { background: #eff6ff; color: #2563eb; }

/* Dashboard Section Cards (No empty voids, natural height) */
.dashboard-card {
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid var(--srl-border);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
  overflow: hidden;
  height: auto;
  margin-bottom: 0;
}

.dashboard-card-header {
  padding: 12px 18px;
  background: #ffffff;
  border-bottom: 1px solid var(--srl-border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 8px;
}

.dashboard-card-title {
  font-size: 0.92rem;
  font-weight: 700;
  color: #0f172a;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 7px;
}

.dashboard-card-body {
  padding: 0;
}

/* Order Status Badges */
.order-status-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 0.72rem;
  font-weight: 700;
  padding: 2.5px 8px;
  border-radius: 6px;
  letter-spacing: 0.2px;
  white-space: nowrap;
}

.status-badge-awaiting-payment { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.status-badge-placed           { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.status-badge-confirmed        { background: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe; }
.status-badge-packed           { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }
.status-badge-out-for-delivery { background: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }
.status-badge-delivered        { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.status-badge-cancelled        { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

/* Custom Snug Table */
.dashboard-table th {
  background: #f8fafc;
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
  border-bottom: 1px solid var(--srl-border);
  padding: 9px 14px;
  white-space: nowrap;
}

.dashboard-table td {
  padding: 9px 14px;
  vertical-align: middle;
  border-bottom: 1px solid #f1f5f9;
  font-size: 0.83rem;
}

.dashboard-table tr:last-child td {
  border-bottom: none;
}

.dashboard-table tr:hover td {
  background-color: #fafbfc;
}

/* Customer Item Row */
.customer-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 16px;
  border-bottom: 1px solid #f1f5f9;
  transition: background-color 0.15s ease;
}

.customer-item:last-child {
  border-bottom: none;
}

.customer-item:hover {
  background-color: #fafbfc;
}

.customer-avatar {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: linear-gradient(135deg, #ff2a85 0%, #1e1526 100%);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.88rem;
  flex-shrink: 0;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
  .welcome-banner-card {
    flex-direction: column;
    align-items: flex-start;
    padding: 14px;
    gap: 12px;
    border-radius: 12px;
  }
  .welcome-banner-left {
    gap: 10px;
  }
  .welcome-banner-avatar {
    width: 38px;
    height: 38px;
    font-size: 1.1rem;
  }
  .welcome-title-row h4 {
    font-size: 1.05rem;
  }
  .welcome-banner-actions {
    width: 100%;
  }
  .welcome-banner-actions a {
    flex: 1;
    justify-content: center;
    font-size: 0.78rem;
    padding: 6px 10px;
    text-align: center;
  }
  .stat-card-compact {
    padding: 12px 14px;
    border-radius: 12px;
  }
  .stat-card-value {
    font-size: 1.25rem;
    margin-bottom: 4px;
  }
  .dashboard-card-header {
    padding: 10px 14px;
  }
  .dashboard-table th,
  .dashboard-table td {
    padding: 8px 10px;
  }
  .customer-item {
    padding: 8px 12px;
  }
}
</style>

<!-- Welcome Banner -->
<div class="welcome-banner-card">
  <div class="welcome-banner-left">
    <div class="welcome-banner-avatar">
      <?= $first_letter ?>
    </div>
    <div>
      <div class="welcome-title-row">
        <h4>Welcome back, <?= html_escape($display_admin_name) ?>! 👋</h4>
        <span class="badge-live"><i class="bi bi-circle-fill" style="font-size: 6px;"></i> Live Data</span>
        <span class="badge-date"><i class="bi bi-calendar3"></i> <?= $today_date ?></span>
      </div>
      <p class="welcome-subtitle">Store command center: live sales, active storefront orders, and catalog inventory.</p>
    </div>
  </div>
  <div class="welcome-banner-actions">
    <a href="<?= base_url('admin/products/add') ?>" class="btn-srl-primary">
      <i class="bi bi-plus-lg"></i> Add Product
    </a>
    <a href="<?= base_url('admin/orders') ?>" class="btn-srl-outline">
      <i class="bi bi-receipt"></i> Online Orders
    </a>
    <a href="<?= base_url('admin/offline_orders') ?>" class="btn-srl-outline">
      <i class="bi bi-shop"></i> Offline Orders
    </a>
  </div>
</div>

<!-- 6 KPI Stat Cards Grid (Single-row on XXL, 2 rows on MD, 0 empty space) -->
<div class="row g-2 g-md-3 mb-3">
  <!-- 1. Gross Online Sales -->
  <div class="col-xxl-2 col-md-4 col-sm-6">
    <div class="stat-card-compact">
      <div>
        <div class="stat-card-header">
          <span class="stat-card-label">Online Sales</span>
          <div class="stat-icon-box pink">
            <i class="bi bi-graph-up-arrow"></i>
          </div>
        </div>
        <h3 class="stat-card-value">₹<?= number_format($gross_online_revenue, 2) ?></h3>
      </div>
      <div class="stat-card-footer">
        <span class="text-muted d-flex align-items-center gap-1" style="font-size: 0.72rem;">
          <i class="bi bi-check-circle-fill text-success"></i> ₹<?= number_format($paid_online_revenue, 2) ?>
        </span>
        <span class="stat-pill success">₹<?= number_format($today_online_revenue, 2) ?> Today</span>
      </div>
    </div>
  </div>

  <!-- 2. Store Walk-in Sales -->
  <div class="col-xxl-2 col-md-4 col-sm-6">
    <div class="stat-card-compact">
      <div>
        <div class="stat-card-header">
          <span class="stat-card-label">Store Sales</span>
          <div class="stat-icon-box yellow">
            <i class="bi bi-shop"></i>
          </div>
        </div>
        <h3 class="stat-card-value">₹<?= number_format($offline_revenue, 2) ?></h3>
      </div>
      <div class="stat-card-footer">
        <span class="stat-pill warning"><?= $offline_orders_count ?> Offline Orders</span>
        <a href="<?= base_url('admin/offline_orders') ?>" class="text-decoration-none fw-semibold" style="color: #d97706;">Store &rarr;</a>
      </div>
    </div>
  </div>

  <!-- 3. Total Online Orders Placed -->
  <div class="col-xxl-2 col-md-4 col-sm-6">
    <div class="stat-card-compact">
      <div>
        <div class="stat-card-header">
          <span class="stat-card-label">Online Orders</span>
          <div class="stat-icon-box blue">
            <i class="bi bi-cart-check"></i>
          </div>
        </div>
        <h3 class="stat-card-value"><?= $total_orders_count ?> <span class="fs-6 fw-normal text-muted">Orders</span></h3>
      </div>
      <div class="stat-card-footer">
        <div class="d-flex gap-1 flex-wrap">
          <span class="stat-pill success"><?= $delivered_orders_count ?> Done</span>
          <span class="stat-pill info"><?= $pending_orders_count ?> Active</span>
        </div>
        <a href="<?= base_url('admin/orders') ?>" class="text-decoration-none fw-semibold" style="color: var(--srl-pink);">Orders &rarr;</a>
      </div>
    </div>
  </div>

  <!-- 4. Registered Customers -->
  <div class="col-xxl-2 col-md-4 col-sm-6">
    <div class="stat-card-compact">
      <div>
        <div class="stat-card-header">
          <span class="stat-card-label">Customers</span>
          <div class="stat-icon-box green">
            <i class="bi bi-people"></i>
          </div>
        </div>
        <h3 class="stat-card-value"><?= $member_count ?> <span class="fs-6 fw-normal text-muted">Users</span></h3>
      </div>
      <div class="stat-card-footer">
        <div class="d-flex gap-1 flex-wrap">
          <span class="stat-pill success"><?= $active_customers_count ?> Active</span>
          <span class="stat-pill info">+<?= $new_customers_month ?> Month</span>
        </div>
        <a href="<?= base_url('admin/customers') ?>" class="text-decoration-none fw-semibold" style="color: var(--srl-pink);">Users &rarr;</a>
      </div>
    </div>
  </div>

  <!-- 5. Product Catalog -->
  <div class="col-xxl-2 col-md-4 col-sm-6">
    <div class="stat-card-compact">
      <div>
        <div class="stat-card-header">
          <span class="stat-card-label">Catalog</span>
          <div class="stat-icon-box teal">
            <i class="bi bi-box-seam"></i>
          </div>
        </div>
        <h3 class="stat-card-value"><?= $product_count ?> <span class="fs-6 fw-normal text-muted">Items</span></h3>
      </div>
      <div class="stat-card-footer">
        <div class="d-flex gap-1 flex-wrap">
          <span class="stat-pill info"><?= $category_count ?> Cats</span>
          <span class="stat-pill success"><?= $active_products_count ?> Active</span>
        </div>
        <a href="<?= base_url('admin/products') ?>" class="text-decoration-none fw-semibold" style="color: #0d9488;">Catalog &rarr;</a>
      </div>
    </div>
  </div>

  <!-- 6. Inventory / Out of Stock Alert -->
  <div class="col-xxl-2 col-md-4 col-sm-6">
    <div class="stat-card-compact">
      <div>
        <div class="stat-card-header">
          <span class="stat-card-label">Stockouts</span>
          <div class="stat-icon-box orange">
            <i class="bi bi-exclamation-triangle"></i>
          </div>
        </div>
        <h3 class="stat-card-value"><?= $out_of_stock_count ?> <span class="fs-6 fw-normal text-muted">Out</span></h3>
      </div>
      <div class="stat-card-footer">
        <?php if ($out_of_stock_count > 0): ?>
          <span class="stat-pill danger"><?= $out_of_stock_count ?> Restock</span>
        <?php elseif ($low_stock_count > 0): ?>
          <span class="stat-pill warning"><?= $low_stock_count ?> Low (≤5)</span>
        <?php else: ?>
          <span class="stat-pill success"><i class="bi bi-check-circle-fill"></i> Healthy</span>
        <?php endif; ?>
        <a href="<?= base_url('admin/products?stock_status=out_of_stock') ?>" class="text-decoration-none fw-semibold" style="color: #ea580c;">Stock &rarr;</a>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================
     BALANCED TWO-COLUMN DASHBOARD LAYOUT (ZERO EMPTY SPACE)
     Left: Online Orders + Out of Stock / Inventory Watchlist
     Right: New Customers + Offline / Walk-in Store Orders
     ============================================================ -->
<div class="row g-3">
  <!-- LEFT COLUMN (col-xl-7 col-lg-7) -->
  <div class="col-xl-7 col-lg-7">
    <!-- 1. New Online Orders -->
    <div class="dashboard-card mb-3">
      <div class="dashboard-card-header">
        <div class="d-flex align-items-center gap-2">
          <h5 class="dashboard-card-title">
            <i class="bi bi-receipt" style="color: var(--srl-pink);"></i> New Orders
          </h5>
          <span class="badge rounded-pill bg-light text-dark border small px-2 py-0.5" style="font-size: 0.72rem;">Latest 5</span>
        </div>
        <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-srl-primary rounded-pill px-3 py-1 fw-bold d-inline-flex align-items-center gap-1 shadow-sm" style="font-size: 0.76rem;">
          View All <i class="bi bi-arrow-right"></i>
        </a>
      </div>
      <div class="dashboard-card-body">
        <?php if (!empty($recent_orders)): ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 dashboard-table">
              <thead>
                <tr>
                  <th class="ps-3">Order #</th>
                  <th>Customer</th>
                  <th>Amount</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th class="text-end pe-3">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recent_orders as $ord): ?>
                  <?php
                    $status_class = 'status-badge-placed';
                    $status_icon  = 'bi bi-receipt';
                    switch ($ord->order_status) {
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
                  <tr>
                    <td class="ps-3">
                      <a href="<?= base_url('admin/orders/detail/' . $ord->id) ?>" class="fw-bold text-dark text-decoration-none">
                        #<?= html_escape($ord->order_number) ?>
                      </a>
                    </td>
                    <td>
                      <div class="fw-semibold text-dark text-truncate" style="max-width: 140px; font-size: 0.82rem;"><?= html_escape($ord->shipping_full_name) ?></div>
                      <div class="text-muted text-truncate" style="font-size: 0.72rem; max-width: 140px;">
                        <?= html_escape($ord->shipping_city) ?>
                      </div>
                    </td>
                    <td>
                      <span class="fw-bold text-dark" style="font-size: 0.86rem;">₹<?= number_format($ord->total_amount, 2) ?></span>
                    </td>
                    <td>
                      <span class="order-status-badge <?= $status_class ?>">
                        <i class="<?= $status_icon ?>"></i> <?= html_escape($ord->order_status) ?>
                      </span>
                    </td>
                    <td class="text-muted text-nowrap" style="font-size: 0.73rem;">
                      <?= date('d M Y, h:i A', strtotime($ord->created_at)) ?>
                    </td>
                    <td class="text-end pe-3 text-nowrap">
                      <a href="<?= base_url('admin/orders/detail/' . $ord->id) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-0.5 fw-semibold" style="font-size: 0.72rem;" title="View Details">
                        View
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="text-center py-4">
            <div class="rounded-circle p-2.5 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(225, 29, 116, 0.08); color: var(--srl-pink);">
              <i class="bi bi-inbox fs-4"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1 small">No Online Orders Found</h6>
            <p class="text-muted mb-0" style="font-size: 0.74rem;">No customer orders placed yet.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- 2. Out of Stock Products & Inventory Watchlist -->
    <div class="dashboard-card">
      <div class="dashboard-card-header">
        <div class="d-flex align-items-center gap-2">
          <h5 class="dashboard-card-title">
            <i class="bi bi-box-seam" style="color: #ea580c;"></i> Out of Stock Products
          </h5>
          <?php if (!empty($out_of_stock_products)): ?>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle small px-2 py-0.5" style="font-size: 0.72rem;">
              <?= count($out_of_stock_products) ?> Items
            </span>
          <?php else: ?>
            <span class="badge bg-success-subtle text-success border border-success-subtle small px-2 py-0.5" style="font-size: 0.72rem;">
              All In Stock
            </span>
          <?php endif; ?>
        </div>
        <a href="<?= base_url('admin/products?stock_status=out_of_stock') ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.76rem;">
          View All <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="dashboard-card-body">
        <?php if (!empty($out_of_stock_products)): ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 dashboard-table">
              <thead>
                <tr>
                  <th class="ps-3">Product</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th class="text-end pe-3">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($out_of_stock_products as $p): ?>
                  <tr>
                    <td class="ps-3">
                      <div class="d-flex align-items-center gap-2">
                        <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center bg-light border flex-shrink-0" style="width: 34px; height: 34px;">
                          <?php if (!empty($p->image) && file_exists('./uploads/products/' . $p->image)): ?>
                            <img src="<?= base_url('uploads/products/' . $p->image) ?>" alt="<?= html_escape($p->name) ?>" class="w-100 h-100 object-fit-cover">
                          <?php else: ?>
                            <i class="bi bi-image text-muted" style="font-size: 0.85rem;"></i>
                          <?php endif; ?>
                        </div>
                        <div class="min-w-0">
                          <span class="fw-bold text-dark d-block text-truncate" style="max-width: 180px; font-size: 0.82rem;"><?= html_escape($p->name) ?></span>
                          <span class="text-muted" style="font-size: 0.7rem;"><?= !empty($p->sku) ? 'SKU: ' . html_escape($p->sku) : '' ?></span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="fw-bold text-dark" style="font-size: 0.84rem;">₹<?= number_format($p->price, 2) ?></span>
                    </td>
                    <td>
                      <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-0.5" style="font-size: 0.7rem;">
                        <i class="bi bi-x-circle me-1"></i>0 stock
                      </span>
                    </td>
                    <td class="text-end pe-3">
                      <a href="<?= base_url('admin/products/edit/' . $p->id) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-0.5 fw-semibold" style="font-size: 0.72rem;">
                        Restock
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <!-- Compact Status Bar (Zero giant empty white space) -->
          <div class="p-2.5 px-3 bg-success-subtle border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-check-circle-fill text-success fs-6"></i>
              <span class="fw-bold small text-success-emphasis" style="font-size: 0.8rem;">All Products In Stock</span>
              <span class="text-muted small d-none d-sm-inline" style="font-size: 0.74rem;">• No active stockouts detected</span>
            </div>
            <span class="badge bg-white text-success border small" style="font-size: 0.68rem;">Healthy</span>
          </div>

          <?php if (!empty($lowest_stock_products)): ?>
            <div class="px-3 py-1.5 bg-light border-bottom d-flex justify-content-between align-items-center">
              <span class="text-uppercase fw-bold text-muted" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                <i class="bi bi-eye text-primary me-1"></i>Inventory Watchlist (Lowest Remaining Stock)
              </span>
              <span class="text-muted small" style="font-size: 0.68rem;">Top 5 items</span>
            </div>
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0 dashboard-table">
                <tbody>
                  <?php foreach ($lowest_stock_products as $p): ?>
                    <tr>
                      <td class="ps-3">
                        <div class="d-flex align-items-center gap-2">
                          <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center bg-light border flex-shrink-0" style="width: 32px; height: 32px;">
                            <?php if (!empty($p->image) && file_exists('./uploads/products/' . $p->image)): ?>
                              <img src="<?= base_url('uploads/products/' . $p->image) ?>" alt="<?= html_escape($p->name) ?>" class="w-100 h-100 object-fit-cover">
                            <?php else: ?>
                              <i class="bi bi-image text-muted" style="font-size: 0.85rem;"></i>
                            <?php endif; ?>
                          </div>
                          <div class="min-w-0">
                            <span class="fw-semibold text-dark d-block text-truncate" style="max-width: 170px; font-size: 0.8rem;"><?= html_escape($p->name) ?></span>
                            <span class="text-muted" style="font-size: 0.68rem;"><?= !empty($p->sku) ? 'SKU: ' . html_escape($p->sku) : '' ?></span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="fw-semibold text-dark" style="font-size: 0.82rem;">₹<?= number_format($p->price, 2) ?></span>
                      </td>
                      <td>
                        <span class="badge <?= ($p->stock <= 5) ? 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' : 'bg-light text-dark border' ?> px-2 py-0.5" style="font-size: 0.7rem;">
                          <?= $p->stock ?> left
                        </span>
                      </td>
                      <td class="text-end pe-3">
                        <a href="<?= base_url('admin/products/edit/' . $p->id) ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-0.5" style="font-size: 0.7rem;">
                          Edit
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- RIGHT COLUMN (col-xl-5 col-lg-5) -->
  <div class="col-xl-5 col-lg-5">
    <!-- 1. New Customers -->
    <div class="dashboard-card mb-3">
      <div class="dashboard-card-header">
        <div class="d-flex align-items-center gap-2">
          <h5 class="dashboard-card-title">
            <i class="bi bi-people-fill text-primary"></i> New Customers
          </h5>
          <span class="badge rounded-pill bg-light text-dark border small px-2 py-0.5" style="font-size: 0.72rem;">Latest 5</span>
        </div>
        <a href="<?= base_url('admin/customers') ?>" class="btn btn-sm btn-srl-outline rounded-pill px-3 py-1 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.76rem;">
          View All <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="dashboard-card-body">
        <?php if (!empty($recent_customers)): ?>
          <?php foreach ($recent_customers as $cust): ?>
            <?php $c_initial = strtoupper(substr($cust->name ?? 'C', 0, 1)); ?>
            <div class="customer-item">
              <div class="d-flex align-items-center gap-2.5 min-w-0">
                <div class="customer-avatar">
                  <?= $c_initial ?>
                </div>
                <div class="min-w-0">
                  <span class="fw-bold text-dark d-block text-truncate" style="font-size: 0.83rem; max-width: 150px;">
                    <?= html_escape($cust->name) ?>
                  </span>
                  <small class="text-muted d-block text-truncate" style="font-size: 0.71rem; max-width: 150px;">
                    <?= html_escape($cust->email) ?>
                  </small>
                </div>
              </div>

              <div class="text-end flex-shrink-0 ms-2">
                <?php if ($cust->status == 1): ?>
                  <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5" style="font-size: 0.66rem;">
                    Active
                  </span>
                <?php else: ?>
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-0.5" style="font-size: 0.66rem;">
                    Inactive
                  </span>
                <?php endif; ?>
                <div class="text-muted" style="font-size: 0.68rem; margin-top: 1px;">
                  <?= date('d M Y', strtotime($cust->created_at)) ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="text-center py-4">
            <div class="rounded-circle p-2.5 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(37, 99, 235, 0.08); color: #2563eb;">
              <i class="bi bi-people fs-4"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1 small">No Customers Yet</h6>
            <p class="text-muted mb-0" style="font-size: 0.74rem;">New accounts will show here.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- 2. Store / Walk-in Offline Orders (Balances Right Column - ZERO empty space) -->
    <div class="dashboard-card">
      <div class="dashboard-card-header">
        <div class="d-flex align-items-center gap-2">
          <h5 class="dashboard-card-title">
            <i class="bi bi-shop" style="color: #d97706;"></i> Store / Offline Orders
          </h5>
          <span class="badge rounded-pill bg-light text-dark border small px-2 py-0.5" style="font-size: 0.72rem;">Latest 5</span>
        </div>
        <a href="<?= base_url('admin/offline_orders') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.76rem;">
          View All <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <div class="dashboard-card-body">
        <?php if (!empty($recent_offline_orders)): ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 dashboard-table">
              <thead>
                <tr>
                  <th class="ps-3">Order #</th>
                  <th>Customer</th>
                  <th>Amount</th>
                  <th class="text-end pe-3">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($recent_offline_orders as $off): ?>
                  <tr>
                    <td class="ps-3">
                      <a href="<?= base_url('admin/offline_orders/detail/' . $off->id) ?>" class="fw-bold text-dark text-decoration-none" style="font-size: 0.8rem;">
                        #<?= html_escape($off->order_number) ?>
                      </a>
                    </td>
                    <td>
                      <span class="fw-semibold text-dark d-block text-truncate" style="max-width: 120px; font-size: 0.8rem;"><?= html_escape($off->shipping_full_name) ?></span>
                      <span class="text-muted" style="font-size: 0.68rem;"><?= html_escape($off->shipping_mobile) ?></span>
                    </td>
                    <td>
                      <span class="fw-bold text-dark" style="font-size: 0.82rem;">₹<?= number_format($off->total_amount, 2) ?></span>
                    </td>
                    <td class="text-end pe-3">
                      <span class="badge <?= ($off->payment_status === 'Paid') ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' ?> rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                        <?= html_escape($off->payment_status ?? 'Pending') ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="text-center py-4">
            <div class="rounded-circle p-2.5 d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: rgba(217, 119, 6, 0.08); color: #d97706;">
              <i class="bi bi-shop fs-4"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1 small">No Offline Orders</h6>
            <p class="text-muted mb-0" style="font-size: 0.74rem;">Walk-in counter sales will appear here.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
