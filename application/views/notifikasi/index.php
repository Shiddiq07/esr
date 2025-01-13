<div class="row">
  <div class="col-md-12">
    <!-- Filter and Sorting -->
    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex">
            <label class="form-label me-2 mt-1">Status</label>

            <?= $this->html->dropDownList('status', $status, $statuses, [
              'class' => 'form-select form-select-sm',
              'prompt' => 'Semua',
              'id' => 'select-status'
            ]) ?>
        </div>

        <button class="btn btn-primary">Tandai Semua Sebagai Dibaca</button>
    </div>

    <!-- Notification List -->
    <div class="list-group" id="notification-list"></div>
  </div>
</div>