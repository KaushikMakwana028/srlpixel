<style>
.avatar-camera-btn {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background: var(--srl-pink-gradient);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: 2px solid #ffffff;
  box-shadow: 0 4px 12px rgba(225, 29, 116, 0.4);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  z-index: 5;
  font-size: 0.8rem;
}
.avatar-camera-btn:hover {
  transform: scale(1.12);
  box-shadow: 0 0 16px rgba(225, 29, 116, 0.6);
}
.password-toggle-btn {
  background: transparent;
  border: none;
  color: #64748b;
  cursor: pointer;
  padding: 0 12px;
  height: 100%;
  display: flex;
  align-items: center;
  transition: color 0.2s ease;
}
.password-toggle-btn:hover {
  color: var(--srl-pink);
}
#addressModal .modal-dialog {
  max-height: calc(100vh - 2rem);
  display: flex;
}
#addressModal .modal-content {
  max-height: calc(100vh - 2rem);
  display: flex;
  flex-direction: column;
  border-radius: 20px;
  border: 1px solid #e2e8f0;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
}
#addressModal .modal-header {
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  padding: 1rem 1.4rem;
  flex-shrink: 0;
}
#addressModal .modal-body {
  overflow-y: auto !important;
  -webkit-overflow-scrolling: touch !important;
  flex: 1 1 auto;
  min-height: 0;
  padding: 1.25rem 1.4rem;
}
#addressModal .modal-footer {
  background: #f8fafc;
  border-top: 1px solid #e2e8f0;
  padding: 0.9rem 1.4rem;
  flex-shrink: 0;
}

@media (max-width: 576px) {
  #addressModal .modal-dialog {
    margin: 10px auto !important;
    max-height: calc(100vh - 20px) !important;
    width: calc(100% - 20px) !important;
  }
  #addressModal .modal-content {
    max-height: calc(100vh - 20px) !important;
    border-radius: 16px !important;
  }
  #addressModal .modal-header {
    padding: 0.85rem 1rem !important;
  }
  #addressModal .modal-body {
    padding: 1rem !important;
  }
  #addressModal .modal-footer {
    padding: 0.75rem 1rem !important;
  }
}

/* User Header & Sidebar Responsive Styling */
.cust-dash-sidebar {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 20px;
  padding: 28px 20px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
  transition: all 0.2s ease;
}
.cust-dash-user-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  margin-bottom: 20px;
}
.cust-dash-avatar-wrap {
  margin-bottom: 12px;
}
.cust-dash-avatar {
  width: 92px;
  height: 92px;
  font-size: 2.2rem;
  border: 3px solid var(--srl-pink);
  background: #fff8fb;
  color: var(--srl-pink);
  font-weight: 800;
  margin: 0 auto;
  border-radius: 50% !important;
  overflow: hidden !important;
  position: relative;
  box-shadow: 0 4px 14px rgba(225, 29, 116, 0.2);
  -webkit-mask-image: -webkit-radial-gradient(white, black);
  isolation: isolate;
}

.cust-dash-avatar img {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  border-radius: 50% !important;
  display: block !important;
}

.cust-dash-user-info {
  text-align: center;
}

.cust-dash-user-name {
  font-size: 1.15rem;
  font-weight: 700;
  color: #0f172a;
}

.cust-dash-role-badge {
  background: rgba(225, 29, 116, 0.08);
  color: var(--srl-pink);
  border: 1px solid rgba(225, 29, 116, 0.2);
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  padding: 4px 12px;
}

.btn-cust-dash-signout-sm {
  background: rgba(239, 68, 68, 0.08);
  color: #ef4444;
  border: 1px solid rgba(239, 68, 68, 0.22);
  border-radius: 50px;
  padding: 5px 12px;
  font-size: 0.76rem;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  text-decoration: none;
  transition: all 0.2s ease;
  flex-shrink: 0;
  white-space: nowrap;
}

.btn-cust-dash-signout-sm:hover,
.btn-cust-dash-signout-sm:active {
  background: #ef4444;
  color: #ffffff;
  border-color: #ef4444;
}

