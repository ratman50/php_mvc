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
    <h1 class="h3 mb-4 text-gray-800">NIVEAUX</h1>
    <form action="/ajouterNiveau" method="POST" class="form_niveau mb-1" >
                        
        <input type="hidden" class="form-control name-niveau" name="niveau" >
        <button type="submit" class="btn btn-outline-primary  addNiveau">+</button>
    </form>                    
             
      <div class="row niveaux" >
      <?php foreach ($data as  $value) {?>
           
           <div class="col-lg-6 card_niveau  " >
   
               <!-- Circle Buttons -->
               <div class="card shadow mb-4 ">
                   <div class="card-header py-3 d-sm-flex align-items-center justify-content-between mb-4">
                       <form action="/modifierNiveau" method="POST" >
                           <input  value="<?=$value["id_niveau"]?>" type="hidden" name="id"/>
                           <input class=" font-weight-bold text-primary w-100 form-control fieldModif border-0 name-value"  name="niveau" type="text" value="<?=$value["libelle_niveau"]?>" disabled />
                       </form>
                       <div class="dropdown no-arrow">
                             <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                                <a class="dropdown-item" href="/supprimerNiveau">supprimer</a>
                                <a class="dropdown-item" href="#">modifier</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Supprimer les classes</a>
                            </div>
                        </div>
                      
                   </div>
                   <form class="card-body position-relative form-class" action="/ajouterClasse"  method="POST">
                       <!-- Circle Buttons (Default) -->
                       <input type="hidden" name="classe" class="className" />
                       <input type="hidden" name="id" class="niveauClasse" value="<?=$value["id_niveau"]?>" />
                       <button type="submit"  class=" addClass btn btn-primary position-absolute"  style="right: 5px;top:-15px">+</button>
                       <?php 
                            
                            $tabClasses=explode(',', $value["CLASSES"]);
                            $tmp=[];
                            $cl=[];
                            foreach ($tabClasses as $val) {
                                $sp=substr($val,0,strlen($val)-1);
                                if(!in_array($sp, $tmp))
                                {
                                    $tmp[]=$sp;
                                }
                                
                            }
                            foreach ($tmp as $t) {
                                foreach ($tabClasses as $vale) {
                                    if (strcmp($t, substr($vale,0,strlen($t)))==0) {
                                        $cl[$t][]=$vale;
                                    }
                                }
                            }
                            ?>
                        <?php  foreach ($cl as $keyCl => $valCl) {?>
                       <form class="d-flex flex-column mb-2 ml-3" action="/ajouterClasse">
                           <input type="text" class=" text-danger w-25 border-0 mb-2" disabled value="<?=$keyCl?>"/>
                           <div>
                               <?php  $i=0;foreach ($valCl as $keyValCl => $v) {  ?>
                                <input type="hidden" name="niveau" value="<?=$v?>"/>
                                <input type="hidden" name="id" value="<?=$value[""]?>"/>
                                <a href="#" class="btn <?=$tabStyleBtn[$i]?> btn-circle">
                                    <i class="fa-sharp fa-solid fa-<?=strtolower(substr($v, -1))?> "></i>                    
                                </a>
                                <?php $i++;} ?>
                                <button type="submit"  class="btn btn-danger btn-circle">
                                    <i class="fa-sharp fa-solid fa-plus"></i>
                                </button>
                            </div>
                       </form>
                       <?php } ?>
                   </form>
               </div>
   
               <!-- Brand Buttons -->
           </div>
   
        <?php } ?>
   
       </div>
   




<?php $content=ob_get_clean()?>
<?php require_once __DIR__.'/../views/index.php';