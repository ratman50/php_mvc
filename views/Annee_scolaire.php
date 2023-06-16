<?php ob_start()?>
<form class="mb-3 row w-100 ">
    <div class="col-12 d-flex w-50 justify-content-end" style="gap:5px">
      <input type="text" class="form-control w-25"  name="annee" id="input_annee">
      <input type="button" value="ajouter une année" id="add_annee" class="btn btn-primary"/>
    </div>

</form>
<script>
  var myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    // var raw = JSON.stringify(tabchecked);

    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: '',
    };
  add_annee.addEventListener("click",(e)=>{
    const target=e.target;
    if(input_annee.value)
    {
      const val_annee=input_annee.value;
      requestOptions.body=JSON.stringify([val_annee]);
      fetch(`http://localhost:8000/annee/add`,requestOptions)
      .then(response=>response.json())
      .then(result=>{
        showModal(result);
      })
    }

  })
</script>
<hr>
<div class="row" id="container_annee">
    
</div>
<script src="/views/js/annee.js"></script>
<?php $content=ob_get_clean()?>
<?php 
require_once __DIR__.'/../views/index.php';
?>


