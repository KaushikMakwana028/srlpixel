<style>
/* ============================================================
   HOME VIEW STYLES
   ============================================================ */

/* Hero Banner Carousel */
.srl-hero-carousel,
.srl-full-banner-carousel {
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12);
  border: 1px solid rgba(255, 42, 133, 0.25);
  position: relative;
  background: #0d1017;
  cursor: grab;
  user-select: none;
  -webkit-user-select: none;
}
.srl-full-banner-carousel.is-dragging {
  cursor: grabbing !important;
}

.srl-full-banner-card {
  position: relative;
  width: 100%;
  height: 480px;
  overflow: hidden;
}

.srl-full-banner-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
  transition: transform 6s ease;
}

.carousel-item.active .srl-full-banner-img {
  transform: scale(1.03);
}

.srl-full-banner-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(90deg, rgba(13, 16, 23, 0.94) 0%, rgba(13, 16, 23, 0.76) 42%, rgba(13, 16, 23, 0.2) 75%, rgba(13, 16, 23, 0) 100%);
  z-index: 2;
}

.srl-full-banner-content {
  color: #ffffff;
  padding: 24px 0;
  text-shadow: 0 2px 12px rgba(0, 0, 0, 0.7);
}

.srl-banner-badge {
  background: rgba(255, 42, 133, 0.25);
  color: var(--srl-pink-glow);
  border: 1px solid rgba(255, 42, 133, 0.45);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  font-size: 0.8rem;
  letter-spacing: 0.5px;
}

.srl-banner-heading {
  letter-spacing: -0.5px;
  line-height: 1.15;
  font-size: 2.35rem;
}

.srl-banner-sub {
  font-size: 0.98rem;
  line-height: 1.5;
  max-width: 520px;
}

.srl-banner-btn {
  padding: 10px 24px;
  font-weight: 700;
  letter-spacing: 0.3px;
  font-size: 0.95rem;
  transition: all 0.25s ease;
}

@media (max-width: 991.98px) {
  .srl-full-banner-card {
    height: 340px;
  }
  .srl-banner-heading {
    font-size: 1.65rem;
  }
}

@media (max-width: 767.98px) {
  .srl-hero-carousel,
  .srl-full-banner-carousel {
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
  }
  .srl-full-banner-card {
    height: clamp(170px, 48vw, 225px);
  }
  .srl-full-banner-overlay {
    background: linear-gradient(90deg, rgba(13, 16, 23, 0.84) 0%, rgba(13, 16, 23, 0.5) 50%, rgba(13, 16, 23, 0.08) 85%, transparent 100%) !important;
    align-items: center !important;
  }
  .srl-full-banner-content {
    padding: 8px 0 !important;
  }
  .srl-banner-heading {
    font-size: clamp(0.92rem, 3.6vw, 1.18rem) !important;
    line-height: 1.22 !important;
    margin-bottom: 6px !important;
    font-weight: 800 !important;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.9);
    max-width: 82% !important;
  }
  .srl-banner-badge {
    font-size: 0.58rem !important;
    padding: 2px 8px !important;
    margin-bottom: 5px !important;
    border-radius: 20px !important;
  }
  .srl-banner-btn {
    font-size: 0.74rem !important;
    padding: 5px 14px !important;
    font-weight: 700 !important;
    box-shadow: 0 3px 10px rgba(225, 29, 116, 0.4) !important;
  }
  .carousel-indicators {
    bottom: 3px !important;
    margin-bottom: 0 !important;
  }
  .carousel-indicators [data-bs-target] {
    width: 5px;
    height: 5px;
    margin: 0 2px;
  }
  .carousel-indicators .active {
    width: 14px;
    height: 5px;
  }
}

.carousel-control-prev-srl,
.carousel-control-next-srl {
  width: 46px;
  height: 46px;
  background: rgba(18, 21, 30, 0.78);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  color: #ffffff;
  border-radius: 50%;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.45);
  border: 1px solid rgba(255, 42, 133, 0.35);
  transition: all 0.25s ease;
  position: absolute;
  z-index: 5;
  cursor: pointer;
}
.carousel-control-prev-srl { left: 20px; }
.carousel-control-next-srl { right: 20px; }

.carousel-control-prev-srl:hover,
.carousel-control-next-srl:hover {
  background: var(--srl-pink-glow);
  border-color: var(--srl-pink-glow);
  color: #ffffff;
  box-shadow: 0 0 20px rgba(255, 42, 133, 0.65);
  transform: translateY(-50%) scale(1.1);
}