.cust-dash-nav {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.cust-dash-nav-link {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 18px;
  border-radius: 12px;
  color: #475569;
  font-weight: 600;
  font-size: 0.94rem;
  text-decoration: none;
  transition: all 0.22s ease-in-out;
  margin-bottom: 4px;
  border: 1px solid transparent;
  width: 100%;
  text-align: left;
  background: transparent;
}

.cust-dash-nav-link:hover {
  color: var(--srl-pink);
  background: #f8fafc;
  transform: translateX(3px);
}

.cust-dash-nav-link.active {
  background: var(--srl-pink-gradient) !important;
  color: #ffffff !important;
  border-color: transparent !important;
  box-shadow: 0 4px 16px rgba(225, 29, 116, 0.35);
  font-weight: 700;
}

.cust-dash-nav-link.active i {
  color: #ffffff !important;
}

/* Mobile Responsive Layout (<768px): Compact, Clean App Header */
@media (max-width: 767.98px) {
  .cust-dash-sidebar {
    padding: 14px 16px !important;
    border-radius: 18px !important;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04) !important;
    margin-bottom: 16px !important;
    border: 1px solid #e2e8f0 !important;
    background: #ffffff !important;
  }

  .cust-dash-user-header {
    flex-direction: row !important;
    align-items: center !important;
    justify-content: flex-start !important;
    text-align: left !important;
    gap: 12px !important;
    margin-bottom: 14px !important;
    padding-bottom: 12px !important;
    border-bottom: 1px solid #f1f5f9 !important;
  }

  .cust-dash-avatar-wrap {
    margin-bottom: 0 !important;
    flex-shrink: 0;
  }

  .cust-dash-avatar {
    width: 54px !important;
    height: 54px !important;
    border-radius: 50% !important;
    overflow: hidden !important;
    border: 2.5px solid var(--srl-pink) !important;
    margin: 0 !important;
    box-shadow: 0 2px 8px rgba(225, 29, 116, 0.25) !important;
    -webkit-mask-image: -webkit-radial-gradient(white, black);
    isolation: isolate;
  }

  .cust-dash-avatar img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    border-radius: 50% !important;
    display: block !important;
  }

  .avatar-camera-btn {
    width: 20px !important;
    height: 20px !important;
    font-size: 0.65rem !important;
    bottom: -2px !important;
    right: -2px !important;
    border-width: 1.5px !important;
    box-shadow: 0 2px 6px rgba(225, 29, 116, 0.4) !important;
  }

  .cust-dash-user-info {
    text-align: left !important;
    margin-top: 0 !important;
    flex-grow: 1;
    min-width: 0;
  }

  .cust-dash-user-name {
    font-size: 1rem !important;
    font-weight: 800 !important;
    margin-bottom: 3px !important;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: #0f172a !important;
  }

  .cust-dash-role-badge {
    font-size: 0.65rem !important;
    font-weight: 700 !important;
    padding: 2px 8px !important;
    letter-spacing: 0.5px !important;
    background: rgba(225, 29, 116, 0.1) !important;
    color: var(--srl-pink) !important;
    border: 1px solid rgba(225, 29, 116, 0.25) !important;
  }

  .btn-cust-dash-signout-sm {
    padding: 6px 12px !important;
    font-size: 0.76rem !important;
    font-weight: 700 !important;
    border-radius: 30px !important;
  }

  /* Segmented Control Nav on Mobile: Flush, Single-Row, Zero Wrapping, No Overlap */
  .cust-dash-nav {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    align-items: center !important;
    justify-content: stretch !important;
    gap: 6px !important;
    background: #f1f5f9 !important;
    padding: 4px !important;
    border-radius: 14px !important;
    border: 1px solid #e2e8f0 !important;
    height: 44px !important;
    min-height: 44px !important;
    max-height: 44px !important;
    box-sizing: border-box !important;
    overflow-x: auto !important;
    scrollbar-width: none !important;
  }
  .cust-dash-nav::-webkit-scrollbar {
    display: none !important;
  }

  .cust-dash-nav-link {
    flex: 1 1 0 !important;
    min-width: 0 !important;
    height: 36px !important;
    max-height: 36px !important;
    line-height: 36px !important;
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: center !important;
    text-align: center !important;
    padding: 0 6px !important;
    font-size: 0.78rem !important;
    font-weight: 600 !important;
    margin: 0 !important;
    width: auto !important;
    border-radius: 10px !important;
    border: none !important;
    gap: 4px !important;
    transform: none !important;
    color: #64748b !important;
    background: transparent !important;
    box-shadow: none !important;
    box-sizing: border-box !important;
    position: relative !important;
  }

  .cust-dash-nav-link span {
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    display: inline-block !important;
    max-width: 100% !important;
  }

  .cust-dash-nav-link i {
    font-size: 0.85rem !important;
    color: #64748b !important;
    flex-shrink: 0 !important;
    margin: 0 !important;
    line-height: 1 !important;
  }

  .cust-dash-nav-link:hover {
    color: #0f172a !important;
    background: rgba(255, 255, 255, 0.6) !important;
  }

  .cust-dash-nav-link.active {
    background: var(--srl-pink-gradient) !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    box-shadow: 0 2px 8px rgba(225, 29, 116, 0.35) !important;
    height: 36px !important;
    max-height: 36px !important;
  }

  .cust-dash-nav-link.active i {
    color: #ffffff !important;
  }

  /* Completely hide desktop signout link on mobile */
  .cust-dash-nav-signout,
  .cust-dash-nav .d-none,
  .cust-dash-nav a[href*="logout"] {
    display: none !important;
  }

  .cust-dash-content-card {
    padding: 18px 14px !important;
    border-radius: 16px !important;
  }
}

.cust-dash-content-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 20px;
  padding: 32px;
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04);
}

.cust-form-label {
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.6px;
  text-transform: uppercase;
  color: #334155;
  margin-bottom: 8px;
  display: block;
}

/* Crisp White Form Inputs */
.cust-form-input,
.cust-dark-input {
  background: #ffffff !important;
  border: 1.5px solid #cbd5e1 !important;
  color: #0f172a !important;
  border-radius: 12px !important;
  padding: 12px 16px !important;
  font-size: 0.94rem !important;
  transition: all 0.2s ease-in-out;
}

.cust-form-input:focus,
.cust-dark-input:focus {
  border-color: var(--srl-pink) !important;
  box-shadow: 0 0 0 3px rgba(225, 29, 116, 0.15) !important;
  background: #ffffff !important;
  outline: none;
}

.input-group:focus-within .input-group-text {
  border-color: var(--srl-pink) !important;
  color: var(--srl-pink) !important;
}

