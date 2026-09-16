<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-diagram-3-fill me-2" style="color: var(--srl-pink);"></i>Categories Management
    </h4>
    <p class="text-muted small mb-0">Organize and manage catalog categories for pixel LED lighting products.</p>
  </div>
  <a href="<?= base_url('admin/categories/add') ?>" class="btn-srl-primary px-4 py-2 rounded-pill shadow-sm d-inline-flex align-items-center">
    <i class="bi bi-plus-circle-fill me-2 fs-6"></i>Add New Category
  </a>
</div>

<!-- Filters & Search Toolbar -->
<div class="srl-filter-card">
  <div class="row g-3 align-items-center">
    <div class="col-12 col-md-5 col-lg-4">
      <div class="srl-filter-input-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="categorySearchInput" class="form-control form-control-sm srl-filter-input" placeholder="Search categories by name, slug, description...">
      </div>
    </div>
    <div class="col-6 col-md-3 col-lg-3">
      <select id="categoryStatusFilter" class="form-select form-select-sm srl-filter-select">
        <option value="">All Statuses</option>
        <option value="1">Active Only</option>
        <option value="0">Inactive Only</option>
      </select>
    </div>
    <div class="col-6 col-md-2 col-lg-2">
      <select id="categoryLimitFilter" class="form-select form-select-sm srl-filter-select">
        <option value="10" selected>10 per page</option>
        <option value="25">25 per page</option>
        <option value="50">50 per page</option>
      </select>
    </div>
    <div class="col-12 col-md-2 col-lg-3 text-md-end text-muted small">
      <span class="badge rounded-pill bg-light text-dark border px-3 py-2" id="categoriesTotalBadge">
        <?= isset($total) ? number_format($total) : count($categories) ?> total
      </span>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--srl-border) !important;">
  <div class="card-header bg-white py-3 px-3 px-sm-4 border-bottom d-flex justify-content-between align-items-center">
    <span class="fw-bold text-dark"><i class="bi bi-list-ul me-2" style="color: var(--srl-pink);"></i>Category List</span>
  </div>

  <div class="table-responsive-container" id="categoriesTableContainer">
    <!-- Spinner overlay -->
    <div class="table-loading-spinner text-center">
      <div class="spinner-border text-danger" role="status" style="color: var(--srl-pink) !important; width: 2.2rem; height: 2.2rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="categoriesTable">
        <thead class="table-light text-uppercase small text-secondary">
          <tr>
            <th style="width: 50px;" class="ps-3 ps-sm-4 d-none d-sm-table-cell">#</th>
            <th style="width: 70px;">Image</th>
            <th>Category Name</th>
            <th class="d-none d-md-table-cell">Slug</th>
            <th class="d-none d-lg-table-cell">Description</th>
            <th style="width: 95px;">Status</th>
            <th class="d-none d-md-table-cell" style="width: 130px;">Created</th>
            <th style="width: 110px;" class="text-end pe-3 pe-sm-4">Actions</th>
          </tr>
        </thead>
        <tbody id="categoriesTableBody">
          <?php $this->load->view('admin/categories/_rows', ['categories' => $categories, 'offset' => $offset ?? 0]); ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination Container -->
  <div class="card-footer bg-white border-top px-3 px-sm-4 py-3" id="categoriesPaginationContainer">
    <?= $pagination ?? '' ?>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let currentPage = 1;
  let searchTimer = null;

  const searchInput = document.getElementById('categorySearchInput');
  const statusFilter = document.getElementById('categoryStatusFilter');
  const limitFilter = document.getElementById('categoryLimitFilter');
  const tableContainer = document.getElementById('categoriesTableContainer');
  const tableBody = document.getElementById('categoriesTableBody');
  const paginationContainer = document.getElementById('categoriesPaginationContainer');
  const totalBadge = document.getElementById('categoriesTotalBadge');

  function bindDeleteButtons() {
    document.querySelectorAll('.btn-delete-category').forEach(button => {
      button.onclick = function () {
        const catId = this.getAttribute('data-id');
        const catName = this.getAttribute('data-name');
        Swal.fire({
          title: 'Delete Category?',
          html: `Are you sure you want to delete <strong>"${catName}"</strong>?<br><small class="text-muted">Products in this category will need reallocation.</small>`,
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
            window.location.href = '<?= base_url('admin/categories/delete/') ?>' + catId;
          }
        });
      };
    });
  }

  function fetchCategories(page = 1) {
    currentPage = page;
    tableContainer.classList.add('loading');

    const params = new URLSearchParams({
      page: currentPage,
      limit: limitFilter.value,
      status: statusFilter.value,
      search: searchInput.value.trim()
    });

    fetch('<?= base_url('admin/categories/ajax_list') ?>?' + params.toString(), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          tableBody.innerHTML = data.html;
          paginationContainer.innerHTML = data.pagination;
          if (totalBadge) {
            totalBadge.innerText = Number(data.total).toLocaleString() + ' total';
          }
          bindDeleteButtons();
        }
      })
      .catch(err => {
        console.error('Error loading categories:', err);
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
        fetchCategories(1);
      }, 300);
    });
  }

  // Filter change handlers
  if (statusFilter) {
    statusFilter.addEventListener('change', () => fetchCategories(1));
  }
  if (limitFilter) {
    limitFilter.addEventListener('change', () => fetchCategories(1));
  }

  // Pagination click delegation
  if (paginationContainer) {
    paginationContainer.addEventListener('click', function (e) {
      const link = e.target.closest('a[data-page]');
      if (link) {
        e.preventDefault();
        const page = parseInt(link.getAttribute('data-page'));
        if (page && page !== currentPage) {
          fetchCategories(page);
          tableContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
      }
    });
  }

  // Initial delete button binding
  bindDeleteButtons();
});
</script>
