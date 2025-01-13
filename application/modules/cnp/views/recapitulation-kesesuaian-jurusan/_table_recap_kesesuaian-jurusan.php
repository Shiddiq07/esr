<?php if (empty($recaps)): ?>

<div class="d-flex flex-column justify-content-center align-items-center">
    <i class="bi bi-exclamation-diamond display-1 mb-3"></i>
    <h1 class="display-4">Rekapitulasi Kosong</h1>
    <p class="text-muted">Silahkan atur filter.</p>
</div>

<?php else: ?>

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
    <h2>REKAPITULASI KESESUAIAN JURUSAN</h2>
    <h5>TAHUN LULUSAN <?= $filter['tahun_angkatan'] ?></h5>
</div>    

<small>Cabang: <?= ucwords($kampus) ?></small>

<?php endif ?>

<div class="table-responsive mt-4">
    <table class="table table-bordered text-center small">
        <thead class="bg-primary">
            <tr>
                <th class="bg-dark">NO</th>
                <th class="bg-dark">JURUSAN</th>
                <th class="bg-dark">TARGET</th>
                <th class="bg-dark">KERJA</th>
                <th class="bg-dark">SESUAI</th>
                <th class="bg-dark">RASIO</th>
                <th class="bg-dark">TIDAK SESUAI</th>
                <th class="bg-dark">RASIO</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $total_target = 0;
            $total_penempatan = 0;
            $total_sesuai = 0;
            $total_tidak_sesuai = 0;

            foreach ($recaps as $key => $recap):

                $total_target += $recap['target'];
                $total_penempatan += $recap['penempatan'];
                $total_sesuai += $recap['sesuai'];
                $total_tidak_sesuai += $recap['tidak_sesuai'];
            ?>

            <tr>
                <td><?= ($key + 1) ?></td>
                <td align="left"><?= $recap['namajurusan'] ?></td>
                <td class="<?= $recap['target'] > 0 ? '' : 'bg-secondary' ?>"><?= formatNumber($recap['target']) ?></td>
                <td class="<?= $recap['penempatan'] > 0 ? '' : 'bg-secondary' ?>"><?= formatNumber($recap['penempatan']) ?></td>
                <td class="<?= $recap['sesuai'] > 0 ? '' : 'bg-secondary' ?>"><?= formatNumber($recap['sesuai']) ?></td>
                <td class="<?= $recap['sesuai_rasio'] > 0 ? '' : 'bg-secondary' ?>"><?= $recap['sesuai_rasio'] > 0 ? formatNumber($recap['sesuai_rasio']) .'%' : '' ?></td>
                <td class="<?= $recap['tidak_sesuai'] > 0 ? '' : 'bg-secondary' ?>"><?= formatNumber($recap['tidak_sesuai']) ?></td>
                <td class="<?= $recap['tidak_rasio'] > 0 ? '' : 'bg-secondary' ?>"><?= $recap['tidak_rasio'] > 0 ? formatNumber($recap['tidak_rasio']) .'%' : '' ?></td>
            </tr>

            <?php endforeach ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="2" class="bg-dark">Total</th>
                <th class="bg-dark-subtle"><?= formatNumber($total_target) ?></th>
                <th class="bg-dark-subtle"><?= formatNumber($total_penempatan) ?></th>
                <th class="bg-dark-subtle"><?= formatNumber($total_sesuai) ?></th>
                <th class="bg-dark-subtle"><?= formatNumber(($total_sesuai / $total_penempatan) * 100, 1) . '%' ?></th>
                <th class="bg-dark-subtle"><?= formatNumber($total_tidak_sesuai) ?></th>
                <th class="bg-dark-subtle"><?= formatNumber(($total_tidak_sesuai / $total_penempatan) * 100, 1) . '%' ?></th>
            </tr>
        </tfoot>
    </table>
</div>

<?php endif ?>