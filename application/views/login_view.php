<style>
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
}

.auth-icon-badge {
  width: 76px;
  height: 76px;
  border-radius: 50%;
  background: var(--srl-pink-gradient);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 18px;
  box-shadow: 0 8px 28px rgba(255, 42, 133, 0.42), 0 0 0 6px rgba(255, 42, 133, 0.08);
  font-size: 1.9rem;
  color: #ffffff;
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
  margin-bottom: 8px;
}

.auth-input-group .input-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 1.05rem;
  pointer-events: none;
}

.auth-input-group .form-control {
  background-color: rgba(18, 22, 34, 0.85) !important;
  border: 1.5px solid rgba(255, 255, 255, 0.15) !important;
  color: #ffffff !important;
  padding: 12px 14px 12px 42px;
  border-radius: 12px;
  font-size: 0.95rem;
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

.auth-hint {
  font-size: 0.76rem;
  color: #94a3b8;
  margin: 0 0 22px 2px;
  display: block;
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
}

.auth-switch-link:hover {
  text-decoration: underline;
}

.auth-security-badges {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-top: 22px;
  padding-top: 18px;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
  flex-wrap: wrap;
}

.auth-security-badges .badge-item {
  font-size: 0.76rem;
  color: #64748b;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.auth-security-badges .badge-item i {
  color: var(--srl-pink);
  font-size: 0.85rem;
}

.auth-security-badges .badge-dot {
  color: #334155;
  font-size: 0.75rem;
}

@media (max-width: 575.98px) {
  .auth-card { padding: 28px 20px; border-radius: 20px; }
  .auth-title { font-size: 1.32rem; }
}
</style>

<div class="auth-top-nav mb-3">
  <a href="<?= base_url() ?>" class="auth-back-link">
    <i class="bi bi-arrow-left"></i>
    <span>Back to Store</span>
  </a>
</div>

<div class="auth-card">
  <div class="auth-logo-header">
    <a href="<?= base_url() ?>" class="d-inline-block">
      <img src="<?= base_url('assets/images/new_logo.png') ?>" alt="SRL Pixel Logo" onerror="this.onerror=null; this.src='<?= base_url('assets/images/logo.png') ?>';">
    </a>
  </div>

  <div class="auth-icon-badge">
    <i class="bi bi-shield-lock-fill"></i>
  </div>

  <div class="text-center mb-4">
    <h4 class="auth-title">Sign In with OTP</h4>
    <p class="auth-subtitle">Enter your registered mobile number to receive a One-Time Password</p>
  </div>

  <?= form_open('login') ?>
    <label for="userPhone" class="auth-form-label">Mobile Number</label>
    <div class="auth-input-group">
      <i class="bi bi-telephone-fill input-icon"></i>
      <input type="tel" name="phone" id="userPhone" class="form-control" placeholder="Enter 10-digit mobile number" maxlength="15" value="<?= set_value('phone') ?>" required autofocus autocomplete="tel">
    </div>
    <small class="auth-hint"><i class="bi bi-info-circle me-1"></i>We'll send a 6-digit OTP via SMS to verify it's you</small>

    <button type="submit" class="auth-btn-submit">
      <i class="bi bi-send-fill"></i>
      <span>Send OTP</span>
    </button>
  <?= form_close() ?>

  <div class="auth-footer-text">
    <span>Don't have an account?</span>
    <a href="<?= base_url('register') ?>" class="auth-switch-link ms-1">Create Account</a>
  </div>

  <div class="auth-security-badges">
    <span class="badge-item"><i class="bi bi-shield-check"></i> 256-Bit Encrypted</span>
    <span class="badge-dot">&bull;</span>
    <span class="badge-item"><i class="bi bi-lightning-charge-fill text-warning"></i> Instant Checkout</span>
  </div>
</div>