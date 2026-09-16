<div class="auth-card">
  <div class="auth-logo-header">
    <a href="<?= base_url('admin/login') ?>">
      <img src="<?= base_url('assets/images/new_logo.png') ?>" alt="SRL Pixel Logo" onerror="this.onerror=null; this.src='<?= base_url('assets/images/logo.png') ?>';">
    </a>
    <h4 class="auth-title">Admin Sign In</h4>
    <p class="auth-subtitle">Access your enterprise administrative portal</p>
  </div>

  <!-- SweetAlert2 delivers notifications dynamically -->

  <?= form_open('admin/login') ?>
    <div class="mb-3">
      <label for="adminEmail" class="auth-form-label">Email Address</label>
      <div class="auth-input-group">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" name="email" id="adminEmail" class="form-control" placeholder="admin@srlpixel.com" value="<?= set_value('email') ?>" required autofocus>
      </div>
    </div>

    <div class="mb-3">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <label for="adminPassword" class="auth-form-label mb-0">Password</label>
      </div>
      <div class="auth-input-group">
        <i class="bi bi-lock input-icon"></i>
        <input type="password" name="password" id="adminPassword" class="form-control" placeholder="••••••••" required>
        <button type="button" class="password-toggle" data-target="adminPassword" aria-label="Toggle password visibility">
          <i class="bi bi-eye"></i>
        </button>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" style="background-color: #12151e; border-color: #2d3345;">
        <label class="form-check-label text-muted" for="rememberMe" style="font-size: 0.85rem;">
          Remember this session
        </label>
      </div>
      <a href="#" class="text-decoration-none" style="color: var(--srl-pink-glow); font-size: 0.85rem;">Forgot Password?</a>
    </div>

    <button type="submit" class="auth-btn-submit">
      <i class="bi bi-box-arrow-in-right me-2"></i>Sign In to Admin
    </button>
  <?= form_close() ?>

  <div class="auth-footer-text">
    Need to register an administrator account? <a href="<?= base_url('admin/register') ?>">Create Admin Account</a>
  </div>
  <div class="auth-footer-text mt-2">
    <a href="<?= base_url('login') ?>" class="text-secondary" style="font-size: 0.82rem;"><i class="bi bi-arrow-left me-1"></i>Go to Customer Portal</a>
  </div>
</div>
