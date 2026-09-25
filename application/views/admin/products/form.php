<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-box-seam me-2" style="color: var(--srl-pink);"></i><?= $is_edit ? 'Edit Product' : 'Add New Product' ?>
    </h4>
    <p class="text-muted small mb-0"><?= $is_edit ? 'Update product specifications, inventory, pricing, and gallery photos' : 'Create and publish a new item into SRL Pixel inventory' ?></p>
  </div>
  <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm d-inline-flex align-items-center">
    <i class="bi bi-arrow-left me-1"></i>Back to Products
  </a>
</div>

<?= form_open_multipart($is_edit ? 'admin/products/edit/' . $product->id : 'admin/products/add', ['id' => 'productForm']) ?>
<div class="row g-4">
  <!-- Left Column: Product Info, Pricing, Description -->
  <div class="col-lg-7">
    <!-- Card 1: Basic Information -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-info-circle me-2 text-primary"></i>Basic Information
        </h6>
      </div>
      <div class="card-body p-4">
        <div class="mb-3">
          <label for="prodName" class="form-label fw-semibold text-secondary small">Product Title <span class="text-danger">*</span></label>
          <div class="auth-input-group mb-0">
            <i class="bi bi-box input-icon"></i>
            <input type="text" name="name" id="prodName" class="form-control bg-light text-dark" placeholder="e.g. WS2812B 5V Addressable RGB LED Strip 60 LEDs/m" value="<?= set_value('name', $product ? $product->name : '') ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label for="prodCategory" class="form-label fw-semibold text-secondary small">Category <span class="text-danger">*</span></label>
          <select name="category_id" id="prodCategory" class="form-select bg-light text-dark py-2" required>
            <option value="">Select Category</option>
            <?php if (!empty($categories)): ?>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat->id ?>" <?= ($product && $product->category_id == $cat->id) ? 'selected' : '' ?>>
                  <?= html_escape($cat->name) ?>
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>


      </div>
    </div>

    <!-- Card 2: Pricing & Stock Inventory -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-cash-stack me-2 text-success"></i>Pricing & Inventory
        </h6>
        <span id="discountBadge" class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1" style="display: none;"></span>
      </div>
      <div class="card-body p-4">
        <div class="row g-3">
          <div class="col-md-4">
            <label for="prodPrice" class="form-label fw-semibold text-secondary small">Regular Price (₹) <span class="text-danger">*</span></label>
            <div class="auth-input-group mb-0">
              <i class="bi bi-currency-rupee input-icon"></i>
              <input type="number" step="0.01" min="0" name="price" id="prodPrice" class="form-control bg-light text-dark" placeholder="1450.00" value="<?= set_value('price', $product ? $product->price : '') ?>" required>
            </div>
          </div>
          <div class="col-md-4">
            <label for="prodDiscountPrice" class="form-label fw-semibold text-secondary small">Discount Price (₹)</label>
            <div class="auth-input-group mb-0">
              <i class="bi bi-percent input-icon"></i>
              <input type="number" step="0.01" min="0" name="discount_price" id="prodDiscountPrice" class="form-control bg-light text-dark" placeholder="1250.00" value="<?= set_value('discount_price', $product ? $product->discount_price : '') ?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex justify-content-between align-items-center">
              <label for="prodStock" class="form-label fw-semibold text-secondary small mb-1">Stock Quantity</label>
              <span id="stockStatusBadge" class="badge bg-secondary-subtle text-secondary" style="font-size: 0.65rem;">Status</span>
            </div>
            <div class="auth-input-group mb-0">
              <i class="bi bi-stack input-icon"></i>
              <input type="number" min="0" name="stock" id="prodStock" class="form-control bg-light text-dark" placeholder="100" value="<?= set_value('stock', $product ? $product->stock : 50) ?>">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Descriptions -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-text-paragraph me-2 text-info"></i>Descriptions & Specifications
        </h6>
      </div>
      <div class="card-body p-4">
        <div class="mb-3">
          <label for="prodShortDesc" class="form-label fw-semibold text-secondary small">Short Summary</label>
          <div class="auth-input-group mb-0">
            <i class="bi bi-card-text input-icon" style="top: 24px;"></i>
            <textarea name="short_description" id="prodShortDesc" rows="2" class="form-control bg-light text-dark" placeholder="Brief 1-2 sentence specification summary for cards and search results..."><?= set_value('short_description', $product ? $product->short_description : '') ?></textarea>
          </div>
        </div>

        <div class="mb-0">
          <label for="prodDesc" class="form-label fw-semibold text-secondary small">Full Product Description & Specifications</label>
          <textarea name="description" id="prodDesc" rows="5" class="form-control bg-light text-dark" placeholder="Provide full details: Operating Voltage (5V/12V), IC Chip Model, Waterproof Rating (IP30/IP65/IP67), Signal Type, and Connector pinout..."><?= set_value('description', $product ? $product->description : '') ?></textarea>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Column: Media (Main Thumbnail & Gallery) & Publishing -->
  <div class="col-lg-5">
    <!-- Card 4: Primary Product Thumbnail Preview & Upload -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-image me-2" style="color: var(--srl-pink);"></i>Main Product Thumbnail
        </h6>
        <span class="badge bg-light text-dark border">Max 2 MB</span>
      </div>
      <div class="card-body p-4 text-center">
        <!-- Live Preview Container -->
        <div id="mainProdPreviewBox" class="rounded-4 border overflow-hidden position-relative mx-auto mb-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 100%; max-width: 280px; height: 210px; background: #0f121a;">
          <?php if ($product && !empty($product->image) && file_exists('./uploads/products/' . $product->image)): ?>
            <img id="mainProdImgElement" src="<?= base_url('uploads/products/' . $product->image) ?>" alt="<?= html_escape($product->name) ?>" class="w-100 h-100 object-fit-cover">
            <span id="mainProdImgBadge" class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white border border-secondary shadow-sm">
              <i class="bi bi-check-circle me-1 text-success"></i>Current Thumbnail
            </span>
          <?php else: ?>
            <img id="mainProdImgElement" src="" alt="Preview" class="w-100 h-100 object-fit-cover" style="display: none;">
            <div id="mainProdPlaceholder" class="text-center p-3">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px; background: rgba(255, 42, 133, 0.12); color: var(--srl-pink);">
                <i class="bi bi-image fs-3"></i>
              </div>
              <p class="text-white-50 small mb-0">No thumbnail selected</p>
              <span class="text-muted" style="font-size: 0.72rem;">JPG, PNG, WEBP, SVG</span>
            </div>
            <span id="mainProdImgBadge" class="position-absolute top-0 start-0 m-2 badge bg-success shadow-sm" style="display: none;">
              <i class="bi bi-sparkles me-1"></i>New Selection
            </span>
          <?php endif; ?>
        </div>

        <!-- Custom Upload Input Button -->
        <div class="mb-3">
          <label for="prodImage" class="btn btn-outline-primary rounded-pill px-4 py-2 w-100 d-inline-flex align-items-center justify-content-center gap-2 mb-1" style="cursor: pointer;">
            <i class="bi bi-upload"></i>
            <span id="mainProdBtnLabel"><?= ($product && !empty($product->image)) ? 'Choose New Thumbnail' : 'Select Product Thumbnail' ?></span>
          </label>
          <input type="file" name="image" id="prodImage" class="d-none" accept="image/jpeg,image/png,image/webp,image/svg+xml">
          <button type="button" id="mainProdResetBtn" class="btn btn-sm btn-link text-danger text-decoration-none mt-1" style="display: none;">
            <i class="bi bi-trash me-1"></i>Reset Selection
          </button>
        </div>

        <div class="text-muted small text-start bg-light p-3 rounded-3 border">
          <div class="d-flex align-items-center gap-2 mb-1">
            <i class="bi bi-info-circle text-primary"></i>
            <span class="fw-semibold text-dark">Thumbnail Specs:</span>
          </div>
          <ul class="mb-0 ps-3" style="font-size: 0.78rem;">
            <li>Size limit: <strong>Strictly 2 MB maximum</strong></li>
            <li>Formats: <strong>JPG, PNG, WEBP, SVG</strong></li>
            <li>Recommended: <strong>Square (800x800px)</strong> with clean background</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Card 5: Product Gallery (Multiple Photos) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-images me-2" style="color: var(--srl-pink);"></i>Product Gallery
        </h6>
        <span class="badge bg-light text-dark border">Max 2 MB / Photo</span>
      </div>
      <div class="card-body p-4">
        <p class="text-muted small mb-2">Upload multiple images (angles, illuminated demos, closeups, and packaging).</p>
        
        <label for="galleryImages" class="btn btn-outline-secondary rounded-pill px-4 py-2 w-100 d-inline-flex align-items-center justify-content-center gap-2 mb-3" style="cursor: pointer;">
          <i class="bi bi-cloud-arrow-up"></i>
          <span>Upload Gallery Photos</span>
        </label>
        <input type="file" name="gallery_images[]" id="galleryImages" class="d-none" multiple accept="image/jpeg,image/png,image/webp,image/svg+xml">

        <!-- Instant Preview Grid for Newly Selected Gallery Files -->
        <div id="galleryPreviewContainer" class="d-flex flex-wrap gap-2 mb-3"></div>

        <?php if ($is_edit && !empty($gallery)): ?>
          <!-- Existing Saved Gallery Images -->
          <div class="border-top pt-3 mt-2">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-semibold text-secondary small">
                <i class="bi bi-collection me-1 text-primary"></i>Saved Gallery Photos (<?= count($gallery) ?>)
              </span>
            </div>
            <div class="row g-2">
              <?php foreach ($gallery as $g_item): ?>
                <div class="col-4 col-sm-3 col-lg-4 text-center" id="gallery-card-<?= $g_item->id ?>">
                  <div class="position-relative border rounded-3 overflow-hidden shadow-sm p-1 bg-white">
                    <img src="<?= base_url('uploads/products/gallery/' . $g_item->image) ?>" alt="Gallery Photo" class="w-100 rounded-2 object-fit-cover" style="height: 80px;">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle p-0 d-flex align-items-center justify-content-center btn-delete-gallery shadow" data-id="<?= $g_item->id ?>" data-prod-id="<?= $product->id ?>" style="width: 24px; height: 24px;" title="Delete this photo">
                      <i class="bi bi-x-lg" style="font-size: 0.7rem;"></i>
                    </button>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Card 6: Publishing Status Card -->
    <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-body p-4">
        <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between">
          <div>
            <label class="form-check-label fw-bold text-dark d-block mb-1" for="prodStatusSwitch">
              Publish Status
            </label>
            <p class="text-muted small mb-0" id="prodStatusDescText">
              <?= (!$product || $product->status == 1) ? 'Active and visible for storefront ordering' : 'Draft / Hidden from catalog' ?>
            </p>
          </div>
          <input class="form-check-input ms-0" type="checkbox" role="switch" name="status" id="prodStatusSwitch" value="1" <?= (!$product || $product->status == 1) ? 'checked' : '' ?> style="width: 2.6em; height: 1.3em; cursor: pointer;">
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Actions Toolbar -->
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-body p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary rounded-pill px-4">
          <i class="bi bi-x-circle me-1"></i>Cancel
        </a>
        <button type="submit" class="btn-srl-primary rounded-pill px-5 py-2">
          <i class="bi bi-check2-circle me-1"></i><?= $is_edit ? 'Update Product' : 'Publish Product' ?>
        </button>
      </div>
    </div>
  </div>