.cust-form-input:disabled,
.cust-dark-input:disabled,
.cust-form-input[readonly],
.cust-dark-input[readonly] {
  background: #f8fafc !important;
  border-color: #e2e8f0 !important;
  color: #64748b !important;
  cursor: not-allowed;
}

.cust-form-input::placeholder,
.cust-dark-input::placeholder {
  color: #94a3b8 !important;
}

/* Saved Addresses Cards */
.address-card {
  background: #ffffff;
  border: 2px solid #e2e8f0;
  border-radius: 16px;
  padding: 20px;
  position: relative;
  transition: all 0.22s ease-in-out;
}

.address-card:hover {
  border-color: #cbd5e1;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
}

.address-card.is-default {
  border-color: var(--srl-pink) !important;
  background: #fff8fb !important;
  box-shadow: 0 4px 18px rgba(225, 29, 116, 0.1) !important;
}

/* Order History Cards - Sleek, Compact & Mobile-Optimized */
.order-history-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 14px 18px;
  margin-bottom: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
  transition: all 0.2s ease-in-out;
}

.order-history-card:hover {
  border-color: rgba(225, 29, 116, 0.3);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
  transform: translateY(-1px);
}

@media (max-width: 767.98px) {
  .order-history-card {
    padding: 12px 14px;
    border-radius: 12px;
    margin-bottom: 10px;
  }
}
</style>

