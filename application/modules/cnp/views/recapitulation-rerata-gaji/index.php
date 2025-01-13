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

                    <?= $this->html->a('COLLEGE', '/cnp/recapitulation-rerata-gaji/college', [
                        'class' => 'nav-link '. $active_college
                    ]) ?>
                    <?= $this->html->a('LP3I JAKARTA', '/cnp/recapitulation-rerata-gaji/plj', [
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
            <div class="row">
                <div class="col-lg-6 offset-lg-3" id="form-filter">
                    <div class="row mt-3">
                        <label for="select-jenis" class="col-sm-4 col-form-label required">Jenis Rekapitulasi</label>
                        <div class="col-sm-8">
                            <?= $this->html->dropDownList('Filter[jenis]', '', [
                                1 => 'Nasional',
                                2 => 'Per Cabang',
                            ], [
                                'class' => 'form-select',
                                'tabIndex' => 1,
                                'id' => 'select-jenis',
                                'prompt' => '- Pilih -',
                                'required' => true
                            ]) ?>
                        </div>
                    </div>

                    <button type="button" id="btn-filter" class="btn btn-primary my-3 float-end">Apply Filter</button>
                </div>
            </div>
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
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" id="table-recap_tools">
                    <li><a class="dropdown-item" href="#" id="link-export-pdf" target="_blank">
                        <i class="bi bi-file-earmark-pdf text-danger"></i> PDF</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div id="table-recapitulation">
            <?= $this->layout->renderPartial('_table_recap_rerata-nasional'); ?>
        </div>
    </div>
</div>
