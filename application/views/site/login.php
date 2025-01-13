<div class="card mb-3">

  <div class="card-body pt-3">
    <?php if ($error): ?>
      <div class="alert alert-info alert-dismissible fade show mt-2" role="alert">
        <i class="bi bi-info-circle me-1"></i>
        <?= implode('<br/>', $error); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif ?>

    <div class="pb-2">
      <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
      <p class="text-center small">Contact your HR for account</p>
    </div>

    <?php /*

    <?= form_open('', [
      'class' => 'row g-3 needs-validation'
    ]); ?>

      <div class="col-12">
        <?= form_label('Username', 'Formlogin-username', [
          'class' => 'form-label',
        ]); ?>

        <div class="input-group has-validation">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
          <?= form_input('Formlogin[username]', $model->username, [
            'class' => 'form-control',
            'id' => 'Formlogin-username',
            'required' => true
          ]); ?>
          <div class="invalid-feedback">Masukkan username anda.</div>
        </div>
      </div>

      <div class="col-12">
        <?= form_label('Password', 'Formlogin-password', [
          'class' => 'form-label',
        ]); ?>

        <?= form_password('Formlogin[password]', $model->password, [
          'class' => 'form-control',
          'id' => 'Formlogin-password'
        ]); ?>
        <div class="invalid-feedback">Masukkan password anda!</div>
      </div>

      <div class="col-12">
        <?= form_submit('login', 'Login', [
          'class' => 'btn btn-primary w-100'
        ]); ?>
      </div>

      <div class="col-12 text-center">&mdash; OR &mdash;</div>

      */ ?>

      <div class="col-12">
        <?= $this->html->a('<span class="bi bi-key"></span> Login with HRIS SSO', SSO_URL .'/auth?token='. SSO_CLIENT_ID, [
          'class' => 'btn btn-info w-100'
        ]) ?>
      </div>

      <?php /*<div class="col-12">
        <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
      </div>*/ ?>

    <?= form_close(); ?>

  </div>
</div>