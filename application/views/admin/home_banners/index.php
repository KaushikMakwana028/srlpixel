<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-images me-2" style="color: var(--srl-pink);"></i>Home Banners
    </h4>
    <p class="text-muted small mb-0">Manage and schedule all homepage promotional sliders and showcase banners.</p>
  </div>
  <a href="<?= base_url('admin/home_banners/add') ?>" class="btn-srl-primary px-4 py-2 rounded-pill shadow-sm d-inline-flex align-items-center">
    <i class="bi bi-plus-circle-fill me-2 fs-6"></i>+ Add Banner
  </a>
</div>

<!-- Filters & Search Toolbar -->
<div class="srl-filter-card mb-4">
  <div class="row g-3 align-items-center">
    <!-- Search by title -->
    <div class="col-12 col-md-4 col-lg-4">
      <div class="srl-filter-input-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="bannerSearchInput" class="form-control form-control-sm srl-filter-input" placeholder="Search by title, subtitle, CTA text...">
      </div>
    </div>

    <!-- Filter by Status -->
    <div class="col-6 col-md-2 col-lg-2">
      <select id="bannerStatusFilter" class="form-select form-select-sm srl-filter-select">
        <option value="">All Status</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>

    <!-- Filter by Type -->
    <div class="col-6 col-md-2 col-lg-2">
      <select id="bannerTypeFilter" class="form-select form-select-sm srl-filter-select">
        <option value="">All Types</option>
        <option value="home">Home</option>
      </select>
    </div>

    <!-- Sort Dropdown -->
    <div class="col-6 col-md-2 col-lg-2">
      <select id="bannerSortFilter" class="form-select form-select-sm srl-filter-select">
        <option value="display_order" selected>Display Order</option>
        <option value="newest">Newest First</option>
        <option value="oldest">Oldest First</option>
      </select>
    </div>

    <!-- Total Count -->
    <div class="col-6 col-md-2 col-lg-2 text-md-end text-muted small">
      <span class="badge rounded-pill bg-light text-dark border px-3 py-2" id="bannersTotalBadge">
        Showing <?= isset($total) ? number_format($total) : count($banners) ?> banner(s)
      </span>
    </div>
  </div>
</div>

