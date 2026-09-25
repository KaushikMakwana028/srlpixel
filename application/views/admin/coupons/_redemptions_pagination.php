<?php if ($total_pages > 1): ?>
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 px-3 px-sm-4 py-3 border-top bg-light-subtle">
    <div class="small text-muted">
      Showing <span class="fw-bold text-dark"><?= min($offset + 1, $total_records) ?></span> to <span class="fw-bold text-dark"><?= min($offset + $limit, $total_records) ?></span> of <span class="fw-bold text-dark"><?= $total_records ?></span> redemptions
    </div>

    <nav aria-label="Redemptions pagination">
      <ul class="pagination pagination-sm mb-0 gap-1">
        <!-- Previous -->
        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
          <a class="page-link rounded-3 px-2.5 py-1 text-decoration-none ajax-page-link" href="#" data-page="<?= max(1, $page - 1) ?>" aria-label="Previous">
            <i class="bi bi-chevron-left"></i>
          </a>
        </li>

        <?php for ($p = 1; $p <= $total_pages; $p++): ?>
          <?php if ($p == 1 || $p == $total_pages || ($p >= $page - 1 && $p <= $page + 1)): ?>
            <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
              <a class="page-link rounded-3 px-3 py-1 text-decoration-none ajax-page-link <?= ($p == $page) ? 'fw-bold' : '' ?>" href="#" data-page="<?= $p ?>">
                <?= $p ?>
              </a>
            </li>
          <?php elseif ($p == $page - 2 || $p == $page + 2): ?>
            <li class="page-item disabled"><span class="page-link rounded-3 px-2 py-1">&hellip;</span></li>
          <?php endif; ?>
        <?php endfor; ?>

        <!-- Next -->
        <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
          <a class="page-link rounded-3 px-2.5 py-1 text-decoration-none ajax-page-link" href="#" data-page="<?= min($total_pages, $page + 1) ?>" aria-label="Next">
            <i class="bi bi-chevron-right"></i>
          </a>
        </li>
      </ul>
    </nav>
  </div>
<?php elseif ($total_records > 0): ?>
  <div class="px-3 px-sm-4 py-2.5 border-top bg-light-subtle d-flex justify-content-between align-items-center">
    <small class="text-muted">Total <span class="fw-bold text-dark"><?= $total_records ?></span> redemptions logged</small>
    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5" style="font-size: 0.7rem;"><i class="bi bi-check2 me-1"></i>All shown</span>
  </div>
<?php endif; ?>
