<style>
/* ============================================================
   CATEGORIES LIST VIEW STYLES
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

/* Category Card Styling */
.srl-category-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 18px;
  overflow: hidden;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
  display: flex;
  flex-direction: column;
  height: 100%;
}

.srl-category-card:hover {
  transform: translateY(-4px);
  border-color: rgba(225, 29, 116, 0.45) !important;
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08), 0 0 16px rgba(255, 42, 133, 0.12) !important;
}

.srl-category-img-wrapper {
  height: 170px;
  background: #090b11;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}

.srl-category-img-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.srl-category-card:hover .srl-category-img-wrapper img {
  transform: scale(1.08);
}

.srl-category-badge {
  position: absolute;
  top: 12px;
  right: 12px;
  background: rgba(18, 21, 30, 0.85);
  backdrop-filter: blur(6px);
  border: 1px solid rgba(255, 42, 133, 0.4);
  color: #ff2a85;
  font-size: 0.72rem;
  font-weight: 700;
  padding: 3px 9px;
  border-radius: 20px;
}

/* Mobile Category Card Scaling */
@media (max-width: 767.98px) {
  .srl-category-card {
    border-radius: 14px;
  }
  .srl-category-img-wrapper {
    height: 125px;
  }
  .srl-category-badge {
    font-size: 0.64rem;
    padding: 2px 7px;
    top: 8px;
    right: 8px;
  }
  .srl-category-card .card-body {
    padding: 10px !important;
  }
  .srl-category-card .category-title {
    font-size: 0.84rem !important;
    line-height: 1.25;
  }
  .srl-category-card p {
    font-size: 0.72rem !important;
    margin-bottom: 8px !important;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.35;
  }
  .srl-category-card .btn {
    padding: 6px 8px !important;
    font-size: 0.76rem !important;
    border-radius: 8px !important;
  }
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
            <li class="breadcrumb-item active text-white-50" aria-current="page">Categories</li>
          </ol>
        </nav>
        
        <div class="d-flex align-items-center gap-2 mb-1">
          <span class="srl-catalog-badge">
            <i class="bi bi-diagram-3-fill"></i> Product Categories
          </span>
          <span class="badge rounded-pill" style="background: rgba(255,255,255,0.08); color: #cbd5e1; font-size: 0.75rem;">
            <?= count($categories) ?> Total
          </span>
        </div>
        <h1 class="srl-catalog-title">Explore Lighting Categories</h1>
        <p class="srl-catalog-desc">Browse our complete range of addressable pixel LEDs, intelligent controllers, neon flex tubes, and power converters.</p>
      </div>

      <!-- Quick stats chip -->
      <div class="d-none d-md-flex flex-column align-items-end gap-2 text-end">
        <div class="srl-hero-stat-chip">
          <i class="bi bi-shield-fill-check text-success"></i>
          <span>Commercial Grade <span class="stat-num">100%</span></span>
        </div>
        <div class="srl-hero-stat-chip">
          <i class="bi bi-truck text-info"></i>
          <span>Express Nationwide Shipping</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Live Search & Filter Bar -->
  <div class="card border-0 shadow-sm rounded-4 p-3 mb-4" style="background: #ffffff; border: 1px solid #e2e8f0 !important;">
    <div class="row g-2 align-items-center">
      <div class="col-12 col-md-8">
        <div class="srl-search-box-wrapper">
          <i class="bi bi-search srl-search-icon" style="color: var(--srl-pink);"></i>
          <input type="text" id="categorySearchInput" class="form-control srl-live-search-input" style="background: #f8fafc !important; border-color: #cbd5e1 !important; color: #1e293b !important;" placeholder="Type to search categories by name or description...">
          <button type="button" id="clearCategorySearch" class="srl-search-clear-btn" title="Clear search">
            <i class="bi bi-x-circle-fill"></i>
          </button>
        </div>
      </div>
      <div class="col-12 col-md-4 d-flex justify-content-between justify-content-md-end align-items-center gap-2">
        <div class="text-muted small">
          <span id="categoryCountBadge" class="badge bg-light text-dark border px-2 py-1 fw-semibold">
            Showing <?= count($categories) ?> categories
          </span>
        </div>
        <div class="d-flex align-items-center gap-1">
          <label for="catPerPage" class="small text-muted mb-0 me-1 d-none d-sm-inline">Show:</label>
          <select id="catPerPage" class="form-select form-select-sm bg-light" style="width: auto; font-size: 0.82rem;">
            <option value="12" selected>12 / page</option>
            <option value="24">24 / page</option>
            <option value="48">48 / page</option>
            <option value="all">All</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- Categories Grid -->
  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-sm-3 g-md-4" id="categoriesGrid">
    <?php if (!empty($categories)): ?>
      <?php foreach ($categories as $cat): ?>
        <?php
          $item_count = $category_counts[$cat->id] ?? 0;
          $desc_text = !empty($cat->description) ? $cat->description : 'High quality lighting products engineered for commercial and festive applications.';
        ?>
        <div class="col category-item-col" data-name="<?= strtolower(html_escape($cat->name)) ?>" data-desc="<?= strtolower(html_escape($desc_text)) ?>">
          <div class="srl-category-card">
            <!-- Image Box -->
            <div class="srl-category-img-wrapper">
              <?php if (!empty($cat->image) && file_exists('./uploads/categories/' . $cat->image)): ?>
                <img src="<?= base_url('uploads/categories/' . $cat->image) ?>" alt="<?= html_escape($cat->name) ?>">
              <?php else: ?>
                <div class="rounded-circle p-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: rgba(255, 42, 133, 0.15);">
                  <i class="bi bi-lightbulb fs-2" style="color: var(--srl-pink-glow);"></i>
                </div>
              <?php endif; ?>
              <span class="srl-category-badge">
                <?= $item_count ?> <?= ($item_count == 1) ? 'item' : 'items' ?>
              </span>
            </div>

            <!-- Card Body -->
            <div class="card-body p-3 p-md-4 d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="fw-bold text-dark mb-0 fs-6 category-title"><?= html_escape($cat->name) ?></h5>
              </div>
              <p class="text-muted small flex-grow-1 mb-3" style="font-size: 0.8rem; line-height: 1.45;">
                <?= html_escape(character_limiter($desc_text, 75)) ?>
              </p>
              <a href="<?= base_url('category/' . $cat->id) ?>" class="btn btn-outline-dark rounded-pill w-100 fw-bold py-2 mt-auto btn-sm d-inline-flex align-items-center justify-content-center gap-1" style="border-color: #cbd5e1; font-size: 0.82rem;">
                <span>Browse Products</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Empty State (Hidden by default, shown when live search returns 0) -->
  <div id="noCategoriesFound" class="text-center py-5 bg-white rounded-4 border shadow-sm my-4 d-none">
    <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background: rgba(255, 42, 133, 0.1);">
      <i class="bi bi-search fs-2" style="color: var(--srl-pink);"></i>
    </div>
    <h5 class="fw-bold text-dark mb-1">No Matching Categories</h5>
    <p class="text-muted mb-3 small">We couldn't find any categories matching your search keyword.</p>
    <button type="button" class="btn-srl-primary btn-sm px-3 py-2" id="resetCatSearchBtn">
      <i class="bi bi-arrow-counterclockwise me-1"></i> Clear Search
    </button>
  </div>

  <!-- Modern Pagination Wrapper -->
  <div class="srl-pagination-wrapper" id="categoryPaginationWrapper">
    <div class="srl-pagination-info" id="categoryPaginationInfo">
      Showing 1 to <?= min(12, count($categories)) ?> of <?= count($categories) ?> categories
    </div>
    <nav aria-label="Category pagination">
      <ul class="srl-pagination" id="categoryPaginationList">
        <!-- Dynamic Page Buttons generated via JS -->
      </ul>
    </nav>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('categorySearchInput');
  const clearBtn = document.getElementById('clearCategorySearch');
  const resetBtn = document.getElementById('resetCatSearchBtn');
  const countBadge = document.getElementById('categoryCountBadge');
  const items = Array.from(document.querySelectorAll('.category-item-col'));
  const noResult = document.getElementById('noCategoriesFound');
  const paginationWrapper = document.getElementById('categoryPaginationWrapper');
  const paginationList = document.getElementById('categoryPaginationList');
  const paginationInfo = document.getElementById('categoryPaginationInfo');
  const perPageSelect = document.getElementById('catPerPage');

  let currentPage = 1;
  let itemsPerPage = 12;
  let filteredItems = [...items];

  function updatePerPage() {
    const val = perPageSelect.value;
    itemsPerPage = (val === 'all') ? 999999 : parseInt(val, 10);
    currentPage = 1;
    render();
  }

  function filterCategories() {
    const query = (searchInput.value || '').trim().toLowerCase();
    
    if (query.length > 0) {
      clearBtn.style.display = 'block';
    } else {
      clearBtn.style.display = 'none';
    }

    filteredItems = items.filter(item => {
      const name = item.getAttribute('data-name') || '';
      const desc = item.getAttribute('data-desc') || '';
      return name.includes(query) || desc.includes(query);
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
      countBadge.textContent = '0 categories found';
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
      countBadge.textContent = `Showing ${total} categories`;
    }

    paginationInfo.textContent = `Showing ${startIdx + 1} to ${endIdx} of ${total} categories`;

    // Render pagination buttons
    renderPaginationButtons(totalPages);
  }

  function renderPaginationButtons(totalPages) {
    if (totalPages <= 1 && filteredItems.length <= itemsPerPage) {
      paginationWrapper.classList.remove('d-none');
    } else {
      paginationWrapper.classList.remove('d-none');
    }

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

  // Event Listeners for Live Search
  searchInput.addEventListener('input', filterCategories);

  clearBtn.addEventListener('click', function () {
    searchInput.value = '';
    filterCategories();
    searchInput.focus();
  });

  if (resetBtn) {
    resetBtn.addEventListener('click', function () {
      searchInput.value = '';
      filterCategories();
      searchInput.focus();
    });
  }

  perPageSelect.addEventListener('change', updatePerPage);

  // Pagination click handler
  paginationList.addEventListener('click', function (e) {
    const btn = e.target.closest('.srl-page-btn');
    if (!btn || btn.classList.contains('disabled') || btn.classList.contains('active')) return;
    const targetPage = parseInt(btn.getAttribute('data-page'), 10);
    if (!isNaN(targetPage)) {
      currentPage = targetPage;
      render();
      // Smooth scroll back to top of grid
      document.getElementById('categoriesGrid').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });

  // Initial render
  updatePerPage();
});
</script>
