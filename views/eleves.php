<?php ob_start()?>
<div class="container-eleve ">
    <nav class="navbar navbar-expand-lg navbar-light bg-light w-25">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item border-right">
                <a   class="text-primary nav-link  addEleve" href="/eleve/form">Ajouter une élève</a>
            </li>
            <?php if (!empty($classe)) { ?>
                
                <li class="nav-item ">
                    <a class="nav-link text-primary border-right" href="/classe/coeff/<?= urlencode($id_classe) ?>">Coefficient</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary"  href="#">Pricing</a>
                </li>
            <?php } ?>
        </ul>

        
    </nav>
    <section class="intro mt-5">
        <div class="bg-image h-100" style="background-color: #f5f7fa;">
            <div class="mask d-flex align-items-center h-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
                                        <table class="table table-striped mb-0">
                                            <thead class="bg-primary">
                                                <?php if(!empty($classe)) { ?>
                                                    <h4 class="text-primary text-center"><?= $classe?></h4>
                                                <?php } ?>
                                                <tr>

                                                    <th scope="col" class="text-white">profile</th>
                                                    <th scope="col" class="text-white">Numero</th>
                                                    <th scope="col" class="text-white">Prénom et Nom</th>
                                                    <th scope="col" class="text-white">Date de naissance</th>
                                                    <th scope="col" class="text-white">Lieu de naissance</th>
                                                    <th scope="col" class="text-white">Sexe</th>
                                                    <th scope="col" class="text-white">Niveau</th>
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
                                                        <td><?= $value["libelle_niveau"]?></td>
                                                        <?php if (empty($classe) ){ ?>
                                                            <td><?= $value["nom_classe"]?></td>
                                                        <?php } ?>
                                                        <td><a href="#">modifier</a></td>
                                                        <td><a href="#">archiver</a></td>
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
</div>

<?php $content=ob_get_clean()?>
<?php require_once __DIR__.'/../views/index.php';?>
