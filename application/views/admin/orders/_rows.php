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
    ?>
    <tr>
      <td class="text-center text-muted small"><?= $i++ ?></td>
      <td>
        <a href="<?= base_url('admin/orders/detail/' . $ord->id) ?>" class="fw-bold text-dark text-decoration-none">
          #<?= html_escape($ord->order_number) ?>
        </a>
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
        <span class="badge bg-light text-dark border px-2 py-1 small"><?= html_escape($ord->payment_method) ?></span>
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
        <a href="<?= base_url('admin/orders/invoice/' . $ord->id) ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1 me-1" title="Print / Download Invoice">
          <i class="bi bi-printer"></i>
        </a>
        <a href="<?= base_url('admin/orders/detail/' . $ord->id) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1" title="View details & update status">
          <i class="bi bi-eye me-1"></i>Details
        </a>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
    <td colspan="9" class="text-center py-5">
      <div class="py-4">
        <i class="bi bi-inbox text-muted fs-1 d-block mb-2"></i>
        <h6 class="fw-bold text-dark mb-1">No Orders Found</h6>
        <p class="text-muted small mb-0">No customer orders match the current filter or search criteria.</p>
      </div>
    </td>
  </tr>
<?php endif; ?>
