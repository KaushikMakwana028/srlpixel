<?php if (!empty($categories)): ?>
  <?php foreach ($categories as $index => $cat): ?>
    <tr>
      <td class="ps-3 ps-sm-4 text-muted small d-none d-sm-table-cell"><?= (isset($offset) ? $offset : 0) + $index + 1 ?></td>
      <td>
        <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center bg-light border shadow-sm" style="width: 50px; height: 50px; min-width: 50px;">
          <?php if (!empty($cat->image) && file_exists('./uploads/categories/' . $cat->image)): ?>
            <img src="<?= base_url('uploads/categories/' . $cat->image) ?>" alt="<?= html_escape($cat->name) ?>" class="w-100 h-100 object-fit-cover">
          <?php else: ?>
            <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(255, 42, 133, 0.08); color: var(--srl-pink);">
              <i class="bi bi-tag-fill fs-5"></i>
            </div>
          <?php endif; ?>
        </div>
      </td>
      <td>
        <span class="fw-bold text-dark d-block"><?= html_escape($cat->name) ?></span>
      </td>
      <td class="text-muted small d-none d-lg-table-cell" style="max-width: 260px;">
        <?= !empty($cat->description) ? html_escape(character_limiter($cat->description, 60)) : '<span class="text-secondary opacity-50">No description</span>' ?>
      </td>
      <td>
        <a href="<?= base_url('admin/categories/status/' . $cat->id) ?>" class="text-decoration-none" title="Click to toggle status">
          <?php if ($cat->status == 1): ?>
            <span class="badge bg-success rounded-pill px-3 py-1"><i class="bi bi-check-circle me-1"></i>Active</span>
          <?php else: ?>
            <span class="badge bg-secondary rounded-pill px-3 py-1"><i class="bi bi-x-circle me-1"></i>Inactive</span>
          <?php endif; ?>
        </a>
      </td>
      <td class="text-muted small d-none d-md-table-cell">
        <?= date('d M Y', strtotime($cat->created_at)) ?>
      </td>
      <td class="text-end pe-3 pe-sm-4">
        <div class="d-inline-flex gap-1">
          <a href="<?= base_url('admin/categories/edit/' . $cat->id) ?>" class="btn btn-sm btn-outline-primary rounded-3 px-2 py-1" title="Edit">
            <i class="bi bi-pencil-square"></i>
          </a>
          <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1 btn-delete-category" data-id="<?= $cat->id ?>" data-name="<?= html_escape($cat->name) ?>" title="Delete">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
    <td colspan="7" class="text-center py-5 text-muted">
      <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
      No categories found matching your criteria.
    </td>
  </tr>
<?php endif; ?>