</div>
<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const maxBytes = 2 * 1024 * 1024; // 2 MB limit



  // Real-time Discount & Savings Badge Calculation
  const priceInput = document.getElementById('prodPrice');
  const discInput = document.getElementById('prodDiscountPrice');
  const discountBadge = document.getElementById('discountBadge');

  function updateDiscountBadge() {
    const regPrice = parseFloat(priceInput.value) || 0;
    const discPrice = parseFloat(discInput.value) || 0;
    if (regPrice > 0 && discPrice > 0 && discPrice < regPrice) {
      const savings = regPrice - discPrice;
      const pct = Math.round((savings / regPrice) * 100);
      discountBadge.textContent = `Save ₹${savings.toFixed(2)} (${pct}% OFF)`;
      discountBadge.style.display = 'inline-block';
    } else {
      discountBadge.style.display = 'none';
    }
  }

  if (priceInput && discInput) {
    priceInput.addEventListener('input', updateDiscountBadge);
    discInput.addEventListener('input', updateDiscountBadge);
    updateDiscountBadge();
  }

  // Real-time Stock Status Badge
  const stockInput = document.getElementById('prodStock');
  const stockBadge = document.getElementById('stockStatusBadge');

  function updateStockBadge() {
    if (!stockInput || !stockBadge) return;
    const stockVal = parseInt(stockInput.value, 10);
    if (isNaN(stockVal) || stockVal <= 0) {
      stockBadge.className = 'badge bg-danger-subtle text-danger border border-danger-subtle';
      stockBadge.textContent = 'Out of Stock';
    } else if (stockVal <= 20) {
      stockBadge.className = 'badge bg-warning-subtle text-warning-emphasis border border-warning-subtle';
      stockBadge.textContent = 'Low Stock (' + stockVal + ')';
    } else {
      stockBadge.className = 'badge bg-success-subtle text-success border border-success-subtle';
      stockBadge.textContent = 'In Stock (' + stockVal + ')';
    }
  }

  if (stockInput) {
    stockInput.addEventListener('input', updateStockBadge);
    updateStockBadge();
  }

  // Publish Status Switch listener
  const prodStatusSwitch = document.getElementById('prodStatusSwitch');
  const prodStatusDesc = document.getElementById('prodStatusDescText');
  if (prodStatusSwitch && prodStatusDesc) {
    prodStatusSwitch.addEventListener('change', function () {
      if (this.checked) {
        prodStatusDesc.textContent = 'Active and visible for storefront ordering';
      } else {
        prodStatusDesc.textContent = 'Draft / Hidden from catalog';
      }
    });
  }

  // Main Thumbnail Upload & Live Preview Handling
  const mainImageInput = document.getElementById('prodImage');
  const mainImgElement = document.getElementById('mainProdImgElement');
  const mainPlaceholder = document.getElementById('mainProdPlaceholder');
  const mainImgBadge = document.getElementById('mainProdImgBadge');
  const mainResetBtn = document.getElementById('mainProdResetBtn');
  const mainBtnLabel = document.getElementById('mainProdBtnLabel');

  const origThumbSrc = mainImgElement ? mainImgElement.getAttribute('src') : '';
  const hasOrigThumb = origThumbSrc && origThumbSrc.length > 0;

  if (mainImageInput) {
    mainImageInput.addEventListener('change', function () {
      const file = this.files[0];
      if (!file) return;

      // Strict 2MB File Size Validation
      if (file.size > maxBytes) {
        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
        Swal.fire({
          title: 'File Too Large',
          html: `The selected product thumbnail is <strong>${sizeMb} MB</strong>.<br>Maximum allowed file size is <strong>2 MB</strong>.`,
          icon: 'warning',
          confirmButtonText: 'Select Smaller Image',
          customClass: {
            popup: 'srl-swal-popup',
            title: 'srl-swal-title',
            htmlContainer: 'srl-swal-html',
            confirmButton: 'srl-swal-confirm'
          },
          buttonsStyling: false
        });
        this.value = '';
        return;
      }

      // Live Instant Preview
      const reader = new FileReader();
      reader.onload = function (e) {
        if (mainImgElement) {
          mainImgElement.src = e.target.result;
          mainImgElement.style.display = 'block';
        }
        if (mainPlaceholder) mainPlaceholder.style.display = 'none';
        if (mainImgBadge) {
          mainImgBadge.className = 'position-absolute top-0 start-0 m-2 badge bg-success shadow-sm';
          mainImgBadge.innerHTML = '<i class="bi bi-sparkles me-1"></i>New: ' + (file.size / 1024).toFixed(0) + ' KB';
          mainImgBadge.style.display = 'inline-block';
        }
        if (mainBtnLabel) mainBtnLabel.textContent = 'Change Selected File';
        if (mainResetBtn) mainResetBtn.style.display = 'inline-block';
      };
      reader.readAsDataURL(file);
    });

    // Reset button
    if (mainResetBtn) {
      mainResetBtn.addEventListener('click', function () {
        mainImageInput.value = '';
        if (hasOrigThumb) {
          mainImgElement.src = origThumbSrc;
          mainImgElement.style.display = 'block';
          if (mainPlaceholder) mainPlaceholder.style.display = 'none';
          if (mainImgBadge) {
            mainImgBadge.className = 'position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white border border-secondary shadow-sm';
            mainImgBadge.innerHTML = '<i class="bi bi-check-circle me-1 text-success"></i>Current Thumbnail';
            mainImgBadge.style.display = 'inline-block';
          }
          if (mainBtnLabel) mainBtnLabel.textContent = 'Choose New Thumbnail';
        } else {
          if (mainImgElement) {
            mainImgElement.src = '';
            mainImgElement.style.display = 'none';
          }
          if (mainPlaceholder) mainPlaceholder.style.display = 'block';
          if (mainImgBadge) mainImgBadge.style.display = 'none';
          if (mainBtnLabel) mainBtnLabel.textContent = 'Select Product Thumbnail';
        }
        this.style.display = 'none';
      });
    }
  }

  // Gallery Multiple Photos Upload & Preview (<= 2MB per photo)
  const galleryInput = document.getElementById('galleryImages');
  const previewContainer = document.getElementById('galleryPreviewContainer');

  if (galleryInput && previewContainer) {
    galleryInput.addEventListener('change', function () {
      previewContainer.innerHTML = '';
      const files = Array.from(this.files);
      if (!files.length) return;

      // Verify each file <= 2MB
      const oversized = files.filter(f => f.size > maxBytes);
      if (oversized.length > 0) {
        const fileNames = oversized.map(f => `<li><strong>${f.name}</strong> (${(f.size / (1024 * 1024)).toFixed(2)} MB)</li>`).join('');
        Swal.fire({
          title: 'Files Exceed 2MB Limit',
          html: `The following selected image(s) exceed <strong>2 MB</strong>:<ul class="text-start mt-2 mb-0 small">${fileNames}</ul><p class="mt-2 mb-0">Please select images under 2 MB each.</p>`,
          icon: 'warning',
          confirmButtonText: 'Understood',
          customClass: {
            popup: 'srl-swal-popup',
            title: 'srl-swal-title',
            htmlContainer: 'srl-swal-html',
            confirmButton: 'srl-swal-confirm'
          },
          buttonsStyling: false
        });
        this.value = '';
        return;
      }

      // Render previews for selected gallery images
      files.forEach((file) => {
        const reader = new FileReader();
        reader.onload = function (e) {
          const card = document.createElement('div');
          card.className = 'border rounded-3 overflow-hidden shadow-sm bg-white p-1 text-center position-relative';
          card.style.width = '88px';

          card.innerHTML = `
            <img src="${e.target.result}" class="w-100 rounded-2 object-fit-cover" style="height: 70px;" alt="${file.name}">
            <span class="badge bg-dark-subtle text-dark border w-100 text-truncate mt-1" style="font-size: 0.6rem;" title="${file.name}">
              ${(file.size / 1024).toFixed(0)} KB
            </span>
            <span class="badge bg-success position-absolute top-0 start-0 m-1 shadow-sm" style="font-size: 0.55rem;">
              New
            </span>
          `;
          previewContainer.appendChild(card);
        };
        reader.readAsDataURL(file);
      });
    });
  }

  // SweetAlert for Deleting Existing Gallery Image
  document.querySelectorAll('.btn-delete-gallery').forEach(btn => {
    btn.addEventListener('click', function () {
      const imgId = this.getAttribute('data-id');
      const prodId = this.getAttribute('data-prod-id');

      Swal.fire({
        title: 'Delete Gallery Image?',
        text: 'Are you sure you want to remove this photo from the product gallery?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-trash me-1"></i> Yes, Remove',
        cancelButtonText: 'Cancel',
        customClass: {
          popup: 'srl-swal-popup',
          title: 'srl-swal-title',
          htmlContainer: 'srl-swal-html',
          confirmButton: 'srl-swal-confirm',
          cancelButton: 'srl-swal-cancel'
        },
        buttonsStyling: false
      }).then(res => {
        if (res.isConfirmed) {
          window.location.href = '<?= base_url('admin/products/delete_gallery_image/') ?>' + imgId + '/' + prodId;
        }
      });
    });
  });
});
</script>
