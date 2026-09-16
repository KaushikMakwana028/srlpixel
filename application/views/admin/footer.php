<?php if (isset($auth_layout) && $auth_layout): ?>
  </div><!-- .auth-page-wrapper -->
<?php else: ?>
      </main><!-- .admin-content -->
    </div><!-- .admin-main -->
  </div><!-- .admin-wrapper -->
<?php endif; ?>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Topbar Profile Dropdown Toggle
  const profileBtn = document.getElementById('profileDropdownBtn');
  const profileCard = document.getElementById('profileDropdownCard');

  if (profileBtn && profileCard) {
    profileBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      profileCard.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
      if (!profileCard.contains(e.target) && !profileBtn.contains(e.target)) {
        profileCard.classList.remove('show');
      }
    });
  }

  // Sidebar Toggle for Mobile with Backdrop, Close Button & Menu Link Close
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
  const sidebarBackdrop = document.getElementById('sidebarBackdrop');
  const adminSidebar = document.getElementById('adminSidebar');

  function openSidebar() {
    if (adminSidebar) adminSidebar.classList.add('show');
    if (sidebarBackdrop) sidebarBackdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    if (adminSidebar) adminSidebar.classList.remove('show');
    if (sidebarBackdrop) sidebarBackdrop.classList.remove('show');
    document.body.style.overflow = '';
  }

  if (sidebarToggle && adminSidebar) {
    sidebarToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      if (adminSidebar.classList.contains('show')) {
        closeSidebar();
      } else {
        openSidebar();
      }
    });
  }

  if (sidebarCloseBtn) {
    sidebarCloseBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      closeSidebar();
    });
  }

  if (sidebarBackdrop) {
    sidebarBackdrop.addEventListener('click', function () {
      closeSidebar();
    });
  }

  // Auto-close sidebar on mobile when a navigation menu link is clicked
  document.querySelectorAll('.sidebar-menu .menu-link').forEach(function (link) {
    link.addEventListener('click', function () {
      if (window.innerWidth < 992) {
        closeSidebar();
      }
    });
  });

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

  // SRL Custom SweetAlert2 Theme Config Helper
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
      title: 'Validation Errors',
      html: <?= json_encode(validation_errors('<div class="mb-1 text-start"><i class="bi bi-dot me-1"></i>', '</div>')) ?>,
      confirmButtonText: 'Correct Inputs'
    });
  <?php endif; ?>

  // SweetAlert Sign Out Confirmation for Admin Links
  document.querySelectorAll('a[href*="admin/logout"]').forEach(function (logoutLink) {
    logoutLink.addEventListener('click', function (e) {
      e.preventDefault();
      const href = this.getAttribute('href');
      srlAlert({
        title: 'Sign Out Administrator?',
        text: 'Are you sure you want to end your active administrator session?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-box-arrow-right me-1"></i> Yes, Sign Out',
        cancelButtonText: 'Cancel'
      }).then(function (result) {
        if (result.isConfirmed) {
          window.location.href = href;
        }
      });
    });
  });
});
</script>
</body>
</html>
