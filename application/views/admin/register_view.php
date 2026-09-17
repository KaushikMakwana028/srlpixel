<?php
$is_standalone = isset($auth_layout) && $auth_layout;
?>

<style>
/* ============================================================
   ADMIN REGISTER VIEW STYLES
   ============================================================ */

.auth-card {
  width: 100%;
  max-width: 460px;
  background: rgba(18, 22, 33, 0.88);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border-radius: 24px;
  border: 1px solid rgba(255, 42, 133, 0.22);
  box-shadow: 0 24px 60px rgba(0, 0, 0, 0.55), 0 0 40px rgba(255, 42, 133, 0.08);
  padding: 38px 34px;
  color: #ffffff;
  position: relative;
  overflow: hidden;
}

.auth-card.auth-card-wide {
  max-width: 620px;
}

.auth-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 12%;
  right: 12%;
  height: 2px;
  background: linear-gradient(90deg, transparent, var(--srl-pink), var(--srl-pink-glow), transparent);
}

.auth-logo-header {
  text-align: center;
  margin-bottom: 26px;
}

.auth-logo-header img {
  max-height: 52px;
  width: auto;
  margin-bottom: 14px;
  filter: drop-shadow(0 2px 12px rgba(255, 42, 133, 0.25));
  transition: transform 0.3s ease;
}

.auth-title {
  font-size: 1.5rem;
  font-weight: 800;
  color: #ffffff;
  margin: 0 0 6px;
  letter-spacing: -0.3px;
}

.auth-subtitle {
  font-size: 0.88rem;
  color: #94a3b8;
  margin: 0;
  line-height: 1.45;
}

.auth-form-label {
  font-size: 0.88rem !important;
  font-weight: 600 !important;
  color: #e2e8f0 !important;
  margin-bottom: 7px !important;
  display: block;
}

.auth-input-group {
  position: relative;
  margin-bottom: 18px;
}

.auth-input-group .input-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 1.05rem;
  pointer-events: none;
  transition: color 0.2s ease;
}

.auth-input-group .form-control {
  background-color: rgba(18, 22, 34, 0.85) !important;
  border: 1.5px solid rgba(255, 255, 255, 0.15) !important;
  color: #ffffff !important;
  padding: 12px 14px 12px 42px;
  border-radius: 12px;
  font-size: 0.92rem;
  transition: all 0.22s ease;
}

.auth-input-group .form-control:focus {
  background-color: rgba(15, 19, 32, 0.98) !important;
  border-color: var(--srl-pink) !important;
  box-shadow: 0 0 0 3px rgba(255, 42, 133, 0.25), 0 0 16px rgba(255, 42, 133, 0.15);
  color: #ffffff !important;
}

.auth-input-group:focus-within .input-icon {
  color: var(--srl-pink-glow);
}

.auth-input-group .form-control::placeholder {
  color: #94a3b8 !important;
  opacity: 1 !important;
}

.auth-input-group .password-toggle {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  cursor: pointer;
  background: transparent;
  border: none;
  padding: 4px 8px;
  font-size: 1rem;
  transition: color 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.auth-input-group .password-toggle:hover {
  color: var(--srl-pink-glow);
}

.auth-btn-submit {
  width: 100%;
  padding: 13px;
  border-radius: 12px;
  background: var(--srl-pink-gradient);
  border: none;
  color: #ffffff;
  font-size: 1rem;
  font-weight: 700;
  letter-spacing: 0.2px;
  box-shadow: 0 4px 20px rgba(255, 42, 133, 0.38);
  transition: all 0.25s ease;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.auth-btn-submit:hover {
  box-shadow: 0 8px 30px rgba(255, 42, 133, 0.55);
  transform: translateY(-2px);
  color: #ffffff;
}

.auth-footer-text {
  text-align: center;
  font-size: 0.88rem;
  color: #94a3b8;
  margin-top: 22px;
}
</style>

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