.carousel-indicators [data-bs-target] {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  margin: 0 5px;
  background-color: rgba(255, 255, 255, 0.5);
  border: none;
  transition: all 0.25s ease;
}

.carousel-indicators .active {
  width: 28px;
  border-radius: 6px;
  background: var(--srl-pink-gradient);
}

/* Category Strip & Continuous Marquee */
.category-strip-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-decoration: none;
  transition: all 0.25s ease;
  padding: 10px;
  border-radius: 16px;
}

.category-strip-img-wrap {
  width: 95px;
  height: 95px;
  border-radius: 50%;
  background: #0d1017;
  border: 2.5px solid rgba(255, 42, 133, 0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  flex-shrink: 0;
}

.category-strip-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
  display: block;
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.category-strip-card:hover .category-strip-img-wrap {
  border-color: var(--srl-pink);
  box-shadow: 0 0 22px rgba(255, 42, 133, 0.55);
  transform: translateY(-4px);
}

.category-strip-card:hover .category-strip-img-wrap img {
  transform: scale(1.12);
}

.category-strip-name {
  margin-top: 10px;
  font-weight: 700;
  font-size: 0.88rem;
  color: var(--srl-text-main);
  text-align: center;
  transition: color 0.2s ease;
}

.category-strip-card:hover .category-strip-name {
  color: var(--srl-pink);
}

/* Category Header Enhancements */
.category-header-row {
  width: 100%;
}

.category-header-icon-box {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: rgba(255, 42, 133, 0.12);
  color: var(--srl-pink);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  box-shadow: 0 4px 14px rgba(255, 42, 133, 0.18);
  flex-shrink: 0;
  transition: all 0.3s ease;
}

.category-header-icon-box:hover {
  background: var(--srl-pink);
  color: #ffffff;
  transform: rotate(6deg) scale(1.05);
}

.category-header-title {
  font-size: 1.15rem;
  letter-spacing: -0.3px;
}

.srl-category-view-all-btn {
  color: var(--srl-pink);
  font-weight: 700;
  font-size: 0.84rem;
  padding: 6px 16px;
  border-radius: 20px;
  background: rgba(255, 42, 133, 0.08);
  border: 1px solid rgba(255, 42, 133, 0.22);
  transition: all 0.25s ease;
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  gap: 5px;
  flex-shrink: 0;
}

.srl-category-view-all-btn:hover {
  background: var(--srl-pink);
  color: #ffffff;
  border-color: var(--srl-pink);
  box-shadow: 0 4px 16px rgba(255, 42, 133, 0.38);
  transform: translateX(3px);
}

@media (max-width: 576px) {
  .category-header-row {
    gap: 6px !important;
  }
  .category-header-icon-box {
    width: 28px !important;
    height: 28px !important;
    font-size: 0.85rem !important;
    border-radius: 8px !important;
  }
  .category-header-title {
    font-size: 0.94rem !important;
    letter-spacing: -0.2px !important;
  }
  .srl-category-view-all-btn {
    padding: 4px 10px !important;
    font-size: 0.74rem !important;
    gap: 3px !important;
  }
}

/* Category Horizontal Slider (Touch-Friendly, Native Swipe, No Auto-Scroll Glitch) */
.srl-category-slider-container {
  width: 100%;
  overflow-x: auto;
  overflow-y: hidden;
  position: relative;
  padding: 6px 2px 14px 2px;
  -webkit-overflow-scrolling: touch;
  scrollbar-width: none;
  -ms-overflow-style: none;
  cursor: grab;
  user-select: none;
  -webkit-user-select: none;
}

.srl-category-slider-container::-webkit-scrollbar {
  display: none;
}

.srl-category-slider-container.is-dragging {
  cursor: grabbing !important;
}

.srl-category-slider-track {
  display: flex;
  align-items: flex-start;
  gap: 18px;
  width: max-content;
  padding: 2px 4px;
}

.srl-category-slider-item {
  flex: 0 0 105px;
  text-align: center;
}

.srl-category-slider-item .category-strip-card {
  padding: 4px;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-decoration: none;
}

.srl-category-slider-item .category-strip-img-wrap {
  width: 84px;
  height: 84px;
  margin: 0 auto;
}

.srl-category-slider-item .category-strip-name {
  font-size: 0.82rem;
  font-weight: 700;
  margin-top: 8px;
  line-height: 1.25;
  color: var(--srl-text-main);
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100px;
  text-align: center;
}

@media (max-width: 576px) {
  .srl-category-slider-track {
    gap: 14px;
    padding-left: 2px;
    padding-right: 14px;
  }
  .srl-category-slider-item {
    flex: 0 0 88px;
  }
  .srl-category-slider-item .category-strip-img-wrap {
    width: 72px;
    height: 72px;
  }
  .srl-category-slider-item .category-strip-name {
    font-size: 0.76rem;
    max-width: 86px;
    margin-top: 6px;
  }
}

/* Luxurious Spacious Trust & Value Assurance Bar */
.srl-trust-showcase-bar {
  background: #ffffff;
  border: 1px solid rgba(226, 232, 240, 0.9);
  border-radius: 22px;
  padding: 32px 36px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04), 0 2px 6px rgba(255, 42, 133, 0.05);
  position: relative;
  overflow: hidden;
  transition: all 0.3s ease;
}

