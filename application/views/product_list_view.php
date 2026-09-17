<style>
/* ============================================================
   PRODUCT LIST VIEW STYLES
   ============================================================ */

.srl-catalog-hero {
  position: relative;
  background: #0f121d;
  background-image:
    radial-gradient(circle at 10% 20%, rgba(225, 29, 116, 0.22) 0%, transparent 48%),
    radial-gradient(circle at 90% 75%, rgba(121, 40, 202, 0.22) 0%, transparent 48%),
    linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
  background-size: 100% 100%, 100% 100%, 30px 30px, 30px 30px;
  border: 1px solid rgba(255, 42, 133, 0.22);
  border-radius: 20px;
  padding: 28px 24px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 0 20px rgba(255, 42, 133, 0.06);
  margin-bottom: 24px;
}

@media (max-width: 576px) {
  .srl-catalog-hero {
    padding: 20px 16px;
    border-radius: 16px;
    margin-bottom: 18px;
  }
}

.srl-catalog-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255, 42, 133, 0.15);
  color: #ff2a85;
  border: 1px solid rgba(255, 42, 133, 0.35);
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

.srl-catalog-title {
  color: #ffffff;
  font-weight: 800;
  font-size: 1.75rem;
  line-height: 1.25;
  margin-top: 8px;
  margin-bottom: 6px;
  letter-spacing: -0.01em;
}

@media (max-width: 576px) {
  .srl-catalog-title {
    font-size: 1.35rem;
  }
}

.srl-catalog-desc {
  color: #94a3b8;
  font-size: 0.9rem;
  max-width: 620px;
  margin-bottom: 0;
}

@media (max-width: 576px) {
  .srl-catalog-desc {
    font-size: 0.8rem;
  }
}

/* Quick stats chip inside hero */
.srl-hero-stat-chip {
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #e2e8f0;
  padding: 6px 14px;
  border-radius: 12px;
  font-size: 0.82rem;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.srl-hero-stat-chip .stat-num {
  color: #ff2a85;
  font-weight: 800;
}

/* Live Search Bar */
.srl-search-box-wrapper {
  position: relative;
  width: 100%;
}

.srl-live-search-input {
  background: #151926 !important;
  border: 1.5px solid rgba(255, 42, 133, 0.3) !important;
  border-radius: 14px !important;
  color: #ffffff !important;
  padding: 12px 42px 12px 44px !important;
  font-size: 0.92rem !important;
  transition: all 0.2s ease !important;
  width: 100%;
}

.srl-live-search-input:focus {
  background: #181d2c !important;
  border-color: #ff2a85 !important;
  box-shadow: 0 0 0 4px rgba(255, 42, 133, 0.22), 0 4px 16px rgba(0, 0, 0, 0.3) !important;
  color: #ffffff !important;
}

.srl-live-search-input::placeholder {
  color: #64748b !important;
}

.srl-search-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #ff2a85;
  font-size: 1.1rem;
  pointer-events: none;
}

.srl-search-clear-btn {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: transparent;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  padding: 4px;
  display: none;
  font-size: 1.1rem;
  transition: color 0.15s ease;
}

.srl-search-clear-btn:hover {
  color: #ff2a85;
}

/* Category Quick Filter Pills (Horizontal Scroll on Mobile) */
.srl-cat-filter-scroll {
  display: flex;
  align-items: center;
  gap: 8px;
  overflow-x: auto;
  padding-bottom: 6px;
  margin-bottom: 20px;
  scrollbar-width: none;
  -ms-overflow-style: none;
}

.srl-cat-filter-scroll::-webkit-scrollbar {
  display: none;
}

.srl-filter-pill {
  white-space: nowrap;
  padding: 7px 16px;
  border-radius: 30px;
  font-size: 0.84rem;
  font-weight: 600;
  color: #475569;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s ease;
  cursor: pointer;
}

.srl-filter-pill:hover {
  color: var(--srl-pink);
  border-color: rgba(225, 29, 116, 0.4);
  background: #fff8fb;
}

.srl-filter-pill.active {
  background: var(--srl-pink-gradient) !important;
  color: #ffffff !important;
  border-color: var(--srl-pink) !important;
  box-shadow: 0 4px 12px rgba(225, 29, 116, 0.35);
}

.srl-filter-pill .pill-count {
  font-size: 0.72rem;
  padding: 1px 6px;
  border-radius: 10px;
  background: rgba(0, 0, 0, 0.08);
  font-weight: 700;
}

