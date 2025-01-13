<script type="text/javascript">
	let getRecapTimeout = null;

	$(document).on('click', '#btn-filter', function(event) {
		event.preventDefault();

		if (getRecapTimeout) {
			clearTimeout(getRecapTimeout);
		}

		getRecapTimeout = setTimeout(() => {
			const tahunAngkatan = $('#select-tahun_angkatan').val();
			const cabang = $('#select-cabang').val();

			if (!tahunAngkatan || !cabang) {
				return;
			}

			const filter = {
				tahun_angkatan: tahunAngkatan,
				cabang: cabang
			};

			$('#table-recapitulation').empty().html('<span class="spinner-grow spinner-grow-sm"></span> Loading...');

			fetch("<?= base_url('/cnp/recapitulation-kesesuaian-jurusan/get-table/'. $src) ?>?" + new URLSearchParams(filter), {
			      method: 'GET'
			    })
			      .then((res) => res.text())
			      .then((res) => {
			        $('#table-recapitulation').empty().html(res);

			        // Update link export
					$('[id^=link-export-]').each(function(index, el) {
						const type = $(this).attr('id').split('-').pop();
						$(this).attr('href', `<?= site_url('/cnp/recapitulation-kesesuaian-jurusan/export-') ?>${type}/<?= $src ?>?${ new URLSearchParams(filter) }`);
					});
			      })
		}, 500)

	});

	$(document).on('change', '#select-tahun_angkatan', function(event) {
		event.preventDefault();

		const tahunAngkatan = $(this).val();

		if (!tahunAngkatan) {
			return;
		}

		fetch("<?= base_url('/cnp/recapitulation-kesesuaian-jurusan/get-cabang/'. $src) ?>?" + new URLSearchParams({tahun_angkatan: tahunAngkatan}), {
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
</script>
