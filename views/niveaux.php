<?php ob_start()?>
                    
 <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">NIVEAUX</h1>
    <form action="/index.php/ajouterNiveau" method="POST" class="form_niveau mb-1" >
                        
        <input type="text" class="form-control" name="niveau">
        <button type="submit" class="btn btn-outline-primary  addNiveau">+</button>
    </form>                    
    <div class="row">

        <div class="col-lg-6">

            <!-- Circle Buttons -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Enseignement secondaire</h6>
                </div>
                <div class="card-body">
                    <p>Use Font Awesome Icons (included with this theme package) along with the circle
                        buttons as shown in the examples below!</p>
                    <!-- Circle Buttons (Default) -->
                    <div class="mb-2">
                        <code>CI</code>
                    </div>
                    <a href="#" class="btn btn-primary btn-circle">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-success btn-circle">
                        <i class="fas fa-check"></i>
                    </a>
                    <a href="#" class="btn btn-info btn-circle">
                        <i class="fas fa-info-circle"></i>
                    </a>
                    <a href="#" class="btn btn-warning btn-circle">
                        <i class="fas fa-exclamation-triangle"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-circle">
                        <i class="fas fa-trash"></i>
                    </a>
                    <!-- Circle Buttons (Small) -->
                    <div class="mt-4 mb-2">
                        <code>CP</code>
                    </div>
                    <a href="#" class="btn btn-primary btn-circle btn-sm">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-success btn-circle btn-sm">
                        <i class="fas fa-check"></i>
                    </a>
                    <a href="#" class="btn btn-info btn-circle btn-sm">
                        <i class="fas fa-info-circle"></i>
                    </a>
                    <a href="#" class="btn btn-warning btn-circle btn-sm">
                        <i class="fas fa-exclamation-triangle"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                    </a>
                    <!-- Circle Buttons (Large) -->
                    <div class="mt-4 mb-2">
                        <code>CE2</code>
                    </div>
                    <a href="#" class="btn btn-primary btn-circle btn-lg">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-success btn-circle btn-lg">
                        <i class="fas fa-check"></i>
                    </a>
                    <a href="#" class="btn btn-info btn-circle btn-lg">
                        <i class="fas fa-info-circle"></i>
                    </a>
                    <a href="#" class="btn btn-warning btn-circle btn-lg">
                        <i class="fas fa-exclamation-triangle"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-circle btn-lg">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
            </div>

            <!-- Brand Buttons -->
            

        </div>

        

    </div>                   




<?php $content=ob_get_clean()?>
<?php require_once __DIR__.'/../views/index.php';