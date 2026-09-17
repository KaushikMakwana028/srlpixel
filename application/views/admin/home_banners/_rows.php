<?php if (!empty($banners)): ?>
  <?php $i = ($offset ?? 0) + 1; ?>
  <?php foreach ($banners as $banner): ?>
    <?php
      $is_expired = false;
      if (!empty($banner->end_date)) {
        $end_timestamp = strtotime($banner->end_date . ' 23:59:59');
        if ($end_timestamp < time()) {
          $is_expired = true;
        }
      }

      $img_url = base_url('assets/images/banner_1.png');
      if (!empty($banner->image)) {
        if (file_exists('./uploads/banners/' . $banner->image)) {
          $img_url = base_url('uploads/banners/' . $banner->image);
        } elseif (file_exists('./assets/images/' . $banner->image)) {
          $img_url = base_url('assets/images/' . $banner->image);
        }
      }
    ?>
    <tr id="bannerRow-<?= $banner->id ?>" class="align-middle">
      <!-- Row Number -->
      <td class="ps-3 ps-sm-4 text-muted fw-semibold" style="font-size: 0.88rem; width: 45px;">
        <?= $i++ ?>
      </td>

      <!-- Banner Thumbnail Image -->
      <td style="width: 120px;">
        <div class="rounded-3 overflow-hidden border shadow-sm position-relative" style="width: 110px; height: 58px; background: #0e121b;">
          <img src="<?= $img_url ?>" alt="<?= html_escape($banner->title) ?>" class="w-100 h-100 object-fit-cover">
        </div>
      </td>

      <!-- Banner Title, Subtitle, & CTA Link -->
      <td>
        <div class="d-flex flex-column">
          <span class="fw-bold text-dark fs-6 mb-1"><?= html_escape($banner->title) ?></span>
          <?php if (!empty($banner->subtitle)): ?>
            <span class="text-muted small mb-1 line-clamp-1" style="max-width: 380px;">
              <?= html_escape($banner->subtitle) ?>
            </span>
          <?php endif; ?>
          <?php if (!empty($banner->button_link)): ?>
            <span class="small" style="font-size: 0.78rem;">
              <i class="bi bi-link-45deg me-1" style="color: var(--srl-pink);"></i>
              <a href="<?= (strpos($banner->button_link, 'http') === 0) ? html_escape($banner->button_link) : base_url($banner->button_link) ?>" target="_blank" class="text-decoration-none fw-semibold" style="color: var(--srl-pink);">
                <?= !empty($banner->button_text) ? html_escape($banner->button_text) : 'Visit Link' ?>
              </a>
            </span>
          <?php endif; ?>
        </div>
      </td>

      <!-- Banner Type Badge -->
      <td>
        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
          <i class="bi bi-house-door-fill me-1"></i><?= strtoupper(html_escape($banner->banner_type ?: 'HOME')) ?>
        </span>
      </td>

      <!-- Display Order -->
      <td class="text-center">
        <span class="badge bg-light text-dark border px-2 py-1 fw-bold">
          <?= (int)$banner->display_order ?>
        </span>
      </td>

      <!-- Start Date -->
      <td>
        <span class="text-secondary small">
          <?= !empty($banner->start_date) ? date('d M Y', strtotime($banner->start_date)) : '<span class="text-muted">-</span>' ?>
        </span>
      </td>

      <!-- End Date -->
      <td>
        <span class="text-secondary small">
          <?= !empty($banner->end_date) ? date('d M Y', strtotime($banner->end_date)) : '<span class="text-muted">-</span>' ?>
        </span>
        <?php if ($is_expired): ?>
          <br>
          <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2" style="font-size: 0.68rem;">
            Expired
          </span>
        <?php endif; ?>
      </td>

      <!-- Status (Active / Inactive) -->
      <td>
        <button type="button" class="badge rounded-pill border-0 px-2 py-1 fw-bold btn-toggle-banner" data-id="<?= $banner->id ?>" style="cursor: pointer; font-size: 0.75rem; <?= $banner->status == 1 ? 'background-color: rgba(16, 185, 129, 0.15); color: #059669;' : 'background-color: rgba(100, 116, 139, 0.15); color: #475569;' ?>">
          <i class="bi <?= $banner->status == 1 ? 'bi-check-circle-fill me-1' : 'bi-x-circle-fill me-1' ?>"></i>
          <?= $banner->status == 1 ? 'Active' : 'Inactive' ?>
        </button>
      </td>

      <!-- Created Date -->
      <td class="d-none d-md-table-cell">
        <span class="text-secondary small d-block"><?= date('d M Y', strtotime($banner->created_at)) ?></span>
        <span class="text-muted" style="font-size: 0.72rem;"><?= date('h:i A', strtotime($banner->created_at)) ?></span>
      </td>

      <!-- Actions -->
      <td class="text-end pe-3 pe-sm-4">
        <div class="d-inline-flex gap-1">
          <a href="<?= base_url('admin/home_banners/edit/' . $banner->id) ?>" class="btn btn-sm btn-light border rounded-3 text-primary d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Edit Banner">
            <i class="bi bi-pencil-fill" style="font-size: 0.8rem;"></i>
          </a>
          <button type="button" class="btn btn-sm btn-light border rounded-3 text-secondary btn-toggle-banner d-inline-flex align-items-center justify-content-center" data-id="<?= $banner->id ?>" style="width: 32px; height: 32px;" title="Toggle Visibility">
            <i class="bi <?= $banner->status == 1 ? 'bi-eye-slash-fill' : 'bi-eye-fill text-success' ?>" style="font-size: 0.8rem;"></i>
          </button>
          <button type="button" class="btn btn-sm btn-light border rounded-3 text-danger btn-delete-banner d-inline-flex align-items-center justify-content-center" data-id="<?= $banner->id ?>" style="width: 32px; height: 32px;" title="Delete Banner">
            <i class="bi bi-trash-fill" style="font-size: 0.8rem;"></i>
          </button>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
    <td colspan="10" class="text-center py-5">
      <div class="py-4">
        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background: rgba(255, 42, 133, 0.1); color: var(--srl-pink);">
          <i class="bi bi-images fs-2"></i>
        </div>
        <h6 class="fw-bold text-dark mb-1">No Home Banners Found</h6>
        <p class="text-muted small mb-3">No banners match your active search or filter criteria.</p>
        <a href="<?= base_url('admin/home_banners/add') ?>" class="btn-srl-primary px-3 py-2 rounded-pill btn-sm d-inline-flex align-items-center">
          <i class="bi bi-plus-circle-fill me-2"></i>Add First Banner
        </a>
      </div>
    </td>
  </tr>
<?php endif; ?>
