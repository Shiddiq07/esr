<script type="text/javascript">
	const src = '<?= !empty($src) ? $src : null ?>';
	let datatableUrl = `<?= site_url('/cnp/recapitulation-alumni-karir/get-data/' . $src) ?>`

	const defCabang = '<?= $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : '' ?>';
</script>

<script type="text/javascript">
	$(document).ready(function() {
		if (defCabang) {
			getListTahun(defCabang)
		}
	});

	$(document).on('click', '#btn-filter', function(event) {
		event.preventDefault();

		const cabang = defCabang ? defCabang : $('#select-cabang').val();
		const tahun_angkatan = $('#select-tahun_angkatan').val();
		const status = $('#select-status').val();
		const tanggalDari = $('#input-date_start').val();
		const tanggalSampai = $('#input-date_end').val();

		if (cabang && tahun_angkatan) {
			const queryParams = {
				cabang,
				tahun_angkatan,
				status,
				tanggal_dari: tanggalDari,
				tanggal_sampai: tanggalSampai
			}

			let newDatatableUrl = datatableUrl +'?'+ new URLSearchParams(queryParams);

			datatable($('#table-recap-alumni'), newDatatableUrl, true);

			$('#panel-recap').show()
		}
	});

	$(document).on('change', '#select-cabang', function(event) {
		event.preventDefault();

		const cabang = defCabang ? defCabang : $(this).val();

		getListTahun(cabang)
	});

	$(document).on('input', '#input-date_start, #input-date_end', function(event) {
		updateDateRange();
	});

	function updateDateRange() {
        const dateStart = $('#input-date_start').val();
        const dateEnd = $('#input-date_end').val();

        // Set max and min year
        $('#input-date_start').attr('max', dateEnd);
        $('#input-date_end').attr('min', dateStart);
    }

    function getListTahun(cabang) {
    	fetch("<?= base_url('/cnp/recapitulation-alumni-karir/get-tahun-angkatan/'. $src) ?>?" + new URLSearchParams({cabang}), {
			method: 'GET'
		})
		.then((res) => res.json())
		.then((res) => {
			if (!res || (res && res.status == false)) {
				return false;
			}

			setDropdown(res, 'select-tahun_angkatan');
		});
    }
</script>