.srl-filter-pill.active .pill-count {
  background: rgba(255, 255, 255, 0.25);
  color: #ffffff;
}

/* Product Cards Grid */
.srl-product-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  height: 100%;
  position: relative;
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.srl-product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
  border-color: #cbd5e1;
}

.srl-discount-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background: #e11d74;
  color: #ffffff;
  font-weight: 800;
  font-size: 0.75rem;
  padding: 3px 8px;
  border-radius: 6px;
  z-index: 3;
}

.srl-product-img-box {
  height: 210px;
  background: #0c0f17;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  overflow: hidden;
  position: relative;
}

.srl-product-img-box img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.srl-product-card:hover .srl-product-img-box img {
  transform: scale(1.08);
}

.srl-product-body {
  padding: 16px;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.srl-product-title {
  font-weight: 700;
  font-size: 0.95rem;
  color: #1e293b;
  margin-bottom: 4px;
  line-height: 1.35;
  text-decoration: none;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  height: 2.7rem;
}

.srl-product-title:hover {
  color: var(--srl-pink);
}

.srl-product-brand {
  font-size: 0.75rem;
  font-weight: 700;
  color: #94a3b8;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 6px;
}

.srl-product-rating {
  color: #cbd5e1;
  font-size: 0.85rem;
  margin-bottom: 8px;
}

.srl-product-rating .active-star {
  color: #f59e0b;
}

.srl-stock-check {
  font-size: 0.82rem;
  font-weight: 600;
  color: #10b981;
  display: flex;
  align-items: center;
  gap: 4px;
  margin-bottom: 10px;
}

.srl-stock-check.out-of-stock {
  color: #ef4444;
}

.srl-price-box {
  display: flex;
  align-items: baseline;
  gap: 8px;
  margin-bottom: 14px;
  margin-top: auto;
}

.srl-old-price {
  font-size: 0.85rem;
  color: #94a3b8;
  text-decoration: line-through;
}

.srl-sale-price {
  font-size: 1.15rem;
  font-weight: 800;
  color: #e11d74;
}

.btn-add-to-cart {
  width: 100%;
  background: #e11d74;
  color: #ffffff;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 0.9rem;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  cursor: pointer;
}

.btn-add-to-cart:hover {
  background: #ff2a85;
  color: #ffffff;
  box-shadow: 0 4px 12px rgba(225, 29, 116, 0.35);
  transform: translateY(-1px);
}

/* Mobile Product Card Adjustments */
@media (max-width: 767.98px) {
  .srl-product-card {
    border-radius: 12px;
  }
  .srl-product-img-box {
    height: 150px;
  }
  .srl-product-body {
    padding: 10px;
  }
  .srl-product-title {
    font-size: 0.82rem;
    height: 2.3rem;
  }
  .srl-product-brand {
    font-size: 0.68rem;
    margin-bottom: 2px;
  }
  .srl-price-box {
    margin-bottom: 8px;
    gap: 4px;
  }
  .srl-sale-price {
    font-size: 0.98rem;
  }
  .srl-old-price {
    font-size: 0.75rem;
  }
  .btn-add-to-cart {
    padding: 7px 10px;
    font-size: 0.78rem;
    border-radius: 6px;
  }
}

/* Pagination Wrapper */
.srl-pagination-wrapper {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 16px;
  margin-top: 24px;
}

.srl-pagination-info {
  font-size: 0.85rem;
  color: #64748b;
  font-weight: 500;
}
</style>

<div class="container py-2 py-md-3">
  <!-- Redesigned SRL Catalog Hero Banner -->
  <div class="srl-catalog-hero">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
      <div>
        <!-- Breadcrumb inside Hero -->
        <nav aria-label="breadcrumb" class="mb-2">
          <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none" style="color: #94a3b8;"><i class="bi bi-house-door me-1"></i>Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">Products</li>
          </ol>
        </nav>

        <div class="d-flex align-items-center gap-2 mb-1">
          <span class="srl-catalog-badge">
            <i class="bi bi-box-seam-fill"></i> SRL Pixel Catalog
          </span>
          <span class="badge rounded-pill" style="background: rgba(255,255,255,0.08); color: #cbd5e1; font-size: 0.75rem;">
            <?= $total_products_count ?? count($products) ?> Total Items
          </span>
        </div>
        <h1 class="srl-catalog-title">All Pixel LED Products</h1>
        <p class="srl-catalog-desc">High-performance addressable RGB/RGBW strips, programmable SD controllers, neon flex ropes, and high-efficiency power supplies.</p>
      </div>

      <!-- Quick stats chip -->
      <div class="d-none d-md-flex flex-column align-items-end gap-2 text-end">
        <div class="srl-hero-stat-chip">
          <i class="bi bi-truck text-info"></i>
          <span>Fast Shipping: <span class="stat-num">Same Day Dispatch</span></span>
        </div>
        <div class="srl-hero-stat-chip">
          <i class="bi bi-shield-check text-success"></i>
          <span>Quality Check: <span class="stat-num">100% Tested</span></span>
        </div>
      </div>
    </div>
  </div>

  <!-- Live Search & Toolbar with Category Dropdown -->
  <div class="card border-0 shadow-sm rounded-4 p-3 mb-4" style="background: #ffffff; border: 1px solid #e2e8f0 !important;">
    <div class="row g-2 align-items-center">
      <!-- Search Input -->
      <div class="col-12 col-md-5">
        <div class="srl-search-box-wrapper">
          <i class="bi bi-search srl-search-icon" style="color: var(--srl-pink);"></i>
          <input type="text" id="productSearchInput" class="form-control srl-live-search-input" style="background: #f8fafc !important; border-color: #cbd5e1 !important; color: #1e293b !important;" placeholder="Type to search products by title, SKU, or specs..." value="<?= html_escape($search_term ?? '') ?>">
          <button type="button" id="clearProductSearch" class="srl-search-clear-btn" title="Clear search">
            <i class="bi bi-x-circle-fill"></i>
          </button>
        </div>
      </div>

      <!-- Category Filter Dropdown (Replaced horizontal pills as requested) -->
      <div class="col-12 col-md-4">
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #cbd5e1 !important;">
            <i class="bi bi-grid-fill" style="color: var(--srl-pink);"></i>
          </span>
          <select id="productCategoryFilter" class="form-select bg-light border-start-0" style="border-color: #cbd5e1 !important; font-size: 0.88rem; color: #1e293b; height: 46px; border-radius: 0 14px 14px 0 !important;">
            <option value="all" <?= empty($current_category) ? 'selected' : '' ?>>All Categories (<?= $total_products_count ?? count($products) ?>)</option>
            <?php if (!empty($categories)): ?>
              <?php foreach ($categories as $c): ?>
                <?php $cnt = $category_counts[$c->id] ?? 0; ?>
                <option value="<?= $c->id ?>" <?= (!empty($current_category) && $current_category == $c->id) ? 'selected' : '' ?>>
                  <?= html_escape($c->name) ?> (<?= $cnt ?>)
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>

      <!-- Items Count & Per Page Selector -->
      <div class="col-12 col-md-3 d-flex justify-content-between justify-content-md-end align-items-center gap-2">
        <div class="text-muted small">
          <span id="productCountBadge" class="badge bg-light text-dark border px-2 py-1 fw-semibold">
            Showing <?= count($products) ?> products
          </span>
        </div>
        <div class="d-flex align-items-center gap-1">
          <label for="prodPerPage" class="small text-muted mb-0 me-1 d-none d-sm-inline">Show:</label>
          <select id="prodPerPage" class="form-select form-select-sm bg-light" style="width: auto; font-size: 0.82rem; height: 38px;">
            <option value="12" selected>12 / page</option>
            <option value="24">24 / page</option>
            <option value="48">48 / page</option>
            <option value="all">All</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- Products Grid -->
  <?php if (!empty($products)): ?>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-sm-3 g-md-4" id="productsGrid">
      <?php foreach ($products as $p): ?>
        <?php
          $has_discount = (!empty($p->discount_price) && $p->discount_price < $p->price);
          $discount_pct = $has_discount ? round((($p->price - $p->discount_price) / $p->price) * 100) : 0;
          $cat_name = $category_map[$p->category_id] ?? 'SRL Pixel Lighting';
        ?>
        <div class="col product-item-col" 
             data-id="<?= $p->id ?>" 
             data-name="<?= strtolower(html_escape($p->name)) ?>" 
             data-sku="<?= strtolower(html_escape($p->sku ?? '')) ?>" 
             data-category="<?= $p->category_id ?>" 
             data-category-name="<?= strtolower(html_escape($cat_name)) ?>" 
             data-price="<?= $p->price ?>">
          <div class="srl-product-card">
            <!-- Discount Badge -->
            <?php if ($has_discount): ?>
              <span class="srl-discount-badge">-<?= $discount_pct ?>%</span>
            <?php endif; ?>

            <!-- Product Image -->
            <a href="<?= base_url('product/' . $p->id) ?>" class="srl-product-img-box text-decoration-none">
              <?php if (!empty($p->image) && file_exists('./uploads/products/' . $p->image)): ?>
                <img src="<?= base_url('uploads/products/' . $p->image) ?>" alt="<?= html_escape($p->name) ?>">
              <?php else: ?>
                <i class="bi bi-image text-muted" style="font-size: 4rem; opacity: 0.35;"></i>
              <?php endif; ?>
            </a>

            <!-- Product Body -->
            <div class="srl-product-body">
              <a href="<?= base_url('product/' . $p->id) ?>" class="srl-product-title" title="<?= html_escape($p->name) ?>">
                <?= html_escape($p->name) ?>
              </a>

              <div class="srl-product-brand">
                <?= html_escape($cat_name) ?>
              </div>

              <!-- In stock check -->
              <div class="srl-stock-check <?= ($p->stock <= 0) ? 'out-of-stock' : '' ?>">
                <?php if ($p->stock > 0): ?>
                  <i class="bi bi-check-lg text-success"></i> In stock
                <?php else: ?>
                  <i class="bi bi-x-circle text-danger"></i> Out of stock
                <?php endif; ?>
              </div>

              <!-- Price Box -->
              <div class="srl-price-box">
                <?php if ($has_discount): ?>
                  <span class="srl-old-price">₹<?= number_format($p->price, 2) ?></span>
                  <span class="srl-sale-price">₹<?= number_format($p->discount_price, 2) ?></span>
                <?php else: ?>
                  <span class="srl-sale-price">₹<?= number_format($p->price, 2) ?></span>
                <?php endif; ?>
              </div>

              <!-- Add To Cart Button -->
              <button type="button" class="btn-add-to-cart" data-id="<?= $p->id ?>" data-name="<?= html_escape($p->name) ?>" <?= ($p->stock <= 0) ? 'disabled' : '' ?>>
                Add To Cart
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <!-- Empty State (Shown when live search or filter returns 0) -->
  <div id="noProductsFound" class="text-center py-5 bg-white rounded-4 border shadow-sm my-4 <?= empty($products) ? '' : 'd-none' ?>">
    <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background: rgba(255, 42, 133, 0.1);">
      <i class="bi bi-search fs-2" style="color: var(--srl-pink);"></i>
    </div>
    <h5 class="fw-bold text-dark mb-1">No Matching Products Found</h5>
    <p class="text-muted mb-3 small">Try clearing your search query or selecting a different category filter.</p>
    <button type="button" class="btn-srl-primary btn-sm px-3 py-2" id="resetProdSearchBtn">
      <i class="bi bi-arrow-counterclockwise me-1"></i> Clear Filters
    </button>
  </div>

  <!-- Modern Pagination Wrapper -->
  <div class="srl-pagination-wrapper" id="productPaginationWrapper">
    <div class="srl-pagination-info" id="productPaginationInfo">
      Showing 1 to <?= min(12, count($products)) ?> of <?= count($products) ?> products
    </div>
    <nav aria-label="Product pagination">
      <ul class="srl-pagination" id="productPaginationList">
        <!-- Dynamic Page Buttons generated via JS -->
      </ul>
    </nav>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('productSearchInput');
  const clearBtn = document.getElementById('clearProductSearch');
  const resetBtn = document.getElementById('resetProdSearchBtn');
  const countBadge = document.getElementById('productCountBadge');
  const items = Array.from(document.querySelectorAll('.product-item-col'));
  const noResult = document.getElementById('noProductsFound');
  const paginationWrapper = document.getElementById('productPaginationWrapper');
  const paginationList = document.getElementById('productPaginationList');
  const paginationInfo = document.getElementById('productPaginationInfo');
  const perPageSelect = document.getElementById('prodPerPage');
  const categorySelect = document.getElementById('productCategoryFilter');

  let currentPage = 1;
  let itemsPerPage = 12;
  let activeCategoryId = '<?= !empty($current_category) ? (string)$current_category : "all" ?>';
  let filteredItems = [...items];

  function updatePerPage() {
    const val = perPageSelect.value;
    itemsPerPage = (val === 'all') ? 999999 : parseInt(val, 10);
    currentPage = 1;
    filterProducts();
  }

  function filterProducts() {
    const query = (searchInput.value || '').trim().toLowerCase();

    if (query.length > 0) {
      clearBtn.style.display = 'block';
    } else {
      clearBtn.style.display = 'none';
    }

    filteredItems = items.filter(item => {
      const name = item.getAttribute('data-name') || '';
      const sku = item.getAttribute('data-sku') || '';
      const catName = item.getAttribute('data-category-name') || '';
      const catId = item.getAttribute('data-category') || '';

      // Category match check
      const matchesCategory = (activeCategoryId === 'all' || catId === activeCategoryId);

      // Query text match check (instant live search)
      const matchesQuery = !query || name.includes(query) || sku.includes(query) || catName.includes(query);

      return matchesCategory && matchesQuery;
    });

    currentPage = 1;
    render();
  }

  function render() {
    const total = filteredItems.length;

    // Hide all items first
    items.forEach(el => el.classList.add('d-none'));

    if (total === 0) {
      noResult.classList.remove('d-none');
      paginationWrapper.classList.add('d-none');
      countBadge.textContent = '0 products found';
      return;
    }

    noResult.classList.add('d-none');

    // Calculate pagination slices
    const totalPages = Math.ceil(total / itemsPerPage) || 1;
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    const startIdx = (currentPage - 1) * itemsPerPage;
    const endIdx = Math.min(startIdx + itemsPerPage, total);

    // Show current page items
    for (let i = startIdx; i < endIdx; i++) {
      filteredItems[i].classList.remove('d-none');
    }

    // Update count badge & pagination info
    const query = (searchInput.value || '').trim();
    if (query) {
      countBadge.textContent = `${total} match${total === 1 ? '' : 'es'} found`;
    } else {
      countBadge.textContent = `Showing ${total} products`;
    }

    paginationInfo.textContent = `Showing ${startIdx + 1} to ${endIdx} of ${total} products`;

    // Render pagination buttons
    renderPaginationButtons(totalPages);
  }

  function renderPaginationButtons(totalPages) {
    paginationWrapper.classList.remove('d-none');

    let html = '';

    // Prev button
    html += `<li><button type="button" class="srl-page-btn ${currentPage === 1 ? 'disabled' : ''}" data-page="${currentPage - 1}" title="Previous Page"><i class="bi bi-chevron-left"></i></button></li>`;

    // Page numbers
    for (let p = 1; p <= totalPages; p++) {
      html += `<li><button type="button" class="srl-page-btn ${currentPage === p ? 'active' : ''}" data-page="${p}">${p}</button></li>`;
    }

    // Next button
    html += `<li><button type="button" class="srl-page-btn ${currentPage === totalPages ? 'disabled' : ''}" data-page="${currentPage + 1}" title="Next Page"><i class="bi bi-chevron-right"></i></button></li>`;

    paginationList.innerHTML = html;
  }

  // Live Instant Search on Input event
  searchInput.addEventListener('input', filterProducts);

  clearBtn.addEventListener('click', function () {
    searchInput.value = '';
    filterProducts();
    searchInput.focus();
  });

  if (resetBtn) {
    resetBtn.addEventListener('click', function () {
      searchInput.value = '';
      activeCategoryId = 'all';
      if (categorySelect) categorySelect.value = 'all';
      filterProducts();
      searchInput.focus();
    });
  }

  // Category Filter Dropdown Change Handler
  if (categorySelect) {
    categorySelect.addEventListener('change', function () {
      activeCategoryId = this.value;
      filterProducts();
    });
  }

  perPageSelect.addEventListener('change', updatePerPage);

  // Pagination Click Handler
  paginationList.addEventListener('click', function (e) {
    const btn = e.target.closest('.srl-page-btn');
    if (!btn || btn.classList.contains('disabled') || btn.classList.contains('active')) return;
    const targetPage = parseInt(btn.getAttribute('data-page'), 10);
    if (!isNaN(targetPage)) {
      currentPage = targetPage;
      render();
      // Smooth scroll back to top of products grid
      const grid = document.getElementById('productsGrid');
      if (grid) {
        grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }
  });

  // Initial Filter & Render
  updatePerPage();
});
</script>
