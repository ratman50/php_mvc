<?php ob_start()?>
<div class="d-flex justify-content-between">
    <a href="/eleve/liste/<?=$classe["id_classe"] ?>" class="btn btn-circle btn-primary"><?= $classe["nom_classe"]?></a>
    <button type='button' class='btn btn-primary ' id='update' >Mettre à jour </button>

</div>
<hr>
<div class="d-flex justify-content-center flex-wrap position-relative container_card" style="gap:15px;" data-classe="<?=$id ?>">
    
</div>
<script src="/views/js/coefficient.js"></script>


<?php $content=ob_get_clean()?>
<?php require_once __DIR__.'/../views/index.php';?>