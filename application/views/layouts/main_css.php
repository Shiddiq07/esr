<!-- Favicons -->
<link href="<?= base_url('web/assets/img/favicon.png') ?>" rel="icon">
<link href="<?= base_url('web/assets/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="<?= base_url('web/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('web/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
<link href="<?= base_url('web/assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
<link href="<?= base_url('web/assets/vendor/quill/quill.snow.css') ?>" rel="stylesheet">
<link href="<?= base_url('web/assets/vendor/quill/quill.bubble.css') ?>" rel="stylesheet">
<link href="<?= base_url('web/assets/vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
<link href="<?= base_url('web/assets/vendor/simple-datatables/datatables.min.css') ?>" rel="stylesheet">
<!-- <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/b-3.0.2/fh-4.0.1/r-3.0.2/datatables.min.css" rel="stylesheet"> -->

<!-- Template Main CSS File -->
<link href="<?= base_url('web/assets/css/style.css') ?>" rel="stylesheet">
<link href="<?= base_url('web/assets/css/custom.css') ?>" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@algolia/autocomplete-theme-classic">

<?php 
# Load self-made file views for setting css
if (!empty($view_css)) {
	if (is_string($view_css)) {
		$this->load->view($view_css);

	} elseif (is_array($view_css)) {
		foreach ($view_css as $key => $css) {
			$this->load->view($css);
		}

	}

}
?>
