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

<div class="container my-4 my-md-5">
  <div class="row g-4">
    <!-- Left Navigation Column (Matches media_1789561734372.png) -->
    <div class="col-lg-3 col-md-4">
      <div class="cust-dash-sidebar text-center">
        <!-- Avatar with Camera Icon Overlay -->
        <div class="position-relative d-inline-block mb-3">
          <div id="customerAvatarContainer" class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow" style="width: 100px; height: 100px; border: 3px solid var(--srl-pink-glow); background: #231b2e; font-size: 2.4rem; overflow: hidden; margin: 0 auto; position: relative;">
            <?php if (!empty($user->profile_image) && file_exists('./uploads/profiles/' . $user->profile_image)): ?>
              <img id="customerAvatarPreviewImg" src="<?= base_url('uploads/profiles/' . $user->profile_image) ?>" alt="<?= html_escape($user->name) ?>" class="w-100 h-100 object-fit-cover">
            <?php else: ?>
              <span id="customerAvatarInitial"><?= strtoupper(mb_substr(trim($user->name), 0, 1)) ?></span>
            <?php endif; ?>
          </div>
          <!-- Camera Icon Overlay Triggering Profile Image Picker -->
          <label for="custProfileImageInput" class="avatar-camera-btn" title="Upload new photo (Max 2MB)">
            <i class="bi bi-camera-fill"></i>
          </label>
        </div>

        <h5 class="fw-bold text-white mb-1"><?= html_escape($user->name) ?></h5>
        <span class="badge px-3 py-1 mb-4" style="background: rgba(255, 42, 133, 0.15); color: var(--srl-pink-glow); font-size: 0.75rem; font-weight: 700; letter-spacing: 0.8px;">
          <?= !empty($user->shop_name) ? html_escape($user->shop_name) : 'CUSTOMER / RETAILER' ?>
        </span>

        <!-- Navigation Tabs (Profile Info, Saved Addresses, My Orders, Sign Out) -->
        <div class="nav flex-column gap-1" id="dashNavTabs" role="tablist">
          <button class="cust-dash-nav-link <?= (!isset($active_tab) || $active_tab === 'profile') ? 'active' : '' ?>" id="tab-profile-btn" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button" role="tab">
            <i class="bi bi-person-fill fs-5"></i>
            <span>Profile Info</span>
          </button>
          <button class="cust-dash-nav-link <?= (isset($active_tab) && $active_tab === 'addresses') ? 'active' : '' ?>" id="tab-addresses-btn" data-bs-toggle="pill" data-bs-target="#tab-addresses" type="button" role="tab">
            <i class="bi bi-geo-alt-fill fs-5"></i>
            <span>Saved Addresses</span>
          </button>
          <button class="cust-dash-nav-link <?= (isset($active_tab) && $active_tab === 'orders') ? 'active' : '' ?>" id="tab-orders-btn" data-bs-toggle="pill" data-bs-target="#tab-orders" type="button" role="tab">
            <i class="bi bi-receipt fs-5"></i>
            <span>My Orders</span>
          </button>
          <a href="<?= base_url('logout') ?>" class="cust-dash-nav-link text-danger mt-3">
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
             SECTION 1: PROFILE INFO & CHANGE PASSWORD
             ============================================================ -->
        <div class="tab-pane fade <?= (!isset($active_tab) || $active_tab === 'profile') ? 'show active' : '' ?>" id="tab-profile" role="tabpanel">
          <div class="cust-dash-content-card mb-4">
            <h4 class="fw-bold text-white mb-4">Profile Information</h4>

            <?= form_open_multipart('dashboard', ['id' => 'customerProfileForm']) ?>
              <input type="hidden" name="action" value="update_profile">
              <input type="file" name="profile_image" id="custProfileImageInput" class="d-none" accept="image/jpeg,image/png,image/webp,image/gif">

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="cust-form-label">Full Name <span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control cust-dark-input" value="<?= set_value('name', $user->name) ?>" required>
                </div>

                <div class="col-md-6">
                  <label class="cust-form-label">Email Address</label>
                  <input type="email" class="form-control cust-dark-input text-muted" value="<?= html_escape($user->email) ?>" disabled readonly>
                  <span class="text-muted" style="font-size: 0.72rem;">Email cannot be modified.</span>
                </div>

                <div class="col-md-6">
                  <label class="cust-form-label">Mobile Number</label>
                  <input type="text" name="phone" class="form-control cust-dark-input" placeholder="e.g. 9876543210" value="<?= set_value('phone', $user->phone) ?>">
                </div>

                <div class="col-md-6">
                  <label class="cust-form-label">Shop Name (Optional)</label>
                  <input type="text" name="shop_name" class="form-control cust-dark-input" placeholder="e.g. Pixel Lights Store" value="<?= set_value('shop_name', isset($user->shop_name) ? $user->shop_name : '') ?>">
                </div>

                <div class="col-12">
                  <label class="cust-form-label">GST Number (Optional)</label>
                  <input type="text" name="gst_number" class="form-control cust-dark-input" placeholder="e.g. 24AAAAA0000A1Z5" value="<?= set_value('gst_number', isset($user->gst_number) ? $user->gst_number : '') ?>">
                </div>

                <div class="col-12">
                  <label class="cust-form-label">Primary / Billing Address</label>
                  <textarea name="address" rows="3" class="form-control cust-dark-input" placeholder="Enter your full business / billing address"><?= set_value('address', $user->address) ?></textarea>
                </div>

                <div class="col-12 pt-2">
                  <button type="submit" class="btn-srl-primary px-4 py-2">
                    <i class="bi bi-check2-circle me-1"></i>Save Profile
                  </button>
                </div>
              </div>
            <?= form_close() ?>
          </div>

          <!-- Change Password Sub-section (Directly inside Profile) -->
          <div class="cust-dash-content-card">
            <h5 class="fw-bold text-white mb-3"><i class="bi bi-shield-lock me-2" style="color: var(--srl-pink);"></i>Change Account Password</h5>
            <p class="text-muted small mb-4">Ensure your account is using a long, random password to stay secure.</p>

            <?= form_open('dashboard/change_password') ?>
              <div class="row g-3">
                <div class="col-12">
                  <label class="cust-form-label">Current Password <span class="text-danger">*</span></label>
                  <input type="password" name="current_password" class="form-control cust-dark-input" placeholder="Enter your current password" required>
                </div>

                <div class="col-md-6">
                  <label class="cust-form-label">New Password <span class="text-danger">*</span></label>
                  <input type="password" name="new_password" class="form-control cust-dark-input" placeholder="Minimum 6 characters" minlength="6" required>
                </div>

                <div class="col-md-6">
                  <label class="cust-form-label">Confirm New Password <span class="text-danger">*</span></label>
                  <input type="password" name="confirm_password" class="form-control cust-dark-input" placeholder="Re-enter new password" minlength="6" required>
                </div>

                <div class="col-12 pt-2">
                  <button type="submit" class="btn btn-outline-light rounded-pill px-4 py-2">
                    <i class="bi bi-key me-1"></i>Update Password
                  </button>
                </div>
              </div>
            <?= form_close() ?>
          </div>
        </div>

        <!-- ============================================================
             SECTION 2: SAVED ADDRESSES (With Set As Default)
             ============================================================ -->
        <div class="tab-pane fade <?= (isset($active_tab) && $active_tab === 'addresses') ? 'show active' : '' ?>" id="tab-addresses" role="tabpanel">
          <div class="cust-dash-content-card">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-2 border-bottom border-secondary border-opacity-25">
              <div>
                <h4 class="fw-bold text-white mb-1">Saved Addresses</h4>
                <p class="text-muted small mb-0">Manage delivery addresses for seamless and fast checkout.</p>
              </div>
              <button type="button" class="btn-srl-primary px-3 py-2 btn-sm" onclick="openAddAddressModal()">
                <i class="bi bi-plus-lg me-1"></i>Add New Address
              </button>
            </div>

            <?php if (empty($addresses)): ?>
              <div class="text-center py-5">
                <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: rgba(255, 42, 133, 0.1); color: var(--srl-pink);">
                  <i class="bi bi-geo-alt fs-2"></i>
                </div>
                <h5 class="fw-bold text-white mb-1">No Saved Addresses Found</h5>
                <p class="text-muted small mb-3">Add a shipping address so you can place orders smoothly.</p>
                <button type="button" class="btn-srl-primary px-4 py-2" onclick="openAddAddressModal()">
                  <i class="bi bi-plus-circle me-1"></i>Add Address Now
                </button>
              </div>
            <?php else: ?>
              <div class="row g-3">
                <?php foreach ($addresses as $addr): ?>
                  <div class="col-md-6">
                    <div class="address-card h-100 d-flex flex-direction-column justify-content-between <?= $addr->is_default ? 'is-default' : '' ?>">
                      <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <h6 class="fw-bold text-white mb-0"><?= html_escape($addr->full_name) ?></h6>
                          <?php if ($addr->is_default): ?>
                            <span class="badge rounded-pill px-2 py-1" style="background: var(--srl-pink-gradient); color: #fff; font-size: 0.72rem;">
                              <i class="bi bi-check-circle-fill me-1"></i>DEFAULT
                            </span>
                          <?php endif; ?>
                        </div>
                        <p class="text-secondary small mb-1">
                          <i class="bi bi-telephone me-1 text-muted"></i><?= html_escape($addr->mobile) ?>
                        </p>
                        <p class="text-light small mb-2" style="line-height: 1.5;">
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

                      <div class="pt-3 border-top border-secondary border-opacity-25 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <?php if (!$addr->is_default): ?>
                          <a href="<?= base_url('dashboard/set_default_address/' . $addr->id) ?>" class="btn btn-sm btn-outline-info rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                            <i class="bi bi-star me-1"></i>Set as Default
                          </a>
                        <?php else: ?>
                          <span class="text-success small" style="font-size: 0.75rem;">
                            <i class="bi bi-check-all me-1"></i>Primary Address
                          </span>
                        <?php endif; ?>

                        <div class="d-flex gap-2">
                          <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-2 py-1" style="font-size: 0.75rem;" onclick="openEditAddressModal(<?= $addr->id ?>)">
                            <i class="bi bi-pencil me-1"></i>Edit
                          </button>
                          <a href="<?= base_url('dashboard/delete_address/' . $addr->id) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 delete-address-btn" style="font-size: 0.75rem;">
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
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-2 border-bottom border-secondary border-opacity-25">
              <div>
                <h4 class="fw-bold text-white mb-1">My Orders</h4>
                <p class="text-muted small mb-0">Track live orders, dispatch status, and purchase history.</p>
              </div>
              <span class="badge bg-dark border border-secondary text-light px-3 py-2 rounded-pill">
                Total Orders: <?= count($orders) ?>
              </span>
            </div>

            <?php if (empty($orders)): ?>
              <div class="text-center py-5">
                <div class="rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; background: rgba(255, 42, 133, 0.1); color: var(--srl-pink);">
                  <i class="bi bi-bag-x fs-2"></i>
                </div>
                <h5 class="fw-bold text-white mb-1">No Orders Placed Yet</h5>
                <p class="text-muted small mb-3">You haven't made any purchases yet. Discover high-quality pixel LED strips & controllers!</p>
                <a href="<?= base_url('products') ?>" class="btn-srl-primary px-4 py-2">
                  <i class="bi bi-shop me-1"></i>Explore Products
                </a>
              </div>
            <?php else: ?>
              <div class="d-flex flex-column gap-3">
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
                        $status_icon  = 'bi bi-check-circle';
                        break;
                      case 'Packed':
                        $status_class = 'status-badge-packed';
                        $status_icon  = 'bi bi-box-seam';
                        break;
                      case 'Out for Delivery':
                        $status_class = 'status-badge-out-for-delivery';
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
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                      <div>
                        <span class="text-secondary small">Order ID:</span>
                        <span class="fw-bold text-white ms-1">#<?= html_escape($ord->order_number) ?></span>
                        <span class="text-muted small ms-2 d-none d-sm-inline">| <?= date('d M Y, h:i A', strtotime($ord->created_at)) ?></span>
                      </div>
                      <span class="order-status-badge <?= $status_class ?>">
                        <i class="<?= $status_icon ?>"></i> <?= html_escape($ord->order_status) ?>
                      </span>
                    </div>

                    <div class="row align-items-center g-3">
                      <div class="col-md-7">
                        <div class="small text-secondary mb-1">Deliver To:</div>
                        <div class="fw-semibold text-white"><?= html_escape($ord->shipping_full_name) ?></div>
                        <div class="text-muted small text-truncate" style="max-width: 90%;">
                          <?= html_escape($ord->shipping_address_line1) ?>, <?= html_escape($ord->shipping_city) ?>, <?= html_escape($ord->shipping_pincode) ?>
                        </div>
                      </div>

                      <div class="col-md-3 col-6">
                        <div class="small text-secondary mb-1">Total Amount:</div>
                        <div class="fw-extrabold fs-5" style="color: var(--srl-pink);">
                          ₹<?= number_format($ord->total_amount, 2) ?>
                        </div>
                        <div class="text-muted" style="font-size: 0.72rem;">
                          <?= html_escape($ord->payment_method) ?>
                        </div>
                      </div>

                      <div class="col-md-2 col-6 text-end">
                        <a href="<?= base_url('dashboard/order/' . $ord->id) ?>" class="btn-srl-primary px-3 py-2 btn-sm text-nowrap">
                          View Details <i class="bi bi-chevron-right ms-1"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- ============================================================
     ADDRESS MODAL (ADD & EDIT)
     ============================================================ -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content text-white" style="background: #141720; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 18px;">
      <div class="modal-header border-secondary border-opacity-25">
        <h5 class="modal-title fw-bold" id="addressModalLabel">Add New Address</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('dashboard/add_address', ['id' => 'addressForm']) ?>
        <div class="modal-body p-4">
          <input type="hidden" name="address_id" id="modalAddressId" value="">

          <div class="row g-3">
            <div class="col-md-6">
              <label class="cust-form-label">Full Name <span class="text-danger">*</span></label>
              <input type="text" name="full_name" id="modalFullName" class="form-control cust-dark-input" placeholder="Recipient's full name" required>
            </div>

            <div class="col-md-6">
              <label class="cust-form-label">Mobile Number <span class="text-danger">*</span></label>
              <input type="text" name="mobile" id="modalMobile" class="form-control cust-dark-input" placeholder="10-digit mobile number" required>
            </div>

            <div class="col-12">
              <label class="cust-form-label">Address Line 1 (Flat, House No., Building, Street) <span class="text-danger">*</span></label>
              <input type="text" name="address_line1" id="modalAddressLine1" class="form-control cust-dark-input" placeholder="House/Flat no., building, street" required>
            </div>

            <div class="col-12">
              <label class="cust-form-label">Address Line 2 (Area, Colony, Sector)</label>
              <input type="text" name="address_line2" id="modalAddressLine2" class="form-control cust-dark-input" placeholder="Area, colony or road">
            </div>

            <div class="col-md-6">
              <label class="cust-form-label">Landmark (Optional)</label>
              <input type="text" name="landmark" id="modalLandmark" class="form-control cust-dark-input" placeholder="e.g. Near City Mall">
            </div>

            <div class="col-md-6">
              <label class="cust-form-label">City <span class="text-danger">*</span></label>
              <input type="text" name="city" id="modalCity" class="form-control cust-dark-input" placeholder="City / Town" required>
            </div>

            <div class="col-md-4">
              <label class="cust-form-label">State <span class="text-danger">*</span></label>
              <input type="text" name="state" id="modalState" class="form-control cust-dark-input" placeholder="e.g. Gujarat" required>
            </div>

            <div class="col-md-4">
              <label class="cust-form-label">Pincode <span class="text-danger">*</span></label>
              <input type="text" name="pincode" id="modalPincode" class="form-control cust-dark-input" placeholder="6-digit pincode" required>
            </div>

            <div class="col-md-4">
              <label class="cust-form-label">Country</label>
              <input type="text" name="country" id="modalCountry" class="form-control cust-dark-input" value="India" required>
            </div>

            <div class="col-12 mt-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="is_default" value="1" id="modalIsDefault">
                <label class="form-check-label text-light small" for="modalIsDefault">
                  Set as default delivery address
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-secondary border-opacity-25">
          <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-srl-primary px-4 py-2" id="saveAddressBtn">Save Address</button>
        </div>
      <?= form_close() ?>
    </div>
  </div>
