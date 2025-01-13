<script type="text/javascript">
	const src = '<?= !empty($src) ? $src : null ?>';
	let urlData = "<?= base_url('/cnp/recapitulation-permintaan/get-table/'. $src) ?>";

	const defCabang = '<?= $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : '' ?>';
</script>

<script type="text/javascript">
	let getRecapTimeout = null;
	const listTahunAngkatan = JSON.parse('<?= json_encode($list_tahun_angkatan) ?>');
	const listCabang = JSON.parse('<?= json_encode($list_cabang) ?>');

	$(document).ready(function() {
		$('#select-jenis').trigger('change');

		if (defCabang) {
			fetch(urlData +'?'+ new URLSearchParams({cabang: defCabang, jenis: 2}), {
			      method: 'GET'
			    })
			      .then((res) => res.text())
			      .then((res) => {
			        $('#table-recapitulation').empty().html(res);

			        // Update link export
					$('[id^=link-export-]').each(function(index, el) {
						const type = $(this).attr('id').split('-').pop();
						$(this).attr('href', `<?= site_url('/cnp/recapitulation-permintaan/export-') ?>${type}/<?= $src ?>?${ new URLSearchParams({cabang: defCabang, jenis: 2}) }`);
					});

					const datatableUrl = `<?= site_url('/cnp/recapitulation-permintaan/get-data/' . $src) ?>?${ new URLSearchParams({cabang: defCabang, jenis: 2}) }`;
					datatable($('#table-recap'), datatableUrl, true);

					$('[id^=link-export-]').hide()
			      })
		}
	});

	$(document).on('change', '#select-jenis', function(event) {
		event.preventDefault();

		const jenis = $(this).val();

		if (jenis == 1) { // Tahun angkatan
			// Remove select cabang
			$('#select-cabang').parent().parent().remove();
			$('#input-date_start').parent().parent().remove();
			$('#input-date_end').parent().parent().remove();

			$('.dropdown-item').show();
			$('.dropdown-item.tool-action').hide();

			const selectTahunAngkatan = $('<div>', {
				class: 'row mt-3'
			}).append(
				$('<label>', {
					for: 'select-tahun_angkatan',
					class: 'col-sm-4 col-form-label required',
					text: 'Tahun Permintaan'
				}),
				$('<div>', {
					class: 'col-sm-8'
				}).append(
					$('<select>', {
						id: 'select-tahun_angkatan',
						class: 'form-select',
						required: true
					})
				)
			);

			$('#form-filter div.row:last').after(selectTahunAngkatan);
			setDropdown(listTahunAngkatan, 'select-tahun_angkatan', '- Pilih -');


		} else if (jenis == 2) {
			// Remove select tahun angkatan
			$('#select-tahun_angkatan').parent().parent().remove();
			$('.dropdown-item').hide();
			$('.dropdown-item.tool-action').show();

			const selectCabang = $('<div>', {
				class: 'row mt-3'
			}).append(
				$('<label>', {
					for: 'select-cabang',
					class: 'col-sm-4 col-form-label required',
					text: 'Cabang'
				}),
				$('<div>', {
					class: 'col-sm-8'
				}).append(
					$('<select>', {
						id: 'select-cabang',
						class: 'form-select',
						required: true
					})
				)
			);

			const inputStart = $('<div>', {
				class: 'row mt-3'
			}).append(
				$('<label>', {
					for: 'input-date_start',
					class: 'col-sm-4 col-form-label',
					text: 'Dari Tanggal'
				}),
				$('<div>', {
					class: 'col-sm-8'
				}).append(
					$('<input>', {
						id: 'input-date_start',
						class: 'form-control',
						type: 'date',
						max: '<?= date('Y-m-d') ?>'
					})
				)
			);

			const inputEnd = $('<div>', {
				class: 'row mt-3'
			}).append(
				$('<label>', {
					for: 'input-date_end',
					class: 'col-sm-4 col-form-label',
					text: 'Sampai Tanggal'
				}),
				$('<div>', {
					class: 'col-sm-8'
				}).append(
					$('<input>', {
						id: 'input-date_end',
						class: 'form-control',
						type: 'date',
						max: '<?= date('Y-m-d') ?>'
					})
				)
			);

			$('#form-filter div.row:last').after(inputEnd).after(inputStart).after(selectCabang);
			setDropdown(listCabang, 'select-cabang', '- Pilih -');
		}
	});

	$(document).on('click', '#btn-filter', function(event) {
		event.preventDefault();

		if (getRecapTimeout) {
			clearTimeout(getRecapTimeout);
		}

		getRecapTimeout = setTimeout(() => {
			const jenis = $('#select-jenis').val();
			const tahunAngkatan = $('#select-tahun_angkatan').val();
			const cabang = $('#select-cabang').val();
			const startDate = $('#input-date_start').val();
			const endDate = $('#input-date_end').val();

			if (jenis == 1 && !tahunAngkatan || jenis == 2 && !cabang) {
				return;
			}

			const filter = {
				jenis: jenis,
				tahun_angkatan: tahunAngkatan,
				cabang: cabang,
				start_date: startDate,
				end_date: endDate,
			};

			$('#table-recapitulation').empty().html('<span class="spinner-grow spinner-grow-sm"></span> Loading...');

			fetch(urlData +'?'+ new URLSearchParams(filter), {
			      method: 'GET'
			    })
			      .then((res) => res.text())
			      .then((res) => {
			        $('#table-recapitulation').empty().html(res);

			        // Update link export
					$('[id^=link-export-]').each(function(index, el) {
						const type = $(this).attr('id').split('-').pop();
						$(this).attr('href', `<?= site_url('/cnp/recapitulation-permintaan/export-') ?>${type}/<?= $src ?>?${ new URLSearchParams(filter) }`);
					});

					// Jenis Cabang
					if (jenis == 2) {
						const datatableUrl = `<?= site_url('/cnp/recapitulation-permintaan/get-data/' . $src) ?>?${ new URLSearchParams(filter) }`;
						datatable($('#table-recap'), datatableUrl, true);
					}
			      })
		}, 500)

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
</script>
