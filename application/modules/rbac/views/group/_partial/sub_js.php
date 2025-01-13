<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
	var modal = $("#draggable");

    $(document).ready(function() {
    	datatable($("#table-group"), "<?= site_url('/rbac/group/get-data') ?>");

    	setTimeout(() => { attachedSelect2('id_parent_id', 'draggable'); }, 1000);
    });

    modal.on('hidden.bs.modal', function () {
	    let forms = $(this).find('form');

	    $.each(forms, function(index, val) {
	    	// Reset input
	    	$.each($(this).find('input, textarea'), function(index, val) {
	    		if ($(this).attr('name') != 'csrf_lpei_esr') {
	    			$(this).val('');
	    		}
	    	});
	    });
	});

    $(document).on('click', '.btn-preview', function(event) {
    	event.preventDefault();
        $('#field-single').attr('disabled', true);

    	let id = $(this).data('id');

    	$.ajax({
    		url: "<?= site_url('/rbac/group/detail/') ?>" + id,
    		type: 'GET',
    		dataType: 'json',
    	})
    	.done(function(data) {
    		if (data) {
	    		let form = $('#form-single');
	    		form.attr('action', '');
	    		form.find('#id_label').val(data.label);
	    		form.find('#id_desc').val(data.desc);

	    		resetMultiParent(data.list_parents);
	    		form.find('#id_parent_id').val(JSON.parse(data.parent_id)).trigger('change');

	    		$('#btn-save').hide();
		    	modal.find('.modal-title').text('Detail Group');
		    	modal.modal('show');
    		} else {
    			swalert('Data tidak ditemukan');
    		}
    	})
    	.fail(function() {
    		swalert({
    			title: 'Gagal ambil data',
    			message: 'Terjadi kesalahan server, silahkan coba beberapa saat lagi atau lapor ke administrator',
    			type: 'error'
    		});
    	})
    	.always(function() {
    	});
    });

    function resetMultiParent(items) {
    	let selection = $('#id_parent_id');


    	selection.select2('destroy');
    	setDropdown(items, 'id_parent_id');

    	setTimeout(() => {
    		attachedSelect2('id_parent_id', 'draggable');
    	}, 500)
    }
</script>
