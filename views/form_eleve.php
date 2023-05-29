<?php ob_start()?>
<div class="container-form d-flex justify-content-center align-items-center ">
    <a href="/eleve">liste des élèves</a>
    <form name="form-eleve" class=" d-flex justify-content-center align-items-center " method="POST" action="/ajouterEleve">
        <fieldset >
            <legend>Disabled fieldset example</legend>
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="disabledTextInput" class="form-label" >Prénom:</label>
                    <input type="text" id="disabledTextInput" name="prenom" class="form-control" >
                    <p class="notification text-danger"></p>

                </div>
                <div class="mb-3 col-6">
                    <label for="disabledTextInput" class="form-label" >Nom:</label>
                    <input type="text" id="disabledTextInput" name="nom" class="form-control" >
                    <p class="notification text-danger"></p>

                </div>

            </div>
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="disabledTextInput" class="form-label" >Date de naissance:</label>
                    <input type="date" id="disabledTextInput" class="form-control" name="date_naiss">
                    <p class="notification text-danger"></p>

                </div>
                <div class="mb-3 col-6">
                    <label for="disabledTextInput" class="form-label" >Lieu de naissance:</label>
                    <input type="text" id="disabledTextInput" class="form-control" name="lieu_naiss">
                    <p class="notification text-danger"></p>
                </div>

            </div>
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="disabledTextInput" class="form-label" >Numero:</label>
                    <input type="text" id="disabledTextInput" name="numero" class="form-control">
                    <p class="notification text-danger"></p>

                </div>
                <div class="mb-3 col-6">
                    <label for="disabledTextInput" class="form-label">Sexe:</label>
                    <div class="d-flex" style="gap:10px">
                        <div  class="">
                            <input  type="radio" name="sexe" id="garcon" value="1" checked>
                            <label  for="garcon">Garçon</label>
                        </div>
                        <div>
                            <input  type="radio" name="sexe" id="fille" value="0">
                            <label  for="fille">Fille</label>

                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="mb-3 col-6 d-flex flex-column form-label niveaux">
                <label for="disabledTextInput" class="">Niveau:</label>
                <select id="disabledSelect" name="niveau" class="form-select">
                    <option  value="">Choisir un niveau</option>
                    <?php foreach ($niveau as $value) {?>
                        <option value="<?=$value["id_niveau"] ?>"><?=$value["libelle_niveau"] ?></option>
                        
                    <?php } ?>
                </select>
                <p class="notification text-danger"></p>

                </div>
                <div class="mb-3 col-6 d-flex flex-column classes" >
                    <label for="disabledTextInput" class="form-label">Classe:</label>
                    <select id="disabledSelect" name="classe" class="form-select">
                        <option value="">Choisir une classe</option>
                    </select>   
                    <p class="notification text-danger"></p>
                
                </div>

            </div>
            
            <div class="d-flex" style="gap:30px">
                <button type="button" class="btn btn-primary" name="save">Ajouter</button>

            </div>
        </fieldset>
    </form>
</div>
<?php $content=ob_get_clean()?>
<?php 
require_once __DIR__.'/../views/index.php';
?>