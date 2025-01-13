<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body pt-3">
            	<div class="table-toolbar mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button id="btn-add" class="btn sbold btn-primary"> Tambah
                                    <i class="bi bi-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            	<table class="table table-striped table-bordered table-hover dt-responsive mt-2" width="100%" id="table-group">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Permission</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade draggable-modal" id="draggable" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Basic Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <fieldset id="field-single">
                    <?= form_open('', ['id' => 'form-single']); ?>

                        <div class="form-group">
                            <?= form_label('Nama Permission', 'id_name'); ?>
                            <?= form_input('Permission[name]', '', [
                                'class' => 'form-control',
                                'id' => 'id_name',
                                'required' => true,
                                'onkeypress' => 'return stringStrip(event)'
                            ]); ?>
                            <small class="help-block text-mute">Nama permission menggunakan huruf dan strip (-)</small>
                        </div>

                        <div class="form-group">
                            <?= form_label('Deskripsi', 'id_description'); ?>
                            <?= form_textarea('Permission[description]', '', [
                                'class' => 'form-control',
                                'id' => 'id_description',
                                'style' => 'height:100px;resize:none;'
                            ]); ?>
                        </div>

                    <?= form_close(); ?>
                </fieldset>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btn-save" class="btn btn-primary" data-style="expand-right">
                    <span class="ladda-label">Simpan</span></button>
            </div>
        </div>
    </div>
</div>
