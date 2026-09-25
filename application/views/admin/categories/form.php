<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-diagram-3-fill me-2" style="color: var(--srl-pink);"></i><?= $is_edit ? 'Edit Category' : 'Add New Category' ?>
    </h4>
    <p class="text-muted small mb-0"><?= $is_edit ? 'Modify category naming and visual branding' : 'Create a new catalog category for pixel LED lighting products' ?></p>
  </div>
  <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm d-inline-flex align-items-center">
    <i class="bi bi-arrow-left me-1"></i>Back to Categories
  </a>
</div>

<?= form_open_multipart($is_edit ? 'admin/categories/edit/' . $category->id : 'admin/categories/add', ['id' => 'categoryForm']) ?>
<div class="row g-4">
  <!-- Left Column: Category Metadata -->
  <div class="col-lg-7">
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-card-heading me-2 text-primary"></i>Category Details
        </h6>
      </div>
      <div class="card-body p-4">
        <div class="mb-3">
          <label for="catName" class="form-label fw-semibold text-secondary small">Category Name <span class="text-danger">*</span></label>
          <div class="auth-input-group mb-0">
            <i class="bi bi-tag input-icon"></i>
            <input type="text" name="name" id="catName" class="form-control bg-light text-dark" placeholder="e.g. Pixel LED Strips" value="<?= set_value('name', $category ? $category->name : '') ?>" required>
          </div>
        </div>



        <div class="mb-0">
          <label for="catDescription" class="form-label fw-semibold text-secondary small">Description</label>
          <div class="auth-input-group mb-0">
            <i class="bi bi-card-text input-icon" style="top: 24px;"></i>
            <textarea name="description" id="catDescription" rows="4" class="form-control bg-light text-dark" placeholder="Describe the types of lighting, controllers, or accessories in this category..."><?= set_value('description', $category ? $category->description : '') ?></textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- Publishing Status Card -->
    <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-body p-4">
        <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between">
          <div>
            <label class="form-check-label fw-bold text-dark d-block mb-1" for="statusSwitch">
              Publish Status
            </label>
            <p class="text-muted small mb-0" id="statusDescText">
              <?= (!$category || $category->status == 1) ? 'Visible in customer navigation, catalog filters, and homepage' : 'Hidden from storefront catalog' ?>
            </p>
          </div>
          <input class="form-check-input ms-0" type="checkbox" role="switch" name="status" id="statusSwitch" value="1" <?= (!$category || $category->status == 1) ? 'checked' : '' ?> style="width: 2.6em; height: 1.3em; cursor: pointer;">
        </div>
      </div>
    </div>
  </div>

  <!-- Right Column: Visual Image & Live Preview -->
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-image me-2" style="color: var(--srl-pink);"></i>Category Image Preview
        </h6>
        <span class="badge bg-light text-dark border">Max 2 MB</span>
      </div>
      <div class="card-body p-4 text-center">
        <!-- Live Preview Container -->
        <div id="catPreviewBox" class="rounded-4 border overflow-hidden position-relative mx-auto mb-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 100%; max-width: 280px; height: 200px; background: #0f121a;">
          <?php if ($category && !empty($category->image) && file_exists('./uploads/categories/' . $category->image)): ?>
            <img id="catImgElement" src="<?= base_url('uploads/categories/' . $category->image) ?>" alt="<?= html_escape($category->name) ?>" class="w-100 h-100 object-fit-cover">
            <span id="catImgBadge" class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white border border-secondary shadow-sm">
              <i class="bi bi-check-circle me-1 text-success"></i>Current Image
            </span>
          <?php else: ?>
            <img id="catImgElement" src="" alt="Preview" class="w-100 h-100 object-fit-cover" style="display: none;">
            <div id="catPlaceholder" class="text-center p-3">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px; background: rgba(255, 42, 133, 0.12); color: var(--srl-pink);">
                <i class="bi bi-image fs-3"></i>
              </div>
              <p class="text-white-50 small mb-0">No image uploaded yet</p>
              <span class="text-muted" style="font-size: 0.72rem;">JPG, PNG, WEBP, SVG</span>
            </div>
            <span id="catImgBadge" class="position-absolute top-0 start-0 m-2 badge bg-success shadow-sm" style="display: none;">
              <i class="bi bi-sparkles me-1"></i>New Selection
            </span>
          <?php endif; ?>
        </div>

        <!-- Custom Upload Input Button -->
        <div class="mb-3">
          <label for="catImage" class="btn btn-outline-primary rounded-pill px-4 py-2 w-100 d-inline-flex align-items-center justify-content-center gap-2 mb-1" style="cursor: pointer;">
            <i class="bi bi-upload"></i>
            <span id="uploadBtnLabel"><?= ($category && !empty($category->image)) ? 'Choose New Image' : 'Select Category Image' ?></span>
          </label>
          <input type="file" name="image" id="catImage" class="d-none" accept="image/jpeg,image/png,image/webp,image/svg+xml">
          <button type="button" id="catResetImgBtn" class="btn btn-sm btn-link text-danger text-decoration-none mt-1" style="display: none;">
            <i class="bi bi-trash me-1"></i>Reset Selection
          </button>
        </div>

        <div class="text-muted small text-start bg-light p-3 rounded-3 border">
          <div class="d-flex align-items-center gap-2 mb-1">
            <i class="bi bi-info-circle text-primary"></i>
            <span class="fw-semibold text-dark">Image Specifications:</span>
          </div>
          <ul class="mb-0 ps-3" style="font-size: 0.78rem;">
            <li>File size: <strong>Strictly 2 MB maximum</strong></li>
            <li>Supported formats: <strong>JPG, PNG, WEBP, SVG</strong></li>
            <li>Recommended aspect: <strong>1:1 Square</strong> (e.g. 600x600px)</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Actions Toolbar -->
  <div class="col-12">
    <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-body p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="<?= base_url('admin/categories') ?>" class="btn btn-outline-secondary rounded-pill px-4">
          <i class="bi bi-x-circle me-1"></i>Cancel
        </a>
        <button type="submit" class="btn-srl-primary rounded-pill px-5 py-2">
          <i class="bi bi-check2-circle me-1"></i><?= $is_edit ? 'Update Category' : 'Save Category' ?>
        </button>
      </div>
    </div>
  </div>
