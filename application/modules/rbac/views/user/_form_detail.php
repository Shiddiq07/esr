<?= form_open('', ['id' => 'form-detail']); ?>

    <div class="form-group">
        <?= form_label('Nama Karyawan', 'id_nama_depan'); ?>
        <div class="row">
            <div class="col-md-4">
                <?= Html::activeTextInput($model, 'nama_depan', [
                    'class' => 'form-control',
                    'id' => 'id_nama_depan',
                    'placeholder' => 'Nama Depan',
                    'required' => true,
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= Html::activeTextInput($model, 'nama_tengah', [
                    'class' => 'form-control',
                    'id' => 'id_nama_tengah',
                    'placeholder' => 'Nama Tengah',
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= Html::activeTextInput($model, 'nama_belakang', [
                    'class' => 'form-control',
                    'id' => 'id_nama_belakang',
                    'placeholder' => 'Nama Belakang',
                ]) ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= form_label('Nomor Induk Karyawan', 'id_nik'); ?>
        <?= Html::activeTextInput($model, 'nik', [
            'class' => 'form-control',
            'id' => 'id_nik'
        ]) ?>
    </div>

	<div class="form-group">
		<?= form_label('Tanggal Gabung', 'id_tanggal_gabung'); ?>
        <?= Html::activeTextInput($model, 'tanggal_gabung', [
            'class' => 'form-control datepicker',
            'id' => 'id_tanggal_gabung',
            'placeholder' => 'dd-mm-yyyy',
        ]) ?>
	</div>

	<div class="form-group">
		<?= form_label('Tanggal Selesai', 'id_tanggal_selesai'); ?>
        <?= Html::activeTextInput($model, 'tanggal_selesai', [
            'class' => 'form-control datepicker',
            'id' => 'id_tanggal_selesai',
            'placeholder' => 'dd-mm-yyyy',
        ]) ?>
	</div>

<?= form_close(); ?>
