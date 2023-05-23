<?php $notification=""?>
<?php ob_start()?>
<div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body notif_content">
        <p><?=$notification?></p>
      </div>
    </div>
  </div>
</div>
<?php $modalNotification=ob_get_clean()?>