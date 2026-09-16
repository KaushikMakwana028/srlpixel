<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? html_escape($title) : 'SRL Pixel Admin' ?></title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- SRL Pixel Theme CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/srlpixel-theme.css') ?>">
</head>
<body>

<?php if (isset($auth_layout) && $auth_layout): ?>
  <!-- Fullpage Centered Auth Mode -->
  <div class="auth-page-wrapper">
<?php else: ?>
  <!-- Admin Dashboard Layout (Sidebar + Topbar + Content) -->
  <div class="admin-wrapper">
    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
      <div class="sidebar-brand d-flex justify-content-between align-items-center">
        <a href="<?= base_url('admin/dashboard') ?>" class="d-flex align-items-center text-decoration-none">
          <img src="<?= base_url('assets/images/new_logo.png') ?>" alt="SRL Pixel Logo" onerror="this.onerror=null; this.src='<?= base_url('assets/images/logo.png') ?>';">
        </a>
        <button type="button" class="btn btn-link text-white-50 p-0 border-0 fs-5 d-lg-none" id="sidebarCloseBtn" aria-label="Close sidebar">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>

      <ul class="sidebar-menu">
        <?php $current_uri = uri_string(); ?>
        <li class="menu-item <?= ($current_uri == 'admin/dashboard' || $current_uri == 'admin') ? 'active' : '' ?>">
          <a href="<?= base_url('admin/dashboard') ?>" class="menu-link">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="menu-item <?= (strpos($current_uri, 'admin/categories') === 0) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/categories') ?>" class="menu-link">
            <i class="bi bi-diagram-3"></i>
            <span>Categories</span>
          </a>
        </li>
        <li class="menu-item <?= (strpos($current_uri, 'admin/products') === 0) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/products') ?>" class="menu-link">
            <i class="bi bi-box-seam"></i>
            <span>Products</span>
          </a>
        </li>
        <li class="menu-item <?= (strpos($current_uri, 'admin/orders') === 0) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/orders') ?>" class="menu-link">
            <i class="bi bi-receipt"></i>
            <span>Orders</span>
          </a>
        </li>
        <li class="menu-item <?= (strpos($current_uri, 'admin/customers') === 0) ? 'active' : '' ?>">
          <a href="<?= base_url('admin/customers') ?>" class="menu-link">
            <i class="bi bi-people"></i>
            <span>Customers</span>
          </a>
        </li>
      </ul>

      <div class="sidebar-footer">
        <a href="<?= base_url('admin/logout') ?>" class="btn-sidebar-signout">
          <i class="bi bi-box-arrow-right"></i>
          <span>Sign Out</span>
        </a>
      </div>
    </aside>

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div class="sidebar-backdrop d-lg-none" id="sidebarBackdrop"></div>

    <!-- Main Content Area -->
    <div class="admin-main">
      <!-- Top Navbar / Header -->
      <header class="admin-topbar">
        <div class="d-flex align-items-center gap-2 gap-sm-3">
          <button class="btn btn-sm btn-light border d-lg-none rounded-3 d-inline-flex align-items-center justify-content-center" id="sidebarToggle" type="button" style="width: 38px; height: 38px;" aria-label="Toggle navigation">
            <i class="bi bi-list fs-4 text-dark"></i>
          </button>
          <div class="admin-breadcrumb">
            <span>Admin</span><span class="d-none d-sm-inline"> / </span><span class="active-crumb"><?= isset($breadcrumb) ? html_escape($breadcrumb) : 'Dashboard' ?></span>
          </div>
        </div>

        <?php
          $admin_name = $this->session->userdata('admin_name') ? $this->session->userdata('admin_name') : 'Ravi';
          $admin_email = $this->session->userdata('admin_email') ? $this->session->userdata('admin_email') : 'admin@srlpixel.com';
          $admin_img = $this->session->userdata('admin_profile_image');
          $first_letter = strtoupper(substr($admin_name, 0, 1));
        ?>

        <!-- Topbar Right: User Profile & Dropdown Card -->
        <div class="user-profile-widget">
          <button class="user-profile-btn" id="profileDropdownBtn" type="button">
            <div class="user-profile-avatar">
              <?php if (!empty($admin_img) && file_exists('./uploads/profiles/' . $admin_img)): ?>
                <img src="<?= base_url('uploads/profiles/' . $admin_img) ?>" alt="<?= html_escape($admin_name) ?>" class="w-100 h-100 rounded-circle object-fit-cover">
              <?php else: ?>
                <?= $first_letter ?>
              <?php endif; ?>
            </div>
            <span class="user-profile-name d-none d-sm-inline"><?= html_escape($admin_name) ?></span>
            <i class="bi bi-caret-down-fill text-muted" style="font-size: 0.75rem;"></i>
          </button>

          <!-- Floating Dropdown Card (Matches Screenshot) -->
          <div class="profile-dropdown-card" id="profileDropdownCard">
            <div class="profile-dropdown-header">
              <div class="dropdown-avatar-circle">
                <?php if (!empty($admin_img) && file_exists('./uploads/profiles/' . $admin_img)): ?>
                  <img src="<?= base_url('uploads/profiles/' . $admin_img) ?>" alt="<?= html_escape($admin_name) ?>">
                <?php else: ?>
                  <?= $first_letter ?>
                <?php endif; ?>
              </div>
              <h6><?= html_escape($admin_name) ?></h6>
              <p><?= html_escape($admin_email) ?></p>
              <span class="admin-role-badge">Admin Role</span>
            </div>
            <ul class="profile-dropdown-links">
              <li>
                <a href="<?= base_url('admin/profile') ?>">
                  <i class="bi bi-person"></i>
                  <span>Profile Settings</span>
                </a>
              </li>
              <li>
                <a href="<?= base_url('admin/profile?tab=password') ?>">
                  <i class="bi bi-key"></i>
                  <span>Change Password</span>
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="<?= base_url('admin/logout') ?>" class="text-signout">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </header>

      <!-- Page Content Container -->
      <main class="admin-content">
<?php endif; ?>