.srl-trust-showcase-bar:hover {
  box-shadow: 0 14px 40px rgba(0, 0, 0, 0.07), 0 4px 12px rgba(255, 42, 133, 0.1);
  border-color: rgba(255, 42, 133, 0.25);
}

.srl-trust-item {
  display: flex;
  align-items: center;
  gap: 20px;
  padding: 8px 12px;
  transition: transform 0.25s ease;
}

.srl-trust-item:hover {
  transform: translateY(-2px);
}

.srl-trust-icon-wrap {
  width: 58px;
  height: 58px;
  border-radius: 16px;
  background: linear-gradient(135deg, #ff2a85 0%, #d81165 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-size: 1.55rem;
  flex-shrink: 0;
  box-shadow: 0 8px 22px rgba(255, 42, 133, 0.32);
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.srl-trust-item:hover .srl-trust-icon-wrap {
  transform: scale(1.08) rotate(3deg);
  box-shadow: 0 10px 26px rgba(255, 42, 133, 0.45);
}

.srl-trust-content {
  display: flex;
  flex-direction: column;
}

.srl-trust-heading {
  font-weight: 800;
  font-size: 0.96rem;
  letter-spacing: 0.6px;
  text-transform: uppercase;
  color: #0f172a;
  margin-bottom: 4px;
  line-height: 1.25;
}

.srl-trust-sub {
  font-size: 0.82rem;
  color: #64748b;
  line-height: 1.4;
  font-weight: 500;
}

@media (min-width: 768px) {
  .srl-trust-item-divider {
    border-left: 1px solid rgba(226, 232, 240, 0.95);
    padding-left: 32px;
  }
}

@media (max-width: 767.98px) {
  .srl-trust-showcase-bar {
    padding: 24px 18px;
    border-radius: 18px;
  }
  .srl-trust-item {
    padding: 10px 4px;
    gap: 16px;
  }
  .srl-trust-icon-wrap {
    width: 48px;
    height: 48px;
    font-size: 1.35rem;
    border-radius: 14px;
  }
  .srl-trust-heading {
    font-size: 0.88rem;
  }
  .srl-trust-sub {
    font-size: 0.76rem;
  }
}


/* Product Cards */
.srl-product-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  height: 100%;
  position: relative;
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.srl-product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
  border-color: #cbd5e1;
}

.srl-discount-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background: #e11d74;
  color: #ffffff;
  font-weight: 800;
  font-size: 0.75rem;
  padding: 3px 8px;
  border-radius: 6px;
  z-index: 3;
}

.srl-product-img-box {
  height: 210px;
  background: #0c0f17;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  overflow: hidden;
  position: relative;
}

.srl-product-img-box img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.srl-product-card:hover .srl-product-img-box img {
  transform: scale(1.08);
}

.srl-product-body {
  padding: 16px;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
}

.srl-product-title {
  font-weight: 700;
  font-size: 0.95rem;
  color: #1e293b;
  margin-bottom: 4px;
  line-height: 1.35;
  text-decoration: none;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  height: 2.7rem;
}

.srl-product-title:hover {
  color: var(--srl-pink);
}

.srl-product-brand {
  font-size: 0.75rem;
  font-weight: 700;
  color: #94a3b8;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 6px;
}

.srl-product-rating {
  color: #cbd5e1;
  font-size: 0.85rem;
  margin-bottom: 8px;
}

.srl-product-rating .active-star {
  color: #f59e0b;
}

.srl-stock-check {
  font-size: 0.82rem;
  font-weight: 600;
  color: #10b981;
  display: flex;
  align-items: center;
  gap: 4px;
  margin-bottom: 10px;
}

