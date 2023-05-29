<?php ob_start()?>
<form class="mb-3 row w-100 " method="POST" action="/ajouterAnnee">
    <div class="col-12 d-flex w-50 justify-content-end" >
      <input type="text" class="form-control w-25"  name="annee" id="inputPassword">
      <input type="submit" value="ajouter une année" class="btn btn-primary"/>
    </div>

</form>
<hr>
<div class="row">
    <?php foreach ($data as  $value) {?>

        <!-- Content Column -->
        <div class="col-3 mb-4 ">
            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between ">
                    <form class="d-flex align-items-center" style="gap:10px" method="POST" action="/modifierAnnee">
                        <input type="hidden" name="id" value="<?=$value["id"]?>" />
                        <input type="text" name="name_scol" class="m-0 w-50 font-weight-bold text-primary border-0  val-annee"  value="<?=$value["name_scol"]?>"/>

                        <?php if($value["etat"]){?>
                        <i  class="  text-success fa-regular fa-circle-check  " style="top:26px;left:120px;"></i>
                    <?php } ?>
                    </form>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" >
                            <?php if($value["etat"]){?>
                                
                                <a class="dropdown-item" href="/desactiverAnnee?id=<?=urlencode($value['id'])?>">desactiver</a>
                                <?php } else { ?>
                                    <a class="dropdown-item" href="/supprimerAnnee?id=<?=urlencode($value['id'])?>">archiver</a>
                                    
                                <a class="dropdown-item" href="/activerAnnee?id=<?=urlencode($value['id'])?>">activer</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <form action="" >

                    </form>
                <div class="card-body mb-3">
                    <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
                    <div class="progress mb-4">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Programmes <span class="float-right">Complete!</span></h4>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                   
                
                
            </div>
        </div>
    <?php
        }
    ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">INFORMATION</h5>
      </div>
      <div class="modal-body notification">
            <?= isset($_SESSION["notification"])?$_SESSION["notification"]:"";
            ?>
      </div>
    </div>
  </div>
</div>
</div>
<?php $content=ob_get_clean()?>
<?php 
require_once __DIR__.'/../views/index.php';
?>


