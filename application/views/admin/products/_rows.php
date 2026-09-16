<?php if (!empty($products)): ?>
  <?php foreach ($products as $index => $prod): ?>
    <tr>
      <td class="ps-3 ps-sm-4 text-muted small d-none d-sm-table-cell"><?= (isset($offset) ? $offset : 0) + $index + 1 ?></td>
      <td>
        <div class="position-relative d-inline-block">
          <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center bg-light border" style="width: 48px; height: 48px;">
            <?php if (!empty($prod->image) && file_exists('./uploads/products/' . $prod->image)): ?>
              <img src="<?= base_url('uploads/products/' . $prod->image) ?>" alt="<?= html_escape($prod->name) ?>" class="w-100 h-100 object-fit-cover">
            <?php else: ?>
              <i class="bi bi-image text-muted fs-4"></i>
            <?php endif; ?>
          </div>
          <?php if (!empty($gallery_counts[$prod->id])): ?>
            <span class="position-absolute bottom-0 end-0 badge rounded-pill shadow-sm text-white" style="background: var(--srl-pink); font-size: 0.6rem; transform: translate(25%, 25%); padding: 2px 5px;" title="<?= $gallery_counts[$prod->id] ?> gallery photos">
              +<?= $gallery_counts[$prod->id] ?>
            </span>
          <?php endif; ?>
        </div>
      </td>
      <td>
        <span class="fw-bold text-dark d-block"><?= html_escape($prod->name) ?></span>
        <?php if (!empty($prod->sku)): ?>
          <span class="badge bg-light text-secondary border small">SKU: <?= html_escape($prod->sku) ?></span>
        <?php endif; ?>
      </td>
      <td class="d-none d-md-table-cell">
        <span class="badge bg-secondary-subtle text-dark border">
          <?= isset($category_map[$prod->category_id]) ? html_escape($category_map[$prod->category_id]) : 'Unassigned' ?>
        </span>
      </td>
      <td>
        <div>
          <span class="fw-bold text-dark">₹<?= number_format($prod->price, 2) ?></span>
          <?php if (!empty($prod->discount_price) && $prod->discount_price < $prod->price): ?>
            <small class="text-danger d-block">Sale: ₹<?= number_format($prod->discount_price, 2) ?></small>
          <?php endif; ?>
        </div>
      </td>
      <td>
        <?php if ($prod->stock > 20): ?>
          <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><?= $prod->stock ?> in stock</span>
        <?php elseif ($prod->stock > 0): ?>
          <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1"><?= $prod->stock ?> low stock</span>
        <?php else: ?>
          <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Out of stock</span>
        <?php endif; ?>
      </td>
      <td>
        <a href="<?= base_url('admin/products/status/' . $prod->id) ?>" class="text-decoration-none" title="Click to toggle status">
          <?php if ($prod->status == 1): ?>
            <span class="badge bg-success rounded-pill px-3 py-1"><i class="bi bi-check-circle me-1"></i>Active</span>
          <?php else: ?>
            <span class="badge bg-secondary rounded-pill px-3 py-1"><i class="bi bi-x-circle me-1"></i>Inactive</span>
          <?php endif; ?>
        </a>
      </td>
      <td class="text-end pe-3 pe-sm-4">
        <div class="d-inline-flex gap-1">
          <a href="<?= base_url('admin/products/edit/' . $prod->id) ?>" class="btn btn-sm btn-outline-primary rounded-3 px-2 py-1" title="Edit">
            <i class="bi bi-pencil-square"></i>
          </a>
          <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1 btn-delete-product" data-id="<?= $prod->id ?>" data-name="<?= html_escape($prod->name) ?>" title="Delete">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
    <td colspan="8" class="text-center py-5 text-muted">
      <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary"></i>
      No products found matching your search or filters.
    </td>
  </tr>
<?php endif; ?>
