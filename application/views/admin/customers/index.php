<div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-wrap gap-3">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-people me-2" style="color: var(--srl-pink);"></i>Customer Directory
    </h4>
    <p class="text-muted small mb-0">Browse and manage registered client accounts, contact information, and active statuses.</p>
  </div>
</div>

<!-- Filters & Search Toolbar -->
<div class="srl-filter-card">
  <div class="row g-3 align-items-center">
    <div class="col-12 col-md-5 col-lg-5">
      <div class="srl-filter-input-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="customerSearchInput" class="form-control form-control-sm srl-filter-input" placeholder="Search by name, email, or phone...">
      </div>
    </div>
    <div class="col-6 col-md-3 col-lg-3">
      <select id="customerStatusFilter" class="form-select form-select-sm srl-filter-select">
        <option value="">All Statuses</option>
        <option value="1">Active Only</option>
        <option value="0">Inactive Only</option>
      </select>
    </div>
    <div class="col-6 col-md-2 col-lg-2">
      <select id="customerLimitFilter" class="form-select form-select-sm srl-filter-select">
        <option value="10" selected>10 per page</option>
        <option value="25">25 per page</option>
        <option value="50">50 per page</option>
      </select>
    </div>
    <div class="col-12 col-md-2 col-lg-2 text-md-end text-muted small">
      <span class="badge rounded-pill bg-light text-dark border px-3 py-2" id="customersTotalBadge">
        <?= isset($total) ? number_format($total) : count($customers) ?> registered
      </span>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--srl-border) !important;">
  <div class="card-header bg-white py-3 px-3 px-sm-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-bold text-dark"><i class="bi bi-person-lines-fill me-2" style="color: var(--srl-pink);"></i>Customer Accounts</span>
  </div>

  <div class="table-responsive-container" id="customersTableContainer">
    <!-- Spinner overlay -->
    <div class="table-loading-spinner text-center">
      <div class="spinner-border text-danger" role="status" style="color: var(--srl-pink) !important; width: 2.2rem; height: 2.2rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="customersTable">
        <thead class="table-light text-uppercase small text-secondary">
          <tr>
            <th style="width: 50px;" class="ps-3 ps-sm-4 d-none d-sm-table-cell">#</th>
            <th>Customer Info</th>
            <th>Phone</th>
            <th class="d-none d-lg-table-cell">Address</th>
            <th style="width: 110px;">Account Status</th>
            <th class="d-none d-md-table-cell" style="width: 130px;">Joined</th>
            <th style="width: 100px;" class="text-end pe-3 pe-sm-4">Actions</th>
          </tr>
        </thead>
        <tbody id="customersTableBody">
          <?php $this->load->view('admin/customers/_rows', [
            'customers' => $customers,
            'offset'    => $offset ?? 0
          ]); ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination Container -->
  <div class="card-footer bg-white border-top px-3 px-sm-4 py-3" id="customersPaginationContainer">
    <?= $pagination ?? '' ?>
  </div>
</div>

