<script type="text/javascript">
	let getRecapTimeout = null;

	$(document).on('submit', '#form-filter-recap', function(event) {
		event.preventDefault();

		let form = $(this).serialize();

		if (getRecapTimeout) {
			clearTimeout(getRecapTimeout);
		}

		getRecapTimeout = setTimeout(() => {
			$('#table-recapitulation').empty().html('<span class="spinner-grow spinner-grow-sm"></span> Loading...');

			fetch("<?= base_url('/cnp/recapitulation-proses-bulanan/get-table/'. $src) ?>?" + new URLSearchParams(form), {
			      method: 'GET'
			    })
			      .then((res) => res.text())
			      .then((res) => {
			        $('#table-recapitulation').empty().html(res);

			        // Update link export
					$('[id^=link-export-]').each(function(index, el) {
						const type = $(this).attr('id').split('-').pop();
						$(this).attr('href', `<?= site_url('/cnp/recapitulation-proses-bulanan/export-') ?>${type}/<?= $src ?>?${ new URLSearchParams(form) }`);
					});
			      })
		}, 500)

	});

    $('#input-date_start, #input-date_end').on('input', function() {
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
