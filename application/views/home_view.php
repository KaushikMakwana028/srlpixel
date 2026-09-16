<div class="container py-2">

  <!-- ============================================================
       1. HERO AUTO-SLIDER (AUTOMATIC SLIDING WITH PREV/NEXT BUTTONS)
       ============================================================ -->
  <div id="heroHomeCarousel" class="carousel slide srl-hero-carousel mb-5" data-bs-ride="carousel" data-bs-interval="4500">
    <!-- Indicators -->
    <div class="carousel-indicators mb-3">
      <?php foreach ($slides as $idx => $slide): ?>
        <button type="button" data-bs-target="#heroHomeCarousel" data-bs-slide-to="<?= $idx ?>" class="<?= $idx === 0 ? 'active' : '' ?>" aria-current="<?= $idx === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $idx + 1 ?>"></button>
      <?php endforeach; ?>
    </div>

    <!-- Carousel Items -->
    <div class="carousel-inner">
      <?php foreach ($slides as $idx => $slide): ?>
        <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
          <div class="srl-carousel-slide" style="background: <?= $slide['bg_gradient'] ?>;">
            <div class="srl-slide-overlay"></div>
            <div class="container position-relative z-2">
              <div class="row align-items-center g-4">
                <div class="col-lg-7 col-md-7 srl-slide-content">
                  <span class="badge rounded-pill px-3 py-2 mb-3 fw-bold" style="background: rgba(255, 42, 133, 0.2); color: var(--srl-pink-glow); border: 1px solid rgba(255, 42, 133, 0.4);">
                    <i class="bi <?= $slide['icon'] ?> me-1"></i><?= $slide['badge'] ?>
                  </span>
                  <h1 class="display-5 fw-extrabold text-white mb-3" style="letter-spacing: -0.5px; line-height: 1.15;">
                    <?= $slide['title'] ?>
                  </h1>
                  <p class="lead text-light opacity-75 mb-4" style="max-width: 580px; font-size: 1.05rem;">
                    <?= $slide['subtitle'] ?>
                  </p>

                  <!-- Mobile Preview Image -->
                  <?php if (!empty($slide['image'])): ?>
                    <div class="d-md-none text-center my-2">
                      <img src="<?= base_url($slide['image']) ?>" alt="<?= html_escape($slide['title']) ?>" class="srl-hero-mobile-img">
                    </div>
                  <?php endif; ?>

                  <div class="d-flex flex-wrap gap-2 gap-md-3 justify-content-center justify-content-md-start">
                    <a href="<?= $slide['btn_link'] ?>" class="btn-srl-primary px-3 px-md-4 py-2 py-md-3 fs-6">
                      <?= $slide['btn_text'] ?> <i class="bi bi-arrow-right ms-1 ms-md-2"></i>
                    </a>
                    <a href="<?= base_url('products') ?>" class="btn btn-outline-light rounded-pill px-3 px-md-4 py-2 py-md-3 fw-semibold fs-6">
                      View Catalog
                    </a>
                  </div>
                </div>

                <!-- Desktop / Tablet Showcase Image on Right -->
                <div class="col-lg-5 col-md-5 d-none d-md-flex justify-content-center align-items-center">
                  <div class="srl-hero-img-container">
                    <div class="srl-hero-img-glow"></div>
                    <img src="<?= base_url($slide['image']) ?>" alt="<?= html_escape($slide['title']) ?>" class="srl-hero-slide-img">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Prev & Next Control Buttons -->
    <button class="carousel-control-prev-srl" type="button" data-bs-target="#heroHomeCarousel" data-bs-slide="prev" aria-label="Previous Slide">
      <i class="bi bi-chevron-left fs-5"></i>
    </button>
    <button class="carousel-control-next-srl" type="button" data-bs-target="#heroHomeCarousel" data-bs-slide="next" aria-label="Next Slide">
      <i class="bi bi-chevron-right fs-5"></i>
    </button>
  </div>


  <!-- ============================================================
       2. LIST OF CATEGORIES (IMAGE AND NAME ONLY)
       ============================================================ -->
  <?php if (!empty($categories)): ?>
    <section class="mb-4 mb-md-5">
      <div class="d-flex justify-content-between align-items-center mb-2 mb-md-3">
        <h5 class="fw-bold text-dark mb-0">
          <i class="bi bi-grid-fill me-2" style="color: var(--srl-pink);"></i>Browse By Category
        </h5>
        <a href="<?= base_url('categories') ?>" class="text-decoration-none fw-semibold small" style="color: var(--srl-pink);">
          All Categories <i class="bi bi-arrow-right"></i>
        </a>
      </div>

      <!-- Mobile Swipeable Horizontal Strip (< 768px) -->
      <div class="d-md-none srl-categories-scroll-wrap">
        <?php foreach ($categories as $cat): ?>
          <div class="srl-category-scroll-item">
            <a href="<?= base_url('category/' . $cat->id) ?>" class="category-strip-card text-decoration-none h-100">
              <div class="category-strip-img-wrap">
                <?php if (!empty($cat->image) && file_exists('./uploads/categories/' . $cat->image)): ?>
                  <img src="<?= base_url('uploads/categories/' . $cat->image) ?>" alt="<?= html_escape($cat->name) ?>">
                <?php else: ?>
                  <i class="bi bi-lightbulb text-muted" style="font-size: 1.8rem; color: var(--srl-pink) !important;"></i>
                <?php endif; ?>
              </div>
              <span class="category-strip-name"><?= html_escape($cat->name) ?></span>
            </a>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Desktop / Tablet Grid (>= 768px) -->
      <div class="d-none d-md-flex row row-cols-sm-3 row-cols-md-5 g-3 justify-content-center">
        <?php foreach ($categories as $cat): ?>
          <div class="col">
            <a href="<?= base_url('category/' . $cat->id) ?>" class="category-strip-card h-100">
              <div class="category-strip-img-wrap">
                <?php if (!empty($cat->image) && file_exists('./uploads/categories/' . $cat->image)): ?>
                  <img src="<?= base_url('uploads/categories/' . $cat->image) ?>" alt="<?= html_escape($cat->name) ?>">
                <?php else: ?>
                  <i class="bi bi-lightbulb text-muted" style="font-size: 2.2rem; color: var(--srl-pink) !important;"></i>
                <?php endif; ?>
              </div>
              <span class="category-strip-name"><?= html_escape($cat->name) ?></span>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>


  <!-- ============================================================
       3. DEFAULT TRUST & FEATURE BADGES STRIP (MATCHING IMAGE 1)
       ============================================================ -->
  <section class="mb-4 mb-md-5">
    <div class="trust-strip-card">
      <div class="row g-2 g-md-4 align-items-center justify-content-around text-center text-md-start">
        <!-- Feature 1: Free Delivery -->
        <div class="col-4">
          <div class="trust-item flex-column flex-md-row justify-content-center justify-content-md-start align-items-center gap-1 gap-md-3">
            <div class="trust-icon-circle">
              <i class="bi bi-truck"></i>
            </div>
            <div>
              <p class="trust-text">FREE DELIVERY<span class="d-none d-md-inline"><br>ON FIRST ORDER</span></p>
            </div>
          </div>
        </div>

        <!-- Feature 2: Pay on Delivery -->
        <div class="col-4 border-start">
          <div class="trust-item flex-column flex-md-row justify-content-center justify-content-md-start align-items-center gap-1 gap-md-3">
            <div class="trust-icon-circle">
              <i class="bi bi-cash-stack"></i>
            </div>
            <div>
              <p class="trust-text">PAY ON<br class="d-none d-md-inline"> DELIVERY</p>
            </div>
          </div>
        </div>

        <!-- Feature 3: Easy Returns -->
        <div class="col-4 border-start">
          <div class="trust-item flex-column flex-md-row justify-content-center justify-content-md-start align-items-center gap-1 gap-md-3">
            <div class="trust-icon-circle">
              <i class="bi bi-box-arrow-in-up-left"></i>
            </div>
            <div>
              <p class="trust-text">EASY<br class="d-none d-md-inline"> RETURNS</p>
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
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="fw-extrabold text-uppercase text-dark mb-0" style="letter-spacing: 0.5px; font-size: calc(1rem + 0.4vw);">
            <?= html_escape($cat->name) ?>
          </h4>
          <a href="<?= base_url('category/' . $cat->id) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-bold text-decoration-none" style="border-color: #dbeafe; color: #2563eb; background: #eff6ff;">
            More Products <i class="bi bi-chevron-right ms-1"></i>
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

                  <!-- 5 Star Rating -->
                  <div class="srl-product-rating">
                    <i class="bi bi-star-fill active-star"></i>
                    <i class="bi bi-star-fill active-star"></i>
                    <i class="bi bi-star-fill active-star"></i>
                    <i class="bi bi-star-fill active-star"></i>
                    <i class="bi bi-star-half active-star"></i>
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
  <section class="mb-5">
    <div class="event-offer-banner">
      <div class="row align-items-center g-4">
        <!-- Event Feature Image on Left -->
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

        <!-- Event Description & Live Countdown on Right -->
        <div class="col-lg-8">
          <div class="text-center text-lg-start">
            <h2 class="display-6 fw-extrabold text-dark mb-2" style="letter-spacing: -0.5px;">
              <?= $offer_event['title'] ?>
            </h2>
            <p class="text-muted mb-4" style="font-size: 1.05rem;">
              <?= $offer_event['subtitle'] ?>
            </p>

            <!-- Real-Time Countdown Timer Boxes -->
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

            <!-- Call-To-Action Button -->
            <a href="<?= $offer_event['button_link'] ?>" class="btn-go-shopping mb-4">
              <?= $offer_event['button_text'] ?> <i class="bi bi-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Mini Deal Items Strip Below (Matching Image 3) -->
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
  </section>

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
});
</script>
