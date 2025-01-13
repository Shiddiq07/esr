<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= strip_tags($title) .' | '. APP_FULLNAME ?></title>
  <meta content="<?= APP_DESC ?>" name="description">
  <meta content="<?= APP_KEYWORDS ?>" name="keywords">

  <?php $this->load->view('layouts/main_css'); ?>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="<?= base_url('web/assets/img/logo.png') ?>" alt="">
        <span class="d-none d-lg-block"><?= APP_NAME ?></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <div id="autocomplete"></div>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <?php $notifications = $this->helpers->getNotifications(def($this->session->userdata('identity'), 'id')) ?>

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number"><?= $notifications['count']['unread'] ?></span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have <?= $notifications['count']['unread'] ?> new notifications
              <a href="<?= site_url('/notifikasi?referrer=unread') ?>"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <?php if ($notifications['data']): ?>
              <?php foreach ($notifications['data'] as $key => $notifikasi): ?>
                
              <li class="notification-item">
                <i class="bi bi-exclamation-circle text-<?= $notifikasi->priority ?>"></i>
                <div>
                  <h4><?= ucfirst($notifikasi->priority) ?></h4>
                  <p class="details <?= $notifikasi->is_read == 0 ? 'fw-bold' : '' ?> "><?= $notifikasi->content ?></p>
                  <time class="time timeago text-muted" 
                    datetime="<?= date(DATE_ISO8601, strtotime($notifikasi->created_at)) ?>">
                      <?= date('d M Y', strtotime($notifikasi->created_at)) ?></time>
                </div>
              </li>

              <li>
                <hr class="dropdown-divider">
              </li>

              <?php endforeach ?>

            <?php endif; ?>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="<?= site_url('/notifikasi') ?>">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="<?= base_url('web/assets/img/messages-1.jpg') ?>" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="<?= base_url('web/assets/img/messages-2.jpg') ?>" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="<?= base_url('web/assets/img/messages-3.jpg') ?>" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?= $this->helpers->getImage() ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= def($this->session->userdata('detail_identity'), 'nama_depan', 'Guest') ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= def($this->session->userdata('detail_identity'), 'nama_depan', 'Guest') ?></h6>
              <span><?= def($this->session->userdata('detail_identity'), 'job_title') ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <?php if (!empty($this->session->userdata('detail_identity'))): ?>

              <li>
                <a class="dropdown-item d-flex align-items-center" href="<?= HRIS_URL .'/profil' ?>" target="_blank">
                  <i class="bi bi-person"></i>
                  <span>My Profile</span>
                </a>
              </li>

              <li>
                <hr class="dropdown-divider">
              </li>

              <li>
                <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                  <i class="bi bi-question-circle"></i>
                  <span>Need Help?</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>

              <li>
                <?= $this->html->a('<i class="bi bi-box-arrow-right"></i><span>Sign Out</span>', '/site/logout', [
                  'class' => 'dropdown-item d-flex align-items-center',
                  'id' => 'link-logout'
                ]) ?>
              </li>

            <?php endif ?>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <?php if (!empty($this->session->userdata('identity'))) $this->menuhelper->run() ?>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?= $title ?></h1>

      <nav>
        <ol class="breadcrumb">
          <?php foreach ($breadcrumbs as $key => $breadcrumb): ?>
            <li class="breadcrumb-item"><?= $breadcrumb ?></li>
          <?php endforeach ?>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <!-- BEGIN ALERT FLASHDATA -->
      <?php if ($this->session->flashdata('danger')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-octagon me-1"></i>
            <?php $this->session->flashdata('danger'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif ?>

      <?php if ($this->session->flashdata('info')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <i class="bi bi-info-circle me-1"></i>
          <?= $this->session->flashdata('info'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif ?>

      <?php if ($this->session->flashdata('warning')): ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            <?= $this->session->flashdata('warning'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      <?php endif ?>

      <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      <?php endif ?>
      <!-- END ALERT FLASHDATA -->

      <?php $this->load->view($view, $data); ?>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      <?= APP_YEAR ?> &copy; <strong><span><?= APP_COPYRIGHT ?></span></strong>.
      <a target="_blank" href="<?= COMPANY_PAGE ?>"><?= APP_COMPANY ?></a>
    </div>

  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- OVERLAY LOADER -->
  <div id="overlay" style="display: none;">
    <div class="spinner-grow" style="width: 50px; height: 50px;" role="status">
      <span class="visually-hidden">Memuat...</span>
    </div>
  </div> 
  <!-- OVERLAY LOADER -->

  <script type="text/javascript" id="csrf">
    var csrf_name = '<?= $this->security->get_csrf_token_name() ?>';
    var csrf_hash = '<?= $this->security->get_csrf_hash() ?>';
    var csrf_expires = Number('<?= $this->config->item('csrf_expire') ?>');
    var key_map = '<?= LOCATIONIQ_API_KEY ?>';
    const baseUrl = '<?= base_url() ?>';
  </script>

  <?php $this->load->view('layouts/main_js'); ?>

</body>

</html>