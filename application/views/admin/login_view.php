<style>
/* ============================================================
   ADMIN LOGIN VIEW STYLES
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
