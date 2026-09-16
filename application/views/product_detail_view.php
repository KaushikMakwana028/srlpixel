<div class="container py-4">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Home</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('categories') ?>" class="text-decoration-none text-muted">Categories</a></li>
      <?php if (!empty($category)): ?>
        <li class="breadcrumb-item"><a href="<?= base_url('category/' . $category->id) ?>" class="text-decoration-none text-muted"><?= html_escape($category->name) ?></a></li>
      <?php endif; ?>
      <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page"><?= html_escape($product->name) ?></li>
    </ol>
  </nav>

  <!-- Product Details Card -->
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden p-3 p-md-5 mb-5" style="border: 1px solid #e2e8f0 !important;">
    <div class="row g-5">

      <!-- ============================================================
           LEFT COLUMN: INTERACTIVE MULTI-ANGLE GALLERY (CLICKABLE IMAGES)
           ============================================================ -->
      <div class="col-lg-6">
        <?php
          $has_discount = (!empty($product->discount_price) && $product->discount_price < $product->price);
          $main_img_url = (!empty($product->image) && file_exists('./uploads/products/' . $product->image))
            ? base_url('uploads/products/' . $product->image)
            : '';
        ?>

        <!-- Main Big Image Preview Box -->
        <div class="main-preview-container mb-3 position-relative" id="mainImageContainer" title="Click to view full-size big image">
          <?php if ($has_discount): ?>
            <span class="srl-discount-badge" style="font-size: 0.85rem; padding: 4px 12px;">
              -<?= $discount_pct ?>% OFF
            </span>
          <?php endif; ?>

          <button type="button" class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-3 shadow-sm" id="btnZoomModal" title="Open Fullscreen Lightbox" style="width: 38px; height: 38px;">
            <i class="bi bi-arrows-fullscreen text-dark"></i>
          </button>

          <?php if (!empty($main_img_url)): ?>
            <img src="<?= $main_img_url ?>" alt="<?= html_escape($product->name) ?>" id="activeLargeImage">
          <?php else: ?>
            <div class="text-center text-muted" id="placeholderImage">
              <i class="bi bi-image" style="font-size: 5rem; opacity: 0.3;"></i>
              <p class="small mb-0 mt-2">No photo available</p>
            </div>
            <img src="" alt="<?= html_escape($product->name) ?>" id="activeLargeImage" style="display: none;">
          <?php endif; ?>
        </div>

        <!-- Thumbnail Selector Row (Main photo + Gallery photos) -->
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="text-muted small fw-semibold">Photo Gallery</span>
          <small class="text-muted"><i class="bi bi-cursor me-1"></i>Click photo to switch view</small>
        </div>

        <div class="gallery-thumbnail-strip" id="galleryThumbnails">
          <!-- Main Thumbnail -->
          <?php if (!empty($main_img_url)): ?>
            <div class="gallery-thumb-item active" data-src="<?= $main_img_url ?>" title="Primary Photo">
              <img src="<?= $main_img_url ?>" alt="Main Photo">
            </div>
          <?php endif; ?>

          <!-- Gallery Photos from product_gallery table -->
          <?php if (!empty($gallery)): ?>
            <?php foreach ($gallery as $g_index => $g_img): ?>
              <?php
                $g_url = base_url('uploads/products/gallery/' . $g_img->image);
              ?>
              <div class="gallery-thumb-item <?= (empty($main_img_url) && $g_index === 0) ? 'active' : '' ?>" data-src="<?= $g_url ?>" title="Gallery Photo <?= $g_index + 1 ?>">
                <img src="<?= $g_url ?>" alt="Gallery Photo <?= $g_index + 1 ?>">
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <p class="text-muted small mt-2 mb-0">
          <i class="bi bi-info-circle me-1" style="color: var(--srl-pink);"></i> Click any thumbnail above to view in the large preview box, or click the main box to view high-resolution full screen.
        </p>
      </div>


      <!-- ============================================================
           RIGHT COLUMN: PRODUCT DETAILS & SPECIFICATIONS
           ============================================================ -->
      <div class="col-lg-6">
        <div class="d-flex align-items-center gap-2 mb-2">
          <?php if (!empty($category)): ?>
            <a href="<?= base_url('category/' . $category->id) ?>" class="badge text-decoration-none rounded-pill px-3 py-1 text-white" style="background: var(--srl-pink);">
              <?= html_escape($category->name) ?>
            </a>
          <?php endif; ?>

          <?php if (!empty($product->sku)): ?>
            <span class="badge bg-light text-secondary border">
              SKU: <?= html_escape($product->sku) ?>
            </span>
          <?php endif; ?>
        </div>

        <h2 class="fw-extrabold text-dark mb-2">
          <?= html_escape($product->name) ?>
        </h2>

        <!-- Rating & Reviews -->
        <div class="d-flex align-items-center gap-2 mb-3">
          <div class="text-warning">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-half"></i>
          </div>
          <span class="text-dark fw-bold small">4.8</span>
          <span class="text-muted small">(38 customer ratings)</span>
        </div>

        <!-- Pricing Block -->
        <div class="p-3 rounded-3 mb-4 bg-light d-flex align-items-baseline gap-3">
          <?php if ($has_discount): ?>
            <span class="display-6 fw-extrabold" style="color: var(--srl-pink);">
              ₹<?= number_format($product->discount_price, 2) ?>
            </span>
            <span class="text-decoration-line-through text-muted fs-5">
              ₹<?= number_format($product->price, 2) ?>
            </span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small">
              Save ₹<?= number_format($product->price - $product->discount_price, 2) ?>
            </span>
          <?php else: ?>
            <span class="display-6 fw-extrabold" style="color: var(--srl-pink);">
              ₹<?= number_format($product->price, 2) ?>
            </span>
          <?php endif; ?>
        </div>

        <!-- Stock Status -->
        <div class="mb-4">
          <?php if ($product->stock > 10): ?>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6">
              <i class="bi bi-check-circle-fill me-1"></i> In Stock (<?= $product->stock ?> units ready to ship)
            </span>
          <?php elseif ($product->stock > 0): ?>
            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 fs-6">
              <i class="bi bi-exclamation-triangle-fill me-1"></i> Only <?= $product->stock ?> left in stock!
            </span>
          <?php else: ?>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fs-6">
              <i class="bi bi-x-circle-fill me-1"></i> Currently Out of Stock
            </span>
          <?php endif; ?>
        </div>

        <!-- Description -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark mb-2">Product Description</h6>
          <p class="text-muted" style="line-height: 1.65;">
            <?= !empty($product->description) ? nl2br(html_escape($product->description)) : 'Premium commercial-grade pixel LED product with superior luminosity, long operating lifespan, and precision timing signals for decorative, architectural, and stage lighting.' ?>
          </p>
        </div>

        <!-- Quantity & Add to Cart -->
        <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
          <div class="input-group" style="width: 130px;">
            <button class="btn btn-outline-secondary" type="button" id="btnQtyMinus">-</button>
            <input type="text" class="form-control text-center fw-bold" id="productQtyInput" value="1" readonly>
            <button class="btn btn-outline-secondary" type="button" id="btnQtyPlus">+</button>
          </div>

          <button type="button" class="btn-srl-primary px-4 py-3 flex-grow-1" id="btnAddToCartDetail" data-id="<?= $product->id ?>" data-name="<?= html_escape($product->name) ?>" <?= ($product->stock <= 0) ? 'disabled' : '' ?>>
            <i class="bi bi-cart-plus me-2"></i>Add To Cart
          </button>

          <button type="button" class="btn btn-dark rounded-pill px-4 py-3 fw-bold" id="btnBuyNowDetail" <?= ($product->stock <= 0) ? 'disabled' : '' ?>>
            <i class="bi bi-lightning-charge-fill me-1" style="color: var(--srl-pink);"></i>Buy Now
          </button>
        </div>

        <!-- Trust Features Strip -->
        <div class="border-top pt-4">
          <div class="row g-3 text-center text-sm-start">
            <div class="col-sm-4">
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-shield-check text-success fs-4"></i>
                <small class="text-dark fw-bold">100% Genuine SRL Pixel Product</small>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-truck text-danger fs-4" style="color: var(--srl-pink) !important;"></i>
                <small class="text-dark fw-bold">Fast Dispatch Across India</small>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-arrow-repeat text-primary fs-4"></i>
                <small class="text-dark fw-bold">Easy 7-Day Replacement</small>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  <!-- ============================================================
       RELATED PRODUCTS SECTION ("MORE FROM THIS CATEGORY")
       ============================================================ -->
  <?php if (!empty($related_products)): ?>
    <div class="mb-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">
          <i class="bi bi-stars me-2" style="color: var(--srl-pink);"></i>You May Also Like
        </h4>
        <?php if (!empty($category)): ?>
          <a href="<?= base_url('category/' . $category->id) ?>" class="text-decoration-none fw-bold small" style="color: var(--srl-pink);">
            View All in <?= html_escape($category->name) ?> <i class="bi bi-arrow-right"></i>
          </a>
        <?php endif; ?>
      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($related_products as $rel): ?>
          <?php
            $rel_discount = (!empty($rel->discount_price) && $rel->discount_price < $rel->price);
            $rel_pct = $rel_discount ? round((($rel->price - $rel->discount_price) / $rel->price) * 100) : 0;
          ?>
          <div class="col">
            <div class="srl-product-card">
              <?php if ($rel_discount): ?>
                <span class="srl-discount-badge">-<?= $rel_pct ?>%</span>
              <?php endif; ?>

              <a href="<?= base_url('product/' . $rel->id) ?>" class="srl-product-img-box text-decoration-none">
                <?php if (!empty($rel->image) && file_exists('./uploads/products/' . $rel->image)): ?>
                  <img src="<?= base_url('uploads/products/' . $rel->image) ?>" alt="<?= html_escape($rel->name) ?>">
                <?php else: ?>
                  <i class="bi bi-image text-muted" style="font-size: 3.5rem; opacity: 0.35;"></i>
                <?php endif; ?>
              </a>

              <div class="srl-product-body">
                <a href="<?= base_url('product/' . $rel->id) ?>" class="srl-product-title" title="<?= html_escape($rel->name) ?>">
                  <?= html_escape($rel->name) ?>
                </a>

                <div class="srl-product-rating">
                  <i class="bi bi-star-fill active-star"></i>
                  <i class="bi bi-star-fill active-star"></i>
                  <i class="bi bi-star-fill active-star"></i>
                  <i class="bi bi-star-fill active-star"></i>
                  <i class="bi bi-star-half active-star"></i>
                </div>

                <div class="srl-price-box">
                  <?php if ($rel_discount): ?>
                    <span class="srl-old-price">₹<?= number_format($rel->price, 2) ?></span>
                    <span class="srl-sale-price">₹<?= number_format($rel->discount_price, 2) ?></span>
                  <?php else: ?>
                    <span class="srl-sale-price">₹<?= number_format($rel->price, 2) ?></span>
                  <?php endif; ?>
                </div>

                <button type="button" class="btn-add-to-cart" data-id="<?= $rel->id ?>" data-name="<?= html_escape($rel->name) ?>" <?= ($rel->stock <= 0) ? 'disabled' : '' ?>>
                  Add To Cart
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>

