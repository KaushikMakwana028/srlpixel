<style>
/* ============================================================
   PRODUCT DETAIL VIEW STYLES
   ============================================================ */

/* Product Detail & Interactive Gallery */
.main-preview-container {
  height: 420px;
  background: #0d1017;
  border: 1px solid rgba(255, 42, 133, 0.25);
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  position: relative;
  overflow: hidden;
  cursor: zoom-in;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.main-preview-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: opacity 0.2s ease, transform 0.3s ease;
}

.main-preview-container:hover img {
  transform: scale(1.03);
}

@media (max-width: 767.98px) {
  .main-preview-container {
    height: 280px;
    border-radius: 14px;
  }
}

.gallery-thumbnail-strip {
  display: flex;
  gap: 10px;
  overflow-x: auto;
  padding-bottom: 6px;
  -webkit-overflow-scrolling: touch;
}

.gallery-thumb-item {
  width: 72px;
  height: 72px;
  border-radius: 12px;
  border: 2px solid rgba(255, 255, 255, 0.12);
  background: #0d1017;
  cursor: pointer;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  flex-shrink: 0;
  transition: all 0.2s ease;
}

@media (max-width: 767.98px) {
  .gallery-thumb-item {
    width: 58px;
    height: 58px;
    border-radius: 10px;
  }
}

.gallery-thumb-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.gallery-thumb-item:hover {
  border-color: var(--srl-pink);
}

.gallery-thumb-item.active {
  border-color: #e11d74 !important;
  box-shadow: 0 0 14px rgba(225, 29, 116, 0.55);
}

/* Product Purchase CTA Buttons & Quantity Selector */
.srl-qty-pill {
  display: inline-flex;
  align-items: center;
  background: #f8fafc;
  border: 1.5px solid #cbd5e1;
  border-radius: 30px;
  padding: 4px;
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.04);
}

.srl-qty-btn {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  border: none;
  background: #ffffff;
  color: #1e293b;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.18s ease;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.srl-qty-btn:hover {
  background: var(--srl-pink);
  color: #ffffff;
  transform: scale(1.08);
}

.srl-qty-val {
  width: 48px;
  border: none;
  background: transparent;
  text-align: center;
  font-weight: 800;
  color: #0f172a;
  font-size: 1rem;
  user-select: none;
}

.srl-btn-cart-cta {
  height: 52px;
  border-radius: 14px;
  background: #ffffff;
  color: var(--srl-pink);
  border: 2px solid var(--srl-pink);
  font-weight: 700;
  font-size: 0.95rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 2px 8px rgba(225, 29, 116, 0.12);
  text-decoration: none;
  white-space: nowrap !important;
  padding: 0 16px;
}

.srl-btn-cart-cta:hover:not(:disabled) {
  background: rgba(225, 29, 116, 0.08);
  color: var(--srl-pink);
  border-color: var(--srl-pink);
  box-shadow: 0 6px 20px rgba(225, 29, 116, 0.25);
  transform: translateY(-2px);
}

.srl-btn-cart-cta:disabled,
.srl-btn-buynow-cta:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  transform: none !important;
  box-shadow: none !important;
}

.srl-btn-buynow-cta {
  height: 52px;
  border-radius: 14px;
  background: var(--srl-pink-gradient);
  color: #ffffff;
  border: 2px solid transparent;
  font-weight: 700;
  font-size: 0.95rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 4px 18px rgba(225, 29, 116, 0.4);
  text-decoration: none;
  white-space: nowrap !important;
  padding: 0 16px;
}

