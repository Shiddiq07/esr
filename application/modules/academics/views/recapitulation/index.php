<div class="row">
    <div class="col">
        <nav class="nav mb-4">
            <div class="container-fluid d-flex">
                <div class="d-flex">
                    <?php if (!$this->helpers->isCollege() && !$this->helpers->isPoltek()): ?>

                    <?php
                        $active_college = $active_plj = $active_akma = '';

                        switch ($src) {
                            case 'college': $active_college = 'active'; break;
                            case 'plj': $active_plj = 'active'; break;
                            case 'akma': $active_akma = 'active'; break;
                        }
                    ?>

                    <?= $this->html->a('COLLEGE', '/academics/recapitulation/college', [
                        'class' => 'nav-link '. $active_college
                    ]) ?>
                    <?= $this->html->a('LP3I JAKARTA', '/academics/recapitulation/plj', [
                        'class' => 'nav-link '. $active_plj
                    ]) ?>

                    <?php endif ?>
                </div>

                <!-- <div class="ms-auto">
                    <a href="">Last Update: 20-05-2024</a>
                </div> -->
            </div>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="float-start d-flex align-items-center">
            <label for="startYear" class="form-label me-2">Dari</label>
            <input type="number" class="form-control me-2" id="startYear" min="1989" max="<?= date('Y') ?>" style="width: 100px;" value="<?= date('Y') ?>">

            <label for="endYear" class="form-label me-2">Sampai</label>
            <input type="number" class="form-control me-2" id="endYear" min="1989" max="<?= date('Y') ?>" style="width: 100px;" value="<?= date('Y') ?>">

            <input type="hidden" class="form-control" id="input-year-recap" value="<?= date('Y') .'-'. date('Y') ?>" readonly style="width: 200px;">
        </div>

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

    <div class="card-body" id="content-table-recapitulation">
        
    </div>
</div>
