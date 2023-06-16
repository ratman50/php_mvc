<?php ob_start()?>
<style>
    @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css");
    #notes{
        width: 0px;
        transition: width 2s ease;
    }
    #notes.active
    {
        width: 150px;
    }
   
   
</style>
<div class="container-eleve ">

    <div class="container_nav  row">
        <nav class="navbar navbar-expand-lg col-lg-5 navbar-light bg-light col-md-12">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item border-right">
                    <a   class="text-primary nav-link  addEleve" href="/niveau">Retour</a>
                </li>
                <li class="nav-item border-right">
                    <a   class="text-primary nav-link  addEleve" href="/eleve/form<?= !empty($classe)?"/".urlencode($id_classe):"" ?>">Ajouter une élève</a>
                </li>
                <?php if (!empty($classe)) { ?>
                    
                    <li class="nav-item ">
                        <a class="nav-link text-primary border-right" href="/discipline/gestion/<?= urlencode($id_classe) ?>">Ajouter une discipline</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-primary border-right" href="/classe/coeff/<?= urlencode($id_classe) ?>">Coefficient</a>
                    </li>
                   
                <?php } ?>
            </ul>
        </nav>

            <?php if (!empty($classe)) { ?>
                <div  class="col-2">
                        <div class="input-group ">
                        <div class="input-group-prepend">
                            <button type="button" class="btn text-light btn-primary" id="semestre"  data-id="<?= $id?>" data-semestre="">choisir un semestre</button>
                            <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu " id="dropdown_semestre">
                                <li class="dropdown-item" >Action</li>
                                <li class="dropdown-item" >Another action</li>
                                <li class="dropdown-item">Something else here</li>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="drop col-lg-5 col-md-12 d-flex " style="gap:10px">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupDiscipline">Discipline</label>
                        </div>
                        <select class="custom-select " id="inputGroupDiscipline">
                            
                        </select>
                    </div>        
                    
                    <div class="input-group mb-3 ">
                        <div class="input-group-prepend ">
                            <label class="input-group-text" for="inputGroupNiveau">Note de</label>
                        </div>
                        <select class="custom-select" id="inputGroupNote" data-id="<?= $data[0]["niveau"]?>">
                            <option value="">CHOISIR</option>
                        </select>
                    </div>        
                </div>
            
            <?php } ?>
            
        <div>

        </div>

    </div>
    <div class="d-flex justify-content-center align-content-center">
        <section class="intro mt-5 " >
            <div class="bg-image " style="background-color: #f5f7fa;">
                <div class="mask d-flex align-items-center h-100">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="">
                                <div class="card">
                                    <div class="card-body  p-0">
                                        <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" >
                                            <table class="table table-striped mb-0 ">
                                                <thead class="bg-primary">
                                                    <?php if(!empty($classe)) { ?>
                                                        <h4 class="text-primary text-center"><?= $classe?></h4>
                                                    <?php } ?>
                                                    <tr>

                                                        <th scope="col" class="text-white">profile</th>
                                                        <th scope="col" class="text-white">Numero</th>
                                                        <th scope="col" class="text-white ">Prénom et Nom</th>
                                                        <th scope="col" class="text-white">Date de naissance</th>
                                                        <th scope="col" class="text-white">Lieu de naissance</th>
                                                        <th scope="col" class="text-white">Sexe</th>
                                                        <?php if (empty($classe) ){ ?>
                                                            <th scope="col" class="text-white">Niveau</th>
                                                        <?php } ?>
                                                        <?php if (empty($classe) ){ ?>
                                                            <th scope="col" class="text-white">Classe</th>
                                                        <?php } ?>
                                                        
                                                        <th scope="col" class="text-white" colspan="2">Actions</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data as  $value) { ?>
                                                        <tr>
                                                            <td><?php if($value["sexe"]) { ?><img class="img-profile rounded-circle" src="/views/img/undraw_profile.svg"> <?php }else { ?> <img class="img-profile rounded-circle" src="/views/img/undraw_profile_1.svg"><?php } ?></td>
                                                            <td> <?=$value["numero"] ?></td>
                                                            <td><?= $value["prenom"]." ".$value["nom"] ?></td>
                                                            <td><?= $value['date_naiss'] ?></td>
                                                            <td><?= $value['lieu_naiss'] ?></td>
                                                            <td><?= $value["sexe"]==1?"garçon":"fille"?></td>
                                                            <?php if (empty($classe) ){ ?>
                                                                <td><?= $value["libelle_niveau"]?></td>
                                                            <?php } ?>
                                                            <?php if (empty($classe) ){ ?>
                                                                <td><?= $value["nom_classe"]?></td>
                                                            <?php } ?>
                                                            <td><a href="#">modifier</a></td>
                                                            <td><a href="#">archiver</a></td>
                                                            <?php 
                                                            
                                                            ?>
                                                        </tr>
                                                    <?php } ?>
                                                    
                            
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php 
            if(!empty($classe)){ ?>
                <div class=" d-flex justify-content-end align-content-center flex-column mt-5 border " id="notes"  >
                    <div class="input d-none flex-column " style="gap: 39px;">
                        <?php    foreach ($data as $value) { ?>
                                <div class="d-flex justify-content-center align-content-center">
                                    <input type="number" class="form-control note_val" value="0" data-eleve="<?= $value["eleve"]  ?>"/>
                                    <span class=" font-weight-bolder">/</span>
                                    <p class="note_max"></p>
                                    <input type="checkbox" checked class="form-control exampes"/>
                                </div>

                         <?php } ?>

                    </div>
                </div>
        <?php    }
        ?>

    </div>
    <div class="row justify-content-center align-content-center mt-3">
        <div class="col-4">loading</div>
        <div class="col-1">
            <button class="btn btn-primary " id="save">Enregistrer</button>
        </div>
    </div>
</div>
<script src="/views/js/eleve.js"></script>
<?php $content=ob_get_clean()?>
<?php require_once __DIR__.'/../views/index.php';?>
