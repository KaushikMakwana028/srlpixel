<style>
/* ============================================================
   ADMIN OFFLINE ORDERS VIEW STYLES
   ============================================================ */

.order-status-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 0.76rem;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 8px;
  letter-spacing: 0.3px;
  white-space: nowrap;
}

.status-awaiting-payment {
  background: #fef3c7;
  color: #92400e;
  border: 1px solid #fde68a;
}

.status-placed {
  background: #e0f2fe;
  color: #0369a1;
  border: 1px solid #bae6fd;
}

.status-confirmed {
  background: #ede9fe;
  color: #6d28d9;
  border: 1px solid #ddd6fe;
}

.status-packed {
  background: #ffedd5;
  color: #c2410c;
  border: 1px solid #fed7aa;
}

.status-out-for-delivery {
  background: #fef9c3;
  color: #854d0e;
  border: 1px solid #fef08a;
}

.status-delivered {
  background: #dcfce7;
  color: #15803d;
  border: 1px solid #bbf7d0;
}

.status-cancelled {
  background: #fee2e2;
  color: #b91c1c;
  border: 1px solid #fecaca;
}

.order-filter-pill-nav {
  display: flex;
  gap: 8px;
  overflow-x: auto;
  padding-bottom: 4px;
  margin-bottom: 20px;
  scrollbar-width: none;
}

.order-filter-pill-nav::-webkit-scrollbar {
  display: none;
}

.order-filter-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 50px;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  color: #475569;
  font-size: 0.82rem;
  font-weight: 600;
  text-decoration: none;
  white-space: nowrap;
  transition: all 0.2s ease;
  cursor: pointer;
}

.order-filter-pill:hover {
  background: #f8fafc;
  color: var(--srl-pink);
  border-color: rgba(225, 29, 116, 0.4);
}

.order-filter-pill.active {
  background: var(--srl-pink-gradient) !important;
  color: #ffffff !important;
  border-color: transparent !important;
  box-shadow: 0 4px 12px rgba(225, 29, 116, 0.35);
}

.order-filter-pill .pill-count {
  background: rgba(0, 0, 0, 0.07);
  padding: 1px 7px;
  border-radius: 12px;
  font-size: 0.72rem;
  font-weight: 700;
}

.order-filter-pill.active .pill-count {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}

/* Compact Table Action Icon Buttons */
.btn-table-action {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 0.85rem;
  border: 1px solid transparent;
  text-decoration: none;
  transition: all 0.18s ease-in-out;
  cursor: pointer;
  padding: 0;
}

.btn-action-view {
  background: #eff6ff;
  color: #2563eb;
  border-color: #dbeafe;
}
.btn-action-view:hover {
  background: #2563eb;
  color: #ffffff;
  border-color: #2563eb;
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
}

.btn-action-edit {
  background: #fffbeb;
  color: #d97706;
  border-color: #fef3c7;
}
.btn-action-edit:hover {
  background: #d97706;
  color: #ffffff;
  border-color: #d97706;
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(217, 119, 6, 0.25);
}

.btn-action-print {
  background: #f1f5f9;
  color: #475569;
  border-color: #e2e8f0;
}
.btn-action-print:hover {
  background: #475569;
  color: #ffffff;
  border-color: #475569;
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(71, 85, 105, 0.25);
}

.btn-action-delete {
  background: #fef2f2;
  color: #dc2626;
  border-color: #fee2e2;
}
.btn-action-delete:hover {
  background: #dc2626;
  color: #ffffff;
  border-color: #dc2626;
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(220, 38, 38, 0.25);
}
</style>

