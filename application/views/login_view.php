<style>
/* ============================================================
   AUTH PAGES STYLING (LOGIN)
   ============================================================ */

.auth-top-nav {
  width: 100%;
  max-width: 460px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.auth-back-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  color: #94a3b8;
  text-decoration: none;
  font-size: 0.84rem;
  font-weight: 600;
  padding: 6px 14px;
  border-radius: 50px;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
  transition: all 0.22s ease;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

.auth-back-link:hover {
  color: #ffffff;
  background: rgba(255, 42, 133, 0.14);
  border-color: rgba(255, 42, 133, 0.35);
  transform: translateX(-3px);
}

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

.auth-options-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 22px;
  flex-wrap: wrap;
  gap: 8px;
}

.auth-remember-check {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
}

.auth-remember-check input[type="checkbox"] {
  width: 17px;
  height: 17px;
  border-radius: 4px;
  background-color: rgba(255, 255, 255, 0.08);
  border: 1.5px solid rgba(255, 255, 255, 0.25);
  accent-color: var(--srl-pink);
  cursor: pointer;
  margin: 0;
}

.auth-remember-check label {
  color: #e2e8f0 !important;
  font-size: 0.85rem;
  font-weight: 500;
  cursor: pointer;
  user-select: none;
  margin: 0;
}

.auth-forgot-link {
  color: var(--srl-pink-glow);
  font-size: 0.85rem;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s ease;
}

.auth-forgot-link:hover {
  color: #ffffff;
  text-shadow: 0 0 8px rgba(255, 42, 133, 0.7);
  text-decoration: underline;
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

.auth-switch-link {
  color: var(--srl-pink-glow) !important;
  font-weight: 700;
  text-decoration: none;
  transition: all 0.2s ease;
}

.auth-switch-link:hover {
  text-decoration: underline;
}

@media (max-width: 575.98px) {
  .auth-card {
    padding: 28px 20px;
    border-radius: 20px;
  }
  .auth-title {
    font-size: 1.32rem;
  }
}
</style>

<!-- Floating Back to Store Link -->
<div class="auth-top-nav mb-3">
  <a href="<?= base_url() ?>" class="auth-back-link">
    <i class="bi bi-arrow-left"></i>
    <span>Back to Store</span>
  </a>
</div>

<div class="auth-card">
  <!-- Brand Logo & Header -->
  <div class="auth-logo-header">
    <a href="<?= base_url() ?>" class="d-inline-block">
      <img src="<?= base_url('assets/images/new_logo.png') ?>" alt="SRL Pixel Logo" onerror="this.onerror=null; this.src='<?= base_url('assets/images/logo.png') ?>';">
    </a>
    <h4 class="auth-title">Customer Sign In</h4>
    <p class="auth-subtitle">Sign in to manage your orders & pixel projects</p>
  </div>

  <?= form_open('login') ?>
    <!-- Email Address -->
    <div class="mb-3">
      <label for="userEmail" class="auth-form-label">Email Address</label>
      <div class="auth-input-group">
        <i class="bi bi-envelope-fill input-icon"></i>
        <input type="email" name="email" id="userEmail" class="form-control" placeholder="user@srlpixel.com" value="<?= set_value('email') ?>" required autofocus autocomplete="email">
      </div>
    </div>

    <!-- Password -->
    <div class="mb-3">
      <label for="userPassword" class="auth-form-label">Password</label>
      <div class="auth-input-group">
        <i class="bi bi-lock-fill input-icon"></i>
        <input type="password" name="password" id="userPassword" class="form-control" placeholder="Enter your password" required autocomplete="current-password">
        <button type="button" class="password-toggle" data-target="userPassword" aria-label="Toggle password visibility" title="Show/hide password">
          <i class="bi bi-eye"></i>
        </button>
      </div>
    </div>

    <!-- High-Contrast Remember Me & Forgot Password -->
    <div class="auth-options-row">
      <div class="auth-remember-check">
        <input type="checkbox" name="remember" id="rememberUser">
        <label for="rememberUser">Remember me</label>
      </div>
      <a href="#" class="auth-forgot-link">Forgot Password?</a>
    </div>

    <!-- Primary Sign In Button -->
    <button type="submit" class="auth-btn-submit">
      <i class="bi bi-box-arrow-in-right"></i>
      <span>Sign In</span>
    </button>
  <?= form_close() ?>

  <!-- Register Link -->
  <div class="auth-footer-text">
    <span>Don't have an account?</span> 
    <a href="<?= base_url('register') ?>" class="auth-switch-link ms-1">Create Account</a>
  </div>

  <!-- Trust & Security Badges -->
  <div class="auth-security-badges">
    <span class="badge-item"><i class="bi bi-shield-check"></i> 256-Bit Encrypted</span>
    <span class="badge-dot">&bull;</span>
    <span class="badge-item"><i class="bi bi-lightning-charge-fill text-warning"></i> Instant Checkout</span>
  </div>
</div>
