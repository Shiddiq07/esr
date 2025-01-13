<div class="row">
    <div class="col">
        <nav class="nav mb-4">
            <?php if (!$this->helpers->isCollege() && !$this->helpers->isPoltek()): ?>

            <div class="container-fluid d-flex">
                <div class="d-flex">
                    <?php
                        $active_college = $active_plj = $active_akma = '';

                        switch ($src) {
                            case 'college': $active_college = 'active'; break;
                            case 'plj': $active_plj = 'active'; break;
                            case 'akma': $active_akma = 'active'; break;
                        }
                    ?>

                    <?= $this->html->a('COLLEGE', '/cnp/recapitulation-alumni-karir/college', [
                        'class' => 'nav-link '. $active_college
                    ]) ?>
                    <?= $this->html->a('LP3I JAKARTA', '/cnp/recapitulation-alumni-karir/plj', [
                        'class' => 'nav-link '. $active_plj
                    ]) ?>
                </div>

                <!-- <div class="ms-auto">
                    <a href="">Last Update: 20-05-2024</a>
                </div> -->
            </div>

            <?php endif ?>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" id="headingFilter"
        data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter" role="button">
        <h5 class="mb-0">Filter Options</h5>
        <i class="bi bi-chevron-down"></i>
    </div>

    <div id="collapseFilter" class="collapse show" aria-labelledby="headingFilter">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <?php if (!$this->helpers->isLokal()): ?>

                    <div class="row mt-3">
                        <label for="select-cabang" class="col-sm-3 col-form-label required">Cabang</label>
                        <div class="col-sm-9">
                            <?= $this->html->dropDownList('Filter[cabang]', '', $list_cabang, [
                                'class' => 'form-control',
                                'tabIndex' => 1,
                                'id' => 'select-cabang',
                                'prompt' => '- Pilih -',
                                'required' => true
                            ]) ?>
                        </div>
                    </div>

                    <?php endif ?>

                    <div class="row mt-3">
                        <label for="select-tahun_angkatan" class="col-sm-3 col-form-label required">Tahun Angkatan</label>
                        <div class="col-sm-9">
                            <?= $this->html->dropDownList('Filter[tahun_angkatan]', '', [], [
                                'class' => 'form-control',
                                'tabIndex' => 2,
                                'id' => 'select-tahun_angkatan',
                                'prompt' => '- Pilih -',
                                'required' => true
                            ]) ?>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label for="select-status" class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <?= $this->html->dropDownList('Filter[status]', '', [
                                Alumniaktifitascollege::STATUS_KERJA => 'Kerja',
                                Alumniaktifitascollege::STATUS_MAGANG => 'Magang',
                            ], [
                                'class' => 'form-control',
                                'tabIndex' => 3,
                                'id' => 'select-status',
                                'prompt' => '- Pilih -'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label for="input-date_start" class="col-sm-3 col-form-label">Dari Tanggal</label>
                        <div class="col-sm-9">
                            <?= $this->html->textInput('Filter[tanggal_awal]', '', [
                                'class' => 'form-control',
                                'tabIndex' => 4,
                                'id' => 'input-date_start',
                                'type' => 'date',
                                'max' => date('Y-m-d')
                            ]) ?>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label for="input-date_end" class="col-sm-3 col-form-label">Sampai Tanggal</label>
                        <div class="col-sm-9">
                            <?= $this->html->textInput('Filter[tanggal_akhir]', '', [
                                'class' => 'form-control',
                                'tabIndex' => 5,
                                'id' => 'input-date_end',
                                'type' => 'date',
                                'max' => date('Y-m-d')
                            ]) ?>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary my-3 float-end" id="btn-filter">Apply Filter</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" id="panel-recap" style="display: none;">
    <div class="card-header">
        <div class="float-end">
            <div class="dropdown dt-buttons">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-cloud-download"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" id="table-recap-alumni_tools">
                    <li><a class="dropdown-item tool-action" href="javascript:;" data-action="0">
                        <i class="bi bi-files"></i> Copy</a></li>
                    <li><a class="dropdown-item tool-action" href="javascript:;" data-action="1">
                        <i class="bi bi-file-earmark-pdf text-danger"></i> PDF</a></li>
                    <li><a class="dropdown-item tool-action" href="javascript:;" data-action="2">
                        <i class="bi bi-file-earmark-excel text-success"></i> Excel</a></li>
                    <li><a class="dropdown-item tool-action" href="javascript:;" data-action="3">
                        <i class="bi bi-file-excel text-success"></i> CSV</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table id="table-recap-alumni" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>IP</th>
                    <th>Jurusan</th>
                    <th>Nama Perusahaan</th>
                    <th>Posisi</th>
                    <th>Gaji</th>
                    <th>Penempatan</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <tr><td colspan="10"><i>Data belum ada.</i></td></tr>
            </tbody>
        </table>
    </div>
</div>
