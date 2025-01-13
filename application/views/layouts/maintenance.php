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

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>503</h1>
        <h2 class="text-center">Kami sedang melakukan pemeliharaan terjadwal. Kami mohon maaf atas ketidaknyamanan ini</h2>
        <img src="<?= BASE_URL . 'web/assets/img/not-found.svg' ?>" class="img-fluid py-5" alt="Page Not Found">

        <div id="timer">
          <span id="days">00</span> days 
          <span id="hours">00</span> hours 
          <span id="minutes">00</span> minutes 
          <span id="seconds">00</span> seconds
      </div>
      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= BASE_URL . 'web/assets/vendor/bootstrap/js/bootstrap.bundle.min.js' ?>"></script>

  <script type="text/javascript">
    // Set the date we're counting down to
    const countDownDate = new Date("<?= MAINTENANCE_UNTIL ?>").getTime();

    // Update the count down every 1 second
    const x = setInterval(function() {
      // Get today's date and time
      const now = new Date().getTime();

      // Find the distance between now and the count down date
      const distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Display the result in the respective elements
      document.getElementById("days").innerHTML = String(days).padStart(2, '0');
      document.getElementById("hours").innerHTML = String(hours).padStart(2, '0');
      document.getElementById("minutes").innerHTML = String(minutes).padStart(2, '0');
      document.getElementById("seconds").innerHTML = String(seconds).padStart(2, '0');

      // If the count down is over, write some text 
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("timer").innerHTML = "<i class='bi bi-emoji-smile-upside-down'></i>";
      }
    }, 1000);

  </script>

</body>

</html>