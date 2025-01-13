<?php $this->load->library('arrayhelper'); ?>

<div class="row">
    <div class="col">
        <nav class="nav mb-4">
            <div class="container-fluid d-flex">
                <div class="d-flex">
                    <?php if (!$this->helpers->isCollege() && !$this->helpers->isPoltek()): ?>
                        
                    <?php
                        $active_college = $active_plj = $active_akma = '';

                        switch ($type) {
                            case 'college': $active_college = 'active'; break;
                            case 'plj': $active_plj = 'active'; break;
                            case 'akma': $active_akma = 'active'; break;
                        }
                    ?>
                        
                    <?= $this->html->a('COLLEGE', '/academics/dashboard/college', [
                        'class' => 'nav-link '. $active_college
                    ]) ?>

                    <?= $this->html->a('LP3I JAKARTA', '/academics/dashboard/plj', [
                        'class' => 'nav-link '. $active_plj
                    ]) ?>

                    <?php endif ?>
                </div>

                <div class="ms-auto d-flex align-items-center">
                    <label for="startYear" class="form-label mt-2 me-2 fw-bold">Periode</label>
                    <?= $this->html->dropdownList('periode', $periode, Arrayhelper::map($inisial_periodes, 'periode', 'periode'), [
                        'class' => 'form-control',
                        'id' => 'select-periode',
                        'prompt' => '- Periode -',
                    ]) ?>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="row dashboard justify-content-center">
    <!-- DATA AWAL Card -->
    <div class="col-xxl-3 col-md-4">
        <div class="card info-card sales-card">
            <div class="filter">
                <a class="icon" href="#"><i class="bi bi-arrow-right-circle-fill"></i></a>
            </div>

            <div class="card-body">
                <h5 class="card-title">DATA AWAL</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-data_awal">0</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End DATA AWAL Card -->

    <!-- AKTIF Card -->
    <div class="col-xxl-3 col-md-4">
        <div class="card info-card sales-card">
            <div class="filter">
                <a class="icon" href="#"><i class="bi bi-arrow-right-circle-fill"></i></a>
            </div>

            <div class="card-body">
                <h5 class="card-title">AKTIF</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-aktif">0</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End AKTIF Card -->

    <!-- CUTI Card -->
    <div class="col-xxl-2 col-md-4">
        <div class="card info-card sales-card">
            <div class="filter">
                <a class="icon" href="#"><i class="bi bi-arrow-right-circle-fill"></i></a>
            </div>

            <div class="card-body">
                <h5 class="card-title">CUTI</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-dash-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-cuti">0</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End CUTI Card -->

    <!-- NON-AKTIF Card -->
    <div class="col-xxl-2 col-md-4">
        <div class="card info-card sales-card">
            <div class="filter">
                <a class="icon" href="#"><i class="bi bi-arrow-right-circle-fill"></i></a>
            </div>

            <div class="card-body">
                <h5 class="card-title">NON-AKTIF</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-x-fill"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-non_aktif">0</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End NON-AKTIF Card -->

    <!-- KELUAR Card -->
    <div class="col-xxl-2 col-md-4">
        <div class="card info-card sales-card">
            <div class="filter">
                <a class="icon" href="#"><i class="bi bi-arrow-right-circle-fill"></i></a>
            </div>

            <div class="card-body">
                <h5 class="card-title">KELUAR</h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-slash"></i>
                    </div>
                    <div class="ps-3">
                        <h6 id="summary-keluar">0</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End KELUAR Card -->
</div>

<div class="card">
	<div class="card-header">
		<h5 class="float-start">Grafik Mahasiswa / PD</h5>
		<span class="float-end">
            <!-- <input type="month" placeholder="yyyy-mm" name="date-pd" id="input-date-pd" class="form-control" title="Month" value="<?= $tahun_angkatan .'-'. date('m') ?>"> -->
            <button class="btn btn-outline-danger btn-sm" id="btn-back-graph-mhs" style="display: none;"><i class="bi bi-arrow-left"></i></button>
        </span>
	</div>

	<div class="card-body pt-3">
		<div class="row">
			<div class="col-lg-12">
				<!-- <div id="report-pd"></div> -->
                <div id="report-cabang"></div>
			</div>

			<!-- <div class="col-lg-12 table-responsive">
				<table class="table table-bordered" id="table-summary-cabang">
					<thead>
						<tr>
							<th>Cabang</th>
							<th>Total</th>
						</tr>
					</thead>

					<tbody>
                        <tr><td colspan="2"><i>Data belum ada.</i></td></tr>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th>Jumlah</th>
                            <th id="total">0</th>
                        </tr>
                    </tfoot>
				</table>
			</div> -->
		</div>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h5 class="float-start">Grafik Status Mahasiswa / PD</h5>

        <?php if (!$this->helpers->isLokal()): ?>

		<span class="float-end d-flex align-items-center">
            <label class="form-label mt-2 me-2">By</label>
            <select class="form-control me-2" id="select-graph-type">
                <option value="prodi">Program Studi</option>
                <option value="cabang">Cabang</option>
            </select>
        </span>

        <?php endif ?>
	</div>

	<div class="card-body pt-3">
		<div class="row">
			<div class="col-lg-12">
				<div id="report-prodi"></div>
			</div>

			<div class="col-lg-12 table-responsive">
				<table class="table table-bordered mt-3" id="table-summary-prodi">
                    <thead>
                        <tr>
                            <th>Prodi</th>
                            <th>Aktif</th>
                            <th>Cuti</th>
                            <th>Non-Aktif</th>
                            <!-- <th>Drop-Out (DO)</th> -->
                            <th>Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="5"><i>Data belum ada.</i></td></tr>
                    </tbody>
                    <tfoot align="right">
                    	<tr>
                    		<th>Total</th>
                    		<th id="total-aktif"></th>
                    		<th id="total-cuti"></th>
                    		<th id="total-non_aktif"></th>
                    		<!-- <th id="total-do"></th> -->
                    		<th id="total-keluar"></th>
                    	</tr>
                    </tfoot>
                </table>
			</div>
		</div>
	</div>
</div>
