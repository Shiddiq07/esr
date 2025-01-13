<div class="row">
    <div class="col">
        <nav class="nav mb-4">
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

                    <?= $this->html->a('COLLEGE', '/cnp/recapitulation-proses-penempatan/college', [
                        'class' => 'nav-link '. $active_college
                    ]) ?>
                    <?= $this->html->a('LP3I JAKARTA', '/cnp/recapitulation-proses-penempatan/plj', [
                        'class' => 'nav-link '. $active_plj
                    ]) ?>
                </div>

                <!-- <div class="ms-auto">
                    <a href="">Last Update: 20-05-2024</a>
                </div> -->
            </div>
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
            <?= form_open('/cnp/recapitulation-proses-penempatan/get-table', [
                'id' => 'form-filter-recap'
            ]); ?>

            <div class="row">
                <div class="col-lg-6 offset-lg-3">
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

                    <div class="row mt-3">
                        <label for="select-tahun_angkatan" class="col-sm-3 col-form-label required">Tahun Angkatan</label>
                        <div class="col-sm-9">
                            <?= $this->html->dropDownList('Filter[tahun_angkatan]', '', [], [
                                'class' => 'form-control',
                                'tabIndex' => 1,
                                'id' => 'select-tahun_angkatan',
                                'prompt' => '- Pilih -',
                                'required' => true
                            ]) ?>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label for="input-date_start" class="col-sm-3 col-form-label">Dari Tanggal</label>
                        <div class="col-sm-9">
                            <?= $this->html->textInput('Filter[tanggal_awal]', '', [
                                'class' => 'form-control',
                                'tabIndex' => 3,
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
                                'tabIndex' => 4,
                                'id' => 'input-date_end',
                                'type' => 'date',
                                'max' => date('Y-m-d')
                            ]) ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary my-3 float-end">Apply Filter</button>
                </div>
            </div>

            <?= form_close(); ?>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="float-end">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-cloud-download"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#" id="link-export-pdf" target="_blank">
                        <i class="bi bi-file-earmark-pdf text-danger"></i> PDF</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div id="table-recapitulation">
            <?= $this->layout->renderPartial('table-recap'); ?>
        </div>
    </div>
</div>
