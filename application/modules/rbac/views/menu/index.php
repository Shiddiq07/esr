<div class="card">
    <div class="card-body pt-3">
        <div class="row">
            <div class="col-md-4">
                <?= form_open(); ?>

                    <div class="row g-2">
                        <div class="col-12">
                            <?= form_label('Tipe Menu', 'id_title', ['class' => 'control-label label-required']); ?>
                            <?= form_input('MenuType[title]', def($model, 'title'), ['class' => 'form-control', 'id' => 'id_title']); ?>
                        </div>

                        <div class="col-12">
                            <?= form_label('Deskripsi', 'id_description', ['class' => 'control-label label-required']); ?>
                            <?= form_input('MenuType[description]', def($model, 'description'), ['class' => 'form-control', 'id' => 'id_description']); ?>
                        </div>

                        <div class="col-12">
                            <?= $this->html->submitButton(
                                !empty($model->title) ? 'Update' : 'Save', [
                                    'class' => 'btn btn-primary'
                                ]
                            ) ?>
                        </div>
                    </div>

                <?= form_close() ?>
            </div>

            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-stripped" id="table-menu">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Menu</th>
                                <th>Deskripsi</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list_type as $key => $value): ?>  
                            <tr>
                                <td><?= ($key + 1) ?></td>
                                <td><?= $value->title ?></td>
                                <td><?= $value->description ?></td>
                                <td>
                                    <?= $this->html->a('List Tautan', "/rbac/menu/list-menu/{$value->id}") ?> | 
                                    <?= $this->html->a('Update', "/rbac/menu/{$value->id}") ?> | 
                                    <?= $this->html->a('Delete', "/rbac/menu/hapus/{$value->id}", [
                                        'onclick' => 'return confirm("Yakin ingin hapus?")'
                                    ]) ?>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>