<div class="container my-3 my-md-5">
  <div class="row g-3 g-md-4">
    <!-- Left Navigation Column -->
    <div class="col-lg-3 col-md-4">
      <div class="cust-dash-sidebar">
        <!-- User Details Header (Stacked on Desktop, Compact Row on Mobile) -->
        <div class="cust-dash-user-header">
          <!-- Avatar with Camera Overlay -->
          <div class="position-relative d-inline-block cust-dash-avatar-wrap">
            <div id="customerAvatarContainer" class="rounded-circle d-flex align-items-center justify-content-center shadow-sm cust-dash-avatar">
              <?php if (!empty($user->profile_image) && file_exists('./uploads/profiles/' . $user->profile_image)): ?>
                <img id="customerAvatarPreviewImg" src="<?= base_url('uploads/profiles/' . $user->profile_image) ?>" alt="<?= html_escape($user->name) ?>" class="w-100 h-100 object-fit-cover rounded-circle">
              <?php else: ?>
                <span id="customerAvatarInitial"><?= strtoupper(mb_substr(trim($user->name), 0, 1)) ?></span>
              <?php endif; ?>
            </div>
            <!-- Camera Icon Overlay Triggering Profile Image Picker -->
            <label for="custProfileImageInput" class="avatar-camera-btn" title="Upload new photo (Max 2MB)">
              <i class="bi bi-camera-fill"></i>
            </label>
          </div>

          <!-- User Name & Role Information -->
          <div class="cust-dash-user-info">
            <h5 class="fw-bold text-dark cust-dash-user-name mb-1"><?= html_escape($user->name) ?></h5>
            <span class="badge rounded-pill cust-dash-role-badge">
              CUSTOMER
            </span>
          </div>

          <!-- Quick Sign Out (Mobile View Only - Top Right Pill) -->
          <div class="d-md-none ms-auto">
            <a href="<?= base_url('logout') ?>" class="btn-cust-dash-signout-sm" onclick="confirmSignOut(event)" title="Sign Out">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </div>
        </div>

        <!-- Navigation Tabs (Segmented Control on Mobile, Vertical Stack on Desktop) -->
        <div class="nav cust-dash-nav" id="dashNavTabs" role="tablist">
          <button class="cust-dash-nav-link <?= (!isset($active_tab) || $active_tab === 'profile') ? 'active' : '' ?>" id="tab-profile-btn" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button" role="tab">
            <i class="bi bi-person-fill"></i>
            <span class="d-none d-md-inline">Profile Info</span>
            <span class="d-inline d-md-none">Profile</span>
          </button>
          <button class="cust-dash-nav-link <?= (isset($active_tab) && $active_tab === 'addresses') ? 'active' : '' ?>" id="tab-addresses-btn" data-bs-toggle="pill" data-bs-target="#tab-addresses" type="button" role="tab">
            <i class="bi bi-geo-alt-fill"></i>
            <span class="d-none d-md-inline">Saved Addresses</span>
            <span class="d-inline d-md-none">Addresses</span>
          </button>
          <button class="cust-dash-nav-link <?= (isset($active_tab) && $active_tab === 'orders') ? 'active' : '' ?>" id="tab-orders-btn" data-bs-toggle="pill" data-bs-target="#tab-orders" type="button" role="tab">
            <i class="bi bi-receipt"></i>
            <span class="d-none d-md-inline">My Orders</span>
            <span class="d-inline d-md-none">Orders</span>
          </button>
          <!-- Desktop Sign Out Item -->
          <a href="<?= base_url('logout') ?>" class="cust-dash-nav-link cust-dash-nav-signout text-danger mt-3 d-none d-md-flex" onclick="confirmSignOut(event)">
            <i class="bi bi-box-arrow-right fs-5"></i>
            <span>Sign Out</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Right Main Content Column -->
    <div class="col-lg-9 col-md-8">
      <div class="tab-content" id="dashTabContent">

        <!-- ============================================================
             SECTION 1: UNIFIED PROFILE INFORMATION & ACCOUNT SECURITY
             ============================================================ -->
        <div class="tab-pane fade <?= (!isset($active_tab) || $active_tab === 'profile') ? 'show active' : '' ?>" id="tab-profile" role="tabpanel">
          <div class="cust-dash-content-card">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
              <div>
                <h4 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                  <i class="bi bi-person-badge-fill" style="color: var(--srl-pink);"></i>Profile Information
                </h4>
                <p class="text-muted small mb-0">Manage your personal account details and contact information.</p>
              </div>
            </div>

            <?= form_open_multipart('profile', ['id' => 'customerProfileForm']) ?>
              <input type="hidden" name="action" value="update_profile">
              <input type="file" name="profile_image" id="custProfileImageInput" class="d-none" accept="image/jpeg,image/png,image/webp,image/gif">

              <!-- Section 1: Personal Contact Details -->
              <div class="mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                  <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: rgba(225, 29, 116, 0.1); color: var(--srl-pink); font-size: 0.85rem;">
                    <i class="bi bi-person-fill"></i>
                  </div>
                  <h6 class="fw-bold text-dark mb-0">Personal Contact Details</h6>
                </div>

                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="cust-form-label">Full Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 12px 0 0 12px; border: 1.5px solid #cbd5e1; border-right: none;"><i class="bi bi-person"></i></span>
                      <input type="text" name="name" class="form-control cust-form-input border-start-0" style="border-radius: 0 12px 12px 0;" value="<?= set_value('name', $user->name) ?>" placeholder="Enter your full name" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="cust-form-label d-flex align-items-center justify-content-between">
                      <span>Mobile Number</span>
                      <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5" style="font-size: 0.68rem;"><i class="bi bi-shield-check me-1"></i>OTP Login</span>
                    </label>
                    <div class="input-group">
                      <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 12px 0 0 12px; border: 1.5px solid #cbd5e1; border-right: none;"><i class="bi bi-phone"></i></span>
                      <input type="text" name="phone" class="form-control cust-form-input border-start-0" style="border-radius: 0 12px 12px 0;" placeholder="e.g. 9876543210" value="<?= set_value('phone', $user->phone) ?>">
                    </div>
                  </div>

                  <div class="col-12">
                    <label class="cust-form-label">Email Address <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 12px 0 0 12px; border: 1.5px solid #cbd5e1; border-right: none;"><i class="bi bi-envelope"></i></span>
                      <input type="email" name="email" class="form-control cust-form-input border-start-0" style="border-radius: 0 12px 12px 0;" value="<?= set_value('email', $user->email) ?>" placeholder="Enter your email address" required>
                    </div>
                    <span class="text-muted d-block mt-1" style="font-size: 0.76rem;">
                      <i class="bi bi-info-circle me-1"></i>Order confirmations, receipts, and digital invoices will be delivered to this email.
                    </span>
                  </div>
                </div>
              </div>

              <!-- Section 2: Default Delivery Address Preview -->
              <?php 
                $default_addr = null;
                if (!empty($addresses)) {
                  foreach ($addresses as $a) {
                    if ($a->is_default == 1) {
                      $default_addr = $a;
                      break;
                    }
                  }
                  if (!$default_addr && !empty($addresses[0])) {
                    $default_addr = $addresses[0];
                  }
                }
              ?>
              <div class="p-3 p-md-3 rounded-4 mb-4 border" style="background: #ffffff; border-color: #e2e8f0 !important;">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: rgba(225, 29, 116, 0.1); color: var(--srl-pink); font-size: 0.85rem;">
                      <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-0">Default Delivery Address</h6>
                  </div>
                  <button type="button" class="btn btn-sm btn-link text-decoration-none p-0 fw-semibold" style="color: var(--srl-pink); font-size: 0.82rem;" onclick="document.getElementById('tab-addresses-btn').click();">
                    Manage Addresses <i class="bi bi-arrow-right"></i>
                  </button>
                </div>

                <?php if ($default_addr): ?>
                  <div class="d-flex align-items-start gap-2 small text-secondary ps-4">
                    <span class="fw-semibold text-dark"><?= html_escape($default_addr->full_name) ?></span> &bull; 
                    <span><?= html_escape($default_addr->address_line1) ?><?= !empty($default_addr->address_line2) ? ', ' . html_escape($default_addr->address_line2) : '' ?>, <?= html_escape($default_addr->city) ?> (<?= html_escape($default_addr->pincode) ?>)</span>
                  </div>
                <?php elseif (!empty($user->address)): ?>
                  <div class="small text-secondary ps-4">
                    <i class="bi bi-geo-alt me-1 text-danger"></i><?= html_escape($user->address) ?>
                  </div>
                <?php else: ?>
                  <div class="small text-muted ps-4">
                    <i class="bi bi-info-circle me-1"></i>No delivery address saved yet. <a href="javascript:void(0)" onclick="openAddAddressModal()" class="text-decoration-none fw-semibold" style="color: var(--srl-pink);">Add one now</a>.
                  </div>
                <?php endif; ?>
              </div>

              <!-- Submit Bar -->
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pt-3 border-top">
                <div class="d-flex align-items-center gap-2 text-muted small">
                  <i class="bi bi-shield-lock-fill text-success fs-5"></i>
                  <span>Your profile details are secured & encrypted</span>
                </div>
                <button type="submit" class="btn-srl-primary px-4 py-2.5 rounded-pill fw-bold shadow-sm d-inline-flex align-items-center gap-2">
                  <i class="bi bi-check2-circle fs-6"></i>Save Profile Changes
                </button>
              </div>
            <?= form_close() ?>
          </div>
        </div>

        <!-- ============================================================
             SECTION 2: SAVED ADDRESSES (With Set As Default)
             ============================================================ -->
        <div class="tab-pane fade <?= (isset($active_tab) && $active_tab === 'addresses') ? 'show active' : '' ?>" id="tab-addresses" role="tabpanel">
          <div class="cust-dash-content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
              <div>
                <h4 class="fw-bold text-dark mb-1">Saved Addresses</h4>
                <p class="text-muted small mb-0">Manage delivery addresses for seamless and fast checkout.</p>
              </div>
              <button type="button" class="btn-srl-primary px-3 py-2 btn-sm rounded-pill fw-bold" onclick="openAddAddressModal()">
                <i class="bi bi-plus-lg me-1"></i>Add New Address
              </button>
            </div>

            <?php if (empty($addresses)): ?>
              <div class="text-center py-5">
                <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: rgba(225, 29, 116, 0.08); color: var(--srl-pink);">
                  <i class="bi bi-geo-alt fs-2"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">No Saved Addresses Found</h5>
                <p class="text-muted small mb-3">Add a shipping address so you can place orders smoothly.</p>
                <button type="button" class="btn-srl-primary px-4 py-2 rounded-pill fw-bold" onclick="openAddAddressModal()">
                  <i class="bi bi-plus-circle me-1"></i>Add Address Now
                </button>
              </div>
            <?php else: ?>
              <div class="row g-3">
                <?php foreach ($addresses as $addr): ?>
                  <div class="col-md-6">
                    <div class="address-card h-100 d-flex flex-column justify-content-between <?= $addr->is_default ? 'is-default' : '' ?>">
                      <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <h6 class="fw-bold text-dark mb-0"><?= html_escape($addr->full_name) ?></h6>
                          <?php if ($addr->is_default): ?>
                            <span class="badge rounded-pill px-2 py-1" style="background: var(--srl-pink-gradient); color: #fff; font-size: 0.72rem; font-weight: 700;">
                              <i class="bi bi-check-circle-fill me-1"></i>DEFAULT
                            </span>
                          <?php endif; ?>
                        </div>
                        <p class="text-muted small mb-2">
                          <i class="bi bi-telephone me-1 text-secondary"></i><?= html_escape($addr->mobile) ?>
                        </p>
                        <p class="text-secondary small mb-3" style="line-height: 1.55;">
                          <?= html_escape($addr->address_line1) ?><br>
                          <?php if (!empty($addr->address_line2)): ?>
                            <?= html_escape($addr->address_line2) ?><br>
                          <?php endif; ?>
                          <?php if (!empty($addr->landmark)): ?>
                            <span class="text-muted">Landmark: <?= html_escape($addr->landmark) ?></span><br>
                          <?php endif; ?>
                          <?= html_escape($addr->city) ?>, <?= html_escape($addr->state) ?> - <strong><?= html_escape($addr->pincode) ?></strong><br>
                          <?= html_escape($addr->country) ?>
                        </p>
                      </div>

                      <div class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <?php if (!$addr->is_default): ?>
                          <a href="<?= base_url('profile/set_default_address/' . $addr->id) ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1" style="font-size: 0.78rem;">
                            <i class="bi bi-star me-1 text-warning"></i>Set as Default
                          </a>
                        <?php else: ?>
                          <span class="text-success small fw-semibold" style="font-size: 0.78rem;">
                            <i class="bi bi-check-all me-1 fs-6"></i>Primary Address
                          </span>
                        <?php endif; ?>

                        <div class="d-flex gap-2">
                          <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1" style="font-size: 0.78rem;" onclick="openEditAddressModal(<?= $addr->id ?>)">
                            <i class="bi bi-pencil me-1"></i>Edit
                          </button>
                          <a href="<?= base_url('profile/delete_address/' . $addr->id) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 delete-address-btn" style="font-size: 0.78rem;" title="Delete Address">
                            <i class="bi bi-trash"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- ============================================================
             SECTION 3: MY ORDERS (Matching Status Designs)
             ============================================================ -->
        <div class="tab-pane fade <?= (isset($active_tab) && $active_tab === 'orders') ? 'show active' : '' ?>" id="tab-orders" role="tabpanel">
          <div class="cust-dash-content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
              <div>
                <h4 class="fw-bold text-dark mb-1">My Orders</h4>
                <p class="text-muted small mb-0">Track live orders, dispatch status, and purchase history.</p>
              </div>
              <span class="badge rounded-pill px-3 py-2" style="background: #f1f5f9; color: #0f172a; border: 1px solid #e2e8f0; font-weight: 700; font-size: 0.82rem;">
                Total Orders: <?= isset($orders_total) ? $orders_total : count($orders) ?>
              </span>
            </div>

            <?php if (empty($orders)): ?>
              <div class="text-center py-5">
                <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: rgba(225, 29, 116, 0.08); color: var(--srl-pink);">
                  <i class="bi bi-bag-x fs-2"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">No Orders Placed Yet</h5>
                <p class="text-muted small mb-3">You haven't made any purchases yet. Discover high-quality pixel LED strips & controllers!</p>
                <a href="<?= base_url('products') ?>" class="btn-srl-primary px-4 py-2 rounded-pill fw-bold">
                  <i class="bi bi-shop me-1"></i>Explore Products
                </a>
              </div>
            <?php else: ?>
              <div class="d-flex flex-column gap-2">
                <?php foreach ($orders as $ord): ?>
                  <?php
                    // Status Badge Icon and CSS class mapping
                    $status_class = 'status-badge-placed';
                    $status_icon  = 'bi bi-receipt';

                    switch ($ord->order_status) {
                      case 'Awaiting Payment':
                        $status_class = 'status-badge-awaiting-payment';
                        $status_icon  = 'bi bi-clock-history';
                        break;
                      case 'Placed':
                        $status_class = 'status-badge-placed';
                        $status_icon  = 'bi bi-receipt';
                        break;
                      case 'Confirmed':
                        $status_class = 'status-badge-confirmed';
                        $status_icon  = 'bi bi-check2-circle';
                        break;
                      case 'Processing':
                        $status_class = 'status-badge-processing';
                        $status_icon  = 'bi bi-box-seam';
                        break;
                      case 'Shipped':
                        $status_class = 'status-badge-shipped';
                        $status_icon  = 'bi bi-truck';
                        break;
                      case 'Delivered':
                        $status_class = 'status-badge-delivered';
                        $status_icon  = 'bi bi-check-circle-fill';
                        break;
                      case 'Cancelled':
                        $status_class = 'status-badge-cancelled';
                        $status_icon  = 'bi bi-x-circle';
                        break;
                    }
                  ?>
                  <div class="order-history-card">
                    <!-- Line 1: Order ID (Left) | Date & Status Badge (Right) -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
                      <div class="d-flex align-items-center gap-1 gap-sm-2 text-truncate">
                        <span class="fw-bold text-dark" style="font-size: 0.88rem;">#<?= html_escape($ord->order_number) ?></span>
                        <span class="text-muted small d-none d-sm-inline" style="font-size: 0.74rem;">• <?= date('d M Y, h:i A', strtotime($ord->created_at)) ?></span>
                      </div>
                      <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small d-inline d-sm-none" style="font-size: 0.7rem;"><?= date('d M Y', strtotime($ord->created_at)) ?></span>
                        <span class="order-status-badge <?= $status_class ?>" style="font-size: 0.72rem; padding: 2px 8px;">
                          <i class="<?= $status_icon ?>"></i> <?= html_escape($ord->order_status) ?>
                        </span>
                      </div>
                    </div>

                    <!-- Line 2 & 3: Recipient & Payment (Left) | Amount & View Details (Right) -->
                    <div class="d-flex justify-content-between align-items-center gap-2 pt-0.5">
                      <div class="min-w-0 flex-grow-1 text-truncate pe-2">
                        <div class="text-dark small fw-semibold text-truncate" style="font-size: 0.82rem;">
                          <i class="bi bi-geo-alt text-pink me-1"></i><?= html_escape($ord->shipping_full_name) ?>
                          <span class="text-muted fw-normal">• <?= html_escape($ord->shipping_city) ?></span>
                        </div>
                        <div class="text-muted text-truncate" style="font-size: 0.72rem;">
                          <?= html_escape($ord->payment_method) ?>
                          <?php if (!empty($ord->payment_status)): ?>
                            <span class="badge <?= ($ord->payment_status === 'Paid') ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' ?>" style="font-size: 0.65rem; padding: 1px 6px;">
                              <?= html_escape($ord->payment_status) ?>
                            </span>
                          <?php endif; ?>
                        </div>
                      </div>

                      <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-auto">
                        <span class="fw-bold fs-6 text-nowrap" style="color: var(--srl-pink);">
                          ₹<?= number_format($ord->total_amount, 2) ?>
                        </span>
                        <a href="<?= base_url('profile/order/' . $ord->id) ?>" class="btn btn-sm btn-srl-primary rounded-pill px-2.5 py-1 text-nowrap fw-bold d-inline-flex align-items-center gap-1" style="font-size: 0.74rem;" title="View Order Details">
                          View Details <i class="bi bi-chevron-right" style="font-size: 0.68rem;"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>

              <?php if (isset($orders_total_pages) && $orders_total_pages > 1): ?>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pt-3 mt-3 border-top" style="border-color: #f1f5f9 !important;">
                  <div class="text-muted small" style="font-size: 0.78rem;">
                    Showing <strong><?= min($orders_offset + 1, $orders_total) ?></strong> to <strong><?= min($orders_offset + $orders_limit, $orders_total) ?></strong> of <strong><?= $orders_total ?></strong> orders
                  </div>
                  <nav aria-label="Orders Pagination">
                    <ul class="pagination pagination-sm mb-0">
                      <li class="page-item <?= ($orders_page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link rounded-start-pill px-3" href="<?= base_url('profile?tab=orders&page=' . max(1, $orders_page - 1)) ?>">&laquo; Prev</a>
                      </li>
                      <?php for ($p = 1; $p <= $orders_total_pages; $p++): ?>
                        <li class="page-item <?= ($p == $orders_page) ? 'active' : '' ?>">
                          <a class="page-link" href="<?= base_url('profile?tab=orders&page=' . $p) ?>" <?= ($p == $orders_page) ? 'style="background: var(--srl-pink); border-color: var(--srl-pink); color: #fff;"' : '' ?>><?= $p ?></a>
                        </li>
                      <?php endfor; ?>
                      <li class="page-item <?= ($orders_page >= $orders_total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link rounded-end-pill px-3" href="<?= base_url('profile?tab=orders&page=' . min($orders_total_pages, $orders_page + 1)) ?>">Next &raquo;</a>
                      </li>
                    </ul>
                  </nav>
                </div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- ============================================================
     ADDRESS MODAL (ADD & EDIT) - RESPONSIVE & SCROLLABLE
     ============================================================ -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg my-sm-3">
    <?= form_open('profile/add_address', ['id' => 'addressForm', 'class' => 'modal-content shadow-lg']) ?>
      <div class="modal-header">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background: rgba(225, 29, 116, 0.1); color: var(--srl-pink);">
            <i class="bi bi-geo-alt-fill fs-5"></i>
          </div>
          <div>
            <h5 class="modal-title fw-bold text-dark mb-0 fs-6 fs-sm-5" id="addressModalLabel">Add Delivery Address</h5>
            <div class="text-muted" style="font-size: 0.72rem;">Enter recipient details for fast and accurate order shipment.</div>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="address_id" id="modalAddressId" value="">

        <div class="row g-2 g-md-3">
          <div class="col-md-6">
            <label class="cust-form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="full_name" id="modalFullName" class="form-control cust-form-input" placeholder="Recipient's full name" required>
          </div>

          <div class="col-md-6">
            <label class="cust-form-label">Mobile Number <span class="text-danger">*</span></label>
            <input type="tel" name="mobile" id="modalMobile" class="form-control cust-form-input" placeholder="10-digit mobile number" required>
          </div>

          <div class="col-12">
            <label class="cust-form-label">Address Line 1 (Flat, House No., Building, Street) <span class="text-danger">*</span></label>
            <input type="text" name="address_line1" id="modalAddressLine1" class="form-control cust-form-input" placeholder="House/Flat no., building, street" required>
          </div>

          <div class="col-12">
            <label class="cust-form-label">Address Line 2 (Area, Colony, Sector)</label>
            <input type="text" name="address_line2" id="modalAddressLine2" class="form-control cust-form-input" placeholder="Area, colony or road">
          </div>

          <div class="col-md-6">
            <label class="cust-form-label">Landmark (Optional)</label>
            <input type="text" name="landmark" id="modalLandmark" class="form-control cust-form-input" placeholder="e.g. Near City Mall">
          </div>

          <div class="col-md-6">
            <label class="cust-form-label">City <span class="text-danger">*</span></label>
            <input type="text" name="city" id="modalCity" class="form-control cust-form-input" placeholder="City / Town" required>
          </div>

          <div class="col-md-4">
            <label class="cust-form-label">State <span class="text-danger">*</span></label>
            <input type="text" name="state" id="modalState" class="form-control cust-form-input" placeholder="e.g. Gujarat" required>
          </div>

          <div class="col-md-4">
            <label class="cust-form-label">Pincode <span class="text-danger">*</span></label>
            <input type="text" name="pincode" id="modalPincode" class="form-control cust-form-input" placeholder="6-digit pincode" required>
          </div>

          <div class="col-md-4">
            <label class="cust-form-label">Country</label>
            <input type="text" name="country" id="modalCountry" class="form-control cust-form-input" value="India" required>
          </div>

          <div class="col-12 mt-2">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="is_default" value="1" id="modalIsDefault" style="accent-color: var(--srl-pink);">
              <label class="form-check-label text-dark small fw-medium" for="modalIsDefault">
                Set as default delivery address
              </label>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn-srl-primary px-4 py-2 rounded-pill fw-bold" id="saveAddressBtn">Save Address</button>
      </div>
    <?= form_close() ?>
  </div>
