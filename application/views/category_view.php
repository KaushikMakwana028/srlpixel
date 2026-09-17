<div class="container py-2 py-md-3">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb mb-0 small">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Home</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('categories') ?>" class="text-decoration-none text-muted">Categories</a></li>
      <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page"><?= html_escape($category->name) ?></li>
    </ol>
  </nav>

  <!-- Category Banner Header (Compact on Mobile) -->
  <div class="card border-0 shadow-sm rounded-4 mb-3 mb-md-4 overflow-hidden text-white" style="background: linear-gradient(135deg, #181c28 0%, #241429 60%, #10131c 100%); border-left: 5px solid var(--srl-pink) !important;">
    <div class="card-body p-3 p-md-4">
      <div class="row align-items-center">
        <div class="col-md-9">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge rounded-pill px-2 py-1" style="background: rgba(255, 42, 133, 0.2); color: var(--srl-pink-glow); font-size: 0.72rem; font-weight: 700;">
              CATEGORY
            </span>
            <span class="badge bg-dark border border-secondary text-light px-2 py-1 small">
              <i class="bi bi-box-seam me-1"></i><?= $total_products ?> products
            </span>
          </div>
          <h3 class="fw-bold mb-1 fs-5 fs-md-3"><?= html_escape($category->name) ?></h3>
          <p class="text-light opacity-75 small mb-0 d-none d-sm-block" style="max-width: 600px;">
            <?= !empty($category->description) ? html_escape($category->description) : 'Explore top-performing commercial and decorative products in this lighting category.' ?>
          </p>
        </div>
        <div class="col-md-3 text-md-end mt-2 mt-md-0 d-none d-md-block">
          <div class="overflow-hidden rounded-3 shadow-sm d-inline-block border" style="width: 80px; height: 80px; background: #0c0f17; border-color: rgba(255,42,133,0.3) !important;">
            <?php if (!empty($category->image) && file_exists('./uploads/categories/' . $category->image)): ?>
              <img src="<?= base_url('uploads/categories/' . $category->image) ?>" alt="<?= html_escape($category->name) ?>" class="w-100 h-100 object-fit-cover">
            <?php else: ?>
              <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-lightbulb text-danger fs-2" style="color: var(--srl-pink) !important;"></i>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Products Grid Matching Image 2 -->
  <?php if (!empty($products)): ?>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-sm-3 g-md-4">
      <?php foreach ($products as $p): ?>
        <?php
          $has_discount = (!empty($p->discount_price) && $p->discount_price < $p->price);
          $discount_pct = $has_discount ? round((($p->price - $p->discount_price) / $p->price) * 100) : 0;
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
                <?= html_escape($category->name) ?>
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
      <i class="bi bi-box-seam text-secondary fs-1 d-block mb-3"></i>
      <h5 class="fw-bold text-dark mb-1">No Products Found in This Category</h5>
      <p class="text-muted mb-4">We are currently restocking products for <?= html_escape($category->name) ?>.</p>
      <a href="<?= base_url('products') ?>" class="btn-srl-primary">
        Browse All Products
      </a>
    </div>
  <?php endif; ?>
</div>
