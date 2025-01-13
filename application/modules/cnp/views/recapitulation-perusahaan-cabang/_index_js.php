<script type="text/javascript">
	const src = '<?= !empty($src) ? $src : null ?>';
	let datatableUrl = `<?= site_url('/cnp/recapitulation-perusahaan-cabang/get-data/' . $src) ?>`
	let summaryUrl = `<?= site_url('/cnp/recapitulation-perusahaan-cabang/summary/' . $src) ?>`;

	const defCabang = '<?= $this->helpers->isLokal() ? $this->session->userdata('kodecabang') : '' ?>';

	const chartskala = initApexChart('chart-skala', 'pie');
	const chartmou = initApexChart('chart-mou', 'donut');
	const chartrelasi = initApexChart('chart-relasi', 'donut');
</script>

<script type="text/javascript">
	$(document).ready(function() {
		setTimeout(() => {
			if (defCabang) {
				datatableUrl += `?${ new URLSearchParams({cabang: defCabang}) }`

				datatable($('#table-recap-perusahaan'), datatableUrl, true);

				fetch(summaryUrl, {
			      method: 'GET'
			    })
			      .then((res) => res.json())
			      .then((res) => {
			      	chartskala.updateOptions({
			      		labels: res.skala.series,
             			series: res.skala.values,
			      	});

			      	chartmou.updateOptions({
			      		labels: res.mou.series,
             			series: res.mou.values,
			      	});

			      	chartrelasi.updateOptions({
			      		labels: res.relasi.series,
             			series: res.relasi.values,
			      	});

			      	$('#card-summary').show()
			      })

				$('#panel-recap').show();
			}
		}, 100)
	});

	$(document).on('click', '#btn-filter', function(event) {
		event.preventDefault();

		const cabang = defCabang ? defCabang : $('#select-cabang').val();
		const tanggalDari = $('#input-date_start').val();
		const tanggalSampai = $('#input-date_end').val();

		if (cabang) {
			const queryParams = {
				cabang,
				tanggal_dari: tanggalDari,
				tanggal_sampai: tanggalSampai
			}

			let newDatatableUrl = datatableUrl +'?'+ new URLSearchParams(queryParams);
			let newSummaryUrl = summaryUrl +'?'+ new URLSearchParams(queryParams);

			datatable($('#table-recap-perusahaan'), newDatatableUrl, true);

			fetch(newSummaryUrl, {
			      method: 'GET'
			    })
			      .then((res) => res.json())
			      .then((res) => {
			      	chartskala.updateOptions({
			      		labels: res.skala.series,
             			series: res.skala.values,
			      	});

			      	chartmou.updateOptions({
			      		labels: res.mou.series,
             			series: res.mou.values,
			      	});

			      	chartrelasi.updateOptions({
			      		labels: res.relasi.series,
             			series: res.relasi.values,
			      	});

			      	$('#card-summary').show()
			      })

			$('#panel-recap').show();
		}
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