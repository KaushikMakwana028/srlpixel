<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-box-seam me-2" style="color: var(--srl-pink);"></i>Products Management
    </h4>
    <p class="text-muted small mb-0">Manage digital pixel strips, neon ropes, controllers, and power converters.</p>
  </div>
  <a href="<?= base_url('admin/products/add') ?>" class="btn-srl-primary px-4 py-2 rounded-pill shadow-sm d-inline-flex align-items-center">
    <i class="bi bi-plus-circle-fill me-2 fs-6"></i>Add New Product
  </a>
</div>

<!-- Filters & Search Toolbar -->
<div class="srl-filter-card">
  <div class="row g-3 align-items-center">
    <div class="col-12 col-md-4 col-lg-3">
      <div class="srl-filter-input-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="productSearchInput" class="form-control form-control-sm srl-filter-input" placeholder="Search product name, SKU...">
      </div>
    </div>
    <div class="col-6 col-md-3 col-lg-3">
      <select id="productCategoryFilter" class="form-select form-select-sm srl-filter-select">
        <option value="">All Categories</option>
        <?php if (!empty($categories)): ?>
          <?php foreach ($categories as $c): ?>
            <option value="<?= $c->id ?>"><?= html_escape($c->name) ?></option>
          <?php endforeach; ?>
        <?php endif; ?>
      </select>
    </div>
    <div class="col-6 col-md-2 col-lg-2">
      <select id="productStatusFilter" class="form-select form-select-sm srl-filter-select">
        <option value="">All Statuses</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>
    <div class="col-6 col-md-3 col-lg-2">
      <select id="productStockFilter" class="form-select form-select-sm srl-filter-select">
        <option value="">All Stock</option>
        <option value="in_stock" <?= (isset($stock_status) && $stock_status === 'in_stock') ? 'selected' : '' ?>>In Stock (>0)</option>
        <option value="out_of_stock" <?= (isset($stock_status) && $stock_status === 'out_of_stock') ? 'selected' : '' ?>>Out of Stock</option>
      </select>
    </div>
    <div class="col-6 col-md-2 col-lg-2">
      <select id="productLimitFilter" class="form-select form-select-sm srl-filter-select">
        <option value="10" selected>10 per page</option>
        <option value="25">25 per page</option>
        <option value="50">50 per page</option>
      </select>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--srl-border) !important;">
  <div class="card-header bg-white py-3 px-3 px-sm-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
    <span class="fw-bold text-dark"><i class="bi bi-list-nested me-2" style="color: var(--srl-pink);"></i>Product Catalog</span>
    <span class="badge rounded-pill bg-light text-dark border px-3 py-2" id="productsTotalBadge">
      <?= isset($total) ? number_format($total) : count($products) ?> items
    </span>
  </div>

  <div class="table-responsive-container" id="productsTableContainer">
    <!-- Spinner overlay -->
    <div class="table-loading-spinner text-center">
      <div class="spinner-border text-danger" role="status" style="color: var(--srl-pink) !important; width: 2.2rem; height: 2.2rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" id="productsTable">
        <thead class="table-light text-uppercase small text-secondary">
          <tr>
            <th style="width: 50px;" class="ps-3 ps-sm-4 d-none d-sm-table-cell">#</th>
            <th style="width: 70px;">Image</th>
            <th>Product & SKU</th>
            <th class="d-none d-md-table-cell">Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th style="width: 95px;">Status</th>
            <th style="width: 100px;" class="text-end pe-3 pe-sm-4">Actions</th>
          </tr>
        </thead>
        <tbody id="productsTableBody">
          <?php $this->load->view('admin/products/_rows', [
            'products'       => $products,
            'category_map'   => $category_map ?? [],
            'gallery_counts' => $gallery_counts ?? [],
            'offset'         => $offset ?? 0
          ]); ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination Container -->
  <div class="card-footer bg-white border-top px-3 px-sm-4 py-3" id="productsPaginationContainer">
    <?= $pagination ?? '' ?>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let currentPage = 1;
  let searchTimer = null;

  const searchInput = document.getElementById('productSearchInput');
  const categoryFilter = document.getElementById('productCategoryFilter');
  const statusFilter = document.getElementById('productStatusFilter');
  const stockFilter = document.getElementById('productStockFilter');
  const limitFilter = document.getElementById('productLimitFilter');
  const tableContainer = document.getElementById('productsTableContainer');
  const tableBody = document.getElementById('productsTableBody');
  const paginationContainer = document.getElementById('productsPaginationContainer');
  const totalBadge = document.getElementById('productsTotalBadge');

  function bindDeleteButtons() {
    document.querySelectorAll('.btn-delete-product').forEach(button => {
      button.onclick = function () {
        const prodId = this.getAttribute('data-id');
        const prodName = this.getAttribute('data-name');
        Swal.fire({
          title: 'Delete Product?',
          html: `Are you sure you want to permanently remove <strong>"${prodName}"</strong>?<br><small class="text-muted">This action will also remove associated gallery photos.</small>`,
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
            window.location.href = '<?= base_url('admin/products/delete/') ?>' + prodId;
          }
        });
      };
    });
  }

  function fetchProducts(page = 1) {
    currentPage = page;
    tableContainer.classList.add('loading');

    const params = new URLSearchParams({
      page: currentPage,
      limit: limitFilter.value,
      category_id: categoryFilter.value,
      status: statusFilter.value,
      stock_status: stockFilter.value,
      search: searchInput.value.trim()
    });

    fetch('<?= base_url('admin/products/ajax_list') ?>?' + params.toString(), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          tableBody.innerHTML = data.html;
          paginationContainer.innerHTML = data.pagination;
          if (totalBadge) {
            totalBadge.innerText = Number(data.total).toLocaleString() + ' items';
          }
          bindDeleteButtons();
        }
      })
      .catch(err => {
        console.error('Error loading products:', err);
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
        fetchProducts(1);
      }, 300);
    });
  }

  // Filter change handlers
  if (categoryFilter) categoryFilter.addEventListener('change', () => fetchProducts(1));
  if (statusFilter) statusFilter.addEventListener('change', () => fetchProducts(1));
  if (stockFilter) stockFilter.addEventListener('change', () => fetchProducts(1));
  if (limitFilter) limitFilter.addEventListener('change', () => fetchProducts(1));

  // Pagination delegation
  if (paginationContainer) {
    paginationContainer.addEventListener('click', function (e) {
      const link = e.target.closest('a[data-page]');
      if (link) {
        e.preventDefault();
        const page = parseInt(link.getAttribute('data-page'));
        if (page && page !== currentPage) {
          fetchProducts(page);
          tableContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
      }
    });
  }

  // Initial delete binding
  bindDeleteButtons();
});
</script>
