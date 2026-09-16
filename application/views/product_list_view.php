<div class="container py-2 py-md-3">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb mb-0 small">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Home</a></li>
      <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">All Products</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2 mb-md-3">
    <div>
      <h4 class="fw-bold text-dark mb-0 fs-5 fs-md-4">
        <i class="bi bi-box-seam me-2" style="color: var(--srl-pink);"></i>Lighting Catalog
      </h4>
      <p class="text-muted small mb-0 d-none d-sm-block">Browse all digital pixel strips, neon flex ropes, controllers, and power converters.</p>
    </div>
    <span class="badge rounded-pill bg-light text-dark border px-2 py-1 small">
      <?= count($products) ?> items
    </span>
  </div>

  <!-- Search & Category Filters Toolbar (Compact on Mobile) -->
  <div class="card border-0 shadow-sm rounded-4 p-2 p-md-3 mb-3 mb-md-4" style="border: 1px solid #e2e8f0 !important; background: #ffffff;">
    <form method="GET" action="<?= base_url('products') ?>" class="row g-2 align-items-center">
      <div class="col-7 col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light border-end-0 text-muted ps-2 pe-1"><i class="bi bi-search"></i></span>
          <input type="text" name="search" value="<?= html_escape($search_term ?? '') ?>" class="form-control form-control-sm bg-light border-start-0 ps-1" placeholder="Search products, SKU...">
        </div>
      </div>
      <div class="col-5 col-md-4">
        <select name="category" class="form-select form-select-sm bg-light" onchange="this.form.submit()">
          <option value="">All Categories</option>
          <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $c): ?>
              <option value="<?= $c->id ?>" <?= (!empty($current_category) && $current_category == $c->id) ? 'selected' : '' ?>>
                <?= html_escape($c->name) ?>
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>
      <div class="col-12 col-md-3 d-flex gap-2">
        <button type="submit" class="btn-srl-primary btn-sm px-3 py-1 flex-grow-1 justify-content-center" style="min-height: 32px; font-size: 0.85rem;">
          <i class="bi bi-funnel me-1"></i>Filter
        </button>
        <?php if (!empty($search_term) || !empty($current_category)): ?>
          <a href="<?= base_url('products') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 d-inline-flex align-items-center" title="Reset Filters" style="font-size: 0.82rem;">
            <i class="bi bi-x-circle me-1"></i>Reset
          </a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <!-- Products Grid Matching Image 2 -->
  <?php if (!empty($products)): ?>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-sm-3 g-md-4">
      <?php foreach ($products as $p): ?>
        <?php
          $has_discount = (!empty($p->discount_price) && $p->discount_price < $p->price);
          $discount_pct = $has_discount ? round((($p->price - $p->discount_price) / $p->price) * 100) : 0;
          $cat_name = $category_map[$p->category_id] ?? 'SRL Pixel Lighting';
        ?>
        <div class="col">
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

              <!-- Rating -->
              <div class="srl-product-rating">
                <i class="bi bi-star-fill active-star"></i>
                <i class="bi bi-star-fill active-star"></i>
                <i class="bi bi-star-fill active-star"></i>
                <i class="bi bi-star-fill active-star"></i>
                <i class="bi bi-star-half active-star"></i>
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
  <?php else: ?>
    <div class="text-center py-5 bg-white rounded-4 border shadow-sm my-4">
      <i class="bi bi-search text-secondary fs-1 d-block mb-3"></i>
      <h5 class="fw-bold text-dark mb-1">No Matching Products Found</h5>
      <p class="text-muted mb-4">Try clearing your search query or selecting a different category.</p>
      <a href="<?= base_url('products') ?>" class="btn-srl-primary">
        Clear Filters
      </a>
    </div>
  <?php endif; ?>
</div>
