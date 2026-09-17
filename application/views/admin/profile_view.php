<style>
.avatar-camera-btn {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: var(--srl-pink-gradient);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: 2px solid #10131c;
  box-shadow: 0 4px 12px rgba(235, 14, 153, 0.45);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  z-index: 5;
  font-size: 0.85rem;
}
.avatar-camera-btn:hover {
  transform: scale(1.12);
  box-shadow: 0 0 16px rgba(235, 14, 153, 0.7);
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <div>
    <h4 class="fw-bold text-dark mb-1">
      <i class="bi bi-person-gear me-2" style="color: var(--srl-pink);"></i>Administrator Profile Settings
    </h4>
    <p class="text-muted small mb-0">Manage your administrative personal credentials, contact info, and security credentials.</p>
  </div>
</div>

<div class="row g-4">
  <!-- Left Side: Profile Summary Card -->
  <div class="col-lg-4">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-body p-3 p-sm-4 text-center" style="background: linear-gradient(180deg, #181c28 0%, #10131c 100%);">
        <div class="position-relative d-inline-block mb-3">
          <div id="profileAvatarContainer" class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow" style="width: 95px; height: 95px; border: 3px solid var(--srl-pink-glow); background: #231b2e; font-size: 2.2rem; overflow: hidden; margin: 0 auto; position: relative;">
            <?php if (!empty($admin->profile_image) && file_exists('./uploads/profiles/' . $admin->profile_image)): ?>
              <img id="avatarPreviewImg" src="<?= base_url('uploads/profiles/' . $admin->profile_image) ?>" alt="<?= html_escape($admin->name) ?>" class="w-100 h-100 object-fit-cover rounded-circle">
            <?php else: ?>
              <span id="avatarInitialText"><?= strtoupper(substr($admin->name, 0, 1)) ?></span>
            <?php endif; ?>
          </div>
          <!-- Camera Icon Overlay Trigger -->
          <label for="profileImage" class="avatar-camera-btn" title="Click to choose new profile photo">
            <i class="bi bi-camera-fill"></i>
          </label>
        </div>
        <h5 class="fw-bold text-white mb-1"><?= html_escape($admin->name) ?></h5>
        <p class="text-secondary small mb-2 text-break"><?= html_escape($admin->email) ?></p>
        <span class="admin-role-badge">Super Admin</span>
      </div>
      <div class="card-body p-3 p-sm-4 bg-white">
        <ul class="list-unstyled mb-0 small">
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted">Account ID</span>
            <span class="fw-bold text-dark">#ADM-<?= str_pad($admin->id, 4, '0', STR_PAD_LEFT) ?></span>
          </li>
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted">Phone Number</span>
            <span class="fw-semibold text-dark"><?= !empty($admin->phone) ? html_escape($admin->phone) : 'Not provided' ?></span>
          </li>
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted">Address</span>
            <span class="fw-semibold text-dark text-end" style="max-width: 60%; word-break: break-word;"><?= !empty($admin->address) ? html_escape($admin->address) : 'Not provided' ?></span>
          </li>
          <li class="d-flex justify-content-between py-2 border-bottom">
            <span class="text-muted">Role Status</span>
            <span class="badge bg-success rounded-pill px-2 py-1">Active</span>
          </li>
          <li class="d-flex justify-content-between py-2">
            <span class="text-muted">Registered On</span>
            <span class="text-secondary"><?= date('d M Y', strtotime($admin->created_at)) ?></span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Right Side: Profile Tabs (Info & Password) -->
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-4" style="border: 1px solid var(--srl-border) !important;">
      <div class="card-header bg-white border-bottom p-2 p-sm-3">
        <ul class="nav nav-pills nav-fill gap-2 flex-column flex-sm-row" id="profileTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link <?= ($active_tab !== 'password') ? 'active' : '' ?> rounded-pill fw-semibold py-2 w-100" id="info-tab" data-bs-toggle="pill" data-bs-target="#info-pane" type="button" role="tab" style="<?= ($active_tab !== 'password') ? 'background: var(--srl-pink-gradient) !important;' : '' ?>">
              <i class="bi bi-person-lines-fill me-1"></i>Edit Profile Information
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?= ($active_tab === 'password') ? 'active' : '' ?> rounded-pill fw-semibold py-2 w-100" id="password-tab" data-bs-toggle="pill" data-bs-target="#password-pane" type="button" role="tab" style="<?= ($active_tab === 'password') ? 'background: var(--srl-pink-gradient) !important;' : '' ?>">
              <i class="bi bi-shield-lock me-1"></i>Change Password
            </button>
          </li>
        </ul>
      </div>

      <div class="card-body p-3 p-sm-4 p-md-5">
        <div class="tab-content" id="profileTabsContent">
          <!-- Tab 1: Profile Information -->
          <div class="tab-pane fade <?= ($active_tab !== 'password') ? 'show active' : '' ?>" id="info-pane" role="tabpanel">
            <?= form_open_multipart('admin/profile', ['id' => 'profileForm']) ?>
              <!-- Hidden avatar file input connected to camera icon -->
              <input type="file" name="profile_image" id="profileImage" class="d-none" accept="image/*">

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="adminName" class="form-label fw-semibold text-secondary small">Full Name <span class="text-danger">*</span></label>
                  <div class="auth-input-group mb-0">
                    <i class="bi bi-person input-icon"></i>
                    <input type="text" name="name" id="adminName" class="form-control bg-light text-dark" value="<?= set_value('name', $admin->name) ?>" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="adminEmail" class="form-label fw-semibold text-secondary small">Email Address <span class="text-danger">*</span></label>
                  <div class="auth-input-group mb-0">
                    <i class="bi bi-envelope input-icon"></i>
                    <input type="email" name="email" id="adminEmail" class="form-control bg-light text-dark" value="<?= set_value('email', $admin->email) ?>" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="adminPhone" class="form-label fw-semibold text-secondary small">Phone Number</label>
                  <div class="auth-input-group mb-0">
                    <i class="bi bi-telephone input-icon"></i>
                    <input type="text" name="phone" id="adminPhone" class="form-control bg-light text-dark" value="<?= set_value('phone', $admin->phone) ?>" placeholder="e.g. 9876543210">
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label fw-semibold text-secondary small">Profile Photo (Max 2MB)</label>
                  <div class="d-flex align-items-center gap-2">
                    <label for="profileImage" class="btn btn-outline-primary rounded-pill px-3 py-2 btn-sm flex-grow-1" style="cursor: pointer;">
                      <i class="bi bi-camera me-1"></i>Choose Photo
                    </label>
                    <span id="adminFileNameLabel" class="text-muted small text-truncate" style="max-width: 140px;">Max 2 MB</span>
                  </div>
                </div>

                <div class="col-12">
                  <label for="adminAddress" class="form-label fw-semibold text-secondary small">Address</label>
                  <div class="auth-input-group mb-0">
                    <i class="bi bi-geo-alt input-icon" style="top: 22px;"></i>
                    <textarea name="address" id="adminAddress" rows="2" class="form-control bg-light text-dark" placeholder="Enter physical street address, city, state, pincode..."><?= set_value('address', $admin->address) ?></textarea>
                  </div>
                  <div class="form-text small">Administrative office or shipping headquarters address.</div>
                </div>

                <div class="col-12 mt-4 pt-2 border-top d-flex justify-content-end">
                  <button type="submit" class="btn-srl-primary rounded-pill px-4 w-100 w-sm-auto justify-content-center">
                    <i class="bi bi-check2-circle me-1"></i>Save Profile Changes
                  </button>
                </div>
              </div>
            <?= form_close() ?>
          </div>

          <!-- Tab 2: Change Password -->
          <div class="tab-pane fade <?= ($active_tab === 'password') ? 'show active' : '' ?>" id="password-pane" role="tabpanel">
            <?= form_open('admin/profile/change_password') ?>
              <div class="row g-3">
                <div class="col-12">
                  <label for="currPass" class="form-label fw-semibold text-secondary small">Current Password <span class="text-danger">*</span></label>
                  <div class="auth-input-group mb-0">
                    <i class="bi bi-key input-icon"></i>
                    <input type="password" name="current_password" id="currPass" class="form-control bg-light text-dark" placeholder="Enter existing password" required>
                    <button type="button" class="password-toggle" data-target="currPass" aria-label="Toggle password">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="newPass" class="form-label fw-semibold text-secondary small">New Password <span class="text-danger">*</span></label>
                  <div class="auth-input-group mb-0">
                    <i class="bi bi-lock input-icon"></i>
                    <input type="password" name="new_password" id="newPass" class="form-control bg-light text-dark" placeholder="Min. 6 characters" required>
                    <button type="button" class="password-toggle" data-target="newPass" aria-label="Toggle password">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                </div>

                <div class="col-md-6">
                  <label for="confPass" class="form-label fw-semibold text-secondary small">Confirm New Password <span class="text-danger">*</span></label>
                  <div class="auth-input-group mb-0">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" name="confirm_password" id="confPass" class="form-control bg-light text-dark" placeholder="Re-type new password" required>
                    <button type="button" class="password-toggle" data-target="confPass" aria-label="Toggle password">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                </div>

                <div class="col-12">
                  <div class="p-3 bg-light rounded-3 border small text-muted">
                    <i class="bi bi-info-circle text-primary me-1"></i> Make sure your new password is at least 6 characters long and distinct from your old password.
                  </div>
                </div>

                <div class="col-12 mt-4 pt-2 border-top d-flex justify-content-end">
                  <button type="submit" class="btn-srl-primary rounded-pill px-4 w-100 w-sm-auto justify-content-center">
                    <i class="bi bi-shield-check me-1"></i>Update Password
                  </button>
                </div>
              </div>
            <?= form_close() ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Sync tab clicks with active styling
  const infoTab = document.getElementById('info-tab');
  const passTab = document.getElementById('password-tab');
  if (infoTab && passTab) {
    infoTab.addEventListener('click', function () {
      this.style.setProperty('background', 'var(--srl-pink-gradient)', 'important');
      passTab.style.removeProperty('background');
    });
    passTab.addEventListener('click', function () {
      this.style.setProperty('background', 'var(--srl-pink-gradient)', 'important');
      infoTab.style.removeProperty('background');
    });
  }

  // Handle Avatar Image Selection & Instant Live Preview
  const profileImageInput = document.getElementById('profileImage');
  const avatarContainer = document.getElementById('profileAvatarContainer');

  if (profileImageInput && avatarContainer) {
    profileImageInput.addEventListener('change', function () {
      const file = this.files[0];
      if (!file) return;

      // Check max size: 2MB (2 * 1024 * 1024 bytes)
      const maxSize = 2 * 1024 * 1024;
      if (file.size > maxSize) {
        Swal.fire({
          title: 'File Too Large',
          html: `The selected image is <strong>${(file.size / (1024 * 1024)).toFixed(2)} MB</strong>.<br>Maximum allowed profile image size is <strong>2 MB</strong>.`,
          icon: 'warning',
          confirmButtonText: 'Understood',
          customClass: {
            popup: 'srl-swal-popup',
            title: 'srl-swal-title',
            htmlContainer: 'srl-swal-html',
            confirmButton: 'srl-swal-confirm'
          },
          buttonsStyling: false
        });
        this.value = '';
        const adminFileName = document.getElementById('adminFileNameLabel');
        if (adminFileName) adminFileName.textContent = 'Max 2 MB';
        return;
      }

      const adminFileName = document.getElementById('adminFileNameLabel');
      if (adminFileName) adminFileName.textContent = file.name;

      // Live Instant Preview inside the circle
      const reader = new FileReader();
      reader.onload = function (e) {
        const initialText = document.getElementById('avatarInitialText');
        if (initialText) {
          initialText.style.display = 'none';
        }
        let previewImg = document.getElementById('avatarPreviewImg');
        if (!previewImg) {
          previewImg = document.createElement('img');
          previewImg.id = 'avatarPreviewImg';
          previewImg.className = 'w-100 h-100 object-fit-cover rounded-circle';
          previewImg.alt = 'Avatar Preview';
          avatarContainer.appendChild(previewImg);
        }
        previewImg.src = e.target.result;
        previewImg.style.display = 'block';
        previewImg.style.borderRadius = '50%';

        // Brief glowing pulse effect to confirm preview
        avatarContainer.style.boxShadow = '0 0 25px rgba(235, 14, 153, 0.8)';
        setTimeout(() => {
          avatarContainer.style.boxShadow = '';
        }, 1200);
      };
      reader.readAsDataURL(file);
    });
  }
});
</script>