</div>
<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function () {


  // Publish switch label update
  const statusSwitch = document.getElementById('statusSwitch');
  const statusDesc = document.getElementById('statusDescText');
  if (statusSwitch && statusDesc) {
    statusSwitch.addEventListener('change', function () {
      if (this.checked) {
        statusDesc.textContent = 'Visible in customer navigation, catalog filters, and homepage';
      } else {
        statusDesc.textContent = 'Hidden from storefront catalog';
      }
    });
  }

  // Image Upload Handling & 2MB Strict Validation
  const catImageInput = document.getElementById('catImage');
  const catImgElement = document.getElementById('catImgElement');
  const catPlaceholder = document.getElementById('catPlaceholder');
  const catImgBadge = document.getElementById('catImgBadge');
  const catResetBtn = document.getElementById('catResetImgBtn');
  const uploadBtnLabel = document.getElementById('uploadBtnLabel');

  const origSrc = catImgElement ? catImgElement.getAttribute('src') : '';
  const hasOrigImg = origSrc && origSrc.length > 0;
  const maxBytes = 2 * 1024 * 1024; // 2 MB

  if (catImageInput) {
    catImageInput.addEventListener('change', function () {
      const file = this.files[0];
      if (!file) return;

      // Validate 2MB Limit
      if (file.size > maxBytes) {
        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
        Swal.fire({
          title: 'File Too Large',
          html: `The selected image is <strong>${sizeMb} MB</strong>.<br>Maximum allowed category image size is <strong>2 MB</strong>.`,
          icon: 'warning',
          confirmButtonText: 'Select Smaller File',
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
        if (catImgElement) {
          catImgElement.src = e.target.result;
          catImgElement.style.display = 'block';
        }
        if (catPlaceholder) catPlaceholder.style.display = 'none';
        if (catImgBadge) {
          catImgBadge.className = 'position-absolute top-0 start-0 m-2 badge bg-success shadow-sm';
          catImgBadge.innerHTML = '<i class="bi bi-sparkles me-1"></i>New: ' + (file.size / 1024).toFixed(0) + ' KB';
          catImgBadge.style.display = 'inline-block';
        }
        if (uploadBtnLabel) uploadBtnLabel.textContent = 'Change Selected File';
        if (catResetBtn) catResetBtn.style.display = 'inline-block';
      };
      reader.readAsDataURL(file);
    });

    // Reset button
    if (catResetBtn) {
      catResetBtn.addEventListener('click', function () {
        catImageInput.value = '';
        if (hasOrigImg) {
          catImgElement.src = origSrc;
          catImgElement.style.display = 'block';
          if (catPlaceholder) catPlaceholder.style.display = 'none';
          if (catImgBadge) {
            catImgBadge.className = 'position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white border border-secondary shadow-sm';
            catImgBadge.innerHTML = '<i class="bi bi-check-circle me-1 text-success"></i>Current Image';
            catImgBadge.style.display = 'inline-block';
          }
          if (uploadBtnLabel) uploadBtnLabel.textContent = 'Choose New Image';
        } else {
          if (catImgElement) {
            catImgElement.src = '';
            catImgElement.style.display = 'none';
          }
          if (catPlaceholder) catPlaceholder.style.display = 'block';
          if (catImgBadge) catImgBadge.style.display = 'none';
          if (uploadBtnLabel) uploadBtnLabel.textContent = 'Select Category Image';
        }
        this.style.display = 'none';
      });
    }
  }
});
</script>
