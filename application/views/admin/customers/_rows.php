<?php if (!empty($customers)): ?>
  <?php foreach ($customers as $index => $cust): ?>
    <?php
      $first_letter = strtoupper(substr($cust->name ?? 'U', 0, 1));
    ?>
    <tr>
      <td class="ps-3 ps-sm-4 text-muted small d-none d-sm-table-cell"><?= (isset($offset) ? $offset : 0) + $index + 1 ?></td>
      <td>
        <div class="d-flex align-items-center gap-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 40px; height: 40px; background: linear-gradient(135deg, #ff2a85 0%, #1e1526 100%); font-size: 1rem; flex-shrink: 0;">
            <?= $first_letter ?>
          </div>
          <div>
            <span class="fw-bold text-dark d-block"><?= html_escape($cust->name) ?></span>
            <small class="text-muted d-block"><?= html_escape($cust->email) ?></small>
          </div>
        </div>
      </td>
      <td>
        <?= !empty($cust->phone) ? '<span class="small text-dark"><i class="bi bi-telephone text-muted me-1"></i>' . html_escape($cust->phone) . '</span>' : '<span class="text-secondary opacity-50 small">Not specified</span>' ?>
      </td>
      <td class="d-none d-lg-table-cell">
        <span class="small text-muted" style="max-width: 240px; display: inline-block;">
          <?= !empty($cust->address) ? html_escape(character_limiter($cust->address, 45)) : '<span class="text-secondary opacity-50">No address recorded</span>' ?>
        </span>
      </td>
      <td>
        <a href="<?= base_url('admin/customers/status/' . $cust->id) ?>" class="text-decoration-none" title="Click to toggle status">
          <?php if ($cust->status == 1): ?>
            <span class="badge bg-success rounded-pill px-3 py-1"><i class="bi bi-check-circle me-1"></i>Active</span>
          <?php else: ?>
            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-1 border border-danger-subtle"><i class="bi bi-slash-circle me-1"></i>Inactive</span>
          <?php endif; ?>
        </a>
      </td>
      <td class="text-muted small d-none d-md-table-cell">
        <?= date('d M Y', strtotime($cust->created_at)) ?>
      </td>
      <td class="text-end pe-3 pe-sm-4">
        <div class="d-inline-flex gap-1">
          <button type="button" class="btn btn-sm btn-outline-info rounded-3 px-2 py-1 btn-view-customer" 
                  data-name="<?= html_escape($cust->name) ?>" 
                  data-email="<?= html_escape($cust->email) ?>" 
                  data-phone="<?= html_escape($cust->phone) ?>" 
                  data-address="<?= html_escape($cust->address) ?>" 
                  data-joined="<?= date('F j, Y', strtotime($cust->created_at)) ?>"
                  title="View Profile Details">
            <i class="bi bi-eye"></i>
          </button>
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
