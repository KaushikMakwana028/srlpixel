<?php if (isset($auth_layout) && $auth_layout): ?>
  </div><!-- .auth-page-wrapper -->
<?php else: ?>
  </main>

  <footer class="customer-footer">
    <div class="container">
      <div class="row g-4 mb-4">
        <!-- Col 1: Brand Info & Social -->
        <div class="col-lg-5 col-md-12">
          <img src="<?= base_url('assets/images/new_logo.png') ?>" alt="SRL Pixel Logo" style="max-height: 48px; width: auto; object-fit: contain; margin-bottom: 16px;" onerror="this.onerror=null; this.src='<?= base_url('assets/images/logo.png') ?>';">
          <p class="footer-desc mb-3">
            SRL PIXEL LED'S GLOWING HUB - India's premier destination for high-grade addressable RGB pixel LED strips, smart programmable controllers, neon flex ropes, and architectural power converters.
          </p>
          <div class="d-flex gap-2 mt-3">
            <a href="#" class="footer-social-btn" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="footer-social-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="footer-social-btn" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
            <a href="#" class="footer-social-btn" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
          </div>
        </div>

        <!-- Col 2: Navigation Links -->
        <div class="col-lg-2 col-6">
          <h6 class="footer-title">Navigation</h6>
          <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
            <li><a href="<?= base_url() ?>" class="footer-link"><i class="bi bi-chevron-right" style="font-size: 0.7rem; color: var(--srl-pink);"></i>Home</a></li>
            <li><a href="<?= base_url('categories') ?>" class="footer-link"><i class="bi bi-chevron-right" style="font-size: 0.7rem; color: var(--srl-pink);"></i>Categories</a></li>
            <li><a href="<?= base_url('products') ?>" class="footer-link"><i class="bi bi-chevron-right" style="font-size: 0.7rem; color: var(--srl-pink);"></i>All Products</a></li>
            <li><a href="<?= base_url('cart') ?>" class="footer-link"><i class="bi bi-chevron-right" style="font-size: 0.7rem; color: var(--srl-pink);"></i>Shopping Cart</a></li>
            <li><a href="<?= base_url('dashboard') ?>" class="footer-link"><i class="bi bi-chevron-right" style="font-size: 0.7rem; color: var(--srl-pink);"></i>My Account</a></li>
          </ul>
        </div>

        <!-- Col 3: Product Categories -->
        <div class="col-lg-2 col-6">
          <h6 class="footer-title">Categories</h6>
          <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
            <li><a href="<?= base_url('category/1') ?>" class="footer-link"><i class="bi bi-chevron-right" style="font-size: 0.7rem; color: var(--srl-pink);"></i>Pixel LED Strips</a></li>
            <li><a href="<?= base_url('category/2') ?>" class="footer-link"><i class="bi bi-chevron-right" style="font-size: 0.7rem; color: var(--srl-pink);"></i>LED Neon Flex</a></li>
            <li><a href="<?= base_url('category/3') ?>" class="footer-link"><i class="bi bi-chevron-right" style="font-size: 0.7rem; color: var(--srl-pink);"></i>Pixel Controllers</a></li>
            <li><a href="<?= base_url('products') ?>" class="footer-link"><i class="bi bi-chevron-right" style="font-size: 0.7rem; color: var(--srl-pink);"></i>LED Accessories</a></li>
          </ul>
        </div>

        <!-- Col 4: Contact Info -->
        <div class="col-lg-3 col-md-12">
          <h6 class="footer-title">Get In Touch</h6>
          <div class="footer-contact-item">
            <i class="bi bi-geo-alt-fill" style="color: var(--srl-pink-glow) !important;"></i>
            <span>Ahmedabad, Gujarat, India - 380001</span>
          </div>
          <div class="footer-contact-item">
            <i class="bi bi-envelope-fill text-primary"></i>
            <span>support@srlpixel.com</span>
          </div>
          <div class="footer-contact-item">
            <i class="bi bi-telephone-fill text-success"></i>
            <span>+91 98765 43210</span>
          </div>
          <div class="footer-contact-item">
            <i class="bi bi-clock-fill text-warning"></i>
            <span>Mon - Sat: 9:30 AM - 7:30 PM</span>
          </div>
        </div>
      </div>

      <!-- Bottom Bar -->
      <div class="footer-bottom-bar d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>&copy; <?= date('Y') ?> <strong class="text-white">SRL PIXEL LED'S GLOWING HUB</strong>. All rights reserved.</span>
        <span class="d-none d-sm-inline"><i class="bi bi-shield-check text-success me-1"></i>100% Verified Quality & Express Dispatch</span>
      </div>
    </div>
  </footer>

  <!-- Mobile Fixed Bottom Navigation Bar (Visible on mobile screens <= 768px) -->
  <nav class="srl-mobile-bottom-nav d-md-none">
    <a href="<?= base_url() ?>" class="srl-bottom-nav-item <?= (uri_string() == '' || uri_string() == 'home') ? 'active' : '' ?>">
      <i class="bi <?= (uri_string() == '' || uri_string() == 'home') ? 'bi-house-door-fill' : 'bi-house-door' ?>"></i>
      <span>Home</span>
    </a>
    <a href="<?= base_url('categories') ?>" class="srl-bottom-nav-item <?= (strpos(uri_string(), 'categor') !== false) ? 'active' : '' ?>">
      <i class="bi <?= (strpos(uri_string(), 'categor') !== false) ? 'bi-grid-fill' : 'bi-grid' ?>"></i>
      <span>Category</span>
    </a>
    <a href="<?= base_url('products') ?>" class="srl-bottom-nav-item <?= (strpos(uri_string(), 'product') !== false) ? 'active' : '' ?>">
      <i class="bi <?= (strpos(uri_string(), 'product') !== false) ? 'bi-box-seam-fill' : 'bi-box-seam' ?>"></i>
      <span>Product</span>
    </a>
    <a href="<?= $this->session->userdata('user_logged_in') ? base_url('dashboard') : base_url('login') ?>" class="srl-bottom-nav-item <?= (uri_string() == 'dashboard' || uri_string() == 'login' || uri_string() == 'register') ? 'active' : '' ?>">
      <i class="bi <?= (uri_string() == 'dashboard' || uri_string() == 'login' || uri_string() == 'register') ? 'bi-person-fill' : 'bi-person' ?>"></i>
      <span>Profile</span>
    </a>
  </nav>

  <!-- High-Resolution Lightbox Modal for Large Image Previews -->
  <div class="modal fade" id="srlImageLightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content bg-dark text-white border-0 shadow-lg rounded-4 overflow-hidden" style="border: 1px solid rgba(255,42,133,0.3) !important;">
        <div class="modal-header border-0 py-3 px-4" style="background: rgba(18,21,30,0.95);">
          <h6 class="modal-title fw-bold" id="lightboxCaption">Product Photo Preview</h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4 text-center d-flex align-items-center justify-content-center" style="min-height: 400px; background: #0c0e14;">
          <img src="" alt="Product Large View" id="lightboxBigImage" class="img-fluid rounded-3" style="max-height: 65vh; object-fit: contain;">
        </div>
        <div class="modal-footer border-0 py-2 px-4 justify-content-between" style="background: rgba(18,21,30,0.95);">
          <small class="text-white-50"><i class="bi bi-arrows-fullscreen me-1"></i>High-resolution SRL Pixel image view</small>
          <button type="button" class="btn btn-sm btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Password Visibility Toggle
  document.querySelectorAll('.password-toggle').forEach(function (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      const targetId = this.getAttribute('data-target');
      const input = document.getElementById(targetId);
      const icon = this.querySelector('i');
      if (input) {
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
    });
  });

  // SRL Custom SweetAlert2 Theme Helper
  function srlAlert(options) {
    const defaults = {
      customClass: {
        popup: 'srl-swal-popup',
        title: 'srl-swal-title',
        htmlContainer: 'srl-swal-html',
        confirmButton: 'srl-swal-confirm',
        cancelButton: 'srl-swal-cancel'
      },
      buttonsStyling: false
    };
    return Swal.fire(Object.assign({}, defaults, options));
  }

  // Flash Message SweetAlert Notifications
  <?php if ($this->session->flashdata('success')): ?>
    srlAlert({
      icon: 'success',
      title: 'Success!',
      text: <?= json_encode($this->session->flashdata('success')) ?>,
      confirmButtonText: 'Great!',
      timer: 3500
    });
  <?php endif; ?>

  <?php if ($this->session->flashdata('error')): ?>
    srlAlert({
      icon: 'error',
      title: 'Attention',
      text: <?= json_encode($this->session->flashdata('error')) ?>,
      confirmButtonText: 'Understood'
    });
  <?php endif; ?>

  <?php if ($this->session->flashdata('warning')): ?>
    srlAlert({
      icon: 'warning',
      title: 'Notice',
      text: <?= json_encode($this->session->flashdata('warning')) ?>,
      confirmButtonText: 'Got It'
    });
  <?php endif; ?>

  <?php if (validation_errors()): ?>
    srlAlert({
      icon: 'error',
      title: 'Validation Notice',
      html: <?= json_encode(validation_errors('<div class="mb-1 text-start"><i class="bi bi-dot me-1"></i>', '</div>')) ?>,
      confirmButtonText: 'Correct Details'
    });
  <?php endif; ?>

  // SweetAlert Sign Out Confirmation for Customer Links
  document.querySelectorAll('a[href*="/logout"]:not([href*="admin"])').forEach(function (logoutLink) {
    logoutLink.addEventListener('click', function (e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      srlAlert({
        title: 'Sign Out?',
        text: 'Are you sure you want to log out from your customer account?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-box-arrow-right me-1"></i> Yes, Log Out',
        cancelButtonText: 'Cancel'
      }).then(function (result) {
        if (result.isConfirmed) {
          window.location.href = href;
        }
      });
    });
  });

  // Global Add To Cart Handler (Home, Categories, Products listing)
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-add-to-cart');
    if (btn) {
      const prodId = btn.getAttribute('data-id');
      const prodName = btn.getAttribute('data-name') || 'Item';
      if (!prodId) return;

      const formData = new FormData();
      formData.append('product_id', prodId);
      formData.append('quantity', 1);

      fetch('<?= base_url('cart/add') ?>', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(res => res.json())
        .then(data => {
          if (data.require_login) {
            Swal.fire({
              title: 'Sign In Required',
              html: 'Please sign in to your customer account to add items to your cart and checkout.',
              icon: 'info',
              showCancelButton: true,
              confirmButtonText: '<i class="bi bi-box-arrow-in-right me-1"></i> Sign In',
              cancelButtonText: 'Continue Browsing',
              customClass: {
                popup: 'srl-swal-popup',
                confirmButton: 'srl-swal-confirm',
                cancelButton: 'srl-swal-cancel'
              },
              buttonsStyling: false
            }).then(res => {
              if (res.isConfirmed) {
                window.location.href = data.login_url || '<?= base_url('login') ?>';
              }
            });
          } else if (data.success) {
            document.querySelectorAll('.cart-badge-count').forEach(badge => {
              badge.innerText = data.cart_count;
            });
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: data.message || `"${prodName}" added to cart!`,
              showConfirmButton: false,
              timer: 2500,
              customClass: {
                popup: 'srl-swal-toast'
              }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Notice',
              text: data.message || 'Unable to add item to cart.',
              customClass: { popup: 'srl-swal-popup', confirmButton: 'srl-swal-confirm' },
              buttonsStyling: false
            });
          }
        })
        .catch(err => console.error('Cart add error:', err));
    }
  });
});
</script>
</body>
</html>
