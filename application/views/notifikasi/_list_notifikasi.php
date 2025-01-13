<?php foreach ($notifikasis as $key => $notifikasi): ?>
  
<div class="list-group-item notification-card mb-3">
    <div class="d-flex align-items-start">
        <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1 <?= !$notifikasi['is_read'] ? 'fw-bold' : '' ?>">
                        <i class="bi bi-exclamation-circle text-<?= $notifikasi['priority'] ?> me-2"></i>
                        <?= ucfirst($notifikasi['priority']) ?>
                    </h5>
                    <time class="time timeago text-muted" 
                    datetime="<?= date(DATE_ISO8601, strtotime($notifikasi['created_at'])) ?>">
                      <?= date('d M Y', strtotime($notifikasi['created_at'])) ?></time>
                </div>
                <button class="btn btn-sm btn-outline-secondary" data-id="<?= $notifikasi['id'] ?>">Tandai sebagai dibaca</button>
            </div>
            <p class="mb-1 mt-2 <?= !$notifikasi['is_read'] ? 'fw-bold' : '' ?>"><?= $notifikasi['content'] ?></p>
            <p><i>Dikirim oleh: <b>Admin</b></i></p>
            <div class="d-flex justify-content-end">
                <button class="btn btn-sm btn-outline-danger me-2">Hapus</button>
            </div>
        </div>
    </div>
</div>

<?php endforeach ?>

<div class="pagination-links">
  <?= $pagination; ?>
</div>

<script type="text/javascript">
  $('.timeago').timeago();
</script>
