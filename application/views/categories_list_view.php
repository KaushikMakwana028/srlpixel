<div class="container py-2 py-md-3">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="mb-2">
    <ol class="breadcrumb mb-0 small">
      <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Home</a></li>
      <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Categories</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 mb-md-4">
    <div>
      <h4 class="fw-bold text-dark mb-0 fs-5 fs-md-4">
        <i class="bi bi-diagram-3 me-2" style="color: var(--srl-pink);"></i>Lighting Categories
      </h4>
      <p class="text-muted small mb-0 d-none d-sm-block">Browse our complete range of addressable pixel LEDs, smart controllers, and power converters.</p>
    </div>
    <span class="badge rounded-pill bg-light text-dark border px-2 py-1 small">
      <?= count($categories) ?> categories
    </span>
  </div>

  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-sm-3 g-md-4">
    <?php if (!empty($categories)): ?>
      <?php foreach ($categories as $cat): ?>
        <div class="col">
          <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid #e2e8f0 !important; transition: all 0.25s ease;">
            <div class="overflow-hidden position-relative d-flex align-items-center justify-content-center" style="height: 160px; background: #0c0f17 !important;">
              <?php if (!empty($cat->image) && file_exists('./uploads/categories/' . $cat->image)): ?>
                <img src="<?= base_url('uploads/categories/' . $cat->image) ?>" alt="<?= html_escape($cat->name) ?>" class="w-100 h-100 object-fit-cover">
              <?php else: ?>
                <div class="rounded-circle p-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: rgba(255, 42, 133, 0.15);">
                  <i class="bi bi-lightbulb fs-2" style="color: var(--srl-pink);"></i>
                </div>
              <?php endif; ?>
            </div>
            <div class="card-body p-3 p-md-4 d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-1">
                <h6 class="fw-bold text-dark mb-0 fs-6"><?= html_escape($cat->name) ?></h6>
                <span class="badge bg-danger-subtle text-danger rounded-pill px-2 py-1" style="font-size: 0.65rem;">
                  <?= $category_counts[$cat->id] ?? 0 ?> items
                </span>
              </div>
              <p class="text-muted small flex-grow-1 mb-3 d-none d-sm-block" style="font-size: 0.78rem;">
                <?= !empty($cat->description) ? html_escape(character_limiter($cat->description, 70)) : 'High quality lighting products engineered for commercial and festive applications.' ?>
              </p>
              <a href="<?= base_url('category/' . $cat->id) ?>" class="btn btn-outline-dark rounded-pill w-100 fw-bold py-1 py-md-2 mt-auto btn-sm" style="border-color: #cbd5e1; font-size: 0.8rem;">
                Browse <i class="bi bi-arrow-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