.srl-stock-check.out-of-stock {
  color: #ef4444;
}

.srl-price-box {
  display: flex;
  align-items: baseline;
  gap: 8px;
  margin-bottom: 14px;
  margin-top: auto;
}

.srl-old-price {
  font-size: 0.85rem;
  color: #94a3b8;
  text-decoration: line-through;
}

.srl-sale-price {
  font-size: 1.15rem;
  font-weight: 800;
  color: #e11d74;
}

.btn-add-to-cart {
  width: 100%;
  background: #e11d74;
  color: #ffffff;
  border: none;
  padding: 10px 16px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 0.9rem;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  cursor: pointer;
}

.btn-add-to-cart:hover {
  background: #ff2a85;
  color: #ffffff;
  box-shadow: 0 4px 12px rgba(225, 29, 116, 0.35);
  transform: translateY(-1px);
}

.srl-btn-more-products {
  background: rgba(225, 29, 116, 0.08);
  color: var(--srl-pink);
  border: 1px solid rgba(225, 29, 116, 0.3);
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.2px;
  line-height: 1.4;
  white-space: nowrap !important;
  transition: all 0.22s ease-in-out;
}

.srl-btn-more-products:hover,
.srl-btn-more-products:focus {
  background: var(--srl-pink-gradient) !important;
  color: #ffffff !important;
  border-color: transparent !important;
  box-shadow: 0 4px 14px rgba(225, 29, 116, 0.35);
  transform: translateX(2px);
}

/* Event / Special Offer Section */
.event-offer-banner {
  background: linear-gradient(135deg, #fdf2f8 0%, #f0f9ff 50%, #f5f3ff 100%);
  border: 1px solid rgba(225, 29, 116, 0.15);
  border-radius: 24px;
  padding: 36px 28px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
}

.event-countdown-card {
  background: #ffffff;
  border-radius: 12px;
  padding: 8px 14px;
  min-width: 58px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
}

.event-countdown-num {
  font-size: 1.4rem;
  font-weight: 800;
  color: #1e293b;
  line-height: 1.1;
}

.event-countdown-label {
  font-size: 0.7rem;
  color: #64748b;
  text-transform: capitalize;
}

.btn-go-shopping {
  background: #e11d74;
  color: #ffffff;
  font-weight: 700;
  padding: 10px 24px;
  border-radius: 50px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  box-shadow: 0 4px 14px rgba(225, 29, 116, 0.35);
  transition: all 0.2s ease;
}

.btn-go-shopping:hover {
  background: #ff2a85;
  color: #ffffff;
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(225, 29, 116, 0.45);
}

.deal-mini-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 10px 14px;
  display: flex;
  align-items: center;
  gap: 12px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
  text-decoration: none;
  transition: all 0.2s ease;
}

.deal-mini-card:hover {
  border-color: var(--srl-pink);
  transform: translateY(-2px);
}

/* Mobile Product Card Adjustments */
@media (max-width: 767.98px) {
  .srl-product-card {
    border-radius: 12px;
  }
  .srl-product-img-box {
    height: 150px;
  }
  .srl-product-body {
    padding: 10px;
  }
  .srl-product-title {
    font-size: 0.82rem;
    height: 2.3rem;
  }
  .srl-product-brand {
    font-size: 0.68rem;
    margin-bottom: 2px;
  }
  .srl-price-box {
    margin-bottom: 8px;
    gap: 4px;
  }
  .srl-sale-price {
    font-size: 0.98rem;
  }
  .srl-old-price {
    font-size: 0.75rem;
  }
  .btn-add-to-cart {
    padding: 7px 10px;
    font-size: 0.78rem;
    border-radius: 6px;
  }
}
</style>

