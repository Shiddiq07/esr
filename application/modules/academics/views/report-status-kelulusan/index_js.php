<script type="text/javascript">
	const src = '<?= !empty($src) ? $src : null ?>';
	let datatableUrl = `<?= site_url('/academics/report-status-kelulusan/get-data/' . $src) ?>`

	const defCabang = '<?= $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : '' ?>';
</script>
<script src="<?= base_url('web/assets/js/api-list-helper.js') ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
		if (defCabang) {
			datatableUrl += `?${ new URLSearchParams({cabang: defCabang}) }`

			datatable($('#table-report-status'), datatableUrl, true);

			$('#panel-recap').show();
		}
	});

	$(document).on('change', '#select-cabang', async function(event) {
		event.preventDefault();

		const cabang = $(this).val();

		$('#select-tahun_angkatan').empty().append('<option value="">- Pilih -</option>')

		if (!cabang) return;

		await getTahunBiodata('select-tahun_angkatan', cabang);
	});

	$(document).on('change', '#select-cabang', async function(event) {
		event.preventDefault();

		const cabang = $('#select-cabang').val();
		const tahunAngkatan = $('#select-tahun_angkatan').val();

		$('#select-jurusan').empty().append('<option value="">- Pilih -</option>')

		if (!cabang) return;

		await getJurusanByCabang('select-jurusan', tahunAngkatan, cabang);
	});

	$(document).on('click', '#btn-filter', function(event) {
		event.preventDefault();

		const cabang = defCabang ? defCabang : $('#select-cabang').val();
		const tahun_angkatan = $('#select-tahun_angkatan').val();
		const jurusan = $('#select-jurusan').val();

		if (cabang) {
			const queryParams = {
				cabang,
				tahun_angkatan,
				jurusan
			}

			datatableUrl += `?${ new URLSearchParams(queryParams) }`

			datatable($('#table-report-status'), datatableUrl, true);

			$('#panel-recap').show();
		}
	});
</script>