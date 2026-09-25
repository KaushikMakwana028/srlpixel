<?php if (!empty($customers)): ?>
  <?php foreach ($customers as $index => $cust): ?>
    <?php
      $first_letter = strtoupper(substr($cust->name ?? 'U', 0, 1));
    ?>
    <tr>
      <td class="ps-3 ps-sm-4 text-muted small d-none d-sm-table-cell"><?= (isset($offset) ? $offset : 0) + $index + 1 ?></td>
      <td>
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm overflow-hidden" style="width: 42px; height: 42px; background: linear-gradient(135deg, #ff2a85 0%, #1e1526 100%); font-size: 1rem; flex-shrink: 0; border: 2px solid #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;">
            <?php if (!empty($cust->profile_image) && file_exists('./uploads/profiles/' . $cust->profile_image)): ?>
              <img src="<?= base_url('uploads/profiles/' . $cust->profile_image) ?>" alt="<?= html_escape($cust->name) ?>" style="width: 100%; height: 100%; object-fit: cover;">
            <?php else: ?>
              <?= $first_letter ?>
            <?php endif; ?>
          </div>
          <div>
            <a href="<?= base_url('admin/customers/view/' . $cust->id) ?>" class="fw-bold text-dark text-decoration-none text-hover-pink d-block">
              <?= html_escape($cust->name) ?>
            </a>
            <small class="text-muted d-block"><?= html_escape($cust->email) ?></small>
          </div>
        </div>
      </td>
      <td>
        <?= !empty($cust->phone) ? '<span class="small text-dark"><i class="bi bi-telephone text-muted me-1"></i>' . html_escape($cust->phone) . '</span>' : '<span class="text-secondary opacity-50 small">Not specified</span>' ?>
      </td>
      <td class="d-none d-lg-table-cell">
        <?php if (!empty($cust->address)): ?>
          <span class="small text-dark d-inline-flex align-items-center gap-1" style="max-width: 280px;" title="<?= html_escape($cust->address) ?>">
            <i class="bi bi-geo-alt-fill text-danger flex-shrink-0" style="font-size: 0.8rem;"></i>
            <span class="text-truncate"><?= html_escape($cust->address) ?></span>
          </span>
        <?php else: ?>
          <span class="text-secondary opacity-50 small">No address recorded</span>
        <?php endif; ?>
      </td>
      <td>
        <a href="<?= base_url('admin/customers/status/' . $cust->id) ?>" class="text-decoration-none" title="Click to toggle status" onclick="return confirm('Change status for <?= html_escape(addslashes($cust->name)) ?>?');">
          <?php if ($cust->status == 1): ?>
            <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1.5 fw-semibold border border-success-subtle d-inline-flex align-items-center gap-1">
              <i class="bi bi-check-circle-fill"></i>Active
            </span>
          <?php else: ?>
            <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1.5 fw-semibold border border-danger-subtle d-inline-flex align-items-center gap-1">
              <i class="bi bi-slash-circle-fill"></i>Inactive
            </span>
          <?php endif; ?>
        </a>
      </td>
      <td class="text-muted small d-none d-md-table-cell">
        <?= date('d M Y', strtotime($cust->created_at)) ?>
      </td>
      <td class="text-end pe-3 pe-sm-4">
        <div class="d-inline-flex gap-1">
          <a href="<?= base_url('admin/customers/view/' . $cust->id) ?>" class="btn btn-sm btn-outline-info rounded-3 px-2 py-1" title="View Customer Profile & Orders">
            <i class="bi bi-eye"></i>
          </a>
          <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1 btn-delete-customer" 
                  data-id="<?= $cust->id ?>" 
                  data-name="<?= html_escape($cust->name) ?>" 
                  title="Delete Customer">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
    <td colspan="7" class="text-center py-5 text-muted">
      <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
      No customer accounts found matching your search or filters.
    </td>
  </tr>
<?php endif; ?>