<div class="container py-2">

  <!-- ============================================================
       1. HERO AUTO-SLIDER (AUTOMATIC SLIDING WITH PREV/NEXT BUTTONS)
       ============================================================ -->
  <div id="heroHomeCarousel" class="carousel slide srl-full-banner-carousel mb-4 mb-md-5" data-bs-ride="carousel" data-bs-interval="5000">
    <!-- Indicators -->
    <div class="carousel-indicators mb-3">
      <?php foreach ($slides as $idx => $slide): ?>
        <button type="button" data-bs-target="#heroHomeCarousel" data-bs-slide-to="<?= $idx ?>" class="<?= $idx === 0 ? 'active' : '' ?>" aria-current="<?= $idx === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $idx + 1 ?>"></button>
      <?php endforeach; ?>
    </div>

    <!-- Carousel Items (Full Banners 1, 2, 3) -->
    <div class="carousel-inner">
      <?php foreach ($slides as $idx => $slide): ?>
        <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
          <div class="srl-full-banner-card">
            <!-- Full Width Banner Graphic -->
            <img src="<?= base_url($slide['banner_img']) ?>" alt="<?= html_escape($slide['title']) ?>" class="srl-full-banner-img" draggable="false">

            <!-- Vignette & Content Overlay -->
            <div class="srl-full-banner-overlay d-flex align-items-center">
              <div class="container px-3 px-md-5">
                <div class="row">
                  <div class="col-12 col-md-8 col-lg-7 srl-full-banner-content">
                    <span class="badge rounded-pill fw-bold srl-banner-badge d-inline-flex align-items-center mb-1 mb-md-3">
                      <i class="bi <?= $slide['icon'] ?> me-1"></i><?= $slide['badge'] ?>
                    </span>
                    <h1 class="fw-extrabold text-white mb-2 srl-banner-heading">
                      <?= $slide['title'] ?>
                    </h1>
                    <p class="lead text-light opacity-90 mb-3 mb-md-4 srl-banner-sub d-none d-sm-block">
                      <?= $slide['subtitle'] ?>
                    </p>

                    <div class="d-flex flex-wrap gap-2 gap-md-3">
                      <a href="<?= $slide['btn_link'] ?>" class="btn-srl-primary srl-banner-btn rounded-pill shadow d-inline-flex align-items-center">
                        <?= $slide['btn_text'] ?> <i class="bi bi-arrow-right ms-1"></i>
                      </a>
                      <a href="<?= base_url('products') ?>" class="btn btn-outline-light rounded-pill px-3 px-md-4 py-2 py-md-3 fw-semibold fs-6 d-none d-md-inline-flex align-items-center">
                        View Catalog
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Prev & Next Control Buttons (Desktop Only) -->
    <button class="carousel-control-prev-srl d-none d-md-flex" type="button" data-bs-target="#heroHomeCarousel" data-bs-slide="prev" aria-label="Previous Slide">
      <i class="bi bi-chevron-left fs-5"></i>
    </button>
    <button class="carousel-control-next-srl d-none d-md-flex" type="button" data-bs-target="#heroHomeCarousel" data-bs-slide="next" aria-label="Next Slide">
      <i class="bi bi-chevron-right fs-5"></i>
    </button>
  </div>


  <!-- ============================================================
       2. LIST OF CATEGORIES (IMAGE AND NAME ONLY)
       ============================================================ -->
  <?php if (!empty($categories)): ?>
    <section class="my-4 my-md-5 pt-2">
      <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4 flex-nowrap gap-2 category-header-row">
        <div class="d-flex align-items-center gap-2 gap-sm-3 min-w-0">
          <div class="category-header-icon-box flex-shrink-0">
            <i class="bi bi-grid-fill"></i>
          </div>
          <div class="min-w-0">
            <h5 class="fw-bold text-dark mb-0 text-nowrap category-header-title">
              Browse By Category
            </h5>
            <span class="text-muted small d-none d-md-inline-block">Discover pixel LEDs, controllers & neon ropes</span>
          </div>
        </div>
        <a href="<?= base_url('categories') ?>" class="srl-category-view-all-btn text-decoration-none flex-shrink-0">
          <span>All Categories</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <!-- Touch-Friendly & Drag-Enabled Category Horizontal Slider -->
      <div class="srl-category-slider-container" id="srlCategorySliderContainer" title="Swipe or drag to explore categories">
        <div class="srl-category-slider-track" id="srlCategorySliderTrack">
          <?php foreach ($categories as $cat): ?>
            <div class="srl-category-slider-item">
              <a href="<?= base_url('category/' . $cat->id) ?>" class="category-strip-card text-decoration-none">
                <div class="category-strip-img-wrap">
                  <?php if (!empty($cat->image) && file_exists('./uploads/categories/' . $cat->image)): ?>
                    <img src="<?= base_url('uploads/categories/' . $cat->image) ?>" alt="<?= html_escape($cat->name) ?>" draggable="false">
                  <?php else: ?>
                    <i class="bi bi-lightbulb text-muted" style="font-size: 2rem; color: var(--srl-pink) !important;"></i>
                  <?php endif; ?>
                </div>
                <span class="category-strip-name"><?= html_escape($cat->name) ?></span>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>


  <!-- ============================================================
       3. SPACIOUS & LUXURIOUS TRUST & FEATURE BADGES
       ============================================================ -->
  <section class="my-5 py-2">
    <div class="srl-trust-showcase-bar">
      <div class="row g-4 align-items-center">
        <!-- Feature 1: Free Delivery -->
        <div class="col-12 col-md-4">
          <div class="srl-trust-item">
            <div class="srl-trust-icon-wrap">
              <i class="bi bi-truck"></i>
            </div>
            <div class="srl-trust-content">
              <h6 class="srl-trust-heading">FREE DELIVERY</h6>
              <p class="srl-trust-sub mb-0">Fast dispatch on all prepaid & COD orders</p>
            </div>
          </div>
        </div>

        <!-- Feature 2: Pay on Delivery -->
        <div class="col-12 col-md-4">
          <div class="srl-trust-item srl-trust-item-divider">
            <div class="srl-trust-icon-wrap">
              <i class="bi bi-cash-stack"></i>
            </div>
            <div class="srl-trust-content">
              <h6 class="srl-trust-heading">PAY ON DELIVERY</h6>
              <p class="srl-trust-sub mb-0">Cash or UPI at your doorstep with zero hassle</p>
            </div>
          </div>
        </div>

        <!-- Feature 3: Easy Returns -->
        <div class="col-12 col-md-4">
          <div class="srl-trust-item srl-trust-item-divider">
            <div class="srl-trust-icon-wrap">
              <i class="bi bi-arrow-repeat"></i>
            </div>
            <div class="srl-trust-content">
              <h6 class="srl-trust-heading">EASY RETURNS</h6>
              <p class="srl-trust-sub mb-0">7 days replacement guarantee & genuine warranty</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================================
       4. CATEGORY WISE PRODUCT SHELVES (MATCHING IMAGE 2)
       ============================================================ -->
  <?php if (!empty($categories)): ?>
    <?php foreach ($categories as $cat): ?>
      <?php 
        $prods = $category_products[$cat->id] ?? [];
        if (empty($prods)) continue;
      ?>
      <section class="mb-4 mb-md-5">
        <!-- Section Header matching Image 2 -->
        <div class="d-flex justify-content-between align-items-center flex-nowrap gap-2 mb-3">
          <h4 class="fw-extrabold text-uppercase text-dark mb-0 text-truncate" style="letter-spacing: 0.5px; font-size: calc(0.95rem + 0.35vw);" title="<?= html_escape($cat->name) ?>">
            <?= html_escape($cat->name) ?>
          </h4>
          <a href="<?= base_url('category/' . $cat->id) ?>" class="btn srl-btn-more-products rounded-pill px-3 py-1 fw-bold text-decoration-none text-nowrap flex-shrink-0 d-inline-flex align-items-center">
            <span>More Products</span> <i class="bi bi-chevron-right ms-1"></i>
          </a>
        </div>

        <!-- Products Grid / Shelf (2-Column on Mobile, 4-Column on Desktop) -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-sm-3 g-md-4">
          <?php foreach ($prods as $p): ?>
            <?php
              $has_discount = (!empty($p->discount_price) && $p->discount_price < $p->price);
              $discount_pct = $has_discount ? round((($p->price - $p->discount_price) / $p->price) * 100) : 0;
            ?>
            <div class="col">
              <div class="srl-product-card">
                <!-- Discount Badge Top-Left -->
                <?php if ($has_discount): ?>
                  <span class="srl-discount-badge">-<?= $discount_pct ?>%</span>
                <?php endif; ?>

                <!-- Product Image Box -->
                <a href="<?= base_url('product/' . $p->id) ?>" class="srl-product-img-box text-decoration-none">
                  <?php if (!empty($p->image) && file_exists('./uploads/products/' . $p->image)): ?>
                    <img src="<?= base_url('uploads/products/' . $p->image) ?>" alt="<?= html_escape($p->name) ?>">
                  <?php else: ?>
                    <i class="bi bi-image text-muted" style="font-size: 4rem; opacity: 0.35;"></i>
                  <?php endif; ?>
                </a>

                <!-- Product Body Details -->
                <div class="srl-product-body">
                  <a href="<?= base_url('product/' . $p->id) ?>" class="srl-product-title" title="<?= html_escape($p->name) ?>">
                    <?= html_escape($p->name) ?>
                  </a>

                  <div class="srl-product-brand">
                    <?= html_escape($cat->name) ?>
                  </div>

                  <!-- In Stock checkmark -->
                  <div class="srl-stock-check <?= ($p->stock <= 0) ? 'out-of-stock' : '' ?>">
                    <?php if ($p->stock > 0): ?>
                      <i class="bi bi-check-lg text-success"></i> In stock
                    <?php else: ?>
                      <i class="bi bi-x-circle text-danger"></i> Out of stock
                    <?php endif; ?>
                  </div>

                  <!-- Price Line -->
                  <div class="srl-price-box">
                    <?php if ($has_discount): ?>
                      <span class="srl-old-price">₹<?= number_format($p->price, 2) ?></span>
                      <span class="srl-sale-price">₹<?= number_format($p->discount_price, 2) ?></span>
                    <?php else: ?>
                      <span class="srl-sale-price">₹<?= number_format($p->price, 2) ?></span>
                    <?php endif; ?>
                  </div>

                  <!-- Add To Cart Button -->
                  <button type="button" class="btn-add-to-cart" data-id="<?= $p->id ?>" data-name="<?= html_escape($p->name) ?>" <?= ($p->stock <= 0) ? 'disabled' : '' ?>>
                    Add To Cart
                  </button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  <?php endif; ?>


  <!-- ============================================================
       5. SPECIAL OFFER / MEGA SHOPPING EVENT (MATCHING IMAGE 3)
       ============================================================ -->
  <!-- <section class="mb-5">
    <div class="event-offer-banner">
      <div class="row align-items-center g-4">
        <div class="col-lg-4 text-center">
          <div class="rounded-4 overflow-hidden shadow-sm d-inline-block bg-white p-2 border" style="max-width: 320px;">
            <div class="rounded-3 overflow-hidden position-relative" style="height: 240px; background: #0c0f17;">
              <?php if (!empty($offer_event['image']) && file_exists('./' . $offer_event['image'])): ?>
                <img src="<?= base_url($offer_event['image']) ?>" alt="SRL Pixel LED Mega Expo" class="w-100 h-100 object-fit-cover rounded-3">
              <?php else: ?>
                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark text-white p-4">
                  <i class="bi bi-stars text-danger fs-1" style="color: var(--srl-pink-glow) !important;"></i>
                </div>
              <?php endif; ?>
              <div class="position-absolute bottom-0 start-0 end-0 p-2 text-center" style="background: linear-gradient(to top, rgba(12,15,23,0.92) 0%, rgba(12,15,23,0.6) 60%, transparent 100%);">
                <span class="badge rounded-pill bg-danger px-3 py-1 fw-bold" style="background: var(--srl-pink-gradient) !important;">MEGA EXPO 2026</span>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="text-center text-lg-start">
            <h2 class="display-6 fw-extrabold text-dark mb-2" style="letter-spacing: -0.5px;">
              <?= $offer_event['title'] ?>
            </h2>
            <p class="text-muted mb-4" style="font-size: 1.05rem;">
              <?= $offer_event['subtitle'] ?>
            </p>

            <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-2 mb-4" id="eventCountdownTimer">
              <div class="event-countdown-card">
                <div class="event-countdown-num" id="timerDays">05</div>
                <div class="event-countdown-label">Days</div>
              </div>
              <div class="event-countdown-card">
                <div class="event-countdown-num" id="timerHours">14</div>
                <div class="event-countdown-label">Hr</div>
              </div>
              <div class="event-countdown-card">
                <div class="event-countdown-num" id="timerMinutes">22</div>
                <div class="event-countdown-label">Min</div>
              </div>
              <div class="event-countdown-card">
                <div class="event-countdown-num" id="timerSeconds">45</div>
                <div class="event-countdown-label">Sc</div>
              </div>
            </div>

            <a href="<?= $offer_event['button_link'] ?>" class="btn-go-shopping mb-4">
              <?= $offer_event['button_text'] ?> <i class="bi bi-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>

      <?php if (!empty($all_products)): ?>
        <hr class="my-4" style="opacity: 0.1;">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">
          <?php foreach (array_slice($all_products, 0, 5) as $deal_item): ?>
            <?php
              $d_price = (!empty($deal_item->discount_price) && $deal_item->discount_price < $deal_item->price) ? $deal_item->discount_price : $deal_item->price;
            ?>
            <div class="col">
              <a href="<?= base_url('product/' . $deal_item->id) ?>" class="deal-mini-card h-100">
                <div class="deal-mini-img d-flex align-items-center justify-content-center border">
                  <?php if (!empty($deal_item->image) && file_exists('./uploads/products/' . $deal_item->image)): ?>
                    <img src="<?= base_url('uploads/products/' . $deal_item->image) ?>" alt="<?= html_escape($deal_item->name) ?>" class="w-100 h-100 object-fit-cover rounded-2">
                  <?php else: ?>
                    <i class="bi bi-lightbulb text-muted fs-4"></i>
                  <?php endif; ?>
                </div>
                <div class="overflow-hidden">
                  <span class="d-block fw-bold text-dark text-truncate small"><?= html_escape($deal_item->name) ?></span>
                  <div class="small text-warning" style="font-size: 0.7rem;">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  </div>
                  <div class="small fw-bold" style="color: var(--srl-pink);">
                    ₹<?= number_format($d_price, 2) ?>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section> -->

