<?php ob_start()?>
<div class="d-flex justify-content-center flex-wrap position-relative container_card" style="gap:15px;margin-top:60px" data-classe="<?=$id ?>">
    
</div>
<script src="/views/js/coefficient.js"></script>


<?php $content=ob_get_clean()?>
<?php require_once __DIR__.'/../views/index.php';?>