<!-- ============================================================
     INTERACTIVE GALLERY & LIGHTBOX JAVASCRIPT
     ============================================================ -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const activeLargeImage = document.getElementById('activeLargeImage');
  const mainImageContainer = document.getElementById('mainImageContainer');
  const btnZoomModal = document.getElementById('btnZoomModal');
  const placeholderImage = document.getElementById('placeholderImage');
  const thumbs = document.querySelectorAll('.gallery-thumb-item');

  // Thumbnail Click -> Switch Main Preview Image
  thumbs.forEach(thumb => {
    thumb.addEventListener('click', function () {
      const src = this.getAttribute('data-src');
      if (!src) return;

      // Update active thumbnail border
      thumbs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');

      // Smooth swap image with fade
      activeLargeImage.style.opacity = '0.3';
      setTimeout(() => {
        activeLargeImage.src = src;
        activeLargeImage.style.display = 'block';
        if (placeholderImage) placeholderImage.style.display = 'none';
        activeLargeImage.style.opacity = '1';
      }, 150);
    });
  });

  // Open Fullscreen Lightbox Modal
  function openLightbox() {
    if (!activeLargeImage || !activeLargeImage.src || activeLargeImage.style.display === 'none') return;
    const lightboxModal = document.getElementById('srlImageLightboxModal');
    const lightboxImg = document.getElementById('lightboxBigImage');
    const lightboxCaption = document.getElementById('lightboxCaption');

    if (lightboxModal && lightboxImg) {
      lightboxImg.src = activeLargeImage.src;
      if (lightboxCaption) {
        lightboxCaption.innerText = "<?= html_escape($product->name) ?>";
      }
      const modal = new bootstrap.Modal(lightboxModal);
      modal.show();
    }
  }

  if (mainImageContainer) {
    mainImageContainer.addEventListener('click', function (e) {
      openLightbox();
    });
  }

  if (btnZoomModal) {
    btnZoomModal.addEventListener('click', function (e) {
      e.stopPropagation();
      openLightbox();
    });
  }

  // Quantity Increment / Decrement
  const qtyInput = document.getElementById('productQtyInput');
  const btnMinus = document.getElementById('btnQtyMinus');
  const btnPlus = document.getElementById('btnQtyPlus');

  if (qtyInput && btnMinus && btnPlus) {
    btnMinus.addEventListener('click', function () {
      let val = parseInt(qtyInput.value) || 1;
      if (val > 1) qtyInput.value = val - 1;
    });

    btnPlus.addEventListener('click', function () {
      let val = parseInt(qtyInput.value) || 1;
      const max = <?= (int)$product->stock ?>;
      if (val < max) qtyInput.value = val + 1;
    });
  }

  // Helper function to update header cart badge
  function updateHeaderBadge(count) {
    document.querySelectorAll('.cart-badge-count').forEach(badge => {
      badge.innerText = count;
    });
  }

  // Show Login Prompt Dialog
  function showLoginPrompt(loginUrl) {
    Swal.fire({
      title: 'Sign In Required',
      html: 'Please sign in to your customer account to add products to your cart and checkout.',
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: '<i class="bi bi-box-arrow-in-right me-1"></i> Sign In',
      cancelButtonText: 'Continue Browsing',
      customClass: {
        popup: 'srl-swal-popup',
        confirmButton: 'srl-swal-confirm',
        cancelButton: 'srl-swal-cancel'
      },
      buttonsStyling: false
    }).then(res => {
      if (res.isConfirmed) {
        window.location.href = loginUrl || '<?= base_url('login') ?>';
      }
    });
  }

  // Add To Cart Click Handler (Detail Page)
  const btnAddToCart = document.getElementById('btnAddToCartDetail');
  if (btnAddToCart) {
    btnAddToCart.addEventListener('click', function () {
      const prodId = this.getAttribute('data-id');
      const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;

      const formData = new FormData();
      formData.append('product_id', prodId);
      formData.append('quantity', qty);

      fetch('<?= base_url('cart/add') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(res => res.json())
        .then(data => {
          if (data.require_login) {
            showLoginPrompt(data.login_url);
          } else if (data.success) {
            updateHeaderBadge(data.cart_count);
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: data.message,
              showConfirmButton: false,
              timer: 2500,
              customClass: { popup: 'srl-swal-toast' }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Notice',
              text: data.message || 'Unable to add product to cart.',
              customClass: { popup: 'srl-swal-popup', confirmButton: 'srl-swal-confirm' },
              buttonsStyling: false
            });
          }
        })
        .catch(err => console.error('Add to cart error:', err));
    });
  }

  // Buy Now Click Handler (Detail Page): Adds to Cart & Redirects to Cart Page
  const btnBuyNow = document.getElementById('btnBuyNowDetail');
  if (btnBuyNow) {
    btnBuyNow.addEventListener('click', function () {
      const prodId = btnAddToCart ? btnAddToCart.getAttribute('data-id') : '<?= $product->id ?>';
      const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;

      const formData = new FormData();
      formData.append('product_id', prodId);
      formData.append('quantity', qty);

      fetch('<?= base_url('cart/add') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(res => res.json())
        .then(data => {
          if (data.require_login) {
            showLoginPrompt(data.login_url);
          } else if (data.success) {
            updateHeaderBadge(data.cart_count);
            // Redirect immediately to shopping cart
            window.location.href = '<?= base_url('cart') ?>';
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Notice',
              text: data.message || 'Unable to process purchase.',
              customClass: { popup: 'srl-swal-popup', confirmButton: 'srl-swal-confirm' },
              buttonsStyling: false
            });
          }
        })
        .catch(err => console.error('Buy now error:', err));
    });
  }
});
</script>
