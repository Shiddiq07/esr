<script type="text/javascript">
	$(document).ready(function() {
		let url = `<?= base_url('/academics/dashboard/get-data-detail') ?>/<?= $src ?>?periode=<?= $periode ?>&status=<?= $status ?>`;

		<?php if ($kode_jurusan): ?>
			url += '&kode_jurusan=<?= $kode_jurusan ?>';
		<?php endif ?>

		<?php if ($kode_cabang): ?>
			url += '&kode_cabang=<?= $kode_cabang ?>';
		<?php endif ?>

    	datatable($("#table-detail"), url, true);
    });
</script>
