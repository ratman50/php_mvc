<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/views/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="/views/css/sb-admin-2.css" rel="stylesheet">

    <title>Document</title>
</head>
<body>
    
    <div  class="container d-flex p-5">
        <div class="w-100">
            <header data-eleve="<?=$id ?>" style="border:2px solid" id="header" class="p-3">
                <h1 class="text-center" id="name_eleve"></h1>
                <footer class=" row">
                    <div class="left col-6">
                        <p class="font-weight-bolder">classe:<span id="name_classe" class="font-weight-lighter"></span></p>
                        <p class="font-weight-bolder">Classe doublée:<span id="double_classe" class="font-weight-lighter"></span></p>
                    </div>
                    <div class="right col-6">
                        <p class="text-right font-weight-bolder" >Date de naissance:<span id="date_naiss" class="font-weight-lighter"></span></p>
                        <p class="text-right font-weight-bolder " >Effectif:<span id="effectif" class="font-weight-lighter"></span></p>
                    </div>
                </footer>
            </header>
            <div class="center">
                <h2>BULLETINS DE NOTES DU <span id="semestre"></span> <span id="annee"></span></h2>
            </div>
    
        </div>
        <table>
            <thead>
                <th>Disciplines</th>
            </thead>
        </table>
    </div>
    <script src="/views/vendor/jquery/jquery.min.js"></script>
    <script src="/views/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/views/js/util.js"></script>

    <script src="/views/js/note.js"></script>
</body>
</html>