</div>

<!-- Real-time Countdown Timer Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const targetDate = new Date("<?= date('Y/m/d H:i:s', strtotime($offer_event['end_time'])) ?>").getTime();

  function updateTimer() {
    const now = new Date().getTime();
    const distance = targetDate - now;

    if (distance <= 0) {
      document.getElementById('timerDays').innerText = '00';
      document.getElementById('timerHours').innerText = '00';
      document.getElementById('timerMinutes').innerText = '00';
      document.getElementById('timerSeconds').innerText = '00';
      return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById('timerDays').innerText = String(days).padStart(2, '0');
    document.getElementById('timerHours').innerText = String(hours).padStart(2, '0');
    document.getElementById('timerMinutes').innerText = String(minutes).padStart(2, '0');
    document.getElementById('timerSeconds').innerText = String(seconds).padStart(2, '0');
  }

  updateTimer();
  setInterval(updateTimer, 1000);

  // ============================================================
  // HERO BANNER MOUSE-DRAG & TOUCH SLIDING
  // ============================================================
  const heroCarousel = document.getElementById('heroHomeCarousel');
  if (heroCarousel) {
    let isDown = false;
    let startX = 0;
    let dist = 0;

    heroCarousel.addEventListener('mousedown', function (e) {
      if (e.button !== 0 || e.target.closest('a, button, .carousel-indicators')) return;
      isDown = true;
      startX = e.pageX;
      dist = 0;
      heroCarousel.classList.add('is-dragging');
    });

    window.addEventListener('mousemove', function (e) {
      if (!isDown) return;
      dist = e.pageX - startX;
      if (Math.abs(dist) > 6) {
        e.preventDefault();
      }
    });

    window.addEventListener('mouseup', function (e) {
      if (!isDown) return;
      isDown = false;
      heroCarousel.classList.remove('is-dragging');
      if (Math.abs(dist) > 35) {
        const bsCarousel = bootstrap.Carousel.getOrCreateInstance(heroCarousel);
        if (dist < 0) {
          bsCarousel.next();
        } else {
          bsCarousel.prev();
        }
      }
    });
  }

  // ============================================================
  // CATEGORY HORIZONTAL SLIDER MOUSE DRAG & WHEEL SCROLL
  // ============================================================
  const categorySlider = document.getElementById('srlCategorySliderContainer');
  if (categorySlider) {
    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;
    let hasDragged = false;

    categorySlider.addEventListener('mousedown', function (e) {
      if (e.button !== 0) return;
      isDown = true;
      hasDragged = false;
      categorySlider.classList.add('is-dragging');
      startX = e.pageX - categorySlider.offsetLeft;
      scrollLeft = categorySlider.scrollLeft;
    });

    window.addEventListener('mousemove', function (e) {
      if (!isDown) return;
      const x = e.pageX - categorySlider.offsetLeft;
      const walk = (x - startX) * 1.4;
      if (Math.abs(walk) > 5) {
        hasDragged = true;
        e.preventDefault();
        categorySlider.scrollLeft = scrollLeft - walk;
      }
    });

    window.addEventListener('mouseup', function () {
      if (!isDown) return;
      isDown = false;
      categorySlider.classList.remove('is-dragging');

      if (hasDragged) {
        const preventClick = function (ev) {
          ev.preventDefault();
          ev.stopPropagation();
          categorySlider.removeEventListener('click', preventClick, true);
        };
        categorySlider.addEventListener('click', preventClick, true);
      }
    });

    // Horizontal scroll with mouse wheel
    categorySlider.addEventListener('wheel', function (e) {
      if (e.deltaY !== 0) {
        e.preventDefault();
        categorySlider.scrollLeft += e.deltaY * 0.9;
      }
    }, { passive: false });
  }
});
</script>
