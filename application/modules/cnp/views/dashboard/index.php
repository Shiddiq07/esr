<div class="row">
    <div class="col">
        <nav class="nav mb-4">
            <div class="container-fluid d-flex">
                <?php if (!$this->helpers->isCollege() && !$this->helpers->isPoltek()): ?>

                <div class="d-flex">

                    <?php
                        $active_college = $active_plj = $active_akma = '';

                        switch ($type) {
                            case 'college': $active_college = 'active'; break;
                            case 'plj': $active_plj = 'active'; break;
                            case 'akma': $active_akma = 'active'; break;
                        }
                    ?>

                    <?= $this->html->a('COLLEGE', '/cnp/dashboard/college', [
                        'class' => 'nav-link '. $active_college
                    ]) ?>
                    <?= $this->html->a('LP3I JAKARTA', '/cnp/dashboard/plj', [
                        'class' => 'nav-link '. $active_plj
                    ]) ?>
                </div>

                <?php endif; ?>

                <div class="ms-auto d-flex align-items-center">
                    <label for="startYear" class="form-label mt-2 me-2 fw-bold w-100">Tahun Angkatan</label>
                    <?= $this->html->dropdownList('tahun_angkatan', end($list_tahun_angkatan), $list_tahun_angkatan, [
                        'class' => 'form-select',
                        'id' => 'select-tahun_angkatan',
                        'prompt' => '- Tahun Angkatan -',
                    ]) ?>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="row dashboard justify-content-center">
    <!-- Total Alumni Card -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Total Alumni</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-total_alumni">0</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Total Alumni Card -->

    <!-- Total Non Target Card -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Non Target</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-non_target">0</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Total Non Target Card -->

    <!-- Total Target Card -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Target</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-total_target">0</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Total Target Card -->

    <!-- Total Kerja by C&P Card -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Kerja by C&P</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-by_cnp">0</h6>
                        <span class="text-success small pt-1 fw-bold" id="percentage-by_cnp_perc">0</span> <span class="text-muted small pt-2 ps-1">achieved</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Total Kerja by C&P Card -->

    <!-- Total Kerja Sendiri Card -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Kerja Sendiri</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-sendiri">0</h6>
                        <span class="text-success small pt-1 fw-bold" id="percentage-sendiri_perc">0</span> <span class="text-muted small pt-2 ps-1">achieved</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Total Kerja Sendiri Card -->

    <!-- Total Wirausaha Card -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Wirausaha</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-wirausaha">0</h6>
                        <span class="text-success small pt-1 fw-bold" id="percentage-wirausaha_perc">0</span> <span class="text-muted small pt-2 ps-1">achieved</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Total Wirausaha Card -->

    <!-- Total On Proses Card -->
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">On Proses</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-on_progres">0</h6>
                        <span class="text-success small pt-1 fw-bold" id="percentage-proses_perc">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Total On Proses Card -->
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" id="headingPenempatan">
        <h5>Grafik Rekapitulasi Penempatan</h5>

        <div class="d-flex align-items-center">
            <?php if (!$this->helpers->isLokal()): ?>

            <label class="form-label me-2 mb-0">Jenis Rekap</label>
            <div class="d-flex align-items-center">
                <?= $this->html->dropdownList('cabang', null, $cabangs, [
                    'class' => 'form-select me-2',
                    'id' => 'select-cabang',
                    'prompt' => 'Nasional',
                ]) ?>

                <i class="bi bi-chevron-down ms-1" data-bs-toggle="collapse" data-bs-target="#collapsePenempatan" aria-expanded="true" aria-controls="collapsePenempatan" role="button"></i>
            </div>

            <?php else: ?>

            <i class="bi bi-chevron-down ms-1" data-bs-toggle="collapse" data-bs-target="#collapsePenempatan" aria-expanded="true" aria-controls="collapsePenempatan" role="button"></i>

            <?php endif ?>
        </div>
    </div>

    <div id="collapsePenempatan" class="collapse show" aria-labelledby="headingPenempatan">
        <div class="card-body">
            <div id="graph-penempatan"></div>

            <div class="table-responsive">
                <table id="table-penempatan" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Cabang</th>
                            <th class="text-end">Kerja By C&P</th>
                            <th class="text-end">Kerja Sendiri</th>
                            <th class="text-end">Wirausaha</th>
                            <th class="text-end">On Proses</th>
                            <th class="text-end">Total Target</th>
                        </tr>
                    </thead>
                    <tbody><tr><td colspan="6"><i>Data belum ada.</i></td></tr></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap" id="headingPerusahaan">
        <h5>Grafik Skala Perusahaan</h5>

        <div class="d-flex align-items-center">
            <label class="form-label me-2 mb-0">Status MOU</label>
            <?= $this->html->dropdownList('status_mou', null, $list_status_mou, [
                'class' => 'form-select me-2',
                'id' => 'select-status_mou',
                'prompt' => 'Semua',
            ]) ?>

            <label class="form-label me-2 mb-0">Penyerapan Alumni</label>
            <?= $this->html->dropdownList('is_contributed', null, [1 => 'Sudah'], [
                'class' => 'form-select me-2',
                'id' => 'select-is_contributed',
                'prompt' => 'Semua',
            ]) ?>

            <div class="d-flex align-items-center">
                <i class="bi bi-chevron-down ms-1" data-bs-toggle="collapse" data-bs-target="#collapsePerusahaan" aria-expanded="true" aria-controls="collapsePerusahaan" role="button"></i>
            </div>
        </div>
    </div>

    <div id="collapsePerusahaan" class="collapse show" aria-labelledby="headingPerusahaan">
        <div class="card-body">
            <div class="row my-4">
                <div class="col-lg-6">
                    <div id="graph-perusahaan"></div>
                </div>

                <div class="col-lg-6">
                    <div class="table-responsive">
                        <table id="table-perusahaan" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Skala</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody><tr><td colspan="6"><i>Data belum ada.</i></td></tr></tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-end" id="perusahaan-total">0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap" id="headingKeterangan">
        <h5>Grafik Analisa Kandidat Gagal</h5>

        <div class="d-flex align-items-center">
            <i class="bi bi-chevron-down ms-1" data-bs-toggle="collapse" data-bs-target="#collapseKeterangan" aria-expanded="true" aria-controls="collapseKeterangan" role="button"></i>
        </div>
    </div>

    <div id="collapseKeterangan" class="collapse show" aria-labelledby="headingKeterangan">
        <div class="card-body">
            <div class="row my-4">
                <div class="col-lg-12">
                    <div id="graph-keterangan"></div>
                </div>

                <?php /*<div class="col-lg-3">
                    <div class="table-responsive">
                        <table id="table-keterangan" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Keterangan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody><tr><td colspan="6"><i>Data belum ada.</i></td></tr></tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-end" id="keterangan-total">0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>*/ ?>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap" id="headingPermintaan">
                <h5>Grafik Permintaan Nasional</h5>

                <div class="d-flex align-items-center">
                    <label class="form-label me-2 mb-0">Tahun Permintaan</label>
                    <?= $this->html->dropdownList('status_mou', end($list_tahun_permintaan), $list_tahun_permintaan, [
                        'class' => 'form-select me-2',
                        'id' => 'select-tahun_permintaan',
                        'prompt' => '- Pilih -',
                    ]) ?>

                    <div class="d-flex align-items-center">
                        <i class="bi bi-chevron-down ms-1" data-bs-toggle="collapse" data-bs-target="#collapsePermintaan" aria-expanded="true" aria-controls="collapsePermintaan" role="button"></i>
                    </div>
                </div>
            </div>

            <div id="collapsePermintaan" class="collapse show" aria-labelledby="headingPermintaan">
                <div class="card-body">
                    <div class="row my-4">
                        <div id="graph-permintaan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
