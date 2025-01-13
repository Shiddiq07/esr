<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $title .' | '. APP_FULLNAME ?></title>
  <meta content="<?= APP_DESC ?>" name="description">
  <meta content="<?= APP_KEYWORDS ?>" name="keywords">

  <?php $this->load->view('layouts/login_css'); ?>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="<?= base_url('web/assets/img/logo.png') ?>" alt="">
                  <span class="d-none d-lg-block"><?= APP_NAME ?></span>
                </a>
              </div><!-- End Logo -->

              <?php $this->load->view($view, $data); ?>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php $this->load->view('layouts/login_js'); ?>

</body>

</html>