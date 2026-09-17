<style>
/* ============================================================
   ADMIN ORDERS VIEW STYLES
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
</style>

<div class="container-fluid px-3 px-md-4 py-4">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
      <h3 class="fw-extrabold text-dark mb-1">Customer Orders</h3>
      <p class="text-muted small mb-0">Track order lifecycle, verify shipping addresses, and manage dispatch statuses.</p>
    </div>
  </div>

  <!-- Standard SRL Filter Card with Normal Dropdown Filter -->
  <div class="srl-filter-card mb-4">
    <div class="row g-3 align-items-center">
      <!-- Search Input -->
      <div class="col-12 col-md-5 col-lg-4">
        <div class="srl-filter-input-wrap">
          <i class="bi bi-search"></i>
          <input type="text" id="orderSearchInput" class="form-control form-control-sm srl-filter-input" placeholder="Search Order #, Customer, Phone, City...">
        </div>
      </div>

      <!-- Normal Dropdown Filter for Order Status -->
      <div class="col-6 col-md-4 col-lg-3">
        <select id="orderStatusFilter" class="form-select form-select-sm srl-filter-select">
          <option value="">All Orders</option>
          <option value="Awaiting Payment">Awaiting Payment</option>
          <option value="Placed">Placed</option>
          <option value="Confirmed">Confirmed</option>
          <option value="Packed">Packed</option>
          <option value="Out for Delivery">Out for Delivery</option>
          <option value="Delivered">Delivered</option>
          <option value="Cancelled">Cancelled</option>
        </select>
      </div>

      <!-- Page Limit Selector -->
      <div class="col-6 col-md-3 col-lg-2">
        <select id="limitSelect" class="form-select form-select-sm srl-filter-select">
          <option value="10" selected>10 per page</option>
          <option value="25">25 per page</option>
          <option value="50">50 per page</option>
          <option value="100">100 per page</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Orders Card -->
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--srl-border) !important;">
    <div class="card-header bg-white py-3 px-3 px-sm-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
      <span class="fw-bold text-dark"><i class="bi bi-receipt me-2" style="color: var(--srl-pink);"></i>Orders List</span>
      <span class="badge rounded-pill bg-light text-dark border px-3 py-2" id="ordersTotalBadge">
        <?= isset($total) ? number_format($total) : count($orders) ?> orders
      </span>
    </div>

    <!-- Table Body -->
    <div class="table-responsive">
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
            <th class="text-end" style="min-width: 100px;">Actions</th>
          </tr>
        </thead>
        <tbody id="ordersTableBody">
          <?= $this->load->view('admin/orders/_rows', ['orders' => $orders, 'offset' => $offset], TRUE) ?>
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
  let currentStatus = '';
  let searchTimeout = null;

  const searchInput  = document.getElementById('orderSearchInput');
  const statusSelect = document.getElementById('orderStatusFilter');
  const limitSelect  = document.getElementById('limitSelect');
  const tableBody    = document.getElementById('ordersTableBody');
  const totalBadge   = document.getElementById('ordersTotalBadge');
  const paginationContainer = document.getElementById('paginationContainer');

  function fetchOrders(page = 1) {
    currentPage = page;
    const searchVal = searchInput ? searchInput.value.trim() : '';
    const statusVal = statusSelect ? statusSelect.value : '';
    const limitVal  = limitSelect ? limitSelect.value : 10;

    tableBody.style.opacity = '0.5';

    const params = new URLSearchParams({
      page: currentPage,
      limit: limitVal,
      search: searchVal,
      status: statusVal
    });

    fetch('<?= base_url('admin/orders/ajax_list') ?>?' + params.toString(), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(res => res.json())
      .then(data => {
        tableBody.style.opacity = '1';
        if (data.status === 'success') {
          tableBody.innerHTML = data.html;
          paginationContainer.innerHTML = data.pagination;
          if (totalBadge) {
            totalBadge.textContent = data.total + ' orders';
          }
          bindPaginationEvents();
        }
      })
      .catch(err => {
        console.error(err);
        tableBody.style.opacity = '1';
      });
  }

  // Normal Dropdown Filter change handler
  if (statusSelect) {
    statusSelect.addEventListener('change', function () {
      fetchOrders(1);
    });
  }

  // Debounced search
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        fetchOrders(1);
      }, 350);
    });
  }

  if (limitSelect) {
    limitSelect.addEventListener('change', function () {
      fetchOrders(1);
    });
  }

  function bindPaginationEvents() {
    paginationContainer.querySelectorAll('.page-link').forEach(link => {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        const page = this.getAttribute('data-page');
        if (page && !this.closest('.page-item').classList.contains('disabled')) {
          fetchOrders(parseInt(page));
        }
      });
    });
  }

  bindPaginationEvents();
});
</script>
