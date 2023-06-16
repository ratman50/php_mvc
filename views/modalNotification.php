<?php $notification=""?>
<?php ob_start()?>
<div class="modal fade"  id="modalNotif">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Information</h5>
      </div>
      <div class="modal-body notif_content">
        <p class="text-primary"></p>
      </div>
    </div>
  </div>
</div>
<script>

const notifContent=document.querySelector(".notif_content p");
function showModal(message) {
  
  if(message)
  {
    notifContent.textContent=message;
      modalNotif.classList.add("show");
      modalNotif.style.display="block";
      setTimeout(() => {
          modalNotif.classList.remove("show");
      modalNotif.style.display="none";
      notifContent.textContent="";
      }, 1300);
  }
}

</script>
<?php $modalNotification=ob_get_clean()?>