<!-- <div class="card">
  <div class="card-body">
    <h3 class="card-title">Welcome back, <?= def($this->session->userdata('detail_identity'), 'nama_depan', 'Guest') ?>!</h3>

    <div class="mt-2">
      <div class="d-flex flex-wrap">
        <a href="<?= site_url('/academics/dashboard') ?>" class="btn btn-light btn-sm me-2 mb-2">Academic Dashboard</a>
        <a href="<?= site_url('/cnp/dashboard') ?>" class="btn btn-light btn-sm me-2 mb-2">C&P Dashboard</a>
        <a href="#" class="btn btn-light btn-sm me-2 mb-2">HR Dashboard</a>
      </div>
    </div>
  </div>
</div>
 -->

<div class="row">
  <div class="col-md-8">
    <!-- Greeting Card -->
    <div class="card greeting-card" style=" border-radius: 35px;">
        <div class="card-body">
            <h3 class="card-title" id="greeting-time"><?= trim(def($this->session->userdata('detail_identity'), 'nama_depan', 'Guest')) ?>!</h3>

            <div class="mt-2">
              <div class="d-flex flex-wrap">
                <a href="<?= site_url('/academics/dashboard') ?>" class="btn btn-light btn-sm me-2 mb-2">Academic Dashboard</a>
                <a href="<?= site_url('/cnp/dashboard') ?>" class="btn btn-light btn-sm me-2 mb-2">C&P Dashboard</a>
                <a href="#" class="btn btn-light btn-sm me-2 mb-2">HR Dashboard</a>
              </div>
            </div>
        </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card text-body" style=" border-radius: 35px;">
      <div class="card-body p-4">

      <div class="d-flex">
        <h6 class="flex-grow-1" id="weather-location">Parung</h6>
        <h6 id="weather-time"><?= date('H:i') ?></h6>
      </div>

      <div class="d-flex flex-column text-center mt-5 mb-4">
        <h6 class="display-4 mb-0 font-weight-bold" id="weather-degree"> 31°C </h6>
        <span class="small" style="color: #868B94" id="weather-text">Rain - Mini Rain</span>
      </div>

      <div class="d-flex align-items-center">
        <div class="flex-grow-1" style="font-size: 1rem;">
          <div><i class="bi bi-wind" style="color: #868B94;"></i> <span class="ms-1" id="weather-wind"> 40 km/h
            </span>
          </div>
          <div><i class="bi bi-droplet-fill" style="color: #868B94;"></i> <span class="ms-1" id="weather-humid"> 84%
            </span></div>
          <?php /*<div><i class="bi bi-sun" style="color: #868B94;"></i> <span class="ms-1"> 0.2h
            </span></div>*/ ?>
        </div>
        <div>
          <i class="bi bi-cloud-lightning-rain fs-1" id="weather-icon"></i>
        </div>
      </div>
    </div>
  </div>
</div>
