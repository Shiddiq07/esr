<script type="text/javascript">
	let currentPage = 1;

	$(document).ready(function() {
		const status = $('#select-status').val();

		fetchData(currentPage, status);
	});

	$(document).on('click', '.pagination-links a.page-link', function(event) {
		event.preventDefault();
		/* Act on the event */

		const page = $(this).data('ci-pagination-page');

		if (page) {
			currentPage = page;
			fetchData(page);
		}
	});

	$(document).on('change', '#select-status', function(event) {
		event.preventDefault();
		/* Act on the event */

		const status = $(this).val();

		fetchData(1, status)
	});

	const fetchData = (page, status = '') => {
		fetch("<?= base_url('/notifikasi/fetch-data/') ?>?" + new URLSearchParams({page, status}), {
      method: 'GET'
    })
      .then((res) => res.json())
      .then((res) => {
      	$('#notification-list').html(res.pagination)
      })
	}

	const readNotif = (id) => {
		fetch(`<?= base_url('/notifikasi/read/') ?>/${id}`, {
      method: 'POST'
    })
      .then((res) => res.json())
      .then((res) => {
      	
      })
	}
</script>
