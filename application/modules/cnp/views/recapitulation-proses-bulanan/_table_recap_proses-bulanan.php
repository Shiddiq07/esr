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
    <h2>TABULASI PENEMPATAN MAGANG & KERJA</h2>
    <h5>TAHUN LULUSAN <?= $filter['tahun_angkatan'] ?></h5>
</div>    

<?php endif ?>

<div class="table-responsive mt-4">
    <table class="table table-bordered text-center small">
        <thead class="bg-primary">
            <tr>
                <th rowspan="3" class="bg-dark-subtle">NO</th>
                <th rowspan="3" class="bg-dark-subtle">CABANG</th>
                <th rowspan="3" class="bg-dark-subtle">TOTAL MHS REGULER</th>
                <th rowspan="3" class="bg-dark-subtle">NON TARGET</th>
                <th rowspan="3" class="bg-dark-subtle">TOTAL TARGET</th>
                <th colspan="9" class="bg-dark">WAJIB KERJA</th>
                <th colspan="9" class="bg-dark">DIBANTU KERJA</th>
                <th rowspan="3" class="bg-dark-subtle">ON PROSES</th>
                <th rowspan="3" class="bg-dark-subtle">TANGGAL UPDATE</th>
            </tr>

            <tr>
                <th colspan="9" class="bg-dark">IPK 3.00 - 4.00</th>
                <th colspan="9" class="bg-dark">IPK 2.75 - 2.99</th>
            </tr>

            <tr>
                <th class="bg-dark">TARGET</th>
                <th class="bg-dark">BY LP3I</th>
                <th class="bg-dark">%</th>
                <th class="bg-dark">SENDIRI</th>
                <th class="bg-dark">%</th>
                <th class="bg-dark">WIRAUSAHA</th>
                <th class="bg-dark">%</th>
                <th class="bg-dark">MAGANG</th>
                <th class="bg-dark">%</th>

                <th class="bg-dark">TARGET</th>
                <th class="bg-dark">BY LP3I</th>
                <th class="bg-dark">%</th>
                <th class="bg-dark">SENDIRI</th>
                <th class="bg-dark">%</th>
                <th class="bg-dark">WIRAUSAHA</th>
                <th class="bg-dark">%</th>
                <th class="bg-dark">MAGANG</th>
                <th class="bg-dark">%</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $total_mhs = 0;
            $total_non_target = 0;
            $total_target = 0;
            $total_target_wajib = 0;
            $total_real_wajib_cnp = 0;
            $total_real_wajib_sendiri = 0;
            $total_real_wajib_wirausaha = 0;
            $total_target_dibantu = 0;
            $total_real_dibantu_cnp = 0;
            $total_real_dibantu_sendiri = 0;
            $total_real_dibantu_wirausaha = 0;
            $total_proses = 0;

            foreach ($recaps as $key => $recap):
                $kampus = ($src == 'college') ? str_replace('KAMPUS', '', strtoupper($recap['namacabang'])) : strtoupper($recap['namacabang']);

                $target_wajib = $recap['target_wajib'] ? $recap['target_wajib'] : '';
                $real_wajib_cnp = $recap['real_wajib_cnp'] ? $recap['real_wajib_cnp'] : '';
                $real_wajib_sendiri = $recap['real_wajib_sendiri'] ? $recap['real_wajib_sendiri'] : '';
                $real_wajib_wirausaha = $recap['real_wajib_wirausaha'] ? $recap['real_wajib_wirausaha'] : '';
                $target_dibantu = $recap['target_dibantu'] ? $recap['target_dibantu'] : '';
                $real_dibantu_cnp = $recap['real_dibantu_cnp'] ? $recap['real_dibantu_cnp'] : '';
                $real_dibantu_sendiri = $recap['real_dibantu_sendiri'] ? $recap['real_dibantu_sendiri'] : '';
                $real_dibantu_wirausaha = $recap['real_dibantu_wirausaha'] ? $recap['real_dibantu_wirausaha'] : '';

                $real_wajib_cnp_per = $recap['real_wajib_cnp'] ? round(($recap['real_wajib_cnp'] / $recap['target_wajib']) * 100) .'%' : '';
                $real_wajib_sendiri_per = $recap['real_wajib_sendiri'] ? round(($recap['real_wajib_sendiri'] / $recap['target_wajib']) * 100) .'%' : '';
                $real_wajib_wirausaha_per = $recap['real_wajib_wirausaha'] ? round(($recap['real_wajib_wirausaha'] / $recap['target_wajib']) * 100) .'%' : '';
                $real_dibantu_cnp_per = $recap['real_dibantu_cnp'] ? round(($recap['real_dibantu_cnp'] / $recap['target_dibantu']) * 100) .'%' : '';
                $real_dibantu_sendiri_per = $recap['real_dibantu_sendiri'] ? round(($recap['real_dibantu_sendiri'] / $recap['target_dibantu']) * 100) .'%' : '';
                $real_dibantu_wirausaha_per = $recap['real_dibantu_wirausaha'] ? round(($recap['real_dibantu_wirausaha'] / $recap['target_wajib']) * 100) .'%' : '';

                $proses = $recap['total_target'] ? $recap['total_target'] - (array_sum([$real_wajib_cnp, $real_wajib_sendiri, $real_wajib_wirausaha]) + array_sum([$real_dibantu_cnp, $real_dibantu_sendiri, $real_dibantu_wirausaha])) : '';

                // Sum Wajib
                $total_mhs += $recap['jumlah_mahasiswa'];
                $total_non_target += ($recap['jumlah_mahasiswa'] - $recap['total_target']);
                $total_target += $recap['total_target'];
                $total_target_wajib += $target_wajib ? $target_wajib : 0;
                $total_real_wajib_cnp += $real_wajib_cnp ? $real_wajib_cnp : 0;
                $total_real_wajib_sendiri += $real_wajib_sendiri ? $real_wajib_sendiri : 0;
                $total_real_wajib_wirausaha += $real_wajib_wirausaha ? $real_wajib_wirausaha : 0;

                // Sum Dibantu
                $total_target_dibantu += $target_dibantu ? $target_dibantu : 0;
                $total_real_dibantu_cnp += $real_dibantu_cnp ? $real_dibantu_cnp : 0;
                $total_real_dibantu_sendiri += $real_dibantu_sendiri ? $real_dibantu_sendiri : 0;
                $total_real_dibantu_wirausaha += $real_dibantu_wirausaha ? $real_dibantu_wirausaha : 0;

                $total_proses += $proses ? $proses : 0;
            ?>
                <tr>
                    <td><?= ($key + 1) ?></td>
                    <td align="left" class="text-nowrap"><?= $kampus ?></td>
                    <td><?= $recap['jumlah_mahasiswa'] ?></td>
                    <td><?= ($recap['jumlah_mahasiswa'] - $recap['total_target']) ?></td>
                    <td><?= $recap['total_target'] ?></td>

                    <td class="fw-bold <?= $target_wajib ? '' : 'bg-secondary' ?>"><?= $target_wajib ?></td>
                    <td class="<?= $real_wajib_cnp ? '' : 'bg-secondary' ?>"><?= $real_wajib_cnp ?></td>
                    <td class="<?= $real_wajib_cnp_per ? '' : 'bg-secondary' ?>"><?= $real_wajib_cnp_per ?></td>
                    <td class="<?= $real_wajib_sendiri ? '' : 'bg-secondary' ?>"><?= $real_wajib_sendiri ?></td>
                    <td class="<?= $real_wajib_sendiri_per ? '' : 'bg-secondary' ?>"><?= $real_wajib_sendiri_per ?></td>
                    <td class="<?= $real_wajib_wirausaha ? '' : 'bg-secondary' ?>"><?= $real_wajib_wirausaha ?></td>
                    <td class="<?= $real_wajib_wirausaha_per ? '' : 'bg-secondary' ?>"><?= $real_wajib_wirausaha_per ?></td>
                    <td class="bg-secondary">&nbsp;</td>
                    <td class="bg-secondary">&nbsp;</td>

                    <td class="fw-bold <?= $target_dibantu ? '' : 'bg-secondary' ?>"><?= $target_dibantu ?></td>
                    <td class="<?= $real_dibantu_cnp ? '' : 'bg-secondary' ?>"><?= $real_dibantu_cnp ?></td>
                    <td class="<?= $real_dibantu_cnp_per ? '' : 'bg-secondary' ?>"><?= $real_dibantu_cnp_per ?></td>
                    <td class="<?= $real_dibantu_sendiri ? '' : 'bg-secondary' ?>"><?= $real_dibantu_sendiri ?></td>
                    <td class="<?= $real_dibantu_sendiri_per ? '' : 'bg-secondary' ?>"><?= $real_dibantu_sendiri_per ?></td>
                    <td class="<?= $real_dibantu_wirausaha ? '' : 'bg-secondary' ?>"><?= $real_dibantu_wirausaha ?></td>
                    <td class="<?= $real_dibantu_wirausaha_per ? '' : 'bg-secondary' ?>"><?= $real_dibantu_wirausaha_per ?></td>
                    <td class="bg-secondary">&nbsp;</td>
                    <td class="bg-secondary">&nbsp;</td>

                    <td class="<?= $proses ? '' : 'bg-secondary' ?>"><?= $proses ? $proses : '' ?></td>
                    <td class="text-nowrap"><?= $recap['tgl_input'] ? date('d-m-Y H:i:s', strtotime($recap['tgl_input'])) : '' ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="2" class="bg-dark-subtle">Total</th>
                <th class="bg-dark-subtle"><?= number_format($total_mhs) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_non_target) ?></th>
                <th class="bg-dark-subtle"><?= number_format($total_target) ?></th>
                <th class="bg-dark"><?= number_format($total_target_wajib) ?></th>
                <th class="bg-dark"><?= number_format($total_real_wajib_cnp) ?></th>
                <th class="bg-dark"><?= $total_real_wajib_cnp ? round(($total_real_wajib_cnp / $total_target_wajib) * 100) : 0 ?>%</th>
                <th class="bg-dark"><?= number_format($total_real_wajib_sendiri) ?></th>
                <th class="bg-dark"><?= $total_real_wajib_sendiri ? round(($total_real_wajib_sendiri / $total_target_wajib) * 100) : 0 ?>%</th>
                <th class="bg-dark"><?= number_format($total_real_wajib_wirausaha) ?></th>
                <th class="bg-dark"><?= $total_real_wajib_wirausaha ? round(($total_real_wajib_wirausaha / $total_target_wajib) * 100) : 0 ?>%</th>
                <th class="bg-dark">&nbsp;</th>
                <th class="bg-dark">&nbsp;</th>

                <th class="bg-dark"><?= number_format($total_target_dibantu) ?></th>
                <th class="bg-dark"><?= number_format($total_real_dibantu_cnp) ?></th>
                <th class="bg-dark"><?= $total_real_dibantu_cnp ? round(($total_real_dibantu_cnp / $total_target_dibantu) * 100) : 0 ?>%</th>
                <th class="bg-dark"><?= number_format($total_real_dibantu_sendiri) ?></th>
                <th class="bg-dark"><?= $total_real_dibantu_sendiri ? round(($total_real_dibantu_sendiri / $total_target_dibantu) * 100) : 0 ?>%</th>
                <th class="bg-dark"><?= number_format($total_real_dibantu_wirausaha) ?></th>
                <th class="bg-dark"><?= $total_real_dibantu_wirausaha ? round(($total_real_dibantu_wirausaha / $total_target_dibantu) * 100) : 0 ?>%</th>
                <th class="bg-dark">&nbsp;</th>
                <th class="bg-dark">&nbsp;</th>
                <th class="bg-dark-subtle"><?= number_format($total_proses) ?></th>
            </tr>
        </tfoot>
    </table>
</div>

<?php endif ?>