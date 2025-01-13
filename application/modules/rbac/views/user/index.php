<h1 class="page-title">User</h1>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body pt-3">
            	<div class="table-toolbar mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="<?= site_url('/rbac/user/create') ?>" class="btn sbold btn-primary"> Tambah
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            	<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table-user">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Status User</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detail" tabindex="-1" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <?= $this->load->view('_form_detail', [
                    'model' => $model
                ]); ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="form-detail" id="btn-save" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