</div>

<script>
// Toggle Password Visibility Helper
function togglePasswordVisibility(inputId, btn) {
  const input = document.getElementById(inputId);
  if (!input) return;
  const icon = btn.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    if (icon) {
      icon.classList.remove('bi-eye');
      icon.classList.add('bi-eye-slash');
    }
  } else {
    input.type = 'password';
    if (icon) {
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
    }
  }
}

document.addEventListener('DOMContentLoaded', function () {
  // Sync tabs with URL query params
  const urlParams = new URLSearchParams(window.location.search);
  const tabParam = urlParams.get('tab');
  if (tabParam) {
    const triggerEl = document.querySelector(`#tab-${tabParam}-btn`);
    if (triggerEl) {
      const tab = new bootstrap.Tab(triggerEl);
      tab.show();
    }
  }

  // Profile image live preview & 2MB max check
  const fileInput = document.getElementById('custProfileImageInput');
  const avatarContainer = document.getElementById('customerAvatarContainer');
  const maxBytes = 2 * 1024 * 1024; // 2 MB

  if (fileInput && avatarContainer) {
    fileInput.addEventListener('change', function () {
      const file = this.files[0];
      if (!file) return;

      if (file.size > maxBytes) {
        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
        Swal.fire({
          title: 'File Too Large',
          html: `The selected photo is <strong>${sizeMb} MB</strong>.<br>Maximum allowed profile image size is <strong>2 MB</strong>.`,
          icon: 'warning',
          confirmButtonText: 'Select Smaller Photo',
          customClass: {
            popup: 'srl-swal-popup',
            title: 'srl-swal-title',
            htmlContainer: 'srl-swal-html',
            confirmButton: 'srl-swal-confirm'
          },
          buttonsStyling: false
        });
        this.value = '';
        return;
      }

      // Instant preview in sidebar and profile info tab
      const reader = new FileReader();
      reader.onload = function (e) {
        if (avatarContainer) {
          const initialSpan = document.getElementById('customerAvatarInitial');
          if (initialSpan) initialSpan.style.display = 'none';

          let previewImg = document.getElementById('customerAvatarPreviewImg');
          if (!previewImg) {
            previewImg = document.createElement('img');
            previewImg.id = 'customerAvatarPreviewImg';
            previewImg.className = 'w-100 h-100 object-fit-cover rounded-circle';
            previewImg.alt = 'Avatar Preview';
            avatarContainer.appendChild(previewImg);
          }
          previewImg.src = e.target.result;
          previewImg.style.display = 'block';
          previewImg.style.borderRadius = '50%';

          avatarContainer.style.boxShadow = '0 0 25px rgba(235, 14, 153, 0.8)';
        }
      };
      reader.readAsDataURL(file);
    });
  }

  // SweetAlert for Address Delete Confirmation
  document.querySelectorAll('.delete-address-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      Swal.fire({
        title: 'Delete Address?',
        text: 'Are you sure you want to remove this saved delivery address?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        customClass: {
          popup: 'srl-swal-popup',
          title: 'srl-swal-title',
          htmlContainer: 'srl-swal-html',
          confirmButton: 'btn btn-danger rounded-pill px-4 me-2',
          cancelButton: 'btn btn-secondary rounded-pill px-4'
        },
        buttonsStyling: false
      }).then(result => {
        if (result.isConfirmed) {
          window.location.href = href;
        }
      });
    });
  });

  // Sync URL search param when switching tabs without full page reload
  document.querySelectorAll('#dashNavTabs [data-bs-toggle="pill"]').forEach(tabBtn => {
    tabBtn.addEventListener('shown.bs.tab', function (e) {
      const targetId = e.target.getAttribute('data-bs-target');
      if (targetId) {
        const tabName = targetId.replace('#tab-', '');
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('tab', tabName);
        window.history.replaceState({}, '', newUrl);
      }
    });
  });
});

