<?php
    $tabStyleBtn=[
        "btn-success",
        "btn-info",
        "btn-warning",
        "btn-light",
        "btn-dark"
    ];
    $tabAlpha=[
        "A",
        "B",
        "C",
        "D",
        "E"
    ]
?>
<?php ob_start()?>
                    
 <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h1 class="h3 mb-4 text-gray-800">NIVEAUX</h1>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Filtres
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php foreach ($this->niveau as  $value) {?>
                <a class="dropdown-item" href="/niveau/list/<?=urlencode($value["id_niveau"]) ?>"><?=$value["libelle_niveau"]?></a>
            <?php } ?>
            </div>
        </div>
    </div>
    <form action="/niveau/ajout" method="POST" class="form_niveau mb-1" >
        <input type="text" class="form-control name-niveau" placeholder="nom niveau" name="niveau" >
        <button type="submit" class="btn btn-outline-primary  addNiveau">+</button>
    </form>                    
             
      <div class="row niveaux" >
        
      <?php foreach ($data as  $value) {?>
           
           <div class="col-lg-3 card_niveau  " >
   
               <!-- Circle Buttons -->
               <div class="card shadow mb-4 ">
                   <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                       <form action="/modifierNiveau" method="POST" >
                           <input class=" font-weight-bold text-primary w-100 form-control fieldModif border-0 name-value"  name="niveau" type="text" value="<?=$value["libelle_niveau"]?>" disabled />
                       </form>
                       <div class="dropdown no-arrow">
                             <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" >
                                <a class="dropdown-item" href="/supprimerNiveau">supprimer</a>
                                <a class="dropdown-item" href="#">modifier</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Supprimer les classes</a>
                            </div>
                        </div>
                      
                   </div>
                   <div class="card-body position-relative " >
                       <!-- Circle Buttons (Default) -->
                       <form action="/Classe/ajout" class="position-absolute d-flex"  style="right: 5px;top:-15px;gap:5px"  method="POST">
                           <input type="hidden" value="<?=$value["id_niveau"]?>" name="id"/>
                            <input type="text" class="form-control" placeholder="nom de la classe" name="classe">
                           <button type="submit"  class=" addClass btn btn-primary" >+</button>
                       </form>
                      <?php foreach ($value["CLASSES"] as $keyClasse => $classe) {;?>
                     
                        <div class="d-flex flex-column m-2 " >
                            <h6 type="text" class=" text-danger w-25 border-0 mb-2"><?=$keyClasse?></h6>
                           <div>
                               <?php ksort($classe); $i=0;foreach ($classe as $keyValCl => $v) {  ?>
                                <a href="/eleve/liste/<?=urlencode($v)?>" class="btn <?=$tabStyleBtn[$i]?> btn-circle">
                                    <i class="fa-sharp fa-solid fa-<?=strtolower($keyValCl)?> "></i>                    
                                </a>
                                <?php $i++;} ?>
                               
                            </div>
                       </div>
                       <hr>
                       <?php } ?>
                   </div>
               </div>
   
               <!-- Brand Buttons -->
           </div>
   
        <?php } ?>
   
       </div>
   




<?php $content=ob_get_clean()?>
<?php require_once __DIR__.'/../views/index.php';