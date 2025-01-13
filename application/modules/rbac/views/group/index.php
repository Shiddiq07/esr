<div class="card">
    <div class="card-body pt-3">
    	<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table-group">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Group</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="draggable" tabindex="-1">
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
	                        <?= form_label('Nama Group', 'id_label'); ?>
	                    	<?= form_input('Group[label]', '', [
	                    		'class' => 'form-control',
	                    		'id' => 'id_label',
                                'required' => true,
	                    	]); ?>
	                    </div>

            			<div class="form-group">
	                    	<?= form_label('Deskripsi Tugas', 'id_desc'); ?>
	                    	<?= form_textarea('Group[desc]', '', [
	                    		'class' => 'form-control',
	                    		'id' => 'id_desc',
                                'style' => 'height:100px;resize:none;'
	                    	]); ?>
            			</div>

                        <div class="form-group">
                            <?= form_label('Group Parent', 'id_parent_id'); ?>
                            <?= form_multiselect('Group[parent_id][]', $list_group, '', [
                                'class' => 'form-control',
                                'id' => 'id_parent_id',
                                // 'style' => 'height:100px;resize:none;'
                            ]); ?>
                        </div>

	        		<?= form_close(); ?>
            	</fieldset>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btn-save" class="btn btn-success" data-style="expand-right">Simpan</button>
            </div>
        </div>
    </div>
</div>