<!-- Customer Details Modal -->
<div class="modal fade" id="customerDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header text-white p-4" style="background: var(--srl-sidebar-bg); border-bottom: 2px solid var(--srl-pink);">
        <h5 class="modal-title fw-bold" id="modalCustomerName">Customer Profile</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <ul class="list-group list-group-flush">
          <li class="list-group-item px-0 py-2 d-flex justify-content-between">
            <span class="text-muted">Email Address:</span>
            <span class="fw-semibold text-dark" id="modalCustomerEmail"></span>
          </li>
          <li class="list-group-item px-0 py-2 d-flex justify-content-between">
            <span class="text-muted">Contact Phone:</span>
            <span class="fw-semibold text-dark" id="modalCustomerPhone"></span>
          </li>
          <li class="list-group-item px-0 py-2 d-flex justify-content-between">
            <span class="text-muted">Registered Date:</span>
            <span class="fw-semibold text-dark" id="modalCustomerJoined"></span>
          </li>
          <li class="list-group-item px-0 py-2">
            <span class="text-muted d-block mb-1">Billing / Delivery Address:</span>
            <span class="fw-normal text-dark" id="modalCustomerAddress"></span>
          </li>
        </ul>
      </div>
      <div class="modal-footer bg-light p-3">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let currentPage = 1;
  let searchTimer = null;

  const searchInput = document.getElementById('customerSearchInput');
  const statusFilter = document.getElementById('customerStatusFilter');
  const limitFilter = document.getElementById('customerLimitFilter');
  const tableContainer = document.getElementById('customersTableContainer');
  const tableBody = document.getElementById('customersTableBody');
  const paginationContainer = document.getElementById('customersPaginationContainer');
  const totalBadge = document.getElementById('customersTotalBadge');

  const customerModalEl = document.getElementById('customerDetailsModal');
  const modalInstance = customerModalEl ? new bootstrap.Modal(customerModalEl) : null;

  function bindCustomerEvents() {
    // View Customer Profile Modal
    document.querySelectorAll('.btn-view-customer').forEach(button => {
      button.onclick = function () {
        document.getElementById('modalCustomerName').innerText = this.getAttribute('data-name') || 'Customer Profile';
        document.getElementById('modalCustomerEmail').innerText = this.getAttribute('data-email') || '-';
        document.getElementById('modalCustomerPhone').innerText = this.getAttribute('data-phone') || 'Not specified';
        document.getElementById('modalCustomerJoined').innerText = this.getAttribute('data-joined') || '-';
        document.getElementById('modalCustomerAddress').innerText = this.getAttribute('data-address') || 'No address recorded';
        if (modalInstance) {
          modalInstance.show();
        }
      };
    });

    // SweetAlert Delete
    document.querySelectorAll('.btn-delete-customer').forEach(button => {
      button.onclick = function () {
        const custId = this.getAttribute('data-id');
        const custName = this.getAttribute('data-name');
        Swal.fire({
          title: 'Delete Customer?',
          html: `Are you sure you want to permanently remove <strong>"${custName}"</strong>?<br><small class="text-muted">This action cannot be undone.</small>`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: '<i class="bi bi-trash me-1"></i> Yes, Delete',
          cancelButtonText: 'Cancel',
          customClass: {
            popup: 'srl-swal-popup',
            title: 'srl-swal-title',
            htmlContainer: 'srl-swal-html',
            confirmButton: 'srl-swal-confirm',
            cancelButton: 'srl-swal-cancel'
          },
          buttonsStyling: false
        }).then(result => {
          if (result.isConfirmed) {
            window.location.href = '<?= base_url('admin/customers/delete/') ?>' + custId;
          }
        });
      };
    });
  }

  function fetchCustomers(page = 1) {
    currentPage = page;
    tableContainer.classList.add('loading');

    const params = new URLSearchParams({
      page: currentPage,
      limit: limitFilter.value,
      status: statusFilter.value,
      search: searchInput.value.trim()
    });

    fetch('<?= base_url('admin/customers/ajax_list') ?>?' + params.toString(), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          tableBody.innerHTML = data.html;
          paginationContainer.innerHTML = data.pagination;
          if (totalBadge) {
            totalBadge.innerText = Number(data.total).toLocaleString() + ' registered';
          }
          bindCustomerEvents();
        }
      })
      .catch(err => {
        console.error('Error loading customers:', err);
      })
      .finally(() => {
        tableContainer.classList.remove('loading');
      });
  }

  // Live search with 300ms debounce
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      clearTimeout(searchTimer);
      searchTimer = setTimeout(() => {
        fetchCustomers(1);
      }, 300);
    });
  }

  // Filter change handlers
  if (statusFilter) statusFilter.addEventListener('change', () => fetchCustomers(1));
  if (limitFilter) limitFilter.addEventListener('change', () => fetchCustomers(1));

  // Pagination delegation
  if (paginationContainer) {
    paginationContainer.addEventListener('click', function (e) {
      const link = e.target.closest('a[data-page]');
      if (link) {
        e.preventDefault();
        const page = parseInt(link.getAttribute('data-page'));
        if (page && page !== currentPage) {
          fetchCustomers(page);
          tableContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
      }
    });
  }

  // Initial event binding
  bindCustomerEvents();
});
</script>
