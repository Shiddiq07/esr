<script type="text/javascript">
	let getRecapTimeout = null;

	$(document).ready(function() {
		$('#input-year-recap').trigger('change');

	    // Initialize with current year
	    const currentYear = new Date().getFullYear();
	    $('#startYear').val(currentYear);
	    $('#endYear').val(currentYear);
	    updateYearRange();
	});

	$(document).on('change', '#input-year-recap', function(event) {
		event.preventDefault();
		/* Act on the event */

		let year = $(this).val();

		if (!year) return false;

		if (getRecapTimeout) {
			clearTimeout(getRecapTimeout);
		}

		getRecapTimeout = setTimeout(() => {
			$('#content-table-recapitulation').empty().html('<span class="spinner-grow spinner-grow-sm"></span> Loading...');

			fetch("<?= base_url('/academics/recapitulation/get-table-recap/'. $src) ?>?" + new URLSearchParams({year}), {
		      method: 'GET'
		    })
		      .then((res) => res.text())
		      .then((res) => {
		        $('#content-table-recapitulation').empty().html(res);
		      })
		}, 500)

	});

	function updateYearRange() {
        const startYear = $('#startYear').val();
        const endYear = $('#endYear').val();

        // Set max and min year
        $('#startYear').attr('max', endYear);
        $('#endYear').attr('min', startYear);

        if ((endYear - startYear) > 2) {
        	swalert({
        		'title': 'Rentang Tahun Terlalu Panjang', 
        		'message': 'Rentang tahun yang Anda pilih melebihi batas maksimum 3 tahun. Harap pilih rentang tahun yang lebih pendek'
        	});

        	$('#startYear').val((endYear - 1)).trigger('input');
        	return false;
        }

        if (startYear && endYear) {
            $('#input-year-recap').val(`${startYear}-${endYear}`).trigger('change');

            // Update link export
            $('[id^=link-export-]').each(function(index, el) {
            	const type = $(this).attr('id').split('-').pop();

            	$(this).attr('href', `<?= site_url('/academics/recapitulation/export-') ?>${type}/<?= $src ?>?year=${startYear}-${endYear}`);
            });
        }
    }

    $('#startYear, #endYear').on('input', function() {
        updateYearRange();
    });

</script>
