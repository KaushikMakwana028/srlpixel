<?php
$is_standalone = isset($auth_layout) && $auth_layout;
?>

<div class="<?= $is_standalone ? 'auth-card auth-card-wide' : 'card border-0 shadow-sm rounded-4' ?>" style="<?= !$is_standalone ? 'background: #ffffff; padding: 30px; border: 1px solid var(--srl-border) !important;' : '' ?>">
  <div class="<?= $is_standalone ? 'auth-logo-header' : 'mb-4 pb-3 border-bottom' ?>">
    <?php if ($is_standalone): ?>
      <a href="<?= base_url('admin/login') ?>">
        <img src="<?= base_url('assets/images/new_logo.png') ?>" alt="SRL Pixel Logo" onerror="this.onerror=null; this.src='<?= base_url('assets/images/logo.png') ?>';">
      </a>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h4 class="<?= $is_standalone ? 'auth-title' : 'fw-bold text-dark mb-1' ?>">
          <i class="bi bi-shield-lock-fill text-danger me-2" style="color: var(--srl-pink) !important;"></i>Admin Registration
        </h4>
        <p class="<?= $is_standalone ? 'auth-subtitle' : 'text-muted small mb-0' ?>">
          Create and authorize a new administrator account (Role = 1)
        </p>
      </div>
      <?php if (!$is_standalone): ?>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
          <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- SweetAlert2 delivers notifications dynamically -->

  <?= form_open('admin/register') ?>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="adminName" class="<?= $is_standalone ? 'auth-form-label' : 'form-label fw-semibold small text-secondary' ?>">Full Name</label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-person input-icon"></i>
          <input type="text" name="name" id="adminName" class="form-control <?= !$is_standalone ? 'bg-light border-light-subtle text-dark' : '' ?>" placeholder="e.g. Ravi Makwana" value="<?= set_value('name') ?>" required>
        </div>
      </div>

      <div class="col-md-6">
        <label for="adminEmail" class="<?= $is_standalone ? 'auth-form-label' : 'form-label fw-semibold small text-secondary' ?>">Email Address</label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-envelope input-icon"></i>
          <input type="email" name="email" id="adminEmail" class="form-control <?= !$is_standalone ? 'bg-light border-light-subtle text-dark' : '' ?>" placeholder="admin@srlpixel.com" value="<?= set_value('email') ?>" required>
        </div>
      </div>

      <div class="col-md-6">
        <label for="adminPhone" class="<?= $is_standalone ? 'auth-form-label' : 'form-label fw-semibold small text-secondary' ?>">Phone Number</label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-telephone input-icon"></i>
          <input type="text" name="phone" id="adminPhone" class="form-control <?= !$is_standalone ? 'bg-light border-light-subtle text-dark' : '' ?>" placeholder="e.g. 9876543210" value="<?= set_value('phone') ?>">
        </div>
      </div>

      <div class="col-md-6">
        <label for="adminPassword" class="<?= $is_standalone ? 'auth-form-label' : 'form-label fw-semibold small text-secondary' ?>">Password</label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-lock input-icon"></i>
          <input type="password" name="password" id="adminPassword" class="form-control <?= !$is_standalone ? 'bg-light border-light-subtle text-dark' : '' ?>" placeholder="••••••••" required>
          <button type="button" class="password-toggle" data-target="adminPassword" aria-label="Toggle password visibility">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>

      <div class="col-12">
        <label for="adminAddress" class="<?= $is_standalone ? 'auth-form-label' : 'form-label fw-semibold small text-secondary' ?>">Office / Hub Address</label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-geo-alt input-icon" style="top: 24px;"></i>
          <textarea name="address" id="adminAddress" rows="2" class="form-control <?= !$is_standalone ? 'bg-light border-light-subtle text-dark' : '' ?>" placeholder="Street, City, State"><?= set_value('address') ?></textarea>
        </div>
      </div>

      <div class="col-12">
        <div class="p-3 rounded-3 <?= $is_standalone ? 'bg-dark' : 'bg-light' ?> border d-flex align-items-center justify-content-between">
          <div>
            <span class="badge bg-danger me-2" style="background: var(--srl-pink-gradient) !important;">Role: Admin (1)</span>
            <span class="<?= $is_standalone ? 'text-muted' : 'text-secondary' ?> small">Created user will have elevated administrative privileges</span>
          </div>
          <span class="badge bg-success">Status: Active</span>
        </div>
      </div>

      <div class="col-12 mt-4">
        <button type="submit" class="auth-btn-submit">
          <i class="bi bi-shield-check me-2"></i>Create Administrator Account
        </button>
      </div>
    </div>
  <?= form_close() ?>

  <div class="<?= $is_standalone ? 'auth-footer-text' : 'text-center mt-4 small text-muted' ?>">
    Already registered an admin? <a href="<?= base_url('admin/login') ?>" class="fw-semibold" style="color: var(--srl-pink-glow);">Sign in to Admin</a>
  </div>
</div>
