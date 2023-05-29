<?php ob_start()?>
<div class="container-eleve ">
    <a type="button"  class=" btn btn-primary addEleve" href="/form_eleve">Ajouter une élève</a>
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
                                                <tr>

                                                    <th scope="col" class="text-white">profile</th>
                                                    <th scope="col" class="text-white">Numero</th>
                                                    <th scope="col" class="text-white">Prénom et Nom</th>
                                                    <th scope="col" class="text-white">Date de naissance</th>
                                                    <th scope="col" class="text-white">Lieu de naissance</th>
                                                    <th scope="col" class="text-white">Sexe</th>
                                                    <th scope="col" class="text-white">Niveau</th>
                                                    <th scope="col" class="text-white">Classe</th>
                                                    <th scope="col" class="text-white" colspan="2">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data as $key => $value) { ?>
                                                    <tr>
                                                        <td><img class="img-profile rounded-circle" src="/views/img/undraw_profile_1.svg"></td>
                                                        <td> <?=$value["numero"] ?></td>
                                                        <td><?= $value["prenom"]." ".$value["nom"] ?></td>
                                                        <td><?= $value['date_naiss'] ?></td>
                                                        <td><?= $value['lieu_naiss'] ?></td>
                                                        <td><?= $value["sexe"]==1?"garçon":"fille"?></td>
                                                        <td><?= $value["libelle_niveau"]?></td>
                                                        <td><?= $value["nom_classe"]?></td>
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
