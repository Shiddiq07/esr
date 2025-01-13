<script type="text/javascript">
	const src = '<?= !empty($src) ? $src : null ?>';
</script>
<script src="<?= base_url('web/assets/js/api-list-helper.js') ?>"></script>

<script type="text/javascript">
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

		const cabang = $('#select-cabang').val();
		const tahun_angkatan = $('#select-tahun_angkatan').val();
		const jurusan = $('#select-jurusan').val();

		if ((cabang || tahun_angkatan) && jurusan) {
			const queryParams = {
				cabang,
				tahun_angkatan,
				jurusan
			}

			const datatableUrl = `<?= site_url('/academics/report-rerata-ipk/get-data/' . $src) ?>?${ new URLSearchParams(queryParams) }`

			datatable($('#table-report-rerata'), datatableUrl, true);

			$('#panel-recap').show()
		}
	});
</script>
