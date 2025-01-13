<?php if (isset($vanilla_css) && $vanilla_css === true): ?>

<style type="text/css">
table {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

table td, table th {
    border: 1px solid #ddd;
    padding: 8px;
}

table tr:hover {background-color: #ddd;}

table th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: center;
    background-color: rgb(108, 117, 125);
    color: white;
    vertical-align: middle;
}

.text-uppercase {
    text-transform: uppercase;
}

.fw-bold {
    font-weight: bold;
}

.text-start {
    text-align: left;
}
</style>

<?php endif ?>

<div class="table-responsive mt-4">
    <table class="table table-bordered text-center small">
        <thead class="bg-primary">
            <tr>
                <th rowspan="2" class="bg-secondary text-light" valign="middle">KAMPUS</th>
                <th rowspan="2" class="bg-secondary text-light" valign="middle">KETERANGAN</th>
                <?php /*<th colspan="<?= !empty($recaps['jurusan']) ? count($recaps['jurusan'][$recaps['periode'][0]]) * 2 : 2 ?>" class="bg-secondary text-light">ANGKATAN <?= $tahun ?></th>*/ ?>

                <?php if ($recaps['periode']): ?>

                    <?php foreach ($recaps['periode'] as $key => $periode): ?>

                    <th colspan="<?= count($recaps['jurusan'][$periode]) ?>" 
                        class="text-uppercase bg-secondary text-light"><?= 'Angkatan '. substr($periode, 0, 4) .' <hr/> Tingkat - '. substr($periode, -1) ?></th>

                    <?php endforeach ?>

                <?php else: ?>

                    <th class="text-uppercase bg-secondary text-light"><?= explode('-', $tahun)[0] .'1' ?></th>
                    <th class="text-uppercase bg-secondary text-light"><?= explode('-', $tahun)[0] .'2' ?></th>

                <?php endif ?>
            </tr>

            <tr>
                <?php if ($recaps['periode']): ?>
                    
                    <?php foreach ($recaps['periode'] as $key => $periode): ?>

                        <?php
                        foreach ($recaps['jurusan'][$periode] as $kode => $jurusan):
                            $nama_jurusan = explode('-', $jurusan)
                        ?>
                            
                        <th class="bg-secondary text-light"><span title="<?= $nama_jurusan[1] ?>"><?= $nama_jurusan[0] ?></span></th>

                        <?php endforeach ?>

                    <?php endforeach ?>

                <?php else: ?>

                    <th class="bg-secondary text-light">&nbsp;</th>
                    <th class="bg-secondary text-light">&nbsp;</th>

                <?php endif ?>
            </tr>
        </thead>

        <tbody>
            <?php if ($recaps['cabang']): ?>
                
                <?php foreach ($recaps['cabang'] as $kode_cabang => $cabang): ?>

                <tr>
                    <td class="text-uppercase fw-bold" rowspan="7" valign="middle"><?= $cabang ?></td>
                </tr>

                    <?php foreach ($recaps['values'] as $status => $value): ?>

                    <tr>                        
                        <td class="text-uppercase text-start"><?= slugToName($status) ?></td>

                        <?php foreach ($recaps['periode'] as $key => $periode): ?>

                            <?php foreach ($recaps['jurusan'][$periode] as $kode_jurusan => $jurusan): ?>

                            <td><?= !empty($value[$kode_cabang][$periode][$kode_jurusan]) ? 
                                number_format($value[$kode_cabang][$periode][$kode_jurusan]) : 0 ?></td>

                            <?php endforeach ?>

                        <?php endforeach ?>

                    </tr>

                    <?php endforeach ?>

                <tr>
                    <td colspan="<?= (count($recaps['jurusan'][$recaps['periode'][0]]) * 2) + 2 ?>" style="padding: 1px">&nbsp;</td>
                </tr>

                <?php endforeach ?>

                <tr>
                    <td rowspan="7" valign="middle" class="text-uppercase fw-bold">Sub Total</td>
                </tr>

                <?php foreach ($recaps['subtotal'] as $status => $value): ?>

                <tr>                        
                    <td class="text-uppercase text-start"><?= slugToName($status) ?></td>

                    <?php foreach ($recaps['periode'] as $key => $periode): ?>

                        <?php foreach ($recaps['jurusan'][$periode] as $kode_jurusan => $jurusan): ?>

                        <td class="fw-bold"><?= !empty($value[$periode][$kode_jurusan]) ? 
                            number_format($value[$periode][$kode_jurusan]) : 0 ?></td>

                        <?php endforeach ?>

                    <?php endforeach ?>

                </tr>

                <?php endforeach ?>

            <?php else: ?>

                <tr>
                    <td colspan="4"><i>Data belum ada.</i></td>
                </tr>

            <?php endif ?>
        </tbody>
    </table>
</div>
