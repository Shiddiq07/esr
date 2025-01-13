<script type="text/javascript">
	let getRecapTimeout = null;
	const listTahunAngkatan = JSON.parse('<?= json_encode($list_tahun_angkatan) ?>');

	$(document).ready(function() {
		$('#select-jenis').trigger('change');
	});

	$(document).on('change', '#select-jenis', function(event) {
		event.preventDefault();

		const jenis = $(this).val();

		// Remove select cabang
		$('#select-cabang').parent().parent().remove();
		$('#select-tahun_angkatan').parent().parent().remove();

		$('.dropdown-item').show();
		$('.dropdown-item.tool-action').hide();

		const selectTahunAngkatan = $('<div>', {
			class: 'row mt-3'
		}).append(
			$('<label>', {
				for: 'select-tahun_angkatan',
				class: 'col-sm-4 col-form-label required',
				text: 'Tahun Angkatan'
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

		if (jenis == 2) {
			$('#select-tahun_angkatan').val('').trigger('change');

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

			$('#form-filter div.row:last').after(selectCabang);

		}

		if (jenis != 1 && jenis != 2) {
			$('#select-tahun_angkatan').parent().parent().remove();
			$('#select-cabang').parent().parent().remove();
		}
	});

	$(document).on('change', '#select-tahun_angkatan', function(event) {
		event.preventDefault();

		const tahunAngkatan = $(this).val();

		if (!tahunAngkatan) {
			return;
		}

		fetch("<?= base_url('/cnp/recapitulation-rerata-gaji/get-cabang/'. $src) ?>?" + new URLSearchParams({tahun_angkatan: tahunAngkatan}), {
			method: 'GET'
		})
		.then((res) => res.json())
		.then((res) => {
			if (!res || (res && res.status == false)) {
				return false;
			}

			setDropdown(res, 'select-cabang');
		});
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

			if (jenis == 1 && !tahunAngkatan || jenis == 2 && !cabang) {
				return;
			}

			const filter = {
				jenis: jenis,
				tahun_angkatan: tahunAngkatan,
				cabang: cabang,
			};

			$('#table-recapitulation').empty().html('<span class="spinner-grow spinner-grow-sm"></span> Loading...');

			fetch("<?= base_url('/cnp/recapitulation-rerata-gaji/get-table/'. $src) ?>?" + new URLSearchParams(filter), {
			      method: 'GET'
			    })
			      .then((res) => res.text())
			      .then((res) => {
			        $('#table-recapitulation').empty().html(res);

			        // Update link export
					$('[id^=link-export-]').each(function(index, el) {
						const type = $(this).attr('id').split('-').pop();
						$(this).attr('href', `<?= site_url('/cnp/recapitulation-rerata-gaji/export-') ?>${type}/<?= $src ?>?${ new URLSearchParams(filter) }`);
					});
			      })
		}, 500)

	});
</script>
