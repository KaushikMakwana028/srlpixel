<div class="auth-card auth-card-wide">
  <div class="auth-logo-header">
    <a href="<?= base_url() ?>">
      <img src="<?= base_url('assets/images/new_logo.png') ?>" alt="SRL Pixel Logo" onerror="this.onerror=null; this.src='<?= base_url('assets/images/logo.png') ?>';">
    </a>
    <h4 class="auth-title">Create Customer Account</h4>
    <p class="auth-subtitle">Join SRL PIXEL LED'S GLOWING HUB community</p>
  </div>

  <!-- SweetAlert2 delivers notifications dynamically -->

  <?= form_open('register') ?>
    <div class="row g-3">
      <!-- Full Name -->
      <div class="col-12">
        <label for="regName" class="auth-form-label">Full Name <span class="text-danger">*</span></label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-person input-icon"></i>
          <input type="text" name="name" id="regName" class="form-control" placeholder="Enter your full name" value="<?= set_value('name') ?>" required autofocus>
        </div>
      </div>

      <!-- Email Address -->
      <div class="col-md-6">
        <label for="regEmail" class="auth-form-label">Email Address <span class="text-danger">*</span></label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-envelope input-icon"></i>
          <input type="email" name="email" id="regEmail" class="form-control" placeholder="name@example.com" value="<?= set_value('email') ?>" required>
        </div>
      </div>

      <!-- Phone Number -->
      <div class="col-md-6">
        <label for="regPhone" class="auth-form-label">Phone Number <span class="text-danger">*</span></label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-telephone input-icon"></i>
          <input type="text" name="phone" id="regPhone" class="form-control" placeholder="10-digit mobile number" value="<?= set_value('phone') ?>" required>
        </div>
      </div>

      <!-- Password -->
      <div class="col-md-6">
        <label for="regPassword" class="auth-form-label">Password <span class="text-danger">*</span></label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-lock input-icon"></i>
          <input type="password" name="password" id="regPassword" class="form-control" placeholder="Min. 6 characters" required>
          <button type="button" class="password-toggle" data-target="regPassword" aria-label="Toggle password visibility">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>

      <!-- Confirm Password -->
      <div class="col-md-6">
        <label for="regConfirmPassword" class="auth-form-label">Confirm Password <span class="text-danger">*</span></label>
        <div class="auth-input-group mb-0">
          <i class="bi bi-lock-fill input-icon"></i>
          <input type="password" name="confirm_password" id="regConfirmPassword" class="form-control" placeholder="Re-type password" required>
          <button type="button" class="password-toggle" data-target="regConfirmPassword" aria-label="Toggle confirm password visibility">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>

      <div class="col-12 mt-4">
        <button type="submit" class="auth-btn-submit">
          <i class="bi bi-check2-circle me-2"></i>Complete Registration
        </button>
      </div>
    </div>
  <?= form_close() ?>

  <div class="auth-footer-text">
    Already have an account? <a href="<?= base_url('login') ?>">Sign In</a>
  </div>
</div>
