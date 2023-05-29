<?php $notification=""?>
<?php ob_start()?>
<div class="modal fade"  id="modalNotif">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Information</h5>
      </div>
      <div class="modal-body notif_content">
        <p class="text-primary"><?=isset($_SESSION["notification"]) ? $_SESSION["notification"] : ""?></p>
      </div>
    </div>
  </div>
</div>
<?php $modalNotification=ob_get_clean()?>