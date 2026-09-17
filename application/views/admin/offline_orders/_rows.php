<?php if (!empty($orders)): ?>
  <?php $i = $offset + 1; foreach ($orders as $ord): ?>
    <?php
      $status_class = 'status-badge-placed';
      $status_icon  = 'bi bi-receipt';

      switch ($ord->order_status) {
        case 'Awaiting Payment':
          $status_class = 'status-badge-awaiting-payment';
          $status_icon  = 'bi bi-clock-history';
          break;
        case 'Placed':
          $status_class = 'status-badge-placed';
          $status_icon  = 'bi bi-receipt';
          break;
        case 'Confirmed':
          $status_class = 'status-badge-confirmed';
          $status_icon  = 'bi bi-check-circle';
          break;
        case 'Packed':
          $status_class = 'status-badge-packed';
          $status_icon  = 'bi bi-box-seam';
          break;
        case 'Out for Delivery':
          $status_class = 'status-badge-out-for-delivery';
          $status_icon  = 'bi bi-truck';
          break;
        case 'Delivered':
          $status_class = 'status-badge-delivered';
          $status_icon  = 'bi bi-check-circle-fill';
          break;
        case 'Cancelled':
          $status_class = 'status-badge-cancelled';
          $status_icon  = 'bi bi-x-circle';
          break;
      }

      $is_paid = ($ord->payment_status === 'Paid');
    ?>
    <tr id="order-row-<?= $ord->id ?>">
      <td class="text-center text-muted small"><?= $i++ ?></td>
      <td>
        <div class="d-flex align-items-center gap-1 flex-wrap">
          <a href="<?= base_url('admin/offline_orders/detail/' . $ord->id) ?>" class="fw-bold text-dark text-decoration-none">
            #<?= html_escape($ord->order_number) ?>
          </a>
          <span class="badge rounded-pill" style="background: rgba(225, 29, 116, 0.1); color: var(--srl-pink); font-size: 0.65rem; font-weight: 700;">
            <i class="bi bi-shop me-1"></i>OFFLINE
          </span>
        </div>
      </td>
      <td>
        <div class="fw-semibold text-dark"><?= html_escape($ord->shipping_full_name) ?></div>
        <div class="text-muted small"><i class="bi bi-telephone me-1"></i><?= html_escape($ord->shipping_mobile) ?></div>
      </td>
      <td>
        <span class="text-secondary small"><?= html_escape($ord->shipping_city) ?>, <?= html_escape($ord->shipping_state) ?></span>
      </td>
      <td>
        <span class="fw-bold text-dark fs-6">₹<?= number_format($ord->total_amount, 2) ?></span>
      </td>
      <td>
        <div class="d-flex flex-column gap-1 align-items-start">
          <span class="badge bg-light text-dark border px-2 py-1 small" style="font-size: 0.72rem;">
            <?= html_escape($ord->payment_method) ?>
          </span>
          <!-- Interactive Payment Status Pill with One-Click Toggle -->
          <button type="button" 
                  class="btn btn-sm p-0 border-0 text-decoration-none payment-toggle-btn"
                  onclick="togglePaymentStatus(<?= $ord->id ?>, '<?= $is_paid ? 'Pending' : 'Paid' ?>')"
                  title="Click to change payment status to <?= $is_paid ? 'Pending' : 'Paid' ?>">
            <?php if ($is_paid): ?>
              <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 0.7rem; font-weight: 700; cursor: pointer;">
                <i class="bi bi-check-circle-fill me-1"></i>Paid <i class="bi bi-arrow-repeat ms-1 opacity-50"></i>
              </span>
            <?php else: ?>
              <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1" style="font-size: 0.7rem; font-weight: 700; cursor: pointer;">
                <i class="bi bi-clock-history me-1"></i>Pending <i class="bi bi-arrow-repeat ms-1 opacity-50"></i>
              </span>
            <?php endif; ?>
          </button>
        </div>
      </td>
      <td>
        <span class="order-status-badge <?= $status_class ?>">
          <i class="<?= $status_icon ?>"></i> <?= html_escape($ord->order_status) ?>
        </span>
      </td>
      <td class="text-muted small text-nowrap">
        <?= date('d M Y, h:i A', strtotime($ord->created_at)) ?>
      </td>
      <td class="text-end text-nowrap">
        <div class="d-inline-flex align-items-center gap-1">
          <!-- View Details -->
          <a href="<?= base_url('admin/offline_orders/detail/' . $ord->id) ?>" class="btn-table-action btn-action-view" title="View Details">
            <i class="bi bi-eye"></i>
          </a>
          <!-- Edit Offline Order -->
          <a href="<?= base_url('admin/offline_orders/edit/' . $ord->id) ?>" class="btn-table-action btn-action-edit" title="Edit Order">
            <i class="bi bi-pencil"></i>
          </a>
          <!-- Print / Download Invoice -->
          <a href="<?= base_url('admin/offline_orders/invoice/' . $ord->id) ?>" target="_blank" class="btn-table-action btn-action-print" title="Print Invoice">
            <i class="bi bi-printer"></i>
          </a>
          <!-- Delete Offline Order -->
          <button type="button" class="btn-table-action btn-action-delete" onclick="deleteOfflineOrder(<?= $ord->id ?>, '<?= html_escape($ord->order_number) ?>')" title="Delete Order">
            <i class="bi bi-trash3"></i>
          </button>
        </div>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
    <td colspan="9" class="text-center py-5">
      <div class="py-4">
        <div class="rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3" style="width: 70px; height: 70px; background: rgba(225, 29, 116, 0.08); color: var(--srl-pink);">
          <i class="bi bi-shop fs-1"></i>
        </div>
        <h6 class="fw-bold text-dark mb-1">No Offline Orders Found</h6>
        <p class="text-muted small mb-3">No store counter sales or walk-in orders match your filter criteria.</p>
        <a href="<?= base_url('admin/offline_orders/create') ?>" class="btn btn-srl-primary rounded-pill px-4 py-2 fw-bold text-decoration-none">
          <i class="bi bi-plus-circle me-1"></i>Create First Offline Order
        </a>
      </div>
    </td>
  </tr>
<?php endif; ?>
