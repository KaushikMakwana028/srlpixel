<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? html_escape($title) : 'SRL Pixel LED\'s Glowing Hub' ?></title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- SRL Pixel Theme CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/srlpixel-theme.css?v=' . (file_exists(FCPATH . 'assets/css/srlpixel-theme.css') ? filemtime(FCPATH . 'assets/css/srlpixel-theme.css') : time())) ?>">
</head>
<body class="d-flex flex-column min-vh-100 <?= !isset($auth_layout) ? 'srl-has-bottom-nav' : '' ?>" data-user-logged-in="<?= $this->session->userdata('user_logged_in') ? '1' : '0' ?>" data-base-url="<?= base_url() ?>">

<?php
  $header_cart_count = 0;
  if ($this->session->userdata('user_logged_in') && $this->session->userdata('user_role') == 0) {
    $u_id = (int)$this->session->userdata('user_id');
    if (isset($this->General_model)) {
      $user_cart_rows = $this->General_model->getAll('cart', ['user_id' => $u_id]);
      if (!empty($user_cart_rows)) {
        foreach ($user_cart_rows as $c_row) {
          $header_cart_count += (int)$c_row->quantity;
        }
      }
    }
  }
  $is_logged_in = ($this->session->userdata('user_logged_in') && $this->session->userdata('user_role') == 0);
  $user_name = $this->session->userdata('user_name') ?: 'User';
  $user_email = $this->session->userdata('user_email') ?: '';
  $user_profile_img = $this->session->userdata('user_profile_image');
  $user_initial = strtoupper(mb_substr(trim($user_name), 0, 1));
  if (empty($user_initial)) {
    $user_initial = 'U';
  }
?>

<?php if (isset($auth_layout) && $auth_layout): ?>
  <!-- Centered Dark & Pink Glowing Auth Card Mode -->
  <div class="auth-page-wrapper flex-grow-1">
<?php else: ?>
  <!-- Standard Customer Portal Navigation Bar -->
  <nav class="navbar navbar-expand-md customer-navbar sticky-top">
    <div class="container d-flex align-items-center justify-content-between">
      <!-- Left: Brand Logo -->
      <a class="navbar-brand d-flex align-items-center gap-2 m-0 p-0" href="<?= base_url() ?>">
        <img src="<?= base_url('assets/images/new_logo2.png') ?>" alt="SRL Pixel Logo" class="customer-brand-logo" onerror="this.onerror=null; this.src='<?= base_url('assets/images/new_logo.png') ?>';">
      </a>

      <!-- Center: Desktop Navigation Links (Hidden on mobile) -->
      <ul class="navbar-nav d-none d-md-flex flex-row gap-1 ms-4 me-auto">
        <li class="nav-item">
          <a class="nav-link customer-nav-link <?= (uri_string() == '' || uri_string() == 'home') ? 'active' : '' ?>" href="<?= base_url() ?>">
            <i class="bi bi-house-door me-1"></i>Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link customer-nav-link <?= (strpos(uri_string(), 'categor') !== false) ? 'active' : '' ?>" href="<?= base_url('categories') ?>">
            <i class="bi bi-grid me-1"></i>Categories
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link customer-nav-link <?= (strpos(uri_string(), 'product') !== false) ? 'active' : '' ?>" href="<?= base_url('products') ?>">
            <i class="bi bi-box-seam me-1"></i>Products
          </a>
        </li>
      </ul>

      <!-- Right: Action Buttons (Cart & Profile - visible on BOTH Mobile & Desktop) -->
      <div class="d-flex align-items-center gap-2">
        <!-- Shopping Cart Circular Icon Button with Live Count Badge -->
        <a href="<?= base_url('cart') ?>" class="nav-icon-circle-btn position-relative" title="View Shopping Cart" id="headerCartBtn">
          <i class="bi bi-cart3"></i>
          <span class="nav-cart-badge cart-badge-count cart-badge-dot" id="headerCartBadge" style="<?= ($header_cart_count > 0) ? 'display:flex !important;' : 'display:none !important;' ?>"><?= $header_cart_count ?></span>
        </a>

        <!-- Profile Avatar / Dropdown Button (COMMENTED OUT AS REQUESTED - DO NOT REMOVE) -->
        <?php /*
        <div class="dropdown">
          <?php if ($is_logged_in): ?>
            <!-- Logged In User Avatar with Initial, First Name & Chevron -->
            <button class="nav-avatar-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="profileDropdownBtn">
              <span class="nav-avatar-circle overflow-hidden p-0 d-inline-flex align-items-center justify-content-center">
                <?php if (!empty($user_profile_img) && file_exists('./uploads/profiles/' . $user_profile_img)): ?>
                  <img src="<?= base_url('uploads/profiles/' . $user_profile_img) ?>" alt="<?= html_escape($user_name) ?>" class="w-100 h-100 object-fit-cover rounded-circle">
                <?php else: ?>
                  <?= html_escape($user_initial) ?>
                <?php endif; ?>
              </span>
              <span class="nav-user-firstname d-none d-sm-inline"><?= html_escape(explode(' ', trim($user_name))[0]) ?></span>
              <i class="bi bi-chevron-down nav-dropdown-chevron"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-2 rounded-4" aria-labelledby="profileDropdownBtn" id="profileDropdownMenu">
              <li class="px-3 py-2 border-bottom mb-1" style="border-color: rgba(255,255,255,0.08) !important;">
                <div class="fw-bold text-white small"><?= html_escape($user_name) ?></div>
                <div class="small text-truncate" style="font-size: 0.76rem; color: #94a3b8 !important;"><?= html_escape($user_email) ?></div>
              </li>
              <li>
                <a class="dropdown-item srl-dropdown-item py-2 d-flex align-items-center gap-2" href="<?= base_url('profile') ?>">
                  <i class="bi bi-person-circle text-pink"></i><span>My Profile</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item srl-dropdown-item py-2 d-flex align-items-center gap-2" href="<?= base_url('profile?tab=orders') ?>">
                  <i class="bi bi-box-seam text-pink"></i><span>My Orders</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item srl-dropdown-item py-2 d-flex align-items-center gap-2" href="<?= base_url('profile?tab=addresses') ?>">
                  <i class="bi bi-geo-alt text-pink"></i><span>Saved Addresses</span>
                </a>
              </li>
              <li><hr class="dropdown-divider my-1" style="border-color: rgba(255,255,255,0.08) !important;"></li>
              <li>
                <a class="dropdown-item srl-dropdown-item srl-dropdown-signout py-2 d-flex align-items-center gap-2" href="<?= base_url('logout') ?>">
                  <i class="bi bi-box-arrow-right"></i><span>Sign Out</span>
                </a>
              </li>
            </ul>
          <?php endif; ?>
        </div>
        */ ?>
        <?php if (!$is_logged_in): ?>
          <!-- Direct Login Button for Guest User -->
          <a href="<?= base_url('login') ?>" class="btn-srl-primary rounded-pill px-3 py-1 fw-bold d-inline-flex align-items-center gap-1 text-decoration-none" style="font-size: 0.85rem;" title="Sign In">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Login</span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <main class="flex-grow-1 py-4">
<?php endif; ?>
