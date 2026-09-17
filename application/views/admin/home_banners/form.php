<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-images me-2" style="color: var(--srl-pink);"></i><?= $is_edit ? 'Edit Banner' : 'Add Banner' ?>
    </h4>
    <p class="text-muted small mb-0"><?= $is_edit ? 'Modify homepage banner graphic, call-to-action link, and schedule.' : 'Create a new banner for homepage.' ?></p>
  </div>
  <a href="<?= base_url('admin/home_banners') ?>" class="btn btn-outline-secondary rounded-pill px-3 py-2 btn-sm d-inline-flex align-items-center">
    <i class="bi bi-arrow-left me-1"></i>Back to Home Banners
  </a>
</div>

<?php if (isset($upload_error) && !empty($upload_error)): ?>
  <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
      <div><strong>Upload Error:</strong> <?= html_escape($upload_error) ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (validation_errors()): ?>
  <div class="alert alert-warning alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
      <div><?= validation_errors() ?></div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?= form_open_multipart($is_edit ? 'admin/home_banners/edit/' . $banner->id : 'admin/home_banners/add', ['id' => 'bannerForm']) ?>
<div class="row g-4">
  <!-- Left Column: Banner Content & Schedule -->
  <div class="col-lg-8">
    <!-- Card 1: Banner Information -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-info-circle-fill me-2 text-primary"></i>Banner Information
        </h6>
      </div>
      <div class="card-body p-4">
        <!-- Title -->
        <div class="mb-3">
          <label for="bannerTitle" class="form-label fw-semibold text-secondary small">BANNER TITLE <span class="text-danger">*</span></label>
          <div class="auth-input-group mb-0">
            <i class="bi bi-type-h1 input-icon"></i>
            <input type="text" name="title" id="bannerTitle" class="form-control bg-light text-dark" placeholder="Enter banner title" value="<?= set_value('title', $banner ? $banner->title : '') ?>" required>
          </div>
        </div>

        <!-- Subtitle -->
        <div class="mb-3">
          <label for="bannerSubtitle" class="form-label fw-semibold text-secondary small">SUBTITLE</label>
          <div class="auth-input-group mb-0">
            <i class="bi bi-card-text input-icon"></i>
            <input type="text" name="subtitle" id="bannerSubtitle" class="form-control bg-light text-dark" placeholder="Enter banner subtitle (optional)" value="<?= set_value('subtitle', $banner ? $banner->subtitle : '') ?>">
          </div>
        </div>

        <!-- Button Text & Button Link -->
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="btnText" class="form-label fw-semibold text-secondary small">BUTTON TEXT</label>
            <div class="auth-input-group mb-0">
              <i class="bi bi-cursor-fill input-icon"></i>
              <input type="text" name="button_text" id="btnText" class="form-control bg-light text-dark" placeholder="e.g., Shop Now" value="<?= set_value('button_text', $banner ? $banner->button_text : 'Shop Now') ?>">
            </div>
          </div>
          <div class="col-md-6">
            <label for="btnLink" class="form-label fw-semibold text-secondary small">BUTTON LINK</label>
            <div class="auth-input-group mb-0">
              <i class="bi bi-link-45deg input-icon"></i>
              <input type="text" name="button_link" id="btnLink" class="form-control bg-light text-dark" placeholder="e.g., products or category/1" value="<?= set_value('button_link', $banner ? $banner->button_link : 'products') ?>">
            </div>
          </div>
        </div>

        <!-- Badge / Eyebrow Tag -->
        <div class="mb-0">
          <label for="badgeText" class="form-label fw-semibold text-secondary small">BADGE / HIGHLIGHT TAG</label>
          <div class="auth-input-group mb-0">
            <i class="bi bi-tag-fill input-icon"></i>
            <input type="text" name="badge_text" id="badgeText" class="form-control bg-light text-dark" placeholder="e.g., DREAM-COLOR INNOVATION" value="<?= set_value('badge_text', $banner ? $banner->badge_text : 'EXCLUSIVE COLLECTION') ?>">
          </div>
          <div class="form-text small text-muted mt-1">Small pill label that displays above the main banner title on the storefront.</div>
        </div>
      </div>
    </div>

    <!-- Card 2: Banner Schedule -->
    <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-calendar-event-fill me-2 text-info"></i>Banner Schedule
        </h6>
      </div>
      <div class="card-body p-4">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="startDate" class="form-label fw-semibold text-secondary small">START DATE</label>
            <input type="date" name="start_date" id="startDate" class="form-control bg-light text-dark" value="<?= set_value('start_date', $banner ? $banner->start_date : '') ?>">
            <span class="text-muted small d-block mt-1">Leave empty for no start date restriction</span>
          </div>
          <div class="col-md-6">
            <label for="endDate" class="form-label fw-semibold text-secondary small">END DATE</label>
            <input type="date" name="end_date" id="endDate" class="form-control bg-light text-dark" value="<?= set_value('end_date', $banner ? $banner->end_date : '') ?>">
            <span class="text-muted small d-block mt-1">Leave empty for no expiry</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Column: Banner Image & Settings -->
  <div class="col-lg-4">
    <!-- Card 3: Banner Image -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-image-fill me-2" style="color: var(--srl-pink);"></i>Banner Image <span class="text-danger">*</span>
        </h6>
        <span class="badge bg-light text-dark border">Max 5MB</span>
      </div>
      <div class="card-body p-4">
        <?php
          $current_img_src = '';
          if ($banner && !empty($banner->image)) {
            if (file_exists('./uploads/banners/' . $banner->image)) {
              $current_img_src = base_url('uploads/banners/' . $banner->image);
            } elseif (file_exists('./assets/images/' . $banner->image)) {
              $current_img_src = base_url('assets/images/' . $banner->image);
            }
          }
        ?>

        <!-- Live Preview Container -->
        <div id="bannerPreviewBox" class="rounded-4 border overflow-hidden position-relative mx-auto mb-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 100%; height: 160px; background: #0c0f17;">
          <?php if (!empty($current_img_src)): ?>
            <img id="bannerImgElement" src="<?= $current_img_src ?>" alt="Banner Preview" class="w-100 h-100 object-fit-cover">
            <span id="bannerImgBadge" class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white border border-secondary shadow-sm">
              <i class="bi bi-check-circle me-1 text-success"></i>Current Image
            </span>
          <?php else: ?>
            <img id="bannerImgElement" src="" alt="Preview" class="w-100 h-100 object-fit-cover" style="display: none;">
            <div id="bannerPlaceholder" class="text-center p-3">
              <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px; background: rgba(255, 42, 133, 0.12); color: var(--srl-pink);">
                <i class="bi bi-cloud-arrow-up fs-3"></i>
              </div>
              <p class="text-white-50 small mb-0">No image selected</p>
              <span class="text-muted" style="font-size: 0.72rem;">Optimal: 1920 x 700 px</span>
            </div>
            <span id="bannerImgBadge" class="position-absolute top-0 start-0 m-2 badge bg-success shadow-sm" style="display: none;">
              <i class="bi bi-sparkles me-1"></i>New Selection
            </span>
          <?php endif; ?>
        </div>

        <div class="mb-2">
          <label for="bannerImageInput" class="form-label fw-semibold text-secondary small">SELECT IMAGE FILE</label>
          <input type="file" name="image" id="bannerImageInput" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp, image/gif" <?= !$is_edit ? 'required' : '' ?>>
        </div>
        <p class="text-muted small mb-0" style="font-size: 0.78rem;">
          Allowed: JPG, JPEG, PNG, WEBP (Max: 5MB). High-resolution horizontal landscape images look best.
        </p>
      </div>
    </div>

    <!-- Card 4: Banner Settings -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom py-3 px-4">
        <h6 class="fw-bold text-dark mb-0">
          <i class="bi bi-sliders me-2 text-secondary"></i>Banner Settings
        </h6>
      </div>
      <div class="card-body p-4">
        <!-- Banner Type -->
        <div class="mb-3">
          <label for="bannerType" class="form-label fw-semibold text-secondary small">BANNER TYPE</label>
          <select name="banner_type" id="bannerType" class="form-select bg-light text-dark">
            <option value="home" <?= (!$banner || $banner->banner_type == 'home') ? 'selected' : '' ?>>Home (Main Top Carousel)</option>
          </select>
        </div>

        <!-- Display Order -->
        <div class="mb-4">
          <label for="displayOrder" class="form-label fw-semibold text-secondary small">DISPLAY ORDER</label>
          <input type="number" name="display_order" id="displayOrder" class="form-control bg-light text-dark" value="<?= set_value('display_order', $banner ? (int)$banner->display_order : 0) ?>" min="0">
          <span class="text-muted small d-block mt-1">Lower number appears first in the slider</span>
        </div>

        <!-- Status Toggle -->
        <div class="p-3 rounded-3 border bg-light">
          <div class="form-check form-switch p-0 d-flex align-items-center justify-content-between">
            <div>
              <label class="form-check-label fw-bold text-dark d-block mb-1" for="statusSwitch">
                STATUS
              </label>
              <p class="text-muted small mb-0" id="statusDescText">
                <?= (!$banner || $banner->status == 1) ? 'Active (Visible on homepage)' : 'Inactive (Hidden)' ?>
              </p>
            </div>
            <input class="form-check-input ms-0" type="checkbox" role="switch" name="status" id="statusSwitch" value="1" <?= (!$banner || $banner->status == 1) ? 'checked' : '' ?> style="width: 2.6em; height: 1.3em; cursor: pointer;">
          </div>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="d-grid gap-2">
      <button type="submit" class="btn-srl-primary py-3 rounded-pill fw-bold fs-6 shadow">
        <i class="bi bi-check2-circle me-2"></i><?= $is_edit ? 'Update Banner' : 'Save Banner' ?>
      </button>
      <a href="<?= base_url('admin/home_banners') ?>" class="btn btn-light border py-2 rounded-pill text-secondary fw-semibold">
        Cancel
      </a>
    </div>
  </div>
</div>
<?= form_close() ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const imageInput   = document.getElementById('bannerImageInput');
  const previewImg   = document.getElementById('bannerImgElement');
  const placeholder  = document.getElementById('bannerPlaceholder');
  const imgBadge     = document.getElementById('bannerImgBadge');
  const statusSwitch = document.getElementById('statusSwitch');
  const statusDesc   = document.getElementById('statusDescText');

  // File Preview Handler
  if (imageInput) {
    imageInput.addEventListener('change', function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
          previewImg.style.display = 'block';
          if (placeholder) placeholder.style.display = 'none';
          if (imgBadge) {
            imgBadge.className = 'position-absolute top-0 start-0 m-2 badge bg-success shadow-sm';
            imgBadge.innerHTML = '<i class="bi bi-sparkles me-1"></i>New Selection';
            imgBadge.style.display = 'inline-block';
          }
        };
        reader.readAsDataURL(file);
      }
    });
  }

  // Status Switch Text Handler
  if (statusSwitch && statusDesc) {
    statusSwitch.addEventListener('change', function () {
      statusDesc.innerText = this.checked
        ? 'Active (Visible on homepage)'
        : 'Inactive (Hidden)';
    });
  }
});
</script>
