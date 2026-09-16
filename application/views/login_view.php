<div class="auth-card">
  <div class="auth-logo-header">
    <a href="<?= base_url() ?>">
      <img src="<?= base_url('assets/images/new_logo.png') ?>" alt="SRL Pixel Logo" onerror="this.onerror=null; this.src='<?= base_url('assets/images/logo.png') ?>';">
    </a>
    <h4 class="auth-title">Customer Sign In</h4>
    <p class="auth-subtitle">Sign in to manage your orders & pixel projects</p>
  </div>

  <!-- SweetAlert2 delivers notifications dynamically -->

  <?= form_open('login') ?>
    <div class="mb-3">
      <label for="userEmail" class="auth-form-label">Email Address</label>
      <div class="auth-input-group">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" name="email" id="userEmail" class="form-control" placeholder="user@srlpixel.com" value="<?= set_value('email') ?>" required autofocus>
      </div>
    </div>

    <div class="mb-3">
      <div class="d-flex justify-content-between align-items-center mb-1">
        <label for="userPassword" class="auth-form-label mb-0">Password</label>
      </div>
      <div class="auth-input-group">
        <i class="bi bi-lock input-icon"></i>
        <input type="password" name="password" id="userPassword" class="form-control" placeholder="••••••••" required>
        <button type="button" class="password-toggle" data-target="userPassword" aria-label="Toggle password visibility">
          <i class="bi bi-eye"></i>
        </button>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="rememberUser" style="background-color: #12151e; border-color: #2d3345;">
        <label class="form-check-label text-muted" for="rememberUser" style="font-size: 0.85rem;">
          Remember me
        </label>
      </div>
      <a href="#" class="text-decoration-none" style="color: var(--srl-pink-glow); font-size: 0.85rem;">Forgot Password?</a>
    </div>

    <button type="submit" class="auth-btn-submit">
      <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
    </button>
  <?= form_close() ?>

  <div class="auth-footer-text">
    Don't have an account? <a href="<?= base_url('register') ?>">Create Account</a>
  </div>
  <div class="auth-footer-text mt-3 pt-3 border-top border-secondary" style="border-color: rgba(255,255,255,0.1) !important;">
    <a href="<?= base_url('admin/login') ?>" class="text-secondary" style="font-size: 0.82rem;">
      <i class="bi bi-shield-lock me-1"></i>Switch to Administrator Login
    </a>
  </div>
</div>
