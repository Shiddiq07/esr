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

    .bg-danger, tr.bg-danger td {
        background-color: #dc3545 !important;
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
    <h2>REKAPITULASI DATA PERMINTAAN PERUSAHAAN</h2>
    <h5>TAHUN <?= $filter['tahun_angkatan'] ?></h5>
</div>

<?php endif ?>

<div class="table-responsive mt-4">
    <table class="table table-bordered text-center small">
        <thead class="bg-primary">
            <tr>
                <th class="bg-dark">NO</th>
                <th class="bg-dark">CABANG</th>
                <th class="bg-dark">JAN</th>
                <th class="bg-dark">FEB</th>
                <th class="bg-dark">MAR</th>
                <th class="bg-dark">APR</th>
                <th class="bg-dark">MEI</th>
                <th class="bg-dark">JUN</th>
                <th class="bg-dark">JUL</th>
                <th class="bg-dark">AGU</th>
                <th class="bg-dark">SEP</th>
                <th class="bg-dark">OKT</th>
                <th class="bg-dark">NOV</th>
                <th class="bg-dark">DES</th>
                <th class="bg-dark">TOTAL</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $subtotal = 0;
            $total_jan = $total_feb = $total_mar = $total_apr = $total_mei = $total_jun = $total_jul = $total_agu = $total_sep = $total_okt = $total_nov = $total_des = 0;

            foreach ($recaps as $key => $recap):
                $total = $recap['jan'] + $recap['feb'] + $recap['mar'] + $recap['apr'] + $recap['mei'] + $recap['jun'] + $recap['jul'] + $recap['agu'] + $recap['sep'] + $recap['okt'] + $recap['nov'] + $recap['des'];
                $subtotal = $subtotal + $total;

                $total_jan += $recap['jan'];
                $total_feb += $recap['feb'];
                $total_mar += $recap['mar'];
                $total_apr += $recap['apr'];
                $total_mei += $recap['mei'];
                $total_jun += $recap['jun'];
                $total_jul += $recap['jul'];
                $total_agu += $recap['agu'];
                $total_sep += $recap['sep'];
                $total_okt += $recap['okt'];
                $total_nov += $recap['nov'];
                $total_des += $recap['des'];

                $is_aktif = strtolower($recap['kelompok']) == Cabang::KELOMPOK_AKTIF || $recap['kelompok'] == Cabang::KELOMPOK_AKTIF_INT;
            ?>

            <tr class="<?= $is_aktif ? '' : 'bg-danger' ?>">
                <td><?= ($key + 1) ?></td>
                <td align="left"><?= $src == 'college' ? str_replace('Kampus ', '', $recap['namacabang']) : $recap['namacabang'] ?></td>
                <td class="<?= $recap['jan'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['jan']) ?></td>
                <td class="<?= $recap['feb'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['feb']) ?></td>
                <td class="<?= $recap['mar'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['mar']) ?></td>
                <td class="<?= $recap['apr'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['apr']) ?></td>
                <td class="<?= $recap['mei'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['mei']) ?></td>
                <td class="<?= $recap['jun'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['jun']) ?></td>
                <td class="<?= $recap['jul'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['jul']) ?></td>
                <td class="<?= $recap['agu'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['agu']) ?></td>
                <td class="<?= $recap['sep'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['sep']) ?></td>
                <td class="<?= $recap['okt'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['okt']) ?></td>
                <td class="<?= $recap['nov'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['nov']) ?></td>
                <td class="<?= $recap['des'] > 0 ? '' : 'bg-secondary' ?>"><?= number_format($recap['des']) ?></td>
                <td class="<?= $total > 0 ? '' : 'bg-secondary' ?>"><?= number_format($total) ?></td>
            </tr>

            <?php endforeach ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="2" class="bg-dark">Total</th>
                <th class="bg-dark-subtle"><?= number_format($total_jan) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_feb) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_mar) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_apr) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_mei) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_jun) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_jul) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_agu) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_sep) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_okt) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_nov) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_des) ?></th>
                <th class="bg-dark-subtle"><?= number_format($subtotal); ?></th>
            </tr>
        </tfoot>
    </table>
</div>

<?php endif ?>