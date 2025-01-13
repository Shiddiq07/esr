<?php defined('BASEPATH') OR exit('No direct script access allowed');

$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url .= "://". @$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= APP_NAME .' | '. APP_FULLNAME ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= BASE_URL . 'web/assets/img/favicon.png' ?>" rel="icon">
  <link href="<?= BASE_URL . 'web/assets/img/apple-touch-icon.png' ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= BASE_URL . 'web/assets/vendor/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet">
  <link href="<?= BASE_URL . 'web/assets/vendor/bootstrap-icons/bootstrap-icons.css' ?>" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= BASE_URL . 'web/assets/css/style.css' ?>" rel="stylesheet">

  <style type="text/css">
    #timer {
      font-size: 2em;
      text-align: center;
    }

    #timer span {
      display: inline-block;
      min-width: 50px;
    }
  </style>
</head>

<body>

  <main>
    <div class="container">

      <section class="section error-404 d-flex flex-column align-items-center justify-content-center">
        <h1>500</h1>
        <h2 class="text-center">A PHP Error was encountered</h2>
        <p>Severity: <?php echo $severity; ?></p>
		<p>Message:  <?php echo $message; ?></p>
		<p>Filename: <?php echo $filepath; ?></p>
		<p>Line Number: <?php echo $line; ?></p>

		<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>
			<div class="text-left border">
				
			<p>Backtrace:</p>
			<?php foreach (debug_backtrace() as $error): ?>

				<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

					<p style="margin-left:10px">
					File: <?php echo $error['file'] ?><br />
					Line: <?php echo $error['line'] ?><br />
					Function: <?php echo $error['function'] ?>
					</p>

				<?php endif ?>

			<?php endforeach ?>

			</div>

		<?php endif ?>
      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= BASE_URL . 'web/assets/vendor/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>

</body>

</html>