// SweetAlert Sign Out Confirmation
function confirmSignOut(e) {
  e.preventDefault();
  const target = e.currentTarget;
  const href = target.getAttribute('href');
  Swal.fire({
    title: 'Sign Out Confirmation',
    text: 'Are you sure you want to sign out of your account?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Sign Out',
    cancelButtonText: 'Stay Logged In',
    customClass: {
      popup: 'srl-swal-popup',
      title: 'srl-swal-title',
      confirmButton: 'srl-swal-confirm-danger me-2',
      cancelButton: 'srl-swal-cancel'
    },
    buttonsStyling: false
  }).then(result => {
    if (result.isConfirmed) {
      window.location.href = href;
    }
  });
}

// Modal Helpers
function openAddAddressModal() {
  const modalEl = document.getElementById('addressModal');
  const modal = new bootstrap.Modal(modalEl);
  document.getElementById('addressModalLabel').textContent = 'Add Delivery Address';
  document.getElementById('addressForm').action = '<?= base_url('profile/add_address') ?>';
  document.getElementById('modalAddressId').value = '';
  document.getElementById('modalFullName').value = '<?= html_escape($user->name) ?>';
  document.getElementById('modalMobile').value = '<?= html_escape($user->phone) ?>';
  document.getElementById('modalAddressLine1').value = '';
  document.getElementById('modalAddressLine2').value = '';
  document.getElementById('modalLandmark').value = '';
  document.getElementById('modalCity').value = '';
  document.getElementById('modalState').value = '';
  document.getElementById('modalPincode').value = '';
  document.getElementById('modalCountry').value = 'India';
  document.getElementById('modalIsDefault').checked = false;
  modal.show();
}

