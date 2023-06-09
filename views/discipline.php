<?php ob_start()?>
<div >
    <div class="container-fluid w-75 ">
        
        <div class="row">
            <div class="input-group mb-3 col-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupNiveau">Niveaux</label>
                </div>
                <select class="custom-select" id="inputGroupNiveau">
                    <option selected value="">Choisir un niveau</option>
                    <?php foreach ($niveau as $key => $value) {?>
                        <option value="<?=$value["id_niveau"] ?>"><?= $value["libelle_niveau"]?></option>

                    <?php }?>
                </select>
            </div>
            <div class="input-group mb-3 col-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupClasse">Classes</label>
                </div>
                <select class="custom-select" id="inputGroupClasse">
                    <option selected value="">Choisir une classe</option>
                   
                </select>
            </div>
        </div>  
        
        <div class="row">
            <div class="input-group mb-3 col-6">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupDiscipline">Groupe Discipline</label>
                </div>
                <!-- <input type="text" disabled value="choisir"/> -->
                <select class="custom-select " id="inputGroupDiscipline">
                    <option selected>Choisir</option>
                    
                </select>
               
            </div>
            <div class="input-group mb-3 col-6">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="">Discipline</span>
                </div>
                <input type="text" class="form-control disabled" id="discipline_value" disabled placeholder="ex:geographie">
                <button type="button" class="btn btn-primary" id="add_discipline" disabled>ok</button>

            </div>
            
        </div>
        <div class="row mb-2">
            <div  class="input-group  col-6 invisible" id="text_group" >
                        <input type="text" class=" form-control"  placeholder="nom du groupe">
                        <button type="button" class="btn btn-primary" id="add_group">ajout</button>
            </div>
            <div class="col-6 invisible">
                <p  id="notification_discipline"></p>
            </div>
        </div>
        <div class="row">
            <div class="col ">

                <h6 class=" title_discipline">Les disciplines de <a href="#" class="text-primary">...</a></h6>
                <div class="container-discipline bg-white border-primary border mb-2 p-3 d-flex flex-wrap rounded" style="height:200px; gap:20px">

                </div>
                <div class="row">
                    <p id="notification_update"></p>
                </div>
                <div class="footer d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="update">Mettre A jour</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="/views/js/discipline.js"></script>

<?php $content=ob_get_clean()?>
<?php require_once __DIR__.'/../views/index.php';?>