<div class="container-fluid px-3 px-md-4 py-4">
  <!-- Page Header with Prominent '+ Create Offline Order' CTA -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h3 class="fw-extrabold text-dark mb-0">Offline Orders</h3>
        <span class="badge rounded-pill bg-light text-secondary border px-3 py-1" style="font-size: 0.75rem;">
          POS & Counter Sales
        </span>
      </div>
      <p class="text-muted small mb-0">Manage manual store purchases, customer counter walk-ins, and phone orders.</p>
    </div>

    <!-- Create Order Button -->
    <a href="<?= base_url('admin/offline_orders/create') ?>" class="btn-srl-primary rounded-pill px-4 py-2 fw-bold d-inline-flex align-items-center gap-2 text-decoration-none shadow-sm">
      <i class="bi bi-plus-circle-fill fs-6"></i>
      <span>Create Offline Order</span>
    </a>
  </div>

  <!-- Summary Stats Strip -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background: rgba(225, 29, 116, 0.1); color: var(--srl-pink); font-size: 1.25rem;">
            <i class="bi bi-shop"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold">Total Offline</div>
            <h4 class="fw-bold text-dark mb-0" id="statTotalOrders"><?= number_format($counts['all']) ?></h4>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-success" style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.12); font-size: 1.25rem;">
            <i class="bi bi-check2-circle"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold">Paid In Full</div>
            <h4 class="fw-bold text-success mb-0"><?= number_format($counts['Paid']) ?></h4>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-warning" style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.12); font-size: 1.25rem;">
            <i class="bi bi-clock-history"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold">Payment Pending</div>
            <h4 class="fw-bold text-warning mb-0" id="statPendingOrders"><?= number_format($counts['Pending']) ?></h4>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="card border-0 shadow-sm rounded-4 p-3 h-100" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-primary" style="width: 44px; height: 44px; background: rgba(13, 110, 253, 0.12); font-size: 1.25rem;">
            <i class="bi bi-box-seam"></i>
          </div>
          <div>
            <div class="text-muted small fw-semibold">Delivered</div>
            <h4 class="fw-bold text-primary mb-0"><?= number_format($counts['Delivered']) ?></h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Standard SRL Filter Card with Dropdowns -->
  <div class="srl-filter-card mb-4">
    <div class="row g-3 align-items-center">
      <!-- Search Input -->
      <div class="col-12 col-md-4 col-lg-4">
        <div class="srl-filter-input-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="orderSearchInput" class="form-control form-control-sm srl-filter-input" placeholder="Search Order #, Customer, Mobile, City...">
        </div>
      </div>

      <!-- Payment Status Filter -->
      <div class="col-6 col-md-3 col-lg-3">
        <select id="paymentStatusFilter" class="form-select form-select-sm srl-filter-select">
          <option value="" <?= ($payment_filter === 'all') ? 'selected' : '' ?>>All Payments</option>
          <option value="Paid" <?= ($payment_filter === 'Paid') ? 'selected' : '' ?>>Paid</option>
          <option value="Pending" <?= ($payment_filter === 'Pending') ? 'selected' : '' ?>>Pending</option>
        </select>
      </div>

      <!-- Order Fulfillment Status Filter -->
      <div class="col-6 col-md-3 col-lg-3">
        <select id="orderStatusFilter" class="form-select form-select-sm srl-filter-select">
          <option value="" <?= ($status_filter === 'all') ? 'selected' : '' ?>>All Order Statuses</option>
          <option value="Placed" <?= ($status_filter === 'Placed') ? 'selected' : '' ?>>Placed</option>
          <option value="Confirmed" <?= ($status_filter === 'Confirmed') ? 'selected' : '' ?>>Confirmed</option>
          <option value="Packed" <?= ($status_filter === 'Packed') ? 'selected' : '' ?>>Packed</option>
          <option value="Out for Delivery" <?= ($status_filter === 'Out for Delivery') ? 'selected' : '' ?>>Out for Delivery</option>
          <option value="Delivered" <?= ($status_filter === 'Delivered') ? 'selected' : '' ?>>Delivered</option>
          <option value="Cancelled" <?= ($status_filter === 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
        </select>
      </div>

      <!-- Page Limit Selector -->
      <div class="col-12 col-md-2 col-lg-2">
        <select id="limitSelect" class="form-select form-select-sm srl-filter-select">
          <option value="10" selected>10 / page</option>
          <option value="25">25 / page</option>
          <option value="50">50 / page</option>
          <option value="100">100 / page</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Orders Card -->
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--srl-border) !important;">
    <div class="card-header bg-white py-3 px-3 px-sm-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
      <span class="fw-bold text-dark"><i class="bi bi-shop me-2" style="color: var(--srl-pink);"></i>Offline Orders List</span>
      <span class="badge rounded-pill bg-light text-dark border px-3 py-2" id="ordersTotalBadge">
        <?= isset($total) ? number_format($total) : count($orders) ?> orders
      </span>
    </div>

    <!-- Table Body with AJAX Container -->
    <div class="table-responsive table-responsive-container" id="tableContainer">
      <div class="table-loading-spinner text-center" id="tableSpinner">
        <div class="spinner-border text-pink" role="status" style="color: var(--srl-pink);">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-uppercase small" style="font-size: 0.76rem; letter-spacing: 0.5px;">
          <tr>
            <th class="text-center" style="width: 50px;">#</th>
            <th>Order Number</th>
            <th>Customer & Mobile</th>
            <th>Location</th>
            <th>Total Amount</th>
            <th>Payment</th>
            <th>Order Status</th>
            <th>Date & Time</th>
            <th class="text-end" style="min-width: 150px;">Actions</th>
          </tr>
        </thead>
        <tbody id="ordersTableBody">
          <?= $this->load->view('admin/offline_orders/_rows', ['orders' => $orders, 'offset' => $offset], TRUE) ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination Footer -->
    <div class="card-footer bg-white border-top p-3" id="paginationContainer">
      <?= $pagination ?>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let currentPage = 1;
  let searchTimeout = null;

  const searchInput         = document.getElementById('orderSearchInput');
  const paymentStatusFilter = document.getElementById('paymentStatusFilter');
  const orderStatusFilter   = document.getElementById('orderStatusFilter');
  const limitSelect         = document.getElementById('limitSelect');
  const tableBody           = document.getElementById('ordersTableBody');
  const tableContainer      = document.getElementById('tableContainer');
  const totalBadge          = document.getElementById('ordersTotalBadge');
  const paginationContainer = document.getElementById('paginationContainer');

  function fetchOrders(page = 1) {
    currentPage = page;
    const searchVal = searchInput ? searchInput.value.trim() : '';
    const paymentVal = paymentStatusFilter ? paymentStatusFilter.value : '';
    const statusVal  = orderStatusFilter ? orderStatusFilter.value : '';
    const limitVal   = limitSelect ? limitSelect.value : 10;

    if (tableContainer) tableContainer.classList.add('loading');

    const params = new URLSearchParams({
      page: page,
      limit: limitVal,
      search: searchVal,
      payment_status: paymentVal,
      status: statusVal
    });

    fetch('<?= base_url('admin/offline_orders/ajax_list') ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: params.toString()
    })
      .then(res => res.json())
      .then(data => {
        if (tableContainer) tableContainer.classList.remove('loading');
        if (data.status === 'success') {
          if (tableBody) tableBody.innerHTML = data.html;
          if (paginationContainer) paginationContainer.innerHTML = data.pagination;
          if (totalBadge) totalBadge.textContent = data.total + ' orders';
          bindPaginationLinks();
        }
      })
      .catch(err => {
        if (tableContainer) tableContainer.classList.remove('loading');
        console.error('Fetch error:', err);
      });
  }

  function bindPaginationLinks() {
    if (!paginationContainer) return;
    const links = paginationContainer.querySelectorAll('.page-link[data-page]');
    links.forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        const page = parseInt(this.getAttribute('data-page'));
        if (page && page !== currentPage) {
          fetchOrders(page);
        }
      });
    });
  }

  // Instant Live Search
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => fetchOrders(1), 300);
    });
  }

  if (paymentStatusFilter) {
    paymentStatusFilter.addEventListener('change', () => fetchOrders(1));
  }

  if (orderStatusFilter) {
    orderStatusFilter.addEventListener('change', () => fetchOrders(1));
  }

  if (limitSelect) {
    limitSelect.addEventListener('change', () => fetchOrders(1));
  }

  bindPaginationLinks();
});

// Quick Toggle Payment Status Function ('Pending' <-> 'Paid')
function togglePaymentStatus(orderId, newStatus) {
  const actionText = (newStatus === 'Paid') ? 'mark this order as PAID' : 'change this order back to PENDING';
  const confirmBtnText = (newStatus === 'Paid') ? 'Yes, Mark as Paid' : 'Yes, Change to Pending';

  Swal.fire({
    title: 'Update Payment Status?',
    text: `Are you sure you want to ${actionText}?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: confirmBtnText,
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
              timer: 1600,
              showConfirmButton: false,
              customClass: { popup: 'srl-swal-popup' }
            });

            // Reload table or refresh current row
            const searchInput = document.getElementById('orderSearchInput');
            if (searchInput) {
              searchInput.dispatchEvent(new Event('input'));
            } else {
              location.reload();
            }
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
            text: 'Network error occurred while updating status.',
            icon: 'error',
            customClass: { popup: 'srl-swal-popup' }
          });
        });
    }
  });
}

// Delete Offline Order Function
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
            });

            // Animate remove row or trigger refresh
            const row = document.getElementById('order-row-' + orderId);
            if (row) {
              row.style.transition = 'all 0.3s ease';
              row.style.opacity = '0';
              row.style.transform = 'scale(0.95)';
              setTimeout(() => {
                const searchInput = document.getElementById('orderSearchInput');
                if (searchInput) {
                  searchInput.dispatchEvent(new Event('input'));
                } else {
                  location.reload();
                }
              }, 300);
            } else {
              location.reload();
            }
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
