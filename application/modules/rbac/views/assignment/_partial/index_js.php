<script src="<?= base_url('/web/assets/vendor/jquery-repeater/jquery.repeater.min.js') ?>" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
    	datatable($("#table-group"), "<?= base_url('/rbac/assignment/get-data') ?>");
    });
</script>
