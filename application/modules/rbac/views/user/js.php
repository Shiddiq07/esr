<script src="<?= base_url('/web/assets/global/scripts/datatable.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('/web/assets/global/plugins/datatables/datatables.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('/web/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('/web/assets/pages/scripts/table-datatables-responsive.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('/web/assets/pages/scripts/ui-modals.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('/web/assets/global/plugins/jquery-repeater/jquery.repeater.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('/web/assets/global/plugins/bootstrap-select2/js/select2.min.js') ?>" type="text/javascript"></script>

<script type="text/javascript">
	var modal_detail = $("#modal-detail");
	var action = "<?= site_url('/rbac/user/simpan-detail') ?>"

    $(document).ready(function() {
    	datatable($("#table-user"), "<?= base_url('/rbac/user/get-data') ?>");
    });

    // Tampilkan modal untuk set detail user
    $(document).on('click', '.btn-add-detail', async function(event) {
    	event.preventDefault();
    	/* Act on the event */

    	let id = $(this).data('id');
    	let data = await getDataDetail(id);

    	modal_detail.modal('show');
		$("#form-detail").prop('action', action +'/'+ id);

		setDataToForm(data, false);

    });

    $(document).on('click', '.btn-preview', async function(event) {
    	event.preventDefault();
    	/* Act on the event */

    	let id = $(this).data('id');
    	let data = await getDataDetail(id);

    	modal_detail.modal('show');
		$("#form-detail").prop('action', action +'/'+ id);

		setDataToForm(data, true);
    });

    $(document).on('click', '.btn-delete', async function(event) {
        event.preventDefault();
        /* Act on the event */

        let id = $(this).data('id');
        let data = await getDataDetail(id);
        let deactivate = false;
        let message = 'Apakah yakin akan menghapus data?';

        if (data) {
            deactivate = true;
            message = 'Data aktif, dan sudah tidak bisa dihapus. Mau menonaktifkannya saja?';
        }

        customConfirmation({type:'warning', message:message}, (confirmation) => {
            if (confirmation) {
                $.ajax({
                    url: "<?= site_url('/rbac/user/hapus/') ?>"+ id +'/'+ deactivate,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        [csrf_name] : csrf_hash
                    }
                })
                .done(function(data) {
                    swalert(data.message);
                })
                .fail(function() {
                    swalert({
                        title: 'Gagal ambil data',
                        message: 'Terjadi kesalahan server, silahkan coba beberapa saat lagi atau lapor ke administrator',
                        type: 'error'
                    });
                })
                .always(function() {
                    datatableReload();
                });
            }
        });
    });

    async function getDataDetail(id) {
    	let result;

    	try {
    		result = await $.ajax({
	    		url: '<?= base_url('/rbac/user/detail/') ?>'+ id,
	    		type: 'GET',
	    		dataType: 'json',
	    	});

    		return result;

    	} catch(err) {
    		console.log(err);
    	}
    }

    function setDataToForm(data, viewOnly = true) {
        let detail = data.user_detail;

        if (detail) {
            // Set Nama
        	$("#id_nama_depan").val(detail.nama_depan);
            $("#id_nama_tengah").val(detail.nama_tengah);
            $("#id_nama_belakang").val(detail.nama_belakang);
            // Set Nama

            $("#id_nik").val(detail.nik);
    		$("#id_tanggal_gabung").val(detail.tanggal_gabung);
    		$("#id_tanggal_selesai").val(detail.tanggal_selesai);
    		$("#id_job_title").val(detail.job_title);
        }

		if (viewOnly) {
			modal_detail.find('input').prop('disabled', true);
			modal_detail.find('select').prop('disabled', true);
			$("#btn-save").hide();
		} else {
			modal_detail.find('input').prop('disabled', false);
			modal_detail.find('select').prop('disabled', false);
			$("#btn-save").show();
		}
    }
</script>
