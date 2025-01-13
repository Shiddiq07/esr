<?php if (empty($recaps)): ?>

<div class="d-flex flex-column justify-content-center align-items-center">
    <i class="bi bi-exclamation-diamond display-1 mb-3"></i>
    <h1 class="display-4">Rekapitulasi Kosong</h1>
    <p class="text-muted">Silahkan atur filter.</p>
</div>

<?php else: ?>

<style type="text/css">
    table.table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table.table td, table.table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    table.table tr:hover {background-color: #ddd;}

    table.table th {
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

    .bg-secondary {
        background-color: #e9ecef;
    }

    .bg-dark {
        background-color: #212529 !important;
        color: #ffffff !important;
    }

    .bg-dark-subtle {
        background-color: #ced4da !important;
    }

    .text-nowrap {
        white-space: nowrap !important;
    }
</style>

<?php if (!empty($is_pdf)): ?>

<div style="text-align: center;">
    <h2>REKAPITULASI RATA-RATA GAJI</h2>
    <h5>TAHUN ANGKATAN <?= $filter['tahun_angkatan'] ?></h5>
</div>

<table width="100%">
    <tr>
        <td>Cabang: <?= $kampus ?></td>
        <td align="right">Tervalidasi: <?= $recaps[0]['tgl_validasi'] ?></td>
    </tr>
</table>

<?php endif ?>

<div class="table-responsive mt-4">
    <table class="table table-bordered text-center small">
        <thead class="bg-primary">
            <tr>
                <th rowspan="2" class="bg-dark">NO</th>
                <th rowspan="2" class="bg-dark">JURUSAN</th>
                <th rowspan="2" class="bg-dark">KERJA</th>
                <th colspan="8" class="bg-dark">RATA-RATA GAJI</th>
            </tr>

            <tr>
                <?php foreach ($skalas as $key => $skala): ?>

                <th class="bg-dark"><?= $skala->skala ?></th>
                <th class="bg-dark">%</th>

                <?php endforeach ?>
            </tr>
        </thead>

        <tbody>
            <?php
            $total_tertempatkan = $total_skala1 = $total_skala2 = $total_skala3 = $total_skala4 = 0;

            foreach ($recaps as $key => $recap):
                $total_tertempatkan += $recap['total_tertempatkan'];
                $total_skala1 += $recap['skala1'];
                $total_skala2 += $recap['skala2'];
                $total_skala3 += $recap['skala3'];
                $total_skala4 += $recap['skala4'];
            ?>

            <tr>
                <td><?= ($key + 1) ?></td>
                <td align="left"><?= $model_jurusan->getNamaJurusan($recap['kodejurusan']) ?></td>
                <td><?= number_format($recap['total_tertempatkan']) ?></td>
                <td><?= number_format($recap['skala1']) ?></td>
                <td><?= formatNumber(($recap['skala1'] / $recap['total_tertempatkan']) * 100) ?>%</td>
                <td><?= number_format($recap['skala2']) ?></td>
                <td><?= formatNumber(($recap['skala2'] / $recap['total_tertempatkan']) * 100) ?>%</td>
                <td><?= number_format($recap['skala3']) ?></td>
                <td><?= formatNumber(($recap['skala3'] / $recap['total_tertempatkan']) * 100) ?>%</td>
                <td><?= number_format($recap['skala4']) ?></td>
                <td><?= formatNumber(($recap['skala4'] / $recap['total_tertempatkan']) * 100) ?>%</td>
            </tr>

            <?php endforeach ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="2" class="bg-dark">Grand Total</th>
                <th class="bg-dark-subtle"><?= number_format($total_tertempatkan) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_skala1) ?></th>
                <th class="bg-dark-subtle"><?= formatNumber(($total_skala1 / $total_tertempatkan) * 100) ?>%</th>
                <th class="bg-dark-subtle"><?= number_format($total_skala2) ?></th>
                <th class="bg-dark-subtle"><?= formatNumber(($total_skala2 / $total_tertempatkan) * 100) ?>%</th>
                <th class="bg-dark-subtle"><?= number_format($total_skala3) ?></th>
                <th class="bg-dark-subtle"><?= formatNumber(($total_skala3 / $total_tertempatkan) * 100) ?>%</th>
                <th class="bg-dark-subtle"><?= number_format($total_skala4) ?></th>
                <th class="bg-dark-subtle"><?= formatNumber(($total_skala4 / $total_tertempatkan) * 100) ?>%</th>
            </tr>
        </tfoot>
    </table>
</div>

<?php endif ?>