<div class="card">
    <div class="card-header">
        <?php if (!empty($nama_cabang)): ?>
            <h5 class="float-start"><?= $nama_cabang ?></h5>
        <?php endif ?>

        <div class="float-end">
            <div class="dropdown dt-buttons">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-cloud-download"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" id="table-detail_tools">
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

    <div class="card-body p-3">
        <table class="table table-bordered table-striped" id="table-detail">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Cabang</th>
                    <th>Jurusan</th>
                    <th>Periode</th>
                    <th>Tingkat</th>
                </tr>
            </thead>

            <tbody>
                <tr><td colspan="7"><i>Data tidak tersedia.</i></td></tr>
            </tbody>
        </table>
    </div>
</div>