</div>

<script>
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

      // Instant preview
      const reader = new FileReader();
      reader.onload = function (e) {
        const initialSpan = document.getElementById('customerAvatarInitial');
        if (initialSpan) initialSpan.style.display = 'none';

        let previewImg = document.getElementById('customerAvatarPreviewImg');
        if (!previewImg) {
          previewImg = document.createElement('img');
          previewImg.id = 'customerAvatarPreviewImg';
          previewImg.className = 'w-100 h-100 object-fit-cover';
          previewImg.alt = 'Avatar Preview';
          avatarContainer.appendChild(previewImg);
        }
        previewImg.src = e.target.result;
        previewImg.style.display = 'block';

        avatarContainer.style.boxShadow = '0 0 25px rgba(235, 14, 153, 0.8)';
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
});

// Modal Helpers
function openAddAddressModal() {
  const modalEl = document.getElementById('addressModal');
  const modal = new bootstrap.Modal(modalEl);
  document.getElementById('addressModalLabel').textContent = 'Add New Address';
  document.getElementById('addressForm').action = '<?= base_url('dashboard/add_address') ?>';
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
  fetch('<?= base_url('dashboard/edit_address/') ?>' + addressId, {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
    .then(res => res.json())
    .then(data => {
      if (data.success && data.address) {
        const addr = data.address;
        const modalEl = document.getElementById('addressModal');
        const modal = new bootstrap.Modal(modalEl);
        document.getElementById('addressModalLabel').textContent = 'Edit Saved Address';
        document.getElementById('addressForm').action = '<?= base_url('dashboard/edit_address/') ?>' + addr.id;
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
        Swal.fire('Error', data.message || 'Unable to fetch address details.', 'error');
      }
    })
    .catch(err => {
      console.error(err);
      Swal.fire('Error', 'Unable to fetch address details.', 'error');
    });
}
</script>