<!-- Data Table Card -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--srl-border) !important;">
  <div class="card-header bg-white py-3 px-3 px-sm-4 border-bottom d-flex justify-content-between align-items-center">
    <span class="fw-bold text-dark"><i class="bi bi-list-stars me-2" style="color: var(--srl-pink);"></i>Active Homepage Slides</span>
  </div>

  <div class="table-responsive-container" id="bannersTableContainer" style="position: relative; min-height: 200px;">
    <!-- Spinner overlay -->
    <div class="table-loading-spinner text-center" id="bannersLoadingSpinner" style="display: none; position: absolute; inset: 0; background: rgba(255, 255, 255, 0.7); z-index: 10; align-items: center; justify-content: center;">
      <div class="spinner-border text-danger" role="status" style="color: var(--srl-pink) !important; width: 2.2rem; height: 2.2rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="bannersTable">
        <thead class="table-light text-uppercase small text-secondary">
          <tr>
            <th style="width: 45px;" class="ps-3 ps-sm-4">#</th>
            <th style="width: 120px;">IMAGE</th>
            <th>BANNER TITLE</th>
            <th style="width: 110px;">BANNER TYPE</th>
            <th style="width: 90px;" class="text-center">ORDER</th>
            <th style="width: 120px;">START DATE</th>
            <th style="width: 120px;">END DATE</th>
            <th style="width: 100px;">STATUS</th>
            <th style="width: 130px;" class="d-none d-md-table-cell">CREATED</th>
            <th style="width: 120px;" class="text-end pe-3 pe-sm-4">ACTIONS</th>
          </tr>
        </thead>
        <tbody id="bannersTableBody">
          <?php $this->load->view('admin/home_banners/_rows', ['banners' => $banners, 'offset' => $offset ?? 0]); ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination Container -->
  <div class="card-footer bg-white border-top px-3 px-sm-4 py-3" id="bannersPaginationContainer">
    <?= $pagination ?? '' ?>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let currentPage = 1;
  let searchTimer = null;

  const searchInput         = document.getElementById('bannerSearchInput');
  const statusFilter        = document.getElementById('bannerStatusFilter');
  const typeFilter          = document.getElementById('bannerTypeFilter');
  const sortFilter          = document.getElementById('bannerSortFilter');
  const loadingSpinner      = document.getElementById('bannersLoadingSpinner');
  const tableBody           = document.getElementById('bannersTableBody');
  const paginationContainer = document.getElementById('bannersPaginationContainer');
  const totalBadge          = document.getElementById('bannersTotalBadge');

  function bindRowEvents() {
    // Delete action
    document.querySelectorAll('.btn-delete-banner').forEach(btn => {
      btn.onclick = function () {
        const bannerId = this.getAttribute('data-id');
        Swal.fire({
          title: 'Delete this banner?',
          text: 'This banner will be removed from your homepage slider.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#e11d74',
          cancelButtonColor: '#64748b',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch('<?= base_url('admin/home_banners/delete/') ?>' + bannerId, {
              headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
              .then(res => res.json())
              .then(res => {
                if (res.success) {
                  Swal.fire({
                    title: 'Deleted!',
                    text: res.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                  });
                  loadData(currentPage);
                } else {
                  Swal.fire('Error', res.message || 'Unable to delete banner.', 'error');
                }
              })
              .catch(() => {
                Swal.fire('Error', 'An unexpected error occurred.', 'error');
              });
          }
        });
      };
    });

    // Toggle status action
    document.querySelectorAll('.btn-toggle-banner').forEach(btn => {
      btn.onclick = function () {
        const bannerId = this.getAttribute('data-id');
        fetch('<?= base_url('admin/home_banners/toggle_status/') ?>' + bannerId, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
          .then(res => res.json())
          .then(res => {
            if (res.success) {
              loadData(currentPage);
            } else {
              Swal.fire('Error', res.message || 'Unable to change status.', 'error');
            }
          })
          .catch(() => {
            Swal.fire('Error', 'An unexpected network error occurred.', 'error');
          });
      };
    });
  }

  function loadData(page = 1) {
    currentPage = page;
    loadingSpinner.style.display = 'flex';

    const params = new URLSearchParams({
      page: page,
      search: searchInput ? searchInput.value.trim() : '',
      status: statusFilter ? statusFilter.value : '',
      banner_type: typeFilter ? typeFilter.value : '',
      sort: sortFilter ? sortFilter.value : 'display_order'
    });

    fetch('<?= base_url('admin/home_banners/ajax_list') ?>?' + params.toString(), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(res => res.json())
      .then(data => {
        tableBody.innerHTML = data.html;
        if (paginationContainer) {
          paginationContainer.innerHTML = data.pagination;
        }
        if (totalBadge) {
          totalBadge.innerText = 'Showing ' + data.total + ' banner(s)';
        }
        bindRowEvents();
        bindPagination();
      })
      .catch(err => {
        console.error('Banners load error:', err);
      })
      .finally(() => {
        loadingSpinner.style.display = 'none';
      });
  }

  function bindPagination() {
    if (!paginationContainer) return;
    paginationContainer.querySelectorAll('a').forEach(link => {
      link.onclick = function (e) {
        e.preventDefault();
        const url = new URL(this.href);
        const p = url.searchParams.get('page') || 1;
        loadData(parseInt(p));
      };
    });
  }

  // Event Listeners
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      clearTimeout(searchTimer);
      searchTimer = setTimeout(() => {
        loadData(1);
      }, 350);
    });
  }

  if (statusFilter) {
    statusFilter.addEventListener('change', () => loadData(1));
  }
  if (typeFilter) {
    typeFilter.addEventListener('change', () => loadData(1));
  }
  if (sortFilter) {
    sortFilter.addEventListener('change', () => loadData(1));
  }

  // Initial event bindings
  bindRowEvents();
  bindPagination();
});
</script>