function openEditAddressModal(addressId) {
  fetch('<?= base_url('profile/edit_address/') ?>' + addressId, {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
    .then(res => res.json())
    .then(data => {
      if (data.success && data.address) {
        const addr = data.address;
        const modalEl = document.getElementById('addressModal');
        const modal = new bootstrap.Modal(modalEl);
        document.getElementById('addressModalLabel').textContent = 'Edit Delivery Address';
        document.getElementById('addressForm').action = '<?= base_url('profile/edit_address/') ?>' + addr.id;
        document.getElementById('modalAddressId').value = addr.id;
        document.getElementById('modalFullName').value = addr.full_name;
        document.getElementById('modalMobile').value = addr.mobile;
        document.getElementById('modalAddressLine1').value = addr.address_line1;
        document.getElementById('modalAddressLine2').value = addr.address_line2 || '';
        document.getElementById('modalLandmark').value = addr.landmark || '';
        document.getElementById('modalCity').value = addr.city;
        document.getElementById('modalState').value = addr.state;
        document.getElementById('modalPincode').value = addr.pincode;
        document.getElementById('modalCountry').value = addr.country || 'India';
        document.getElementById('modalIsDefault').checked = (parseInt(addr.is_default) === 1);
        modal.show();
      } else {
        Swal.fire({
          title: 'Error',
          text: data.message || 'Unable to fetch address details.',
          icon: 'error',
          customClass: { popup: 'srl-swal-popup' }
        });
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire({
        title: 'Error',
        text: 'Unable to fetch address details.',
        icon: 'error',
        customClass: { popup: 'srl-swal-popup' }
      });
    });
}
</script>