.srl-btn-buynow-cta:hover:not(:disabled) {
  background: linear-gradient(135deg, #ff4195 0%, #d11267 100%);
  color: #ffffff;
  box-shadow: 0 8px 25px rgba(225, 29, 116, 0.55);
  transform: translateY(-2px);
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

.product-title-detail {
  font-size: clamp(1.15rem, 3.8vw, 1.85rem);
  line-height: 1.25;
  font-weight: 800;
  word-break: break-word;
}

.srl-stock-badge {
  display: inline-flex !important;
  align-items: center !important;
  flex-wrap: wrap !important;
  white-space: normal !important;
  word-break: break-word !important;
  max-width: 100% !important;
  font-size: 0.85rem !important;
  line-height: 1.35 !important;
  padding: 6px 12px !important;
  border-radius: 8px !important;
}

.product-detail-desc {
  font-size: 0.92rem;
  line-height: 1.6;
  word-break: break-word;
}

@media (max-width: 576px) {
  .srl-btn-cart-cta,
  .srl-btn-buynow-cta {
    height: 48px !important;
    font-size: 0.92rem !important;
    border-radius: 12px !important;
    padding: 0 12px !important;
  }
  .srl-btn-cart-cta i,
  .srl-btn-buynow-cta i {
    font-size: 1.15rem !important;
  }
  .srl-purchase-area {
    padding: 14px 12px !important;
    border-radius: 14px !important;
  }
  .srl-qty-btn {
    width: 30px !important;
    height: 30px !important;
  }
  .srl-qty-val {
    width: 38px !important;
    font-size: 0.92rem !important;
  }
  .srl-stock-badge {
    font-size: 0.78rem !important;
    padding: 4px 8px !important;
  }
  .product-detail-desc {
    font-size: 0.85rem !important;
    line-height: 1.55 !important;
  }
}
</style>

<div class="container py-3 py-md-4">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-3 mb-md-4">
    <ol class="breadcrumb mb-0 flex-wrap" style="font-size: 0.84rem;">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Home</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('categories') ?>" class="text-decoration-none text-muted">Categories</a></li>
      <?php if (!empty($category)): ?>
        <li class="breadcrumb-item"><a href="<?= base_url('category/' . $category->id) ?>" class="text-decoration-none text-muted"><?= html_escape($category->name) ?></a></li>
      <?php endif; ?>
      <li class="breadcrumb-item active text-dark fw-semibold text-truncate" style="max-width: 200px;" aria-current="page"><?= html_escape($product->name) ?></li>
    </ol>
  </nav>

  <!-- Product Details Card -->
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden p-3 p-sm-4 p-md-5 mb-4 mb-md-5" style="border: 1px solid #e2e8f0 !important; max-width: 100%;">
    <div class="row g-3 g-md-5">

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
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
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
        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
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

        <h2 class="fw-extrabold text-dark mb-2 product-title-detail">
          <?= html_escape($product->name) ?>
        </h2>

        <!-- Pricing Block -->
        <div class="p-2 p-sm-3 rounded-3 mb-3 bg-light d-flex align-items-baseline flex-wrap gap-2 gap-sm-3">
          <?php if ($has_discount): ?>
            <span class="fw-extrabold" style="color: var(--srl-pink); font-size: clamp(1.35rem, 4.5vw, 2.1rem); line-height: 1.1;">
              ₹<?= number_format($product->discount_price, 2) ?>
            </span>
            <span class="text-decoration-line-through text-muted" style="font-size: clamp(0.9rem, 3.2vw, 1.1rem);">
              ₹<?= number_format($product->price, 2) ?>
            </span>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 small">
              Save ₹<?= number_format($product->price - $product->discount_price, 2) ?>
            </span>
          <?php else: ?>
            <span class="fw-extrabold" style="color: var(--srl-pink); font-size: clamp(1.35rem, 4.5vw, 2.1rem); line-height: 1.1;">
              ₹<?= number_format($product->price, 2) ?>
            </span>
          <?php endif; ?>
        </div>

        <!-- Stock Status -->
        <div class="mb-3">
          <?php if ($product->stock > 10): ?>
            <span class="badge bg-success-subtle text-success border border-success-subtle srl-stock-badge">
              <i class="bi bi-check-circle-fill me-1"></i> In Stock (<?= $product->stock ?> units ready to ship)
            </span>
          <?php elseif ($product->stock > 0): ?>
            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle srl-stock-badge">
              <i class="bi bi-exclamation-triangle-fill me-1"></i> Only <?= $product->stock ?> left in stock!
            </span>
          <?php else: ?>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle srl-stock-badge">
              <i class="bi bi-x-circle-fill me-1"></i> Currently Out of Stock
            </span>
          <?php endif; ?>
        </div>

        <!-- Description -->
        <div class="mb-3">
          <h6 class="fw-bold text-dark mb-1 mb-md-2" style="font-size: 0.95rem;">Product Description</h6>
          <p class="text-muted product-detail-desc mb-0">
            <?= !empty($product->description) ? nl2br(html_escape($product->description)) : 'Premium commercial-grade pixel LED product with superior luminosity, long operating lifespan, and precision timing signals for decorative, architectural, and stage lighting.' ?>
          </p>
        </div>

        <!-- Purchase Action Area -->
        <div class="srl-purchase-area p-3 p-md-4 rounded-4 mb-4" style="background: #ffffff; border: 1.5px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);">
          <!-- Quantity Row -->
          <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom flex-wrap gap-2">
            <div>
              <span class="fw-bold text-dark d-block" style="font-size: 0.92rem;">Select Quantity:</span>
              <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-shield-check text-success me-1"></i><?= ($product->stock > 0) ? $product->stock . ' units ready to dispatch' : 'Out of stock' ?></small>
            </div>
            <!-- Custom Styled Quantity Selector -->
            <div class="srl-qty-pill">
              <button class="srl-qty-btn" type="button" id="btnQtyMinus" aria-label="Decrease quantity">
                <i class="bi bi-dash"></i>
              </button>
              <input type="text" class="srl-qty-val" id="productQtyInput" value="1" readonly>
              <button class="srl-qty-btn" type="button" id="btnQtyPlus" aria-label="Increase quantity">
                <i class="bi bi-plus"></i>
              </button>
            </div>
          </div>

          <!-- Action Buttons (Add to Cart & Buy Now - Full width responsive stack on mobile, side-by-side on tablet/desktop) -->
          <div class="row g-2 g-sm-3">
            <div class="col-12 col-sm-6">
              <button type="button" class="srl-btn-cart-cta w-100" id="btnAddToCartDetail" data-id="<?= $product->id ?>" data-name="<?= html_escape($product->name) ?>" <?= ($product->stock <= 0) ? 'disabled' : '' ?>>
                <i class="bi bi-cart-plus-fill me-2 fs-5"></i>
                <span>Add To Cart</span>
              </button>
            </div>
            <div class="col-12 col-sm-6">
              <button type="button" class="srl-btn-buynow-cta w-100" id="btnBuyNowDetail" <?= ($product->stock <= 0) ? 'disabled' : '' ?>>
                <i class="bi bi-lightning-charge-fill me-2 fs-5"></i>
                <span>Buy Now</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Trust Features Strip -->
        <div class="border-top pt-3 pt-md-4">
          <div class="row g-2 g-sm-3 text-start">
            <div class="col-12 col-sm-4">
              <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background: #f8fafc;">
                <i class="bi bi-shield-check text-success fs-5 flex-shrink-0"></i>
                <span class="text-dark fw-bold" style="font-size: 0.8rem; line-height: 1.25;">100% Genuine SRL Pixel Product</span>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background: #f8fafc;">
                <i class="bi bi-truck fs-5 flex-shrink-0" style="color: var(--srl-pink) !important;"></i>
                <span class="text-dark fw-bold" style="font-size: 0.8rem; line-height: 1.25;">Fast Dispatch Across India</span>
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background: #f8fafc;">
                <i class="bi bi-arrow-repeat text-primary fs-5 flex-shrink-0"></i>
                <span class="text-dark fw-bold" style="font-size: 0.8rem; line-height: 1.25;">Easy 7-Day Replacement</span>
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

      <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-sm-3 g-md-4">
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
    const num = parseInt(count) || 0;
    document.querySelectorAll('.cart-badge-count').forEach(badge => {
      badge.innerText = num;
      badge.style.setProperty('display', (num > 0) ? 'flex' : 'none', 'important');
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
