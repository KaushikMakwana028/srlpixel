<?php if (!empty($usages)): ?>
  <?php foreach ($usages as $idx => $u): ?>
    <?php
      $row_num = $offset + $idx + 1;
      $first_letter = strtoupper(substr($u->customer_name ?? 'U', 0, 1));
    ?>
    <tr>
      <td class="ps-3 ps-sm-4 text-muted fw-semibold" style="font-size: 0.82rem; width: 45px;"><?= $row_num ?></td>
      <td>
        <div class="d-flex align-items-center gap-2.5">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs overflow-hidden flex-shrink-0" style="width: 38px; height: 38px; background: linear-gradient(135deg, #ff2a85 0%, #1e1526 100%); font-size: 0.95rem;">
            <?php if (!empty($u->profile_image) && file_exists('./uploads/profiles/' . $u->profile_image)): ?>
              <img src="<?= base_url('uploads/profiles/' . $u->profile_image) ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
            <?php else: ?>
              <?= $first_letter ?>
            <?php endif; ?>
          </div>
          <div>
            <?php if (!empty($u->user_id)): ?>
              <a href="<?= base_url('admin/customers/view/' . $u->user_id) ?>" class="fw-bold text-dark text-decoration-none text-hover-pink d-block" style="font-size: 0.88rem;">
                <?= html_escape($u->customer_name ?? 'Registered Customer') ?>
              </a>
            <?php else: ?>
              <span class="fw-bold text-dark d-block" style="font-size: 0.88rem;"><?= html_escape($u->customer_name ?? 'Guest') ?></span>
            <?php endif; ?>
            <small class="text-muted d-block" style="font-size: 0.74rem;">
              <?= !empty($u->customer_phone) ? html_escape($u->customer_phone) : (!empty($u->customer_email) ? html_escape($u->customer_email) : 'No Contact Info') ?>
            </small>
          </div>
        </div>
      </td>
      <td>
        <?php if (!empty($u->order_id)): ?>
          <a href="<?= base_url('admin/orders/detail/' . $u->order_id) ?>" class="fw-bold text-decoration-none font-monospace small" style="color: var(--srl-pink);">
            #<?= html_escape($u->order_number ?? ('ORD-' . $u->order_id)) ?>
          </a>
        <?php else: ?>
          <span class="text-muted small">N/A</span>
        <?php endif; ?>
        <?php if (!empty($u->order_status)): ?>
          <?php
            $badge_bg = 'bg-light text-secondary border';
            if ($u->order_status == 'Delivered') $badge_bg = 'bg-success-subtle text-success border border-success-subtle';
            elseif ($u->order_status == 'Placed' || $u->order_status == 'Confirmed') $badge_bg = 'bg-primary-subtle text-primary border border-primary-subtle';
            elseif ($u->order_status == 'Cancelled') $badge_bg = 'bg-danger-subtle text-danger border border-danger-subtle';
          ?>
          <span class="badge <?= $badge_bg ?> d-block mt-1" style="font-size: 0.68rem; width: fit-content;">
            <?= html_escape($u->order_status) ?>
          </span>
        <?php endif; ?>
      </td>
      <td>
        <span class="fw-bold text-success" style="font-size: 0.9rem;">
          -₹<?= number_format($u->discount_amount, 2) ?>
        </span>
      </td>
      <td>
        <span class="fw-bold text-dark" style="font-size: 0.9rem;">
          ₹<?= number_format($u->order_total, 2) ?>
        </span>
      </td>
      <td class="pe-3 pe-sm-4 text-nowrap">
        <span class="text-dark d-block fw-semibold" style="font-size: 0.82rem;"><?= date('d M Y', strtotime($u->created_at)) ?></span>
        <small class="text-muted" style="font-size: 0.74rem;"><i class="bi bi-clock me-1"></i><?= date('h:i A', strtotime($u->created_at)) ?></small>
      </td>
    </tr>
  <?php endforeach; ?>
<?php else: ?>
  <tr>
    <td colspan="6" class="text-center py-5 text-muted">
      <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; background: rgba(255, 42, 133, 0.08); color: var(--srl-pink);">
        <i class="bi bi-inbox fs-3"></i>
      </div>
      <h6 class="fw-bold text-dark mb-1">No Redemptions Logged Yet</h6>
      <p class="small text-muted mb-0" style="max-width: 400px; margin: 0 auto;">
        When customers use <strong><?= html_escape($coupon->code) ?></strong> at checkout, their details and order savings will appear here in real-time.
      </p>
    </td>
  </tr>
<?php endif